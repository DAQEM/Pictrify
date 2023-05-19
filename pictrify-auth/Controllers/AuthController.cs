using dotenv.net;
using Microsoft.Net.Http.Headers;
using Newtonsoft.Json;
using pictrify_auth.API;
using pictrify_auth.Entities;
using pictrify_auth.Models;

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
        
        if (validCredentials)
        {
            Claim[] claims = {
                new(ClaimTypes.Name, model.Username)
            };

            SymmetricSecurityKey key = new(Encoding.UTF8.GetBytes(DotEnv.Read()["SECRET_KEY"]));
            SigningCredentials creds = new(key, SecurityAlgorithms.HmacSha256);

            JwtSecurityToken token = new(
                issuer: DotEnv.Read()["ISSUER"],
                audience: DotEnv.Read()["AUDIENCE"],
                claims: claims,
                expires: DateTime.UtcNow.AddDays(7),
                signingCredentials: creds
            );

            return Ok(new { token = new JwtSecurityTokenHandler().WriteToken(token) });
        }

        return Unauthorized();
    }

    [HttpPost("register")]
    public async Task<IActionResult> Register(RegisterModel model)
    {
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
            return Ok(new { message = "Registration successful" });
        }

        if (responseMessage != null)
        {
            string responseContent = await responseMessage.Content.ReadAsStringAsync();
            ErrorResponseModel? errorObject = JsonConvert.DeserializeObject<ErrorResponseModel>(responseContent);
            string reason = errorObject?.Reason ?? "Registration failed";
            return BadRequest(new { message = reason });
        }
        return BadRequest(new { message = "Registration failed" });
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
