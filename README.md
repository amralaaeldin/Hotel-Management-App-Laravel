# Hotel Management App - Laravel

## Description
`Hotel Management App - Laravel` was the graduation project of some ITI group, instructed by Eng. Ahmed Abd Elftah. <br />
The project contains authentication and authorization for multi guards and multi roles, reservation system and payment through Stipe gateway, CRUD operations on people, rooms and floors, and provides API endpoint that gets staff working in the hotel. <br />
It also contains command to create admin, queues & listeners to notify client and make some actions. <br />
It also fulfills all authentication operations, including email verification and password reset and so on.


## To run it
- clone `https://github.com/amralaaeledin/Hotel-Management-App-Laravel.git`
- create mysql user named `root` with no password
- create mysql database named `hotel_project`
- create an account on [`mailtrap`](mailtrap.io) 
- create a dev account on [`stripe`](https://dashboard.stripe.com/register) 
- add env variables in `.env.example` file:
  - add your database host
  - add your database port

  - add your mailtrap port
  - add your mailtrap username
  - add your mailtrap password

  - add your stripe publishable key
  - add your stripe secret key

- change name of `.env.example` file to `.env`
- install [composer](https://getcomposer.org) and add it to your operating system environment variables
- open terminal in project folder
  - run command `composer install` 
  - run command `npm install` 
  - run command `npm run dev` 
  - run command `php artisan serve` 
- now you can go to `http://localhost:8000/` 

## Endpoints
|          |  Method  |      Endpoint         | Description | 
| :---:    | :---:    |         :---:         | :---: |   
| `root`   | GET      | `/`                   | root welcome page of laravel |
| `admin`  | GET      | `admin/register`      | enables admin to add another admin | 
|          | GET      | `admin/login`         | admin login | 
|          | POST     | `admin/logout`        | admin logout | 
|          | GET      | `admin/dashboard`     | admin dashboard |  
|          | GET      | `admin/managers`      | gets managers of hotel |  
|          | GET      | `admin/receptionists` | gets receptionists of hotel |  
|          | GET      | `admin/clients`       | gets clients of hotel | 
|          | GET      | `admin/floors`        | gets floors of hotel  |
|          | GET      | `admin/rooms`         | gets rooms of hotel | 
|          | GET      | `admin/reservations`  | gets placed reservations | 
|`client`  | GET      |  `client/register`    | client register |  
|          |  GET     |  `client/login`       | client login  |
|          |  POST    |  `client/logout`      | client logout | 
|          |  GET     |  `client/dashboard`   | client dashboard |  
|          |  GET     |  `client/reservations`| gets logged in client reservations |  
|          |  PUT     |  `clients/approve/{client}`| approve client |  
|          |  GET     |  `clients/{client}/edit`   | form to edit client |   
|          |  DELETE  |  `clients/{client}`        | delete client |
|`floor`   | GET      |  `floors` | gets floors of the hotel  | 
|          |  GET     |  `floors/create` | form to create floor | 
|          |  GET     |  `floors/{floor}/edit` | form to edit floor |  
|          |  DELETE  |  `floors/{floor}` | delete floor |
| `room`   |  GET     |  `rooms` | gets rooms of the hotel | 
|          | GET      |  `rooms/create` | form to create room  |
|          | GET      |  `rooms/{room}/edit` | form to edit room |  
|          | DELETE   |  `rooms/{room}` | delete room |
|`manager` |  GET     |  `manager/dashboard` | manager dashboard |
|          | GET      |  `manager/clients` | gets clients  |
|          | GET      |  `manager/receptionists` | gets receptionists in the hotel  |
|          | GET      |  `manager/receptionists/{receptionist}`| ban a receptionist   |
|          | GET      |  `manager/reservations` | gets placed reservations  |
|          | GET      |  `manager/floors` | gets floors of the hotel   |
|          | GET      |  `manager/rooms` | gets rooms of the hotel  |
|          | GET      |  `managers/{manager}/edit` | form to edit manager |  
|          | DELETE   |  `managers/{manager}` | delete manager |
|`receptionist`|  GET |   `receptionist/dashboard` | receptionist dashboard  |
|          | GET      |   `receptionist/clients` | gets not accepted clients so far |  
|          | GET      |   `receptionist/my-clients` | gets clients of logged in receptionist |   
|          | GET      |   `receptionist/reservations` | get reservations of clients of the receptionist |  
|          |  GET     |   `receptionists/{receptionist}/edit` | form to edit receptionist  |
|          |  DELETE  |   `receptionists/{receptionist}` | delete receptionist  |
|`staff`   |  GET     |   `staff/register/{role}` | form to create manager or receptionist |
|`api`     |  POST    |   `api/tokens/create` | receives [email, password, token_name] and generates |token to access `api/staff` endpoint |
|          | GET      |   `api/staff` | gets staff of the hotel - credentials must be of registered staff |account  


## Packages Used 
- laravel/sanctum
- spatie/laravel-permission
- cybercog/laravel-ban
- nesbot/carbon
- yajra/laravel-datatables
- rinvex/countries
- cartalyst/stripe-laravel
- guzzlehttp/guzzle
