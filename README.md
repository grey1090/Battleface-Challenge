# Battleface-Challenge



**Docker Instance:**
 We use sail in this porject please run all php artisan commands in the laravel_test_1 container.
  Steps:
  1. cd into BattleFace_Challange dir
  2. run docker-compose ps to check running containers 
  3. run docker exec -it {container id} bash to run the workspace for all php artisan commands
  4. run docker-compose up to spin up containers should have workspace and mysql.
  5. db connections are all in the .env file 
  
  
  
**Generate User:**
 1.hit the http://localhost/quotes endpoint, to save time on the project im creatng one user once that endpoint is hit so that the jwt-token can be created.
 
 
 **Overall flow for app**
 
 The web.php routses has one GET method that creates a user thatt will generate an auth token. password is not needed becuase im using email to identify as you can 
 in the AuthController.php lines 16-20. the idea behind this is that we create a token once the /quotes enpoint is loaded as seen in the vanilla js. from there the 
 the api headers are passed into a payload so that we can we fetch the POST of the actual qoute which will be displayed in json format on top of the form.
 

   
   
