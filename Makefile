console:
	php artisan tinker

deploy:
	git push heroku

test:
	php artisan test

lint:
	composer run-script phpcs  -- --standard=PSR12 app

lint-fix:
	composer run-script phpcbf -- --standard=PSR12 app 

setup:
	composer install
	cp -n .env.example .env|| true
	php artisan key:gen --ansi
	touch database/database.sqlite
	php artisan migrate
	php artisan db:seed
	npm install

start:
	php artisan serve
