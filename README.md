# Aspireapp
A mini version of Aspire app.  This is code challenge test before techincal interviewing of Aspire company.  
This App requires: `PHP 7.2.5`, `Composer` 
# Set up
Make sure to do the follow steps to set up the app.  
Run command `composer install` to install all dependencies.  
Database: this app is using `sqlite` database to help you easier in setting up. You don't need to configure database, the system configured already. The database is placed at `db/aspireapp.db `.  
Run `php bin/console doctrine:migrations:migrate` to migrate database table structure.  
Run `php bin/console doctrine:fixtures:load` to init login info. This command will create 2 users for system. They are:  
> `demo@aspireapp.com / pwd123` --> Normal user.  
> `admin@aspireapp.com / adminpwd123` --> Admin user.

Run: `php -S 127.0.0.1:8000 -t public`  to start the web server. You can access web server with URL: `http://localhost:8000`.  
If you got any problem with port 8000. Please choose another free port on your PC.  
 


