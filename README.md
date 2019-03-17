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

## Tests

```bash
cp phpunit.xml.dist phpunit.xml

php vendor/bin/phpunit
```

## Install

1. Clone this repository

```bash
git clone https://github.com/ferdyrurka/weather-app.git
```

2. Complete the variable in .env.dist and rename .env.dist file

```bash
cp .env.dist .env
```

3. Create directories

```bash
mkdir var
mkdir var/cache
chmod 777 var/cache
```

4. Composer

```bash
composer install
```

5. Run docker 

```bash
docker-compose up -d
```

4. First endpoint found in the url: http://localhost/api/v1/get-current-weather/{cityName}
 and using method HTTP GET
 
 Example request: http://localhost/api/v1/get-current-weather/Kraków
 
5. Second endpoint found in the url: http://localhost/api/v1/get-last-save-weather/{cityName}
 and using method HTTP GET
 
 Example request: http://localhost/api/v1/get-last-save-weather/Kraków
 
## License

* None

## Author

* Łukasz Staniszewski < kontakt@lukaszstaniszewski.pl >