# Livewire Manage User

En esta aplicación vamos a ver una implementación de una API protegida con JWT y el consumo de esta misma con livewire.

## Step 1 (Clone repository)
Clone the repository
```sh
git clone https://github.com/salejo28/livewire-user-manage.git
```

## Step 2 (Install dependencies)
Navigate to project folder
```sh
cd livewire-user-manage
```

And run follow commands to install dependencies
```sh
npm install && composer install
```

## Step 3 (Setup .env file)
Copy the content in the **.env.example** and create the **.env** file and paste the content there.

Modify the database variables
```sh
DB_CONNECTION=mysql
DB_HOST=YOUR_DB_HOST
DB_PORT=YOUR_DB_PORT
DB_DATABASE=YOUR_DATABASE_NAME
DB_USERNAME=YOUR_USER_OF_DB
DB_PASSWORD=PASSWORD_OF_USER
```

Now run the command to generate the **JWT_SECRET**
```sh
php artisan jwt:secret
```
Or we can manually in the **.env** file
```sh
JWT_SECRET=YOUR_SECRET
```

## Step 4 (Create the database)
If you using **phpmyadmin** create the database with the same name that you put in the **.env** file

Or if you using **mysql** in the bash linux or unix bash start the mysql service access to mysql and run the SQL STATEMENT
```sql
CREATE DATABASE YOUR_DATABASE_NAME;
```

## Step 5 (Migrate the database)
To migrate the database will run the next command
```sh
php artisan migrate:fresh
```
El comando **php artisan migrate:fresh** lo que hace es si ya las migraciones se habían hecho entonces elimina esas tablas y las vuelve a crear.

Pero si lo que queremos es migrar solo una nueva tabla corremos el comando
```sh
php artisan migrate
```

## Step 6 (Run the project)
Execute the command
```sh
php artisan serve
```

And open the browser an put **localhost:8000** and proof the application

## API

The URL REQUESTS for the api are

##### Authentication
- [POST] **Login** -> http://localhost:8000/api/v1/auth/login
Data to send (example)
```json
{
  "email": "john.doe@email.com",
  "password": "password"
}
```
- [POST] **Register** -> http://localhost:8000/api/v1/auth/register
Data to send (example)
```json
{
  "name": "John Doe",
  "email": "john.doe@email.com",
  "password": "password"
}
```
- [POST] **Logout** -> http://localhost:8000/api/v1/auth/logout
No data to send (example)
But this endpoint need the **Authentication Header**
```json
{
  "headers": {
    "Authorization": "Bearer {{TOKEN}}"
  }
}
```

##### User
- [GET] **Get users paginated** -> http://localhost:8000/api/v1/users?search=&page=1
In the **search** query send the name or email and return the users paginated according to the search query 
- [POST] **Create User** -> http://localhost:8000/api/v1/users
Data to send (example)
```json
{
  "name": "John Doe",
  "email": "john.doe@email.com",
  "password": "password"
}
```
- [PUT] **Update user** -> http://localhost:8000/api/v1/users/{{uid}}
The **uid** is the id of user to delete
Data to send (example)
```json
{
  "name": "John Doe",
  "email": "john.doe@email.com",
}
```
- [DELETE] **Delete User** -> http://localhost:8000/api/v1/users/{{uid}}
The **uid** is the id of user to delete