
Required:
- PHP 8.1+
- PostgresSql

1) in project create .env and fill it from .env.example
2) copy .env.example to .env and set properties for your db
   in .env Fill next fields with your local data:
```
   * DB_DATABASE=test_devport
   * DB_USERNAME=***
   * DB_PASSWORD=***
```
3) run next commands:
```
- composer install
- php artisan key:generate
- php artisan jwt:secret
- php artisan migrate
- php artisan db:seed
```

Stack:
Lumen
PostgreSQL


Task:
Create RESTFull API.


Description:
Create the API to share the company's information for the logged users.
Please use the Repository-Service pattern in your task.


Details:
Create DB migrations for the tables: users, companies, etc.
Suggest the DB structure. Fill the DB with the test data.


Endpoints:
- https://domain.com/api/user/register
  — method POST
  — fields: first_name [string], last_name [string], email [string], password [string], phone [string]


- https://domain.com/api/user/sign-in
  — method POST
  — fields: email [string], password [string]


- https://domain.com/api/user/recover-password
  — method POST/PATCH
  — fields: email [string] // allow to update the password via email token


- https://domain.com/api/user/companies
  — method GET
  — fields: title [string], phone [string], description [string]
  — show the companies, associated with the user (by the relation)


- https://domain.com/api/user/companies
  — method POST
  — fields: title [string], phone [string], description [string]
  — add the companies, associated with the user (by the relation)
