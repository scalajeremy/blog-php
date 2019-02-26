DROP SCHEMA IF EXISTS blog CASCADE;
CREATE SCHEMA blog;

--creation of enumerate for table usage
CREATE TYPE blog.boolean AS ENUM('True', 'False');

--create tables
CREATE TABLE users{
    user_id SERIAL PRIMARY KEY,
    last_name VARCHAR(50) NOT NULL CHECK (last_name != ''),
    first_name VARCHAR(50) NOT NULL CHECK (first_name != ''),
    username VARCHAR(50) NOT NULL CHECK (last_name != '') UNIQUE,
    passwd VARCHAR(255) NOT NULL,
    email VARCHAR (50) NOT NULL CHECK (email SIMILAR TO '[a-zA-Z0-9_\-]+@([a-zA-Z0-9_\-]+\.[a-z]{2,4})') UNIQUE, 
    is_admin blog.boolean NOT NULL
};

CREATE TABLE articles{
    article_id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    date_publication TIMESTAMP NOT NULL,
    autor INTEGER NOT NULL,
    FOREIGN KEY (autor) REFERENCES users (user_id)
};

CREATE TABLE images{
    img_id SERIAL PRIMARY KEY,
    photo OID NOT NULL,
    img_name varchar(50)
};

CREATE TABLE comments{
    comment_id SERIAL PRIMARY KEY,
    content TEXT NOT NULL,
    date_comment TIMESTAMP NOT NULL,
    autor INTEGER NOT NULL,
    FOREIGN KEY (autor) REFERENCES users (user_id)
};

CREATE TABLE categories{
    category_id SERIAL PRIMARY KEY,
    cat_name NOT NULL UNIQUE,
};

CREATE TABLE list_of_categories{
    article INTEGER NOT NULL,
    category INTEGER NOT NULL,
    FOREIGN KEY (article) REFERENCES articles(article_id),
    FOREIGN KEY (catergory) REFERENCES catergories(category_id),
    PRIMARY KEY (article, category) 
};

CREATE TABLE list_of_comments{
    article INTEGER NOT NULL,
    comment INTEGER NOT NULL,
    FOREIGN KEY (article) REFERENCES articles(article_id),
    FOREIGN KEY (comment) REFERENCES comments(comment_id),
    PRIMARY KEY (article, comment)
};

--view to get all comment by articles 
CREATE VIEW commentsByArticles AS
	SELECT u.username, c.content, c.date_comment
	FROM list_of_comments lc, articles a, comments c, users u
	WHERE lc.article = a.article_id AND u.user_id = c.autor 
        AND  

--view to get all articles by categories
CREATE VIEW articlesByCategories AS
    SELECT
    FROM
    WHERE
    ORDER BY