using System.Text.RegularExpressions;

namespace pictrify_auth.Utils;

public partial class PasswordChecker
{
    public static List<string> CheckPasswordRequirements(string password)
    {
        List<string> missingRequirements = new();
        
        if (!OneLowerCaseRegex().IsMatch(password))
            missingRequirements.Add("At least one lowercase letter");
        if (!OneUpperCaseRegex().IsMatch(password))
            missingRequirements.Add("At least one uppercase letter");
        if (!OneDigitRegex().IsMatch(password))
            missingRequirements.Add("At least one digit");
        if (!OneSpecialCharacterRegex().IsMatch(password))
            missingRequirements.Add("At least one special character (from @$!%*#?&)");
        if (password.Length < 8)
            missingRequirements.Add("Minimum length of 8 characters");
        
        return missingRequirements.Count == 0 ? new List<string>() : missingRequirements;
    }

    [GeneratedRegex("(?=.*[a-z])")]
    private static partial Regex OneLowerCaseRegex();
    
    [GeneratedRegex("(?=.*[A-Z])")]
    private static partial Regex OneUpperCaseRegex();
    
    [GeneratedRegex("(?=.*\\d)")]
    private static partial Regex OneDigitRegex();
    
    [GeneratedRegex("(?=.*[@$!%*#?&])")]
    private static partial Regex OneSpecialCharacterRegex();
}