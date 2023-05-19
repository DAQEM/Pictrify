namespace pictrify_auth.Models;

public class ErrorResponseModel
{
    public string Error { get; set; }
    public string? Reason { get; set; }
}