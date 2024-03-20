CREATE TABLE MotionPicture (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  rating DECIMAL(3, 1),
  production VARCHAR(255),
  budget BIGINT,
  PRIMARY KEY (id)
);

CREATE TABLE User (
  email VARCHAR(255) NOT NULL PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  age INT
);

CREATE TABLE Likes (
    mpid INT NOT NULL,
    uemail VARCHAR(255) NOT NULL,
    FOREIGN KEY (uemail) REFERENCES User(email),
    FOREIGN KEY (mpid) REFERENCES MotionPicture(id),
    PRIMARY KEY (uemail, mpid)
);

CREATE TABLE Movie (
  mpid INT NOT NULL,
  boxoffice_collection INT,
  FOREIGN KEY (mpid) REFERENCES MotionPicture(id),
  PRIMARY KEY (mpid)
);

CREATE TABLE Series (
  mpid INT NOT NULL,
  season_count INT,
  FOREIGN KEY (mpid) REFERENCES MotionPicture(id),
  PRIMARY KEY (mpid)
);

CREATE TABLE People (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  nationality VARCHAR(255),
  dob DATE,
  gender ENUM('M', 'F'),
  PRIMARY KEY (id)
);

CREATE TABLE Role (
  mpid INT NOT NULL,
  pid INT NOT NULL,
  role_name VARCHAR(255),
  FOREIGN KEY (mpid) REFERENCES MotionPicture(id),
  FOREIGN KEY (pid) REFERENCES People(id),
  PRIMARY KEY (mpid, pid)
);

CREATE TABLE Award (
  mpid INT NOT NULL,
  pid INT NOT NULL,
  award_name VARCHAR(255) NOT NULL,
  award_year YEAR,
  FOREIGN KEY (mpid) REFERENCES MotionPicture(id),
  FOREIGN KEY (pid) REFERENCES People(id),
  PRIMARY KEY (mpid, pid, award_name, award_year)
);

CREATE TABLE Genre (
  mpid INT NOT NULL,
  genre_name VARCHAR(255) NOT NULL,
  FOREIGN KEY (mpid) REFERENCES MotionPicture(id),
  PRIMARY KEY (mpid, genre_name)
);

CREATE TABLE Location (
  mpid INT NOT NULL,
  zip INT,
  city VARCHAR(255),
  country VARCHAR(255),
  FOREIGN KEY (mpid) REFERENCES MotionPicture(id),
  PRIMARY KEY (mpid, zip)
);