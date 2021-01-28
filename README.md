# TimeAndPlace
:apple: **Logger software.** _This software needs a good written description. Until then, see the help file._

**While this software was written entirely by me, it was based on the [Bluepanel](https://github.com/Volxz/BluePanel) software written by Ethan Gallant.**

:dart: Ethan Gallant provided the inspiration, design, prototyping, and beta testing for the bulk of this project via his BluePanel app.

:orange: You can see a working demonstration of TimeAndPlace at https://demo.iquark.ca

---------------------

How to install from a GitHub repo
===================================


Assume that npm is already installed ...

Installing Laravel
* Laravel version 7.x
* Node JS version 12.x
* using PHP version 7.3

0. stop mysql server on AWS machines as they are typically limited in RAM
   `sudo service mysql stop`
  
1. Create a linux user and change to user of account   
   
............................
2. Install Composer 
..............................

a) Run  sh composer.install.sh (get latest copy of this script from https://getcomposer.org)
OR: https://getcomposer.org/doc/faqs/how-to-install-composer-programmatically.md

```
#!/bin/bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'e0012edf3e80b6978849f5eff0d4b4e4c79ff1609dd1e613307e16318854d24ae64f26d17af3ef0bf7cfb710ca74755a') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```

b) Add this to the path in .profile: $HOME/.config/composer/vendor/bin ...

`echo 'PATH="$HOME/.config/composer/vendor/bin:$PATH"' >> ~/.profile`

c) Make a link to composer: 

```
mkdir ~/bin
mv composer.phar  ~/bin/
cd bin
ln -s composer.phar composer
cd
```

d) logout and log in again so that ./profile will add ~/bin to the path

.......................................
END of Install Composer 
.......................................

3. `git clone https://github.com/salamander2/TimeAndPlace.git`

4. `cd ~/TimeAndPlace`

5. `composer install`

6. `npm i fsevents@latest -f --save-optional`
   `npm install`

7. comment out gradient backgrounds. 

  > `vi node_modules/bootstrap/scss/mixins/_background-variant.scss`
  Comment out the two lines that start "@include deprecate"
   
8. `npm run dev`

9. setup Laravel
  `php artisan storage:link`
  `php artisan key:generate`

  `cp ENV_file ./TimeAndPlace/.env`
   *** set Laravel SQL admin username and password here
 
10. set file permissions correctly

```
sudo chgrp -R www-data storage
sudo chgrp -R www-data bootstrap/cache
sudo chmod -R ug+rwx bootstrap/cache
sudo find storage -type d -exec chmod 775 {} \;
sudo find storage -type f -exec chmod 664 {} \;
```

11. start sql server again
  > `sudo service mysql start`
	
12. Create SQL logins needed:

```
> mysql -u root -p
# Create a database in mysql - use same info as in .env file
> CREATE DATABASE loggerDB;

Create user:
> CREATE USER 'useruseruser'@'localhost' IDENTIFIED BY 'passwordpassword';
  (using the user and password from .env file)
> GRANT ALL on loggerDB.* TO 'useruseruser'@'localhost';
> GRANT SELECT,REFERENCES ON schoolDB.* TO 'useruseruser'@'localhost';
```

13. make migrations
`> php artisan migrate:fresh`

14. seed database. 
NOTE: The file database/seeds/UserTableSeeder.php will tell you the admin user name and initial password.
`> php artisan db:seed`

15. Test with built-in server: `php artisan serve --host localIP --port 8888`
   and then fix up Apache2 to me the server.
