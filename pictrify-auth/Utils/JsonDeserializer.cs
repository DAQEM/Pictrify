using Newtonsoft.Json;
using Newtonsoft.Json.Linq;

namespace pictrify_auth.Utils;

public abstract class JsonDeserializer<T> : JsonConverter<T>
{
    public override void WriteJson(JsonWriter writer, T? value, JsonSerializer serializer)
    {
        throw new NotImplementedException("Writing JSON is not supported by this custom deserializer.");
    }
    
    protected string GetAsString(JToken? token)
    {
        return token?.Value<string>() ?? "";
    }
    
    protected DateTime GetAsDateTime(JToken? token)
    {
        return token?.Value<DateTime>() ?? DateTime.MinValue;
    }
    
    protected Guid GetAsGuid(JToken? token)
    {
        if (token?.Type == JTokenType.String && Guid.TryParse(token.Value<string>(), out Guid result))
        {
            return result;
        }

        return Guid.Empty;
    }
}