# https://laravel.com/docs/8.x/eloquent#generating-model-classes
# ------------------------------------------------------------
# Local env
# ------------------------------------------------------------
## https://github.com/HendricksK/docker-laravel-postgres-nginx/tree/PHP74
## git clone git@github.com:HendricksK/docker-laravel-postgres-nginx.git
## git checkout PHP74
## cd into application/public
## git clone git@github.com:HendricksK/forumapp.git
# ------------------------------------------------------------
# requirements
# ------------------------------------------------------------
## - Build a PHP REST API, using Laravel or Symfony that demonstrates the following:
# ------------------------------------------------------------
##  - The ability to architect an application using PHP7, and the following:
##  - Unit Testing
##  - Composer
##  - Restful API
##  - Modern Coding Standards
##  - Design Patterns
# ------------------------------------------------------------
##  - Use GitHub as the source control. Email through the Git repo’s URL once created and make sure
##  - you check in regularly.
##  - / Assignment Overview
##  - The API must also cater for the following entities:
##  - User
##  - Post
##  - Comment
##  - Category
##  - To reduce complexity please note that a post may only belong to one category.
##  - A swagger document that outlines all of the API endpoints.
##  - Please note that we specifically want to test knowledge and implementation of design patterns.
##  - / Additional Requirements
##  - You will need to create a logger that will log all API requests and responses. This class will however have to use the GATEWAY PATTERN so that the storage system can be changed from database to files.
##  - You will need to demonstrate an understanding of the REPOSITORY PATTERN during your database interactions.


# SWAGGER
## used the staic swagger-ui option https://github.com/swagger-api/swagger-ui/blob/master/docs/usage/installation.md#static-files-without-http-or-html
## moved dist folder from swagger-ui github to public swagger folder, along with composer install for swagger
## running swagger ./vendor/zircote/swagger-php/bin/openapi -o ./public/swagger/openapi.json ./routes/api.php 
## will add more folder routes as required
