# PHP-Signup-System
This project is a barebones, CSS-less signup system, demonstrating basic web security utilizing HTML + PHP functionality. Some basic features included are:
- Model-View-Controller (MVC) application structure
- Hashed passwords
- Session regeneration
- Signup, login and sign out functionality

## Setup Instructions (XAMPP install and Database Setup)
1. Install [XAMPP](https://www.apachefriends.org/download.html) or something similar to run the MySQL and Apache HTTP Server services
2. Start up `xampp-control.exe` (run as Administrator), then start the Apache and MySQL services
3. Go to [PHPMyAdmin](http://localhost/phpmyadmin/) (MySQL management page)
   1. Click the "Databases" tab, then create a new DB with any name you want (your_db_name)
   2. You should have a blank page on "Structure" tab.
   3. Click "SQL" at the top
   4. Copy the code from [db.sql](https://github.com/jadonscombs/PHP-Signup-System/blob/main/db.sql) into the query box, then click "Go"
   5. The database structure should be all set up now (we'll use this to store user account data)
4. Now clone/place this repo (PHP-Signup-System) into the `xampp/htdocs` folder
   - Each folder inside `xampp/htdocs` represents a "website"
   - Example: To see `xampp/htdocs/PHP-Signup-System/` in action, go to `http://localhost/PHP-Signup-System` (this will work after you complete all the steps)
   - Sidenote: If you are *not* using XAMPP, I recommend placing this project/repo wherever local website files are picked up by your Apache server
5. Now we must change a couple lines in the [includes/db.inc.php](https://github.com/jadonscombs/PHP-Signup-System/blob/main/includes/dbh.inc.php) file
   1. Open the `db.inc.php` file, and change the `$dbname` value from `'myfirstdatabase'` to the name you gave in **Step 3**
   2. Save the file  

## Demonstration
1. Assuming you have opened `xampp-control.exe` with administrator privileges, make sure you have started the **Apache** and **MySQL** services
2. Open a web browser and navigate to `http://localhost/PHP-Signup-System`
3. Voila! You should now see a basic webpage with a **Login** and **Signup** section
4. If for some reason this is _not_ the case, please let me know and I will gladly resolve the issue. Thanks!
