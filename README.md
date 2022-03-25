# instruct-ERIC-api-task
Small program that features some endpoints to expose sample data

PREREQUISITES
=============
You will only need docker running on your machine to build the image for this program (was using docker 4.6.1 to build the project).

HOW TO USE
==========
The first thing to do to setup the program, is to run the containers.

Via command line, cd into the root of the project, you will find the docker-compose.yaml file.

You will want to enter the command `docker-compose up --build` to fire up the containers and get the containerised server running.

The local server is currently set up to list to port 8080, http://localhost:8080 in the url will bring you to the site.

DATABASE
========
We will next want to setup the database.

Depending on whether or not you wish to mirror the database directory from the container to you machine, you can simply remove the comment from `- ./mysql-data:/var/lib/mysql` in the docker-compose.yaml file to create the link.

Next, you will want to run the database setup script.

Run `docker exec -it database /bin/bash` to access the bash terminal in the db container.

Once in, run `mysql -u root -p < /var/www/servicesInit.sql`.

When prompt for the password, for this task, the password will simply be `password`.

You should now have a fully setup api program!

THE API
=======
The GET endpoint is http://localhost:8080/service/{countryCode}, where it will expect a parameter 'countryCode' followed by the 2-character country code as a value.
If a record is found with the country code provided, you will get a JSON string back with the record's data.

The POST endpoint is http://localhost:8080/service, and expects 4 parameters - 'ref', 'centre', 'service' and 'country', the request will fail if any one of those parameters are omitted.

CLI
===
The program features a cli tool to perform the same operations as the api endpoints!

To use this CLI, we must go into the php-apache container `docker exec -it php-apache /bin/bash` and use the custom `serviceCli` command.

To get started, enter `serviceCli -h` or `serviceCli --help` for information on how to make queries.

Some pre-made commands exist in the 'test.txt' file if you want to see some examples!

TESTS
=====
Included in the repository, is a .txt file within the src/ directory, it holds more details about how the endpoints work, as well as detailing expectations.
