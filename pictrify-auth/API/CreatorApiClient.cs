using System.Text;
using Newtonsoft.Json;
using pictrify_auth.Entities;
using pictrify_auth.Utils;

namespace pictrify_auth.API;

public static class CreatorApiClient
{
    public static async Task<Creator?> GetUserById(Guid id)
    {
        string url = $"{Constants.BaseApiUrl}/creator/{Uri.EscapeDataString(id.ToString())}";
        HttpResponseMessage response = await new HttpClient().GetAsync(url);

        if (response.IsSuccessStatusCode)
        {
            HttpContent content = response.Content;
            string json = await content.ReadAsStringAsync();
            Creator? user = JsonConvert.DeserializeObject<Creator>(json, new Creator.Deserializer());
            return user;
        }
        return null;
    }

    public static async Task<Creator?> GetCreatorByEmail(string email)
    {
        string url = $"{Constants.BaseApiUrl}/creator/email/{Uri.EscapeDataString(email)}";
        HttpResponseMessage response = await new HttpClient().GetAsync(url);

        if (response.IsSuccessStatusCode)
        {
            HttpContent content = response.Content;
            string json = await content.ReadAsStringAsync();
            Creator? user = JsonConvert.DeserializeObject<Creator>(json, new Creator.Deserializer());
            return user;
        }
        return null;
    }
    
    public static async Task<Creator?> GetCreatorByUsername(string username)
    {
        string url = $"{Constants.BaseApiUrl}/creator/username/{Uri.EscapeDataString(username)}";
        HttpResponseMessage response = await new HttpClient().GetAsync(url);

        if (response.IsSuccessStatusCode)
        {
            HttpContent content = response.Content;
            string json = await content.ReadAsStringAsync();
            Creator? user = JsonConvert.DeserializeObject<Creator>(json, new Creator.Deserializer());
            return user;
        }
        return null;
    }

    public static async Task<Creator?> GetCreatorById(string creatorId)
    {
        string url = $"{Constants.BaseApiUrl}/creator/{Uri.EscapeDataString(creatorId)}";
        HttpResponseMessage response = await new HttpClient().GetAsync(url);

        if (response.IsSuccessStatusCode)
        {
            HttpContent content = response.Content;
            string json = await content.ReadAsStringAsync();
            Creator? user = JsonConvert.DeserializeObject<Creator>(json, new Creator.Deserializer());
            return user;
        }
        return null;
    }

    public static async Task<HttpResponseMessage?> CreateCreator(Creator creator)
    {
        string url = $"{Constants.BaseApiUrl}/creator";
        string json = JsonConvert.SerializeObject(new
        {
            username = creator.Username,
            email = creator.Email,
            password_hash = creator.PasswordHash,
            password_salt = creator.PasswordSalt
        });
        StringContent content = new(json, Encoding.UTF8, "application/json");
        return await new HttpClient().PostAsync(url, content);
    }
}