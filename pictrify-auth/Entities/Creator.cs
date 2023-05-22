using Newtonsoft.Json;
using Newtonsoft.Json.Linq;
using pictrify_auth.Models;
using pictrify_auth.Utils;

namespace pictrify_auth.Entities;

public class Creator
{
    public Guid Id { get; set; }
    public string Username { get; set; }
    public string Email { get; set; }
    public string PasswordHash { get; set; }
    public string PasswordSalt { get; set; }
    public DateTime CreatedAt { get; set; }
    private bool _isPasswordHashed = false;

    public void HashPassword()
    {
        if (!_isPasswordHashed)
        {
            PasswordSalt = Hasher.GenerateSalt();
            PasswordHash = Hasher.HashPassword(PasswordHash, PasswordSalt);
            _isPasswordHashed = true;
        }
    }
    
    public bool CanLogin(LoginModel model)
    {
        model.Password = Hasher.HashPassword(model.Password, PasswordSalt);
        return string.Equals(Username, model.Username, StringComparison.CurrentCultureIgnoreCase) && PasswordHash == model.Password;
    }

    public override string ToString()
    {
        return $"Creator(Id={Id}, " +
               $"Username={Username}, " +
               $"Email={Email}, " +
               $"PasswordHash={PasswordHash}, " +
               $"PasswordSalt={PasswordSalt}, " +
               $"CreatedAt={CreatedAt})";
    }

    public class Deserializer : JsonDeserializer<Creator>
    {
        public override Creator ReadJson(JsonReader reader, Type objectType, Creator? existingValue, bool hasExistingValue,
            JsonSerializer serializer)
        {
            JObject jsonObject = JObject.Load(reader);
            return new Creator
            {
                Id = GetAsGuid(jsonObject["_id"]),
                Username = GetAsString(jsonObject["username"]),
                Email = GetAsString(jsonObject["email"]),
                PasswordHash = GetAsString(jsonObject["password_hash"]),
                PasswordSalt = GetAsString(jsonObject["password_salt"]),
                CreatedAt = GetAsDateTime(jsonObject["created_at"]),
                _isPasswordHashed = true
            };
        }
    }
}