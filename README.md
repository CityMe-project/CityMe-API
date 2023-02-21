# CityMe Laravel API

## The project

The CityMe project aims at creating a framework for mapping, exploring and analyzing official and non-official neighborhoods, regions of interest, districts and other areas that constitute people’s mental map of the city. By harvesting data from our map-based application and social media platforms, we can better understand how citizens spatially reason about administrative and non-administrative regions in the urban landscape, such as parishes, residential areas, informal neighborhoods, historical centers and commercial areas.
[More information](https://github.com/CityMe-project/cityme)

## 🎓 Objectives

- **Make available a web map survey and questionnaire interface**
- Perform spatial analysis to compare and characterize the regions from surveyed data and user-generated content from social media
- Evaluate survey results based on sociodemographic attributes
- Explore results based on administrative boundaries, official names, census blocks, urban morphology, landmarks and points of interest

## API

The API allow seamless communication with the [APP](https://github.com/cleitonro/cityme-app) creating and consuming the data from the data base to the site/map vice versa.

## Methods
API requests must follow the standards:
| Method | Description |
|---|---|
| `GET` | Returns information from one or more records. |
| `POST` | Used to create a new record. |
| `PUT` | Update registration data or change your status. |
| `DELETE` | Removes a system registry. |

## Answers

| Code | Description |
|---|---|
| `200` | Request executed successfully (success).|
| `400` | Validation errors or entered fields do not exist in the system.|
| `401` | Invalid access data.|
| `404` | Searched record not found.|
| `405` | Method not implemented.|
| `410` | The searched record has been deleted from the system and is no longer available.|
| `422` | The data entered is outside the scope defined for the field.|
| `429` | Maximum number of requests reached. (*wait a few seconds and try again*)|

## Limits (limitation)
There is a limit of `60` requests per minute per app+user.
You can track these limits in the `headers`: `X-RateLimit-Limit`, `X-RateLimit-Remaining` sent in all API responses.
`list` actions display `50` records per page. It is not possible to change this number.
For security reasons, all requests must be made through the `HTTPS` protocol.

## Routes

| Method | Route | Description |
|---|---|---|
| `POST` | login | Use to enter in the [web version](https://github.com/cleitonro/cityme-web) on the survey section. |
| `POST` | register | Use to register in the [web version](https://github.com/cleitonro/cityme-web) on the survey section. |
| `POST` | loginVerify | System to auto login with a token. |
| `GET` | surveys | Get surveys information. |
| `GET` | surveys/user | Get a survey with logged user information. |
| `POST` | surveys/submit | Submit a valid survey. |
| `GET` | questions | Get all questions with section/subsection/options. |
| `GET` | answers/survey | Get the logged user answers. |
| `POST` | answers | Save logged user answers. |
| `GET` | geometries/survey | Get the logged user geometries. |
| `POST` | geometries | Save logged user geometries. |
| `GET` | geometries/output | Get 10 random surveys with geometries. |

## Important
This is my first Laravel API, the app does not have a seeder, you must initialize the database with *php artisan migrate* then restore a blank database with all mandatory data(can be found here "link").

## Build the app
- Clone the project
- Go to the folder application using cd command on your cmd or terminal
- Run *composer install* on your cmd or terminal
- Copy .env.example file to .env on the root folder. You can type copy .env.example .env if using command prompt Windows or cp .env.example .env if using terminal, Ubuntu
- Open your .env file and change the database name (DB_DATABASE) to whatever you have, username (DB_USERNAME) and password (DB_PASSWORD) field correspond to your configuration.
- Run php artisan key:generate
- Run php artisan migrate
- Run php artisan serve
- Go to http://localhost:8000/

## This was possible with 
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="200"></a></p>
</p>

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
