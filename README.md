# RealtimeBus

## Description
RealtimeBus is a mobile app that sends you a notification when it's time to catch the bus, so you don't have to wait outside for a long time.

This project involves an API that stores data such as bus stops and bus routes.

The API uploads a protobuf file that contains bus schedules.

# Technical description
## Languages and frameworks
This project is developed using following languages and frameworks :
- PHP 8.2.11
- Symfony 7.1

## Secrets
Project variables are stored in .env file.

There is one .env file per environment :
- .env : Production
- .env.staging : Staging
- .env.test : Test
- .env.test.local Local test 
- .env.local : Local

Some variables are sensible and should not be committed.

So, these variables should be stored as secrets.

To store a variable as secret, run these following commands :

- Create a secret : (This command work also to update a secret)
```
php bin/console secrets:set MY_VARIABLE
```
- Get list of secrets :
```
php bin/console secrets:list --reveal
```

## Unit tests
Unit tests ensure that the code works properly and helps prevent errors in production.

Here is the command to execute unit tests:
```
php bin/phpunit
```

## Deployment
A CI/CD pipeline has been configured to deploy the project in the production server when code is pushed on the main branch.

### Workflow
The deploy.yml file performs the following actions :
- Clean the www directory
- Clone the main branch on the production server
- Clean the project
- Build with composer

### Deploy in a new environment
Here are the different actions that have been done to deploy this project in a new environment.
- On the project repository > Settings > Secrets and variables > Actions, the following variables may change :
    - DATABASE_URL : Database connection strings
    - TARGET_HOST : server host
    - TARGET_USER : server username
    - KNOW_HOST : contains hosts

- export SYMFONY_DECRYPTION_KEY=base64 encoded private key

## Pull request to main branch
The CI/CD pipeline of the API includes auto-tagging. 

When a branch is merged into the main branch, a tag is automatically created. 

Commit messages must contain the word **[major]** to create a new major version (e.g., 1.0) or **[minor]** for a minor version (1.1). 

If none of these words are present in the message, a patch version tag will be created (1.0.1).

## SonarQube

Run `docker pull sonarqube` to install SonarQube with Docker.

Run `docker run -d --name sonarqube -p 9000:9000 -p 9092:9092 sonarqube` to launch SonarQube.

You can access on your browser at the following address : `http://localhost:9000`

Run `docker run --rm -e SONAR_HOST_URL="http://host.docker.internal:9000" -e SONAR_LOGIN="sqp_e25679d8fe8be9844c6836e22c563caeafd7c0c5" -v "local\project\path:/usr/src" sonarsource/sonar-scanner-cli -Dsonar.projectKey=realtimebus-api` to scan project sources.

## Warnings 
### Failed To Push Limit
This exception is thrown by the Google Protobuf package. 

GTFS files (src/Gtfs) should not be manually modified under any circumstances. 

If these files need to be updated, they must be regenerated from the .proto file using the `protoc` command line tool or this online generator. 

Any minor modification to the GTFS sources (such as adding spaces, line breaks, or changing the namespace) will trigger the above error.

## Versions
- 1.0: Initial deployment