
#### A Laravel application for managing the subscribers of a MailerLite account via the MailerLite API.

## INSTALLATION INSTRUCTIONS

#### **MySQL database setup**

- Install PHP 7.4 and MySQL 5.x on your local machine.
- Download or clone the project to your local machine.
- Install Composer. You can download Composer from the official Composer website. Follow the installation instructions for your operating system.


#### **MySQL database setup** 

- Open a command prompt or terminal window.
- Log in to MySQL with administrative privileges by entering the following command:
```
mysql -u root -p

```
_This will prompt you for your MySQL root password._

- Once you are logged in, enter the following command to create a new database:
```
CREATE DATABASE dbname;
```
_Replace `dbname` with the name of the database you want to create._

- To restore the database dump provided in the project  to your new database, follow these steps:
  - Navigate to the project directory
  -  Run the following command to restore the database dump:
```
mysql -u username -p dbname < dumpfile.sql

```
_Replace `username` with your MySQL username, `dbname` with the name of the database you created in the previous section._


### Installing Dependencies and running the project

- Open a terminal window or command prompt and navigate to the project directory.

- Install the project dependencies by running the following command:
  
```
composer install
```
- Copy the `.env.example` file in the project root directory to `.env` and update the database settings to match your MySQL installation:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_mysql_username
DB_PASSWORD=your_mysql_password 

```
- Generate an application key by running the following command:
```
php artisan key:generate

```
- Start the development server by running the following command:
```
php artisan serve
```
- Open your web browser and go to http://localhost:8000 to see the project running locally. 

