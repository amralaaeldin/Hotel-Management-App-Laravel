# Hotel Management App - Laravel 

## Description


## To run it


## Endpoints
- `root`
 GET|HEAD        / .............................................................................   

- `admin`
GET|HEAD        admin/register ..... admin.register › AdminAuth\RegisteredUserController@create  
GET|HEAD        admin/login ..... admin.login › AdminAuth\AuthenticatedSessionController@create  
POST            admin/logout .. admin.logout › AdminAuth\AuthenticatedSessionController@destroy  
GET|HEAD        admin/dashboard ............................................... admin.dashboard  
GET|HEAD        admin/managers ........................................ ManagerController@index  
GET|HEAD        admin/receptionists .............................. ReceptionistController@index  
GET|HEAD        admin/clients .......................................... ClientController@index  
GET|HEAD        admin/floors ............................................ FloorController@index  
GET|HEAD        admin/rooms .............................................. RoomController@index  
GET|HEAD        admin/reservations ................................ ReservationController@index  

- `client`
GET|HEAD        client/register .. client.register › ClientAuth\RegisteredUserController@create  
GET|HEAD        client/login .. client.login › ClientAuth\AuthenticatedSessionController@create  
POST            client/logout client.logout › ClientAuth\AuthenticatedSessionController@destroy  
GET|HEAD        client/dashboard ............................................. client.dashboard  
GET|HEAD        client/reservations ............... ReservationController@getClientReservations  
GET|HEAD        clients ................................ clients.index › ClientController@index  
PUT             clients/approve/{client} ........... clients.approve › ClientController@approve  
GET|HEAD        clients/{client}/edit .................... clients.edit › ClientController@edit  
PUT|PATCH       clients/{client} ..................... clients.update › ClientController@update  
DELETE          clients/{client} ................... clients.destroy › ClientController@destroy  

- `floor`
GET|HEAD        floors ................................... floors.index › FloorController@index  
POST            floors ................................... floors.store › FloorController@store  
GET|HEAD        floors/create .......................... floors.create › FloorController@create  
GET|HEAD        floors/{floor}/edit ........................ floors.edit › FloorController@edit  
PUT             floors/{floor} ......................... floors.update › FloorController@update  
DELETE          floors/{floor} ....................... floors.destroy › FloorController@destroy  

- `manager`
GET|HEAD        manager/dashboard ........................................... manager.dashboard  
GET|HEAD        manager/clients ........................................ ClientController@index  
GET|HEAD        manager/floors .......................................... FloorController@index  
GET|HEAD        manager/receptionists ............................ ReceptionistController@index  
GET|HEAD        manager/receptionists/{receptionist} receptionists.ban › ReceptionistControlle…  
GET|HEAD        manager/reservations .............................. ReservationController@index  
GET|HEAD        manager/rooms ............................................ RoomController@index  
GET|HEAD        managers ............................. managers.index › ManagerController@index  
GET|HEAD        managers/{manager}/edit ................ managers.edit › ManagerController@edit  
PUT|PATCH       managers/{manager} ................. managers.update › ManagerController@update  
DELETE          managers/{manager} ............... managers.destroy › ManagerController@destroy  

- `receptionist`
GET|HEAD        receptionist/dashboard ................................. receptionist.dashboard  
GET|HEAD        receptionist/clients ....................... ClientController@getNotAcceptedYet  
GET|HEAD        receptionist/my-clients ........................ ClientController@getMyAccepted  
GET|HEAD        receptionist/reservations ReservationController@getAcceptedClientsReservations   
GET|HEAD        receptionists .............. receptionists.index › ReceptionistController@index  
GET|HEAD        receptionists/{receptionist}/edit receptionists.edit › ReceptionistController@…  
PUT|PATCH       receptionists/{receptionist} receptionists.update › ReceptionistController@upd…  
DELETE          receptionists/{receptionist} receptionists.destroy › ReceptionistController@de…  

- `reservations`
GET|HEAD        reservations ................. reservations.index › ReservationController@index  
GET|HEAD        reservations/success ..... reservations.confirm › ReservationController@confirm  

- `staff`
GET|HEAD        staff/register/{role} ... staff.register › Auth\RegisteredUserController@create
POST            staff/register/{role} ....... staff.store › Auth\RegisteredUserController@store

- `api`
GET|HEAD        api/staff ........................................... Api\StaffController@index  
POST            api/tokens/create .............................................................  
