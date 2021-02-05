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

All notes
![all-notes](https://user-images.githubusercontent.com/6689087/107039981-46dd6780-67c7-11eb-8063-625940841604.png)

Add a note
![add-note](https://user-images.githubusercontent.com/6689087/107040047-5eb4eb80-67c7-11eb-8187-92a121fca5ea.png)

Update a note
![update-note](https://user-images.githubusercontent.com/6689087/107040062-62e10900-67c7-11eb-9c0e-296353566e8a.png)

Delete a note
![delete-note](https://user-images.githubusercontent.com/6689087/107040069-64aacc80-67c7-11eb-8d99-92bdf1f7ee8e.png)

Search for notes
![search-note](https://user-images.githubusercontent.com/6689087/107040074-65dbf980-67c7-11eb-838b-a26491c64f99.png)
