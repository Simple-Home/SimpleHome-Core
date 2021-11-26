<p align="center">
  <a href="https://github.com/Simple-Home/Simple-Home">
    <img src="https://simple-home.github.io/documentation/0.2/img/logo.svg" height="100" width="100">
  </a>
  <h1 align="center">Simple Home V4</h3>
  <h3 align="center">Make your own simple smart home & automation system</h3>
  <p align="center">
    <a href="https://simple-home.github.io/documentation/0.2/">Documentation</a>
    <sub><sup>•</sub></sup>
    <a href="https://github.com/Simple-Home/Simple-Home/issues">Report bugs</a>
  </p>
  <p align="center">
    <a href="https://github.com/Simple-Home/Simple-Home/search?l=php">
        <img src="https://img.shields.io/badge/PHP-brightgreen.svg"/>
    </a>
    <a href="https://laravel.com/">
        <img src="https://img.shields.io/badge/framework-Laravel-red.svg"/>
    </a>
    <a href="https://github.com/Simple-Home/Simple-Home/search?l=js">
        <img src="https://img.shields.io/badge/JS-red.svg"/>
    </a>
    <a href="https://github.com/Simple-Home/Simple-Home/search?l=html">
        <img src="https://img.shields.io/badge/HTML-blue.svg"/>
    </a>
    <a href="https://discord.gg/XJpT3UQ">
        <img src="https://img.shields.io/discord/604697675430101003.svg?color=Blue&label=Discord&logo=Discord"/>
    </a>
    <a href="./LICENSE">
        <img src="https://img.shields.io/badge/License-MIT-yellow.svg"/>
    </a>
  </p>
</p>

## Server Requirements
* PHP 7.4 or greater.
* PHP [cURL extension](https://www.php.net/manual/en/book.curl.php)
* PHP [mySQLi extension](https://www.php.net/manual/en/book.mysqli.php)
* PHP [mbstring extension](https://www.php.net/manual/en/book.mbstring.php)
* PHP [xml extension](https://www.php.net/manual/en/book.dom.php)
* PHP [dom extension](https://www.php.net/manual/en/book.dom.php)
* Composer
* MySQL Server

## Installation
* Download the Simple Home Project to your web server (/var/www/)  
  ```git clone https://github.com/Simple-Home/Simple-Home.git```
* cd into the LAR_v4_Simple_Home_Server-master
* Run the command: ```composer install```
* Run the command: ```npm install && npm run production``` 
* Run the command: ```php artisan passport:install``` 
* Create a database in MySQL
* Visit your webservers URL and proceed with setup

## License
Distributed under the MIT License. See `LICENSE` for more information.

## Contributors
<a href="https://github.com/Simple-Home/Simple-Home/graphs/contributors">
  <img src="https://contrib.rocks/image?repo=Simple-Home/Simple-Home" />
</a>

## Few Images:
![Login](https://user-images.githubusercontent.com/22167469/136594442-137416f0-2e24-45d9-bda2-3435d88b1489.png)
![MainBoard](https://user-images.githubusercontent.com/22167469/136594502-92fa0793-bc15-4144-879e-6f7057b0c0c2.png)
![Detail](https://user-images.githubusercontent.com/22167469/136594548-8d0d57e8-45e8-4da9-9548-aff98de98ef8.png)
![DeviceControl](https://user-images.githubusercontent.com/22167469/136594627-b0836230-fb32-407a-9ee0-e4dac7c58639.png)
![integrationsManagments](https://user-images.githubusercontent.com/22167469/136594672-4620c890-afca-495d-af27-97aa65109f04.png)

## Comunity
[![Join our Discord server!](https://invidget.switchblade.xyz/XJpT3UQ)](http://discord.gg/XJpT3UQ)

## SFTP Config
```json
{
    "name": "Simple-Home",
    "host": "",
    "protocol": "sftp",
    "port": 22,
    "username": "",
    "password": "",
    "remotePath": "/",
    "uploadOnSave": true,
    "useTempFile": true,
    "openSsh": true,
    "ignore": [
        ".vscode",
        ".git",
        ".DS_Store",
        ".gitkeep",
        ".TODO",
        ".TODO",
        "README.md",
        "LICENSE",
        "virtualDevice.ps1",
        ".editorconfig",
        ".example"
    ]
}
```
