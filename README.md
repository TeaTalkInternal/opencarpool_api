# opencarpool_api
Restful APi's written in Php backed with mysql for ride sharing or carpooling.

#### You access via POSTMAN too https://documenter.getpostman.com/view/12807879/TVKHVvPi

# Steps to setup

- Please host opencarpool_api in your hosting environment
- Setup your mysql using the SQL_dump.sql file
- Add your credentials in db_connect_credentials.php


#### You may also use the following API hosted at http://teatalk.one/open_carpool


## Indices

* [Ungrouped](#ungrouped)

  * [accept_trip_request](#1-accept_trip_request)
  * [book_trip](#2-book_trip)
  * [create_trip](#3-create_trip)
  * [delete_trip](#4-delete_trip)
  * [edit_trip](#5-edit_trip)
  * [fetch_booked_trips](#6-fetch_booked_trips)
  * [fetch_lat_longs](#7-fetch_lat_longs)
  * [fetch_profile](#8-fetch_profile)
  * [login](#9-login)
  * [reject_trip_request](#10-reject_trip_request)
  * [show_all_trips](#11-show_all_trips)
  * [show_my_trips](#12-show_my_trips)
  * [sign_up](#13-sign_up)
  * [trip_details](#14-trip_details)
  * [unbook_trip](#15-unbook_trip)
  * [update_device_token](#16-update_device_token)


--------


## Ungrouped



### 1. accept_trip_request



***Endpoint:***

```bash
Method: POST
Type: RAW
URL: {{OpenCarpool_Base_URL}}/accept_trip_request.php
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Content-Type | application/json |  |



***Body:***

```js        
{
"ownerEmail" : "kevinvishal347@gmail.com",
	"bookedTripID" : 1526959522,
	"bookieEmail" : "moni@gmail.com",
	"seatsBooked" : 2
}
```



### 2. book_trip



***Endpoint:***

```bash
Method: POST
Type: RAW
URL: {{OpenCarpool_Base_URL}}/book_trip.php
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Content-Type | application/json |  |



***Body:***

```js        
{
	"bookieEmail" : "moni@gmail.com",
	"seatsBooked" : "1",
	"totalSeatsOffered" : "5",
	"ownerEmail" : "kevinvishal347@gmail.com",
	"bookiePhoneNumber" : "8147002674",
	"bookieName" : "kevinvishal347",
	"bookedTripID" : 1518873360,
	"ownerPhoneNumber" : "8147002674",
	"deviceType" : 1
}
```



### 3. create_trip



***Endpoint:***

```bash
Method: POST
Type: RAW
URL: {{OpenCarpool_Base_URL}}/create_trip.php
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Content-Type | application/json |  |
| Authorization | Basic NTU2NzIwOldlbGNvbWVAMTIz |  |



***Body:***

```js        
{
  "trip_path": "",
  "source_name": "Koramangala",
  "destination_name": "Tavant Technologies",
  "source_lat": 12.9027774,
  "source_lng": 77.5881542,
  "destination_lat": 12.9279232,
  "destination_lng": 77.6271078,
  "tripDate": "2019-Aug-27",
  "schedule_type": 1,
  "time_leaving_source": "11:51",
  "time_leaving_destination": "12:52",
  "number_of_seats": 2,
  "traveller_type": 1,
  "trip_type": 1,
  "total_trip_time": "62mins",
  "trip_via": "100 Feet Ring Rd/Outer Ring Rd",
  "total_trip_distance": "7.3 km",
  "phone_number": "8147002674",
  "email": "vaibhav.koppal@tavant.com",
  "is_trip_live": 1,
  "isBooked": 0,
  "isPending": 0,
  "day1": 1,
  "day2": 1,
  "day3": 1,
  "day4": 1,
  "day5": 1,
  "day6": 0,
  "day7": 0,
  "records": [
    {
      "distance": "0.3 km",
      "duration": "2 mins",
      "latitude": "12.9148937",
      "longitude": "77.5882616",
      "rawInstructions": 67267362763
    },
    {
      "distance": "0.2 km",
      "duration": "1 min",
      "latitude": "12.9119933",
      "longitude": "77.5877879",
      "rawInstructions": "Turn left after Trendy Pre - School (on the left)",
      "routeId": 67267362763
    },
    {
      "distance": "1.3 km",
      "duration": "4 mins",
      "latitude": "12.9105318",
      "longitude": "77.58773189999999",
      "rawInstructions": "Turn left onto 9th Cross RdPass by Sree Tirumalagiri Lakshmi Venkateshwara Devasthanam (on the right)",
      "routeId": 67267362763
    },
    {
      "distance": "0.4 km",
      "duration": "1 min",
      "latitude": "12.9106421",
      "longitude": "77.60000719999999",
      "rawInstructions": "Turn left at Jayadev Junction 2 onto 100 Feet Ring Rd/Bannerghatta Main Rd/Outer Ring RdPass by Shilpa Kala Mantap (on the left)",
      "routeId": 67267362763
    },
    {
      "distance": "2.4 km",
      "duration": "6 mins",
      "latitude": "12.9142517",
      "longitude": "77.5998867",
      "rawInstructions": "Keep right to continue on Bannerghatta Main RdPass by the pharmacy (on the left in 1.0&nbsp,km)",
      "routeId": 67267362763
    }
  ]
}
```



### 4. delete_trip



***Endpoint:***

```bash
Method: POST
Type: RAW
URL: {{OpenCarpool_Base_URL}}/delete_trip.php
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Content-Type | application/json |  |
| Authorization | Basic NTU2NzIwOldlbGNvbWVAMTIz |  |



***Body:***

```js        
{
	"unique_trip_id" : 1561617741,
	"ownerEmail" : "kevin.v@tavant.com"
}
```



### 5. edit_trip



***Endpoint:***

```bash
Method: POST
Type: RAW
URL: {{OpenCarpool_Base_URL}}/update_trip.php
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Content-Type | application/json |  |



***Body:***

```js        
{
	"unique_trip_id" : 1560880618,
	"trip_path" : "",
	"source_name" : "J P Nagar Phase 2",
	"destination_name" : "Jayanagar 9 th phase",
	"source_lat" : 12.9027774,
	"source_lng" : 77.5881542,
	"destination_lat" : 12.9279232,
	"destination_lng" : 77.6271078,
	"tripDate":"2019-Aug-17",
	"schedule_type":1,
	"time_leaving_source" : "09:00",
	"time_leaving_destination" : "18:00",
	"number_of_seats" : 1,
	"traveller_type" : 1,
	"trip_type" : 1,
	"total_trip_time" : "63 mins",
	"trip_via" : "100 Feet Ring Rd/Outer Ring Rd",
	"total_trip_distance" : "7.3 km",
	"phone_number" : "8147002674",
	"email" : "kevinvishal347@gmail.com",
	"is_trip_live" : 1,
	"isBooked" : 0,
	"isPending" : 0,
	"day1" : 1,
	"day2" : 1,
	"day3" : 1,
	"day4" : 1,
	"day5" : 1,
	"day6" : 0,
	"day7" : 0,
	"records" : [
   {
      "distance":"0.3 km",
      "duration":"2 mins",
      "latitude":"12.9148937",
      "longitude":"77.5882616",
      "rawInstructions":67267362763
   },
   {
      "distance":"0.2 km",
      "duration":"1 min",
      "latitude":"12.9119933",
      "longitude":"77.5877879",
      "rawInstructions":"Turn left after Trendy Pre - School (on the left)",
      "routeId":67267362763
   },
   {
      "distance":"1.3 km",
      "duration":"4 mins",
      "latitude":"12.9105318",
      "longitude":"77.58773189999999",
      "rawInstructions":"Turn left onto 9th Cross RdPass by Sree Tirumalagiri Lakshmi Venkateshwara Devasthanam (on the right)",
      "routeId":67267362763
   },
   {
      "distance":"0.4 km",
      "duration":"1 min",
      "latitude":"12.9106421",
      "longitude":"77.60000719999999",
      "rawInstructions":"Turn left at Jayadev Junction 2 onto 100 Feet Ring Rd/Bannerghatta Main Rd/Outer Ring RdPass by Shilpa Kala Mantap (on the left)",
      "routeId":67267362763
   },
   {
      "distance":"2.4 km",
      "duration":"6 mins",
      "latitude":"12.9142517",
      "longitude":"77.5998867",
      "rawInstructions":"Keep right to continue on Bannerghatta Main RdPass by the pharmacy (on the left in 1.0&nbsp,km)",
      "routeId":67267362763
   }]
}
```



### 6. fetch_booked_trips



***Endpoint:***

```bash
Method: GET
Type: 
URL: {{OpenCarpool_Base_URL}}/fetch_booked_trips.php
```



***Query params:***

| Key | Value | Description |
| --- | ------|-------------|
| email | moni@gmail.com |  |



### 7. fetch_lat_longs



***Endpoint:***

```bash
Method: GET
Type: 
URL: {{OpenCarpool_Base_URL}}/fetchLatLongs.php
```



***Query params:***

| Key | Value | Description |
| --- | ------|-------------|
| routeId | 1519959519 |  |



### 8. fetch_profile


fetch profile


***Endpoint:***

```bash
Method: GET
Type: 
URL: {{OpenCarpool_Base_URL}}/fetch_profile.php
```



***Query params:***

| Key | Value | Description |
| --- | ------|-------------|
| email | kevin.v@tavant.com |  |



### 9. login


Login


***Endpoint:***

```bash
Method: POST
Type: RAW
URL: {{OpenCarpool_Base_URL}}/login_pool.php
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Content-Type | application/json |  |



***Body:***

```js        
{
"email" : "vaibhav.koppal@tavant.com",
"deviceToken" : "676eruvfeg78r3ewurb3y3d3hkir439r3rhkfh",
"deviceType" : 2,
"password" : "123456"
}

```



### 10. reject_trip_request



***Endpoint:***

```bash
Method: POST
Type: RAW
URL: {{OpenCarpool_Base_URL}}/reject_trip_request.php
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Content-Type | application/json |  |



***Body:***

```js        
{
	"ownerEmail" : "kevinvishal347@gmail.com",
	"bookedTripID" : 1560880618,
	"bookieEmail" : "moni@gmail.com",
	"seatsBooked" : 2
}
```



### 11. show_all_trips


Show All Trips


***Endpoint:***

```bash
Method: GET
Type: 
URL: {{OpenCarpool_Base_URL}}/show_all_trips_with_filter.php
```



***Query params:***

| Key | Value | Description |
| --- | ------|-------------|
| email | vaibhav.koppal@tavant.com |  |



### 12. show_my_trips


My Trips


***Endpoint:***

```bash
Method: GET
Type: 
URL: {{OpenCarpool_Base_URL}}/show_my_trips.php
```



***Query params:***

| Key | Value | Description |
| --- | ------|-------------|
| email | kevinvishal347@gmail.com |  |



### 13. sign_up


Sign Up


***Endpoint:***

```bash
Method: POST
Type: RAW
URL: {{OpenCarpool_Base_URL}}/sign_up_pool.php
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Content-Type | application/json |  |



***Body:***

```js        
{
"username" : "Vaibhav126",
"email" : "vaibhav12678@gmail.com",
"phonenumber" : "8147002675",
"deviceToken" : "676eruvfeg78r3ewurb3y3d3hkir439r3rhkfh",
"deviceType" : 2,
"password" : "123456"

}


```



### 14. trip_details


Trip Details


***Endpoint:***

```bash
Method: GET
Type: 
URL: {{OpenCarpool_Base_URL}}/fetch_trip_via_id.php
```



***Query params:***

| Key | Value | Description |
| --- | ------|-------------|
| trip_id | 1518873360 |  |



### 15. unbook_trip



***Endpoint:***

```bash
Method: POST
Type: RAW
URL: {{OpenCarpool_Base_URL}}/unbook_trip.php
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Content-Type | application/json |  |



***Body:***

```js        
{
	"bookieEmail" : "kevinvishal347@gmail.com",
	"bookedTripID" : 1526959522,
	"ownerEmail" : "moni@gmail.com",
	"seatsBooked" : 2
}
```



### 16. update_device_token



***Endpoint:***

```bash
Method: POST
Type: RAW
URL: {{OpenCarpool_Base_URL}}/update_device_token.php
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Content-Type | application/json |  |



***Body:***

```js        
{
"email" : "moni@gmail.com",
"deviceToken" : "555556MMMM76eruvfeg78r3ewurb3y3d3hkir439r3rhkfh",
"deviceType" : 2
}

```



---
[Back to top](#opencarpool)
> Made with &#9829; by [thedevsaddam](https://github.com/thedevsaddam) | Generated at: 2020-09-28 13:07:45 by [docgen](https://github.com/thedevsaddam/docgen)

