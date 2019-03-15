# Weather app

[![Build Status](https://travis-ci.org/ferdyrurka/weather-app.svg?branch=master)](https://travis-ci.org/ferdyrurka/weather-app)

[![Coverage Status](https://coveralls.io/repos/github/ferdyrurka/weather-app/badge.svg?branch=master)](https://coveralls.io/github/ferdyrurka/weather-app?branch=master)

## Task

Prepare two REST endpoints in Symfony 4 using PHP 7.2 and share it on GitHub:

1. to get current weather from https://openweathermap.org/current by city name
     save all data into a database

2. get data provided in the first endpoint (so from our application database) by city name.

## Dilemmas

1. First option is save ready data (array) and city name and 
   second option is save all data to columns and tables.
    * I choose first option because I don't anticipate further 
    development of the application. If this application would be continuously 
    developed and the API capabilities would be modified, I would choose the second option. 

## License

* None

## Author

* Łukasz Staniszewski < kontakt@lukaszstaniszewski.pl >