namespace pictrify_auth.Controllers;

public class RefreshTokenRequestModel
{
    public string OldToken { get; set; }
    public string RefreshToken { get; set; }
}