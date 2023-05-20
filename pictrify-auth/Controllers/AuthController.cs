using dotenv.net;
using Newtonsoft.Json;
using pictrify_auth.API;
using pictrify_auth.Entities;
using pictrify_auth.Models;
using pictrify_auth.Utils;

namespace pictrify_auth.Controllers;

using Microsoft.AspNetCore.Mvc;
using Microsoft.IdentityModel.Tokens;
using System;
using System.IdentityModel.Tokens.Jwt;
using System.Security.Claims;
using System.Text;
using System.Threading.Tasks;

[Route("api/[controller]")]
[ApiController]
public class AuthController : ControllerBase
{
    [HttpPost("login")]
    public async Task<IActionResult> Login(LoginModel model)
    {
        bool validCredentials = false;
        Creator? creator = await CreatorApiClient.GetCreatorByUsername(model.Username);
        if (creator != null) {
            validCredentials = creator.CanLogin(model);
        }
        
        if (validCredentials && creator != null)
        {
            Claim[] claims = {
                new("_id", creator.Id.ToString()),
                new("_username", model.Username),
                new("_email", creator.Email),
            };

            SymmetricSecurityKey key = new(Encoding.UTF8.GetBytes(DotEnv.Read()["SECRET_KEY"]));
            SigningCredentials credentials = new(key, SecurityAlgorithms.HmacSha256);

            JwtSecurityToken token = new(
                issuer: DotEnv.Read()["ISSUER"],
                audience: DotEnv.Read()["AUDIENCE"],
                claims: claims,
                expires: DateTime.UtcNow.AddDays(7),
                signingCredentials: credentials
            );

            return Ok(new { token = new JwtSecurityTokenHandler().WriteToken(token) });
        }

        return Unauthorized();
    }

    [HttpPost("register")]
    public async Task<IActionResult> Register(RegisterModel model)
    {
        List<string> missingPasswordRequirements = PasswordChecker.CheckPasswordRequirements(model.Password);
        if (missingPasswordRequirements.Any())
        {
            return BadRequest(new { message = $"Password does not meet the following requirements: {string.Join(", ", missingPasswordRequirements)}" });
        }

        Creator creator = new()
        {
            Username = model.Username,
            Email = model.Email,
            PasswordHash = model.Password,
        };
        
        creator.HashPassword();
        
        HttpResponseMessage? responseMessage = await CreatorApiClient.CreateCreator(creator);
        if (responseMessage is { IsSuccessStatusCode: true })
        {
            Claim[] claims = {
                new("_id", creator.Id.ToString()),
                new("_username", creator.Username),
                new("_email", creator.Email),
            };

            SymmetricSecurityKey key = new(Encoding.UTF8.GetBytes(DotEnv.Read()["SECRET_KEY"]));
            SigningCredentials credentials = new(key, SecurityAlgorithms.HmacSha256);

            JwtSecurityToken token = new(
                issuer: DotEnv.Read()["ISSUER"],
                audience: DotEnv.Read()["AUDIENCE"],
                claims: claims,
                expires: DateTime.UtcNow.AddDays(7),
                signingCredentials: credentials
            );
            
            return Ok(new { message = "Registration successful", token = new JwtSecurityTokenHandler().WriteToken(token)});
        }

        if (responseMessage != null)
        {
            string responseContent = await responseMessage.Content.ReadAsStringAsync();
            ErrorResponseModel? errorObject = JsonConvert.DeserializeObject<ErrorResponseModel>(responseContent);
            return BadRequest(new { message = errorObject?.Reason ?? "Registration failed" });
        }
        return BadRequest(new { message = "Registration failed" });
    }
    
    [HttpPost("verify")]
    public async Task<IActionResult> Verify(VerifyModel model)
    {
        try
        {
            JwtSecurityTokenHandler tokenHandler = new();
            TokenValidationParameters validationParameters = new()
            {
                ValidateIssuerSigningKey = true,
                IssuerSigningKey = new SymmetricSecurityKey(Encoding.ASCII.GetBytes(DotEnv.Read()["SECRET_KEY"])),
                ValidateIssuer = true,
                ValidIssuer = DotEnv.Read()["ISSUER"],
                ValidateAudience = true,
                ValidAudience = DotEnv.Read()["AUDIENCE"],
            };

            ClaimsPrincipal claimsPrincipal;
            try
            {
                claimsPrincipal = tokenHandler.ValidateToken(model.Token, validationParameters, out _);
            }
            catch (Exception)
            {
                return BadRequest(new { error = "Invalid token" });
            }

            string? creatorId = claimsPrincipal.FindFirst("_id")?.Value;
            string? creatorUsername = claimsPrincipal.FindFirst("_username")?.Value;
            string? creatorEmail = claimsPrincipal.FindFirst("_email")?.Value;

            if (creatorId != null && creatorUsername != null && creatorEmail != null)
            {
                Creator? creator = await CreatorApiClient.GetCreatorById(creatorId);
                
                if (creator != null)
                {
                    if (creator.Username == creatorUsername && creator.Email == creatorEmail)
                    {
                        return Ok(new { valid = true, user = new
                            {
                                id = creator.Id.ToString(), 
                                username = creator.Username, 
                                email = creator.Email
                            } 
                        });
                    }
                }
            }
            return BadRequest(new { error = "Invalid token" });
        }
        catch (Exception)
        {
            return StatusCode(500, new { error = "An error occurred during token verification" });
        }
    }

    
    // [HttpPost("refresh-token")]
    // [Authorize]
    // public async Task<IActionResult> RefreshToken(RefreshTokenRequestModel model)
    // {
    //     // Retrieve the old JWT and refresh token from the request
    //     string oldToken = model.OldToken;
    //     string refreshToken = model.RefreshToken;
    //
    //     // Perform token refreshing logic, e.g., verify the old token and refresh token combination
    //
    //     if (IsValidRefreshToken(refreshToken) && ValidateToken(oldToken, out ClaimsPrincipal claims))
    //     {
    //         // Retrieve the user's identity or relevant data from the old token claims
    //         string userId = claims.FindFirst(ClaimTypes.NameIdentifier)?.Value;
    //     
    //         // Generate a new JWT with extended expiration
    //         string newToken = GenerateJwtToken(userId);
    //
    //         // Return the new token
    //         return Ok(new { token = newToken });
    //     }
    //
    //     return BadRequest(new { message = "Invalid refresh token or expired token" });
    // }
    //
    // private bool IsValidRefreshToken(string refreshToken)
    // {
    //     
    // }
    //
    // private bool ValidateToken(string oldToken, out ClaimsPrincipal claims)
    // {
    //     
    // }
    //
    //
    // [HttpPost("logout")]
    // [Authorize]
    // public async Task<IActionResult> Logout()
    // {
    //     // Perform logout logic, e.g., invalidate the user's token or remove it from the token blacklist
    //
    //     // Return a success message or appropriate response
    //     return Ok(new { message = "Logout successful" });
    // }
}
