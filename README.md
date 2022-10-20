# Hotel Management App - Laravel

## Description
`Hotel Management App - Laravel` was the graduation project of some ITI group, instructed by Eng. Ahmed Abd Elftah

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
-now you can go to `http://localhost:8000/` 

## Endpoints
- `root` <br />
  GET   |     `/` ............................................ root welcome page of laravel   
- `admin` <br />
  GET        |  `admin/register` ..... admin.register › AdminAuth\RegisteredUserController@create  
  GET        |  `admin/login` ..... admin.login › AdminAuth\AuthenticatedSessionController@create  
  POST       |  `admin/logout` .. admin.logout › AdminAuth\AuthenticatedSessionController@destroy  
  GET        |  `admin/dashboard` ............................................... admin.dashboard  
  GET        |  `admin/managers` ........................................ ManagerController@index  
  GET        |  `admin/receptionists` .............................. ReceptionistController@index  
  GET        |  `admin/clients` .......................................... ClientController@index  
  GET        |  `admin/floors` ............................................ FloorController@index  
  GET        |  `admin/rooms` .............................................. RoomController@index  
  GET        |  `admin/reservations` ................................ ReservationController@index 
- `client` <br />
  GET        |  `client/register` .. client.register › ClientAuth\RegisteredUserController@create  
  GET        |  `client/login` .. client.login › ClientAuth\AuthenticatedSessionController@create  
  POST       |  `client/logout` client.logout › ClientAuth\AuthenticatedSessionController@destroy  
  GET        |  `client/dashboard` ............................................. client.dashboard  
  GET        |  `client/reservations` ............... ReservationController@getClientReservations  
  GET        |  `clients` ................................ clients.index › ClientController@index  
  PUT        |  `clients/approve/{client}` ........... clients.approve › ClientController@approve  
  GET        |  `clients/{client}/edit` .................... clients.edit › ClientController@edit  
  PUT|PATCH  |  `clients/{client}` ..................... clients.update › ClientController@update  
  DELETE     |  `clients/{client}` ................... clients.destroy › ClientController@destroy 
- `floor` <br />
  GET        |  `floors` ................................. get floors of the hotel  
  GET        |  `floors/create` .......................... form to create floor  
  GET        |  `floors/{floor}/edit` .................... form to edit floor  
  DELETE     |  `floors/{floor}` ......................... form to delete floor 
- `room` <br />
  GET        |  `rooms` .................................. get rooms of the hotel  
  GET        |  `rooms/create` ........................... form to create room  
  GET        |  `rooms/{room}/edit` ...................... form to edit room  
  DELETE     |  `rooms/{room}` ........................... form to delete room 
- `manager` <br />
  GET        |  `manager/dashboard` ........................................... manager.dashboard  
  GET        |  `manager/clients` ........................................ ClientController@index  
  GET        |  `manager/floors` .......................................... FloorController@index  
  GET        |  `manager/receptionists` ............................ ReceptionistController@index  
  GET        |  `manager/receptionists/{receptionist}` receptionists.ban › ReceptionistControlle…  
  GET        |  `manager/reservations` .............................. ReservationController@index  
  GET        |  `manager/rooms` ............................................ RoomController@index  
  GET        |  `managers` ............................. managers.index › ManagerController@index  
  GET        |  `managers/{manager}/edit` ................ managers.edit › ManagerController@edit  
  PUT|PATCH  |  `managers/{manager}` ................. managers.update › ManagerController@update  
  DELETE     |  `managers/{manager}` ............... managers.destroy › ManagerController@destroy 
- `receptionist` <br />
  GET        |   `receptionist/dashboard` ................................. receptionist.dashboard  
  GET        |   `receptionist/clients` ....................... ClientController@getNotAcceptedYet  
  GET        |   `receptionist/my-clients` ........................ ClientController@getMyAccepted  
  GET        |   `receptionist/reservations` ReservationController@getAcceptedClientsReservations   
  GET        |   `receptionists` .............. receptionists.index › ReceptionistController@index  
  GET        |   `receptionists/{receptionist}/edit` receptionists.edit › ReceptionistController@…  
  PUT|PATCH  |   `receptionists/{receptionist}` receptionists.update › ReceptionistController@upd…  
  DELETE     |   `receptionists/{receptionist}` receptionists.destroy › ReceptionistController@de… 
- `reservations` <br />
  GET        |   `reservations` ............. gets placed reservations   
- `staff` <br />
  GET        |   `staff/register/{role}` .... form to add manager or receptionist
- `api` <br />
  POST       |   `api/tokens/create` ........ receives [email, password, token_name] and generates token to access `api/staff` endpoint
  GET        |   `api/staff` ................ gets staff of the hotel  
  - credentials must be of registered staff account  