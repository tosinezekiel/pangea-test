# Pangea task
A simple notification system built in PHP (Laravel)

# Requirements
```sh
    "php": "^7.3|^8.0"
```
# Setting it up
These are the steps to get the app up and running. Once you're using the app.

1. Clone the repository
2. `composer install`
3. Rename `.env.example` to `.env` and run `php artisan key:generate`
4. Create a MySQL database. Add the database name to your `.env`
6. Run migrations: `php artisan migrate`
7. Run `php artisan serve` 
8. Run `php artisan schedule:work`
9. Run `php artisan test`

## Request response samples
```sh
CreatE Topic
Endpoint : /api/topics
HTTP Verb: `POST`
{
	"title":"Go duck duck"
}
```

```sh
Subsribe to topic
Endpoint : /api/subscribe/{reference}
HTTP Verb: `POST`
```

```sh
Publish to topic
Endpoint : /api/publish/{reference}
HTTP Verb: `POST`
```