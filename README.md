# Photo Gallery # 

The original Photo Gallery project was a tutorial and an introduction into more advanced OOP practices in PHP by Lynda.com.
(I am not sure of the licensing, if any, to the original lynda tutorial so I did not include it in this project.)

The original project files can be found in the deliverables section of my website at [Casperwilkes.net](http://casperwilkes.net/resume).

When I want to learn a new framework, I usually pull out the original tutorial and build out the idea with the framework in mind.
Each time I re-build it I try to improve it a little more.

This version of Photo Gallery was an exercise in [Laravel](https://github.com/laravel/framework).

Previous versions can be found here:
- [FuelPHP version](https://github.com/casperwilkes/photo_gallery_new) 

## What is Photo Gallery? ##

The Photo Gallery is an extremely simplified photo uploading application. The original purpose of the project was to teach 
programmers several key features most applications will want:

* Upload files
* Create a login / logout system
* Create log files
* Read from files
* Write to files
* CRUD interaction with databases

## Project setup ##
1. The first thing you need to do after cloning the project is create a database and possibly a user to manage that database.
2. Copy the `.env.example` to `.env`. 
 * There are some default values I pre-filled, you can change them if you wish. The `APP_NAME` value will properly populate
    across the application. 
3. If you decided to use another database user, populate the credentials of the database in the `.env` file's appropriate section. 
4. From the command line in the base directory of the project, run `composer install`.
 * Make sure to have composer installed. If for some reason you don't, you can get it [here](https://getcomposer.org/)
5. After composer has installed all the necessary packages, run the artisan setup script. `php artisan setup`
 * This will generate your application's key, create cache files of important scripts, and migrate you database
    * with options, it can even pre-seed your database with data. ([see below](#setup)) 

## Custom Artisan Scripts ##

For this application, I wrote a couple custom scripts to help out with installation of the project and cleanup while developing.

### Setup ###

This script is used for setting up the application for the first time. It should only need to be run once, but won't hurt 
anything to run it again.

```bash
php artisan setup [-s]
```

The setup script will: 
* Generate an app key for the `.env` file
* Generate the public image directory
* Setup route/config/services cache files
* Run all existing migrations to setup the database
* Options Include:
 * {-s|--seed}
  * This will seed the database with mock data and populate the image directory with photographs and user avatars

### Clear ###

This script is used for cleaning up the application when you are developing with it. This script can be run as often and as
many times as you need to. It's used for clearing out cache/img/log files.

```bash
php artisan clear [-s,-i,-g,-m,-a]
```
Completely refreshes the application logs|migrations|seeds|images|caches)

This script will:
* Clears out all images in the public img directory
* Clears out log files
* Clears out all the caches
* Re-builds class, route, config caches
* Re-runs the migrations
* Re-seeds the database
* Options Include:
 * {-s|--seed}
  * This will seed the database with mock data and populate the image directory with photographs and user avatars
 * {-i|--image}
  * Clears the image directories
 * {-g|--generate}
  * Generate route|class|config cache files
 * {-m|--migrate}
  * Re-run the migrations
 * {-a|--a}
  * Runs all of the previously mentioned options at once
  
#### Note: #####
It is recommended that you use the php artisan commands because of permissions. If you upload an image, or run the seeder, 
when you go to run the clear command and haven't run setup, the permissions will be set for the web-server, not the user running
artisan. This can complicate things for quick development. 

A work around for this is to run artisan as the web server:
```bash
sudo -u www-data php artisan "$@"
```

## Seeding ##

There are several seeders setup for this project that each serve a distinct purpose. All seeders are capable of simple 
iteration adjustment.

### Users ###

* UsersTableSeeder: populates the database with mock users.
* UsersProfileSeeder: populates the users profile data (avatar {more below}|bio) 
* CommentTableSeeder: populates the comment table for random users

#### Default User ####

Included with the migrations is a test user:
 - username: admin
 - email: admin@admin.com
 - password: password
 
#### Note ####
 
All of the user's passwords are set to `password` in case you want to log in with them and modify something.

### Photographs ###

Photographs are pulled from [faker](https://github.com/fzaninotto/Faker) preferred sites. Sometimes the image seeders 
can take a bit longer than you'd like because they actually fetch the images and download/resize them. If you're not 
happy with how long it's taking for some reason, you can adjust the iteration counts.  

* PhotoTableSeeder: populates the public `public/img/main` and `public/img/main/thumb` directories with random images 
    and associates them with a random user.
* UsersProfileSeeder: also populates the `public/img/avatar` and `public/img/avatar/thumb` directories with user avatars 
    and associates them with a random user.

## In Closing ##

Have fun with it. I'm always interested if it helped you or you just happened to like it. If you'd like to see anything else
added, let me know. 