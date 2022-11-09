# PHP Assignment - Forum - Setup Guide

Developer: **Tauseef Ahamed**

API documentation url: https://documenter.getpostman.com/view/23252632/2s8YeiwbY5

## Requirements
- PHP 8
- Composer 
- MySql


## Setup Instructions

### Step 1

Set up git clone of the project repo on the local environment.
  
### Step 2

Run the following composer command for install the php dependencies.

`composer update`

### Step 3

Copy the **.env.example** file to the root directory and rename it as **.env**, update the database credentials in the **.env** file.

### Step 4

Run the following cli command for generate the application key. 

`php artisan key:generate`

### Step 5

Run the following command Migrating the database and insert sample data to the application

`php artisan migrate --seed`

if above command isn't working run this command `php artisan migrate:fresh --seed`

### Step 6

Run the following command for start the php laravel in build server

`php artisan serve`

The application will run in **8000** port. You can access the application from http://localhost:8000

### Step 7

Please give write permission for public/uploads folder for support the upload image feature.


============================================================

Thank you
