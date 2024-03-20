# Description

This project provides a simple interface for interacting with a MySQL database about Movie. It includes functionality for querying the database and displaying the results in a table.

## index.php:  PHP Database Interaction

This PHP file provides a simple interface for interacting with a MySQL database. It includes functionality for querying the database and displaying the results in a table.

- Connect to a MySQL database using PDO
- Execute SQL queries and fetch the results
- Display the results in a table with headers
- Search for actors by name
- Like a movie as a user
- Check if a user exists
- Check if a user has already liked a movie
- Insert a like into the 'Likes' table

Usage

1. Set your database server name, username, password, and database name at the top of the file.
2. Use the `executeQuery` function to execute a SQL query and get the results.
3. Use the `displayTable` function to display the results in a table.
4. Use the `checkUserExists`, `checkLikeExists`, and `insertLike` functions to implement the movie liking feature.



## SQL Database Scripts

This repository contains two SQL scripts: `script.sql` and `insert_data.sql`.

## script.sql

The `script.sql` file is a script for creating a database schema for a movie database. The schema includes the following tables:

- `MotionPicture`: Contains information about a motion picture, such as its name, rating, production company, and budget.
- `User`: Contains information about users, such as their email, name, and age.
- `Likes`: Records which users have liked which motion pictures.
- `Movie`: Contains additional information about movies, such as their box office collection.
- `Series`: Contains additional information about series, such as their number of seasons.
- `People`: Contains information about people involved in the motion pictures, such as actors and directors.
- `Role`: Records the roles that people have played in different motion pictures.
- `Award`: Records the awards that have been given to people for their work in different motion pictures.
- `Genre`: Records the genres of different motion pictures.
- `Location`: Records the filming locations of different motion pictures.

## insert_data.sql

The `insert_data.sql` file is a script for inserting data into the tables created by `script.sql`. This script should be run after `script.sql` to populate the database with initial data.

## Usage

1. Run `script.sql` to create the database schema.
2. Run `insert_data.sql` to insert data into the tables.

Please note that these scripts should be run in a MySQL environment.