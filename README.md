# school
SCHOOL MANAGEMENT SYSTEM

---

<h3 align="center">HOW TO SETUP</h3>
<br>

To run the system locally or deploy it for testing, follow the steps below:

### Requirements
- PHP >= 7.4 (or higher)
- MySQL
- Web Server (e.g., XAMPP, MAMP, WAMP, Apache/Nginx)
- Composer >= 7.4 (or higher)

### Setup Procedure (Linux Version)

1. sudo apt-get update
2. sudo apt-get install git
3. sudo git init
4. git clone [http://github.com/sabadope/school](http://github.com/sabadope/school)
5. Change directory "**cd** **school**"
6. sudo apt install php8.3-cli
7. php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
8. php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'.PHP_EOL; } else { echo 'Installer corrupt'.PHP_EOL; unlink('composer-setup.php'); exit(1); }"
9. php composer-setup.php
10. php -r "unlink('composer-setup.php');"
11. sudo mv composer.phar /usr/local/bin/composer
12. git config --global --add safe.directory /opt/lampp/htdocs/school
13. sudo apt-get install php8.3-dom php8.3-xml php8.3-curl
14. sudo chown -R $USER:$USER /opt/lampp/htdocs/school
15. composer install
16. Open your browser and go to: [http://localhost/phpmyadmin/](http://localhost/phpmyadmin/)
17. Click on the **Databases** tab.
18. Create the following database:
   - `db_school`

19. Import the following SQL files:
   - For those following databases, just click the **import** tab from the mysql server, after that locate each sql files inside of the `school/database` folder, and select the `db_school.sql`.

20. Click the **Go** button to complete the import.
21. Go back to the terminal.
22. sudo apt install php8.3-mysql
23. php artisan key:generate
24. php artisan serve
25. Now open your browser and visit: [http://127.0.0.1:8000](http://127.0.0.1:8000)

   > **To start the program.**

### THAT'S ALL! I hope you followed the steps correctly and enjoy using the program!
