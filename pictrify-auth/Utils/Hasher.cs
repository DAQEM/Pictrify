using System.Security.Cryptography;
using System.Text;

namespace pictrify_auth.Utils;

public static class Hasher
{
    public static string HashPassword(string password, string salt)
    {
        byte[] passwordBytes = Encoding.UTF8.GetBytes(password);
        byte[] saltBytes = Encoding.UTF8.GetBytes(salt);

        byte[] saltedPasswordBytes = new byte[passwordBytes.Length + saltBytes.Length];
        
        Buffer.BlockCopy(passwordBytes, 0, saltedPasswordBytes, 0, passwordBytes.Length);
        Buffer.BlockCopy(saltBytes, 0, saltedPasswordBytes, passwordBytes.Length, saltBytes.Length);
        
        byte[] hashedBytes = SHA256.HashData(saltedPasswordBytes);
        string hashedPassword = Convert.ToBase64String(hashedBytes);
        return hashedPassword;
    }

    public static string GenerateSalt()
    {
        byte[] saltBytes = new byte[32];
        using (RandomNumberGenerator rng = RandomNumberGenerator.Create())
        {
            rng.GetBytes(saltBytes);
        }

        string salt = Convert.ToBase64String(saltBytes);
        return salt;
    }
}