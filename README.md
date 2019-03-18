## Team
[Ludivine](https://github.com/LudivineHay)

[Thibaut](https://github.com/ThibautJanssens)

[Jamal](https://github.com/rabujev)

[Jeremy](https://github.com/scalajeremy)

# Mots Pressés

A working and simple Slim-PHP-Twig-PostgresSQL application for blogging with a MVC architecture.
It also uses Docker.

The application consist of a blog, with an admin section. You can display posts, posts by categories, the team. You can obviously register on the website, and login/logout.

With the admin section, you'll have a dashboard to see how many posts, categories, users you'll have on your application.
You'll also be able to add/edit/delete posts, article and users.

## Useful links

[Mockup](https://balsamiq.cloud/sei7jok/po0krtx/r44C8)

[Trello](https://trello.com/b/s88qJWJX/les-mots-press%C3%A9s)

## Status

- Working environnement

## Known issues

- When a category is deleted, and a post had only this category attached to it then it won't be displayed anymore even though the post is still in the database. -fix is to just check if when we want to delete a category, get all the posts that only have this category and change the category to a default one which is called 'uncategorised'

## To-do

- Comment section add/edit/delete/display


## Install the Application
You'll need docker, npm and composer, php, php-pgsql.

Clone the repository in the folder of your choice.
	```git clone https://github.com/rabujev/blog-php.git```

Then go inside the folder and install all the dependencies.
	```cd blog-php && npm install && composer install```

To start the application on dev-mode in local, just run the command
	```npm run dev```
	
The gulpfile.js will start docker with adminer for the database on `localhost:9000`
, and also the php server at `localhost:8080`

*You have a db.sql file that can set up the database. You just need to import it in your database.*
*Do not forget to edit the `src/System/settings.php` file to your database port, username, password, database name.* 
