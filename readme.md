## Laravel 4.2 Starter CMS Template

##Installation

###1. Install via composer

You can use composer create-project to install without downloading zip or cloning this repo.
```
$ composer create-project kayrules/laravel-starter
```

###2. Manual Install

Alternatively, you can manually install by cloning this repo or download the zip file from this repo, and run composer install.
```
$ git clone https://github.com/kayrules/laravel-starter.git .
$ composer install
```

####a. Setup Permission

After composer finished install the dependencies, it should automatically change the storage folder permission to 777. Just incase if it's not did as expected, you need to manually change it recursively as command below.
```
$ chmod -R 777 app/storage/
```

####b. Initial Migration
---
	> php artisan migrate --package=cartalyst/sentry
	> php artisan migrate
	> php artisan db:seed


