# Simple Note App

This simple app offers Create Read Update Delete (CRUD) functionality with PHP. We use the PDO extension to connect to MySQL database. Additionally we use prepared statements to prevent against SQL injection attacks.

The project allows us to add, view, update and delete notes. There is pagination and search functionality.

The project was written as a *challenge to create CRUD withous using separate files* for adding, editing, and deleting notes. 

There are basically two files:
1. db.php - contains connection to Database
2. index.php - contains logic and markup

The project uses Bootstrap 5 on the front-end. And adding, editing and deleting notes is done with modal windows. 


## Usage

1. Create a new database - `test`
2. Create a table for storing notes
```sql
CREATE TABLE `test`.`notes` ( `id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(100) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB; 
```

## Screenshots
