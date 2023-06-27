<p align="center"><a href="https://avyatech.com" target="_blank"><img src="https://www.avyatech.com/wp-content/uploads/2018/05/logo.svg" width="200" alt="Avya Logo"></a></p>

## 🚀 Av Demo Ecom
This is an ecommerce demo app, developed by Avya Tech Pvt. Ltd.

## Technology Used
`Frontend` Next.js v13.4.4, Tailwindcss

`Backend API` Laravel 10, PHP 8.1

`Database` MySql

`API Doc` Postman


## Instruction to be followed to setup

Composer Update: Make a copy of all files on server and then run "composer update"

ENV file changes: Rename the .env.example file to .env and do changes as required

APP_NAME=AvyaDemoEcom

APP_DEBUG=true (true/false)

APP_URL=https://av-ecom-cms.avdemosites.com (domain name)

DB_CONNECTION=mysql

DB_HOST=127.0.0.1 (host)

DB_PORT=3306

DB_DATABASE=avyaecom (database name)

DB_USERNAME=root (database user)

DB_PASSWORD=**** (password)

permission changes

change permission to 777 for "storage" folder

DB migrations

run artisan command to migrate DB: "php artisan migrate"
