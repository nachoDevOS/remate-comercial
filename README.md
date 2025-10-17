<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<!-- <p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/agustinmejia/farmacia/master/public/img/icon.png" width="150"></a></p> -->

# Laravel template  with Voyager

## Instalación
```
composer install
cp .env.example .env
php artisan template:install
```"# remate-comercial" 

> Servidor de Socket.IO.

## Requesitos
- Nodejs >= 22

## Install

```sh
npm install
```

## Modify Developer and Production

```sh
//Developer 
const server = require('http').createServer();

//Production
const server = require('https').createServer({
   key: fs.readFileSync("/etc/letsencrypt/live/rematecomercial-server.soluciondigital.dev/privkey.pem"),
   cert: fs.readFileSync("/etc/letsencrypt/live/rematecomercial-server.soluciondigital.dev/fullchain.pem")
 });
```

## Usage

```sh
npm start
```
