# Pineapple Web Developer Test
## How to launch locally:
1. Start Apache server
2. Start MySQL server
3. Create MySQL user
4. Create the database (queries are avaialble in startup-queries.sql in project's root directory).
5. Update dbConfig.ini (in this case located in project's root directory) with your MySQL user credentials.
6. Main page is available at http://localhost/
8. Admin page is available at http://localhost/admin

## Detailed steps on how to launch locally (Windows machines):
1. In order to launch the project locally please use [XAMPP](https://www.apachefriends.org/index.html)
2. Pull all the files from the repository into htdocs directory (by default /c/xampp/jtdpcs)
3. Start Apache and MySQL
4. Go to [PHPMyAdmin page](http://localhost/phpmyadmin/index.php)
5. Open SQL tab
6. Execute query from startup-queries.sql file inside project's root directory.
7. If they are different from default - update dbConfig.ini with your MySQL user credentials.
8. Main page is available at http://localhost/
9. Admin page is available at http://localhost/admin
