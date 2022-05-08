# PHP Login with Unit Test Using Clean Architecture
Simple PHP & MySQL Login Project coded with clean architecture and unit test

---

### Features
* Register User
* Login User

### Prerequisite
* For quick installation, please install XAMPP with PHP 8 at [XAMPP official site](https://www.apachefriends.org/download.html)
* Install composer at [https://getcomposer.org/](Composer official site)

---

### Installation
1. Import/run the populate.sql to your database MySQL. 
2. Run the commands 
```sh
// clone the project
git clone https://github.com/thirthfamous/php-clean-architecture.git

// go to the project directory
cd php-clean-architecture

// install the dependencies
composer install

// run the tests
vendor\bin\phpunit test

// run the server
php -S 127.0.0.1:8080 -t public
```

---

### Architecture
The application architecture follow the Clean Architecture

![Clean Architecture drawio](https://user-images.githubusercontent.com/30696403/167250776-f2cda279-12d7-4132-8565-88f45f124d94.png)
