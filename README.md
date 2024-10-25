# URL Shortener API usage guidelines

1. Start the server with `php artisan serve` command and open an HTTP Client (Postman, Insomnia, Thunderclient etc).

2. Send a `POST` request to the `/api/v1/users` route. send this JSON data in the request body(alternatively, you can send your own form data for registration):

```
    {
        "name": "Saif Kamal",
        "email": "kamal.saifkamal534@gmail.com",
        "password": "123456"
    }
```

3. Now that the user is registered, send a `POST` request to `/api/v1/login` route. Send this JSON data in the request body (or the `email` & `password` credentials of yours). This will provide an API Personal Access Token in the response body. Copy the token so that you can use it as a bearer token in the subsequent request for access.

```
    {
        "email": "kamal.saifkamal534@gmail.com",
        "password": "123456"
    }
```

4. Now you can access the sanctum protected resources. To test whether you can access sanctum protected routes, try `api/v1/users` with the personal access token as the bearer token(Authorization)  to get the list of users in the response.

5. To send a long URL, send a `POST` request to `/api/v1/shorten` route. Send this JSON data in the request body (or you can use any custom long URL of yours). Use the personal access token in the bearer token Authorization section in your HTTP Client GUI(Postman,Insomnia etc). Here's an example format:

```
    {
        "long_url": "YOUR_LONG_URL"
    }
```

6. If you do #5, this will provide a short URL of the entered long URL in the response(v1). You can visit the link by clicking on it. The format for short URL is: `/v1/shorten/{shortUrl}`. The `shortUrl` is the 6 digit unique identifier string, not the full URL. You can find the short url unique identifiers in the `urls` table `short_url` column of the database (`database.sqlite` file). The `v1/shorten/{shortUrl}` route is not protected by sanctum so it's publicly accessible to visit.

7. If you want to check the visit counts for each short URL, go to `v2/shorten/{shortUrl}` route and check the database `urls` table `visit_count` column/attribute value. This is only applicable for v2.
