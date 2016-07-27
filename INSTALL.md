# Installation instructions

For installation, we need to consider some topics:
 - Firstly, install PHP 5.6.18
 - Secondly, install PHPUnit 5.2 for testing proposes
 
Now, follow these steps:
 - Clone repository
 - composer install
 
To fill database with json. 
 - Should create an empty database.
 - Add database credentials, hostname and database name to
 src/Config.php
 - to generate database values from json file at data/prezis.json, run phpunit tests/PDOPreziListTest.php