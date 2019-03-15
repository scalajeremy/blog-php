DROP SCHEMA IF EXISTS blog CASCADE;
CREATE SCHEMA blog;

--creation of enumerate for table usage
CREATE TYPE blog.boolean AS ENUM('True', 'False');

--create tables
CREATE TABLE users(
    user_id SERIAL PRIMARY KEY,
    last_name VARCHAR(50) NOT NULL CHECK (last_name != ''),
    first_name VARCHAR(50) NOT NULL CHECK (first_name != ''),
    username VARCHAR(50) NOT NULL CHECK (last_name != '') UNIQUE,
    passwd VARCHAR(255) NOT NULL,
    email VARCHAR (50) NOT NULL CHECK (email SIMILAR TO '(([a-zA-Z0-9_\-]+\.)?)+[a-zA-Z0-9_\-]+@([a-zA-Z0-9_\-]+\.[a-z]{2,4})') UNIQUE,
    permission_lvl INTEGER NOT NULL CHECK (permission_lvl >= 0 AND permission_lvl <= 2), --2 = admin, 1 = author, 0 = user
    is_active blog.boolean NOT NULL
);

CREATE TABLE articles(
    article_id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    date_publication TIMESTAMP NOT NULL,
    author INTEGER NOT NULL,
    FOREIGN KEY (author) REFERENCES users (user_id)
);

CREATE TABLE images(
    img_id SERIAL PRIMARY KEY,
    photo OID NOT NULL,
    img_name VARCHAR(50)
);

CREATE TABLE comments(
    comment_id SERIAL PRIMARY KEY,
    content TEXT NOT NULL,
    date_comment TIMESTAMP NOT NULL,
    author INTEGER NOT NULL,
    article INTEGER NOT NULL,
    FOREIGN KEY (author) REFERENCES users (user_id),
    FOREIGN KEY (article) REFERENCES articles (article_id)
);

CREATE TABLE categories(
    category_id SERIAL PRIMARY KEY,
    cat_name VARCHAR (50) NOT NULL UNIQUE
);

CREATE TABLE list_of_categories(
    article INTEGER NOT NULL,
    category INTEGER NOT NULL,
    FOREIGN KEY (article) REFERENCES articles(article_id),
    FOREIGN KEY (category) REFERENCES categories(category_id),
    PRIMARY KEY (article, category)
);

--insert users for test
INSERT INTO users(last_name, first_name, username, passwd, email, permission_lvl, is_active) VALUES ('Rabujev','Jamal', 'rabujev', '$2y$10$LSU1yKLvvcVDVZ5H2RI45.pLve4.VXm7D4tpz22uMWjqlB.OHYHwG', 'jamal.admin@gmail.com', 2, 'True');
INSERT INTO users(last_name, first_name, username, passwd, email, permission_lvl, is_active) VALUES ('Hay','Ludivine', 'ludivine', '$2y$10$LSU1yKLvvcVDVZ5H2RI45.pLve4.VXm7D4tpz22uMWjqlB.OHYHwG', 'ludivine.admin@gmail.com', 2, 'True');
INSERT INTO users(last_name, first_name, username, passwd, email, permission_lvl, is_active) VALUES ('Scala','Jeremy', 'thejameskiller', '$2y$10$LSU1yKLvvcVDVZ5H2RI45.pLve4.VXm7D4tpz22uMWjqlB.OHYHwG', 'jeremy.admin@gmail.com', 2, 'True');
INSERT INTO users(last_name, first_name, username, passwd, email, permission_lvl, is_active) VALUES ('Janssens','Thibaut', 'bicky', '$2y$10$LSU1yKLvvcVDVZ5H2RI45.pLve4.VXm7D4tpz22uMWjqlB.OHYHwG', 'bicky.admin@gmail.com', 2, 'True');
INSERT INTO users(last_name, first_name, username, passwd, email, permission_lvl, is_active) VALUES ('Bove', 'Alex', 'daddy', '$2y$10$LSU1yKLvvcVDVZ5H2RI45.pLve4.VXm7D4tpz22uMWjqlB.OHYHwG', 'test5@gmail.com', 1, 'True');
INSERT INTO users(last_name, first_name, username, passwd, email, permission_lvl, is_active) VALUES ('Degueldre','Samuel','hackerman','$2y$10$LSU1yKLvvcVDVZ5H2RI45.pLve4.VXm7D4tpz22uMWjqlB.OHYHwG','test6@gmail.com', 0, 'True');

--insert categories for test
INSERT INTO categories(category_id, cat_name) VALUES(0, 'uncategorized');
INSERT INTO categories(cat_name) VALUES('Meditation');
INSERT INTO categories(cat_name) VALUES('Work environment');
INSERT INTO categories(cat_name) VALUES('Gaming');
INSERT INTO categories(cat_name) VALUES('Developpement');
INSERT INTO categories(cat_name) VALUES('Hacking');

--insert list_of_categories

--drop everthing
--drop view commentsbyarticles;
--drop view articlesbycategories;
--drop table comments;
--drop table images;
--drop table list_of_categories;
--drop table articles;
--drop table categories;
--drop table users;
