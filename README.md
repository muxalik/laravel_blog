<div align="center">
<a href="https://github.com/muxailk/laravel_blog">

![home page](https://github.com/muxailk/laravel_blog/blob/master/public/images/readme/logo.png)

</a>
</div>

<h1 align="center">Laravel Blog</h1>
<p align="center"><a href="https://github.com/josuapsianturi/velflix/blob/main/LICENSE"><img src="https://poser.pugx.org/cpriego/valet-linux/license.svg" alt="License"></a>
</p>

## About

Laravel Blog is a Laravel testing project using stack (Laravel, Pest,).

> **Note**
>   Work is still in Progress

## Table of Contents

* [Screenshots](#screenshots)
* [Requirements](#requirements)
* [Installation](#installation)
* [Testing](#testing)
* [License](#license)

<a name="screenshots"></a>
## Screenshots

![home page](https://github.com/muxailk/laravel_blog/blob/master/public/images/readme/Screenshot_1.jpg)

[main](https://github.com/muxailk/laravel_blog/blob/master/public/images/readme/Screenshot_2.jpg)

![footer](https://github.com/muxailk/laravel_blog/blob/master/public/images/readme/Screenshot_3.jpg)

![admin home 1](https://github.com/muxailk/laravel_blog/blob/master/public/images/readme/Screenshot_4.jpg)

[admin home 2](https://github.com/muxailk/laravel_blog/blob/master/public/images/readme/Screenshot_5.jpg)

![admin posts](https://github.com/muxailk/laravel_blog/blob/master/public/images/readme/Screenshot_6.jpg)

<a name="requirements"></a>
## Requirements

Package | Version
--- | ---
[Node](https://nodejs.org/en/) | V16.16.0+
[Npm](https://nodejs.org/en/)  | V8.11.0+ 
[Composer](https://getcomposer.org/)  | V2.2.5+
[Php](https://www.php.net/)  | V8.0.2+
[Mysql](https://www.mysql.com/)  |V5.7+

<a name="installation"></a>
## Installation

> **Warning**
>   Make sure to follow the requirements first.

Here is how you can run the project locally:
1. Clone this repo
    ```sh
    git clone https://github.com/josuapsianturi/velflix.git
    ```

1. Go into the project root directory
    ```sh
    cd velflix
    ```

1. Copy .env.example file to .env file
    ```sh
    cp .env.example .env
    ```
1. Create database `velflix` (you can change database name)

1. Create account and get an API key themoviedb [ here](https://www.themoviedb.org/settings/api). Make sure to copy `API Read Access Token (v4 auth)`.

1. Go to `.env` file 
    - set database credentials (`DB_DATABASE=velflix`, `DB_USERNAME=root`, `DB_PASSWORD=`)
    - paste `TMDB_TOKEN=(your API key)` 
    > Make sure to follow your database username and password

1. Install PHP dependencies 
    ```sh
    composer install
    ```

1. Generate key 
    ```sh
    php artisan key:generate
    ```

1. install front-end dependencies
    ```sh
    npm install && npx mix
    ```

1. Run migration
    ```
    php artisan migrate
    ```
    
1. Run seeder
    ```
    php artisan db:seed
    ```
    this command will create 2 users (admin and normal user):
     > email: admin@gmail.com , password: password

     > email: user@gmail.com , password: password 

1. Run server 
    > for valet users visit `velflix.test` in your favorite browser
   
    ```sh
    php artisan serve
    ```  

1. Visit `localhost:8000` in your favorite browser.     

    > Make sure to follow your Laravel local Development Environment.

<a name="testing"></a>
## Testing

> **Warning** <br>
> Testing database is not set up!
> Every time running tests you work with primary database.<br> Be careful with your data safety!

```sh
./vendor/bin/pest
```


<a name="license"></a>

## License
Laravel Blog is an open-sourced software licensed under [the MIT license](https://github.com/muxailk/laravel_blog/blob/main/LICENSE)
