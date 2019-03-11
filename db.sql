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

--view to get all comment by articles
CREATE VIEW commentsByArticles AS
	SELECT u.username AS "Username", c.content AS "Content", c.date_comment AS "Date", a.article_id AS "Id_article"
	FROM articles a, comments c, users u
	WHERE c.article = a.article_id AND u.user_id = c.author
    ORDER BY a.article_id;

--view to get all articles by categories
CREATE VIEW articlesByCategories AS
    SELECT c.category_id AS "Cat_Id", a.title AS "Title", a.content AS "Content", u.username AS "Username"
    FROM categories c, articles a, users u, list_of_categories lc
    WHERE c.category_id = lc.category AND u.user_id = a.author AND a.article_id = lc.article
    ORDER BY c.category_id;

--insert users for test
INSERT INTO users(last_name, first_name, username, passwd, email, permission_lvl, is_active) VALUES ('Rabujev','Jamal', 'rabujev', 'pass123', 'test.test@gmail.com', 2, 'True');
INSERT INTO users(last_name, first_name, username, passwd, email, permission_lvl, is_active) VALUES ('Hay','Ludivine', 'ludivine', 'pass123', 'test2@gmail.com', 2, 'True');
INSERT INTO users(last_name, first_name, username, passwd, email, permission_lvl, is_active) VALUES ('Scala','Jeremy', 'thejameskiller', 'pass123', 'test3@gmail.com', 2, 'True');
INSERT INTO users(last_name, first_name, username, passwd, email, permission_lvl, is_active) VALUES ('Janssens','Thibaut', 'bicky', 'pass123', 'test4@gmail.com', 2, 'True');
INSERT INTO users(last_name, first_name, username, passwd, email, permission_lvl, is_active) VALUES ('Bove', 'Alex', 'daddy', 'pass123', 'test5@gmail.com', 1, 'True');
INSERT INTO users(last_name, first_name, username, passwd, email, permission_lvl, is_active) VALUES ('Degueldre','Samuel','hackzorr','pass123','test6@gmail.com', 0, 'True');
INSERT INTO users(last_name, first_name, username, passwd, email, permission_lvl, is_active) VALUES ('admin', 'admin', 'admin', '$2y$10$LSU1yKLvvcVDVZ5H2RI45.pLve4.VXm7D4tpz22uMWjqlB.OHYHwG', 'admin@admin.com', 2, 'True');

--insert articles for test
INSERT INTO articles(title, content, date_publication, author) VALUES ('Narwhals', 'They are the jedi of the sea', NOW(), 4);
INSERT INTO articles(title, content, date_publication, author) VALUES ('Meditation at work', 'Sleep all day', NOW(), 1);
INSERT INTO articles(title, content, date_publication, author) VALUES ('Narcissistic Personality Disorder', 'The hallmarks of
    Narcissistic Personality Disorder (NPD) are grandiosity, a lack of empathy for other people,
    and a need for admiration. People with this condition are frequently described as arrogant,
    self-centered, manipulative, and demanding. They may also concentrate on grandiose fantasies
    (e.g. their own success, beauty, brilliance) and may be convinced that they deserve special treatment.
    These characteristics typically begin in early adulthood and must be consistently evident in multiple contexts,
    such as at work and in relationships. ', NOW(), 2);
INSERT INTO articles(title, content, date_publication, author) VALUES ('WOW', 'ma bite', NOW(), 5);

--insert comments for test
INSERT INTO comments(content, date_comment, author, article) VALUES ('Super comment', NOW(), 1, 3);
INSERT INTO comments(content, date_comment, author, article) VALUES ('Wow', NOW(), 2, 1);
INSERT INTO comments(content, date_comment, author, article) VALUES ('Amazing', NOW(), 3, 1);
INSERT INTO comments(content, date_comment, author, article) VALUES ('Very effective', NOW(), 4, 2);
INSERT INTO comments(content, date_comment, author, article) VALUES ('Nicely written', NOW(), 4, 3);

--insert categories for test
INSERT INTO categories(cat_name) VALUES('Meditation');
INSERT INTO categories(cat_name) VALUES('Work environment');
INSERT INTO categories(cat_name) VALUES('Wildlife');
INSERT INTO categories(cat_name) VALUES('Living style');

--insert list_of_categories
INSERT INTO list_of_categories(article, category) VALUES (1, 3);
INSERT INTO list_of_categories(article, category) VALUES (1, 2);
INSERT INTO list_of_categories(article, category) VALUES (2, 1);
INSERT INTO list_of_categories(article, category) VALUES (3, 2);
INSERT INTO list_of_categories(article, category) VALUES (4, 4);

--drop everthing
--drop view commentsbyarticles;
--drop view articlesbycategories;
--drop table comments;
--drop table images;
--drop table list_of_categories;
--drop table articles;
--drop table categories;
--drop table users;