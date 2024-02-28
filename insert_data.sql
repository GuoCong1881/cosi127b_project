-- Inserting data into MotionPicture table
INSERT INTO MotionPicture (name, rating, production, budget)
VALUES ('Movie 1', 7.5, 'Production 1', 1000000),
       ('Movie 2', 8.1, 'Production 2', 2000000);

-- Inserting data into User table
INSERT INTO User (email, name, age)
VALUES ('user1@example.com', 'User 1', 30),
       ('user2@example.com', 'User 2', 25);

-- Inserting data into Likes table
INSERT INTO Likes (uemail, mpid)
VALUES ('user1@example.com', 1),
       ('user2@example.com', 2);

-- Inserting data into Movie table
INSERT INTO Movie (mpid, boxoffice_collection)
VALUES (1, 5000000),
       (2, 8000000);

-- Inserting data into Series table
INSERT INTO Series (mpid, season_count)
VALUES (1, 3),
       (2, 2);

-- Inserting data into People table
INSERT INTO People (name, nationality, dob, gender)
VALUES ('Person 1', 'USA', '1980-01-01', 'Male'),
       ('Person 2', 'UK', '1990-01-01', 'Female');

-- Inserting data into Role table
INSERT INTO Role (mpid, pid, role_name)
VALUES (1, 1, 'Actor'),
       (2, 2, 'Director');

-- Inserting data into Award table
INSERT INTO Award (mpid, pid, award_name, award_year)
VALUES (1, 1, 'Best Actor', 2020),
       (2, 2, 'Best Director', 2021);

-- Inserting data into Genre table
INSERT INTO Genre (mpid, genre_name)
VALUES (1, 'Action'),
       (2, 'Drama');

-- Inserting data into Location table
INSERT INTO Location (mpid, zip, city, country)
VALUES (1, 10001, 'New York', 'USA'),
       (2, 90210, 'Beverly Hills', 'USA');