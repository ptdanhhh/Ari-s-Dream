# CS174 Final Project Ari's Dream

### Host with xampp

1. Add folder to xampp htdocs folder

### For mysql database

1. CREATE DATABASE Project174;
2. USE Project174;
3. CREATE TABLE user_info(
   id INT NOT NULL,  
   user_name VARCHAR(255),
   hashed_password VARCHAR(255),
   salt VARCHAR(255),
   PRIMARY KEY(id));
4. CREATE TABLE user_data(
   id INT NOT NULL,  
   text_input VARCHAR(255),
   image_file VARCHAR(255),
   user VARCHAR(255),
   PRIMARY KEY(id));
