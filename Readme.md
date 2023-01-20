# Test Task
Author: Artur Paklin

---

### 1. Set up the project

This project uses a Docker. Before starting a project, you need to copy `.env.sample` to `.env`, thus there would be
configured enviromental variables for docker.
For application env variables, copy inside web/ the `.env.sample` to `.env`

Also, to setup the dependencies, you will need to manually install composer deps inside the `web/`.
And, run also `$ composer dump-autoload`;

After that, just run: `docker-compose up`.

For running a migration, you will need to connect to the php-fpm container, and run in the project directory 
the following command:

`$ ./vendor/bin/doctrine-migrations migrate`

Migration will create Users table and will add a user `admin` with password `option123`.

The following URLs are active:
/ -> used for testing if user is authorized
/login -> for logging in process
/file -> UI for upload
/upload -> the POST handler for file uploader