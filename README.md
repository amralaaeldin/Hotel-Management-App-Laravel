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
- `root`
 GET        / .............................................................................   

- `admin`
GET   |     `admin/register` ..... admin.register › AdminAuth\RegisteredUserController@create  
GET   |     `admin/login` ..... admin.login › AdminAuth\AuthenticatedSessionController@create  
POST  |     `admin/logout` .. admin.logout › AdminAuth\AuthenticatedSessionController@destroy  
GET   |     `admin/dashboard` ............................................... admin.dashboard  
GET   |     `admin/managers` ........................................ ManagerController@index  
GET   |     `admin/receptionists` .............................. ReceptionistController@index  
GET   |     `admin/clients` .......................................... ClientController@index  
GET   |     `admin/floors` ............................................ FloorController@index  
GET   |     `admin/rooms` .............................................. RoomController@index  
GET   |     `admin/reservations` ................................ ReservationController@index  

- `client`
GET        client/register .. client.register › ClientAuth\RegisteredUserController@create  
GET        client/login .. client.login › ClientAuth\AuthenticatedSessionController@create  
POST            client/logout client.logout › ClientAuth\AuthenticatedSessionController@destroy  
GET        client/dashboard ............................................. client.dashboard  
GET        client/reservations ............... ReservationController@getClientReservations  
GET        clients ................................ clients.index › ClientController@index  
PUT             clients/approve/{client} ........... clients.approve › ClientController@approve  
GET        clients/{client}/edit .................... clients.edit › ClientController@edit  
PUT|PATCH       clients/{client} ..................... clients.update › ClientController@update  
DELETE          clients/{client} ................... clients.destroy › ClientController@destroy  

- `floor`
GET        floors ................................... floors.index › FloorController@index  
POST            floors ................................... floors.store › FloorController@store  
GET        floors/create .......................... floors.create › FloorController@create  
GET        floors/{floor}/edit ........................ floors.edit › FloorController@edit  
PUT             floors/{floor} ......................... floors.update › FloorController@update  
DELETE          floors/{floor} ....................... floors.destroy › FloorController@destroy  

- `manager`
GET        manager/dashboard ........................................... manager.dashboard  
GET        manager/clients ........................................ ClientController@index  
GET        manager/floors .......................................... FloorController@index  
GET        manager/receptionists ............................ ReceptionistController@index  
GET        manager/receptionists/{receptionist} receptionists.ban › ReceptionistControlle…  
GET        manager/reservations .............................. ReservationController@index  
GET        manager/rooms ............................................ RoomController@index  
GET        managers ............................. managers.index › ManagerController@index  
GET        managers/{manager}/edit ................ managers.edit › ManagerController@edit  
PUT|PATCH       managers/{manager} ................. managers.update › ManagerController@update  
DELETE          managers/{manager} ............... managers.destroy › ManagerController@destroy  

- `receptionist`
GET        receptionist/dashboard ................................. receptionist.dashboard  
GET        receptionist/clients ....................... ClientController@getNotAcceptedYet  
GET        receptionist/my-clients ........................ ClientController@getMyAccepted  
GET        receptionist/reservations ReservationController@getAcceptedClientsReservations   
GET        receptionists .............. receptionists.index › ReceptionistController@index  
GET        receptionists/{receptionist}/edit receptionists.edit › ReceptionistController@…  
PUT|PATCH       receptionists/{receptionist} receptionists.update › ReceptionistController@upd…  
DELETE          receptionists/{receptionist} receptionists.destroy › ReceptionistController@de…  

- `reservations`
GET        reservations ................. reservations.index › ReservationController@index  
GET        reservations/success ..... reservations.confirm › ReservationController@confirm  

- `staff`
GET        staff/register/{role} ... staff.register › Auth\RegisteredUserController@create
POST            staff/register/{role} ....... staff.store › Auth\RegisteredUserController@store

- `api`
GET        api/staff ........................................... Api\StaffController@index  
POST            api/tokens/create .............................................................  
