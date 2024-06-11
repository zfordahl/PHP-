<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Home</title>
      <link rel="stylesheet" href="style.css">
      <!-- 
         Name of file and purpose:
         Course name:CS235 Server-side Development
         Project: Week 5 project
         Developer name: Zach Fordahl
         Email: zfordahl@csp.edu
         Date: 11/17/2023
         
         Future Revisions:
         Date:
         Person:
         What was done: Added stored procedures and stored statements to the area that user can modify
         -->
   </head>
   <body>
      <!--Nav bar-->
      <div class = "index">
         <nav>
            <h2 class="logo"><a href ="./index.php">NaturalFitnessGoals</a></h2>
            <ul>
               <li><a href ="./personalTraining.php">Personal Training</a></li>
               <li><a href ="./membership.php">MemberShip</a></li>
               <li><a href ="./aboutUs.php">About Us</a></li>
               <li><a href ="./myAccount.php">My Account</a></li>
            </ul>
         </nav>
         <!-- quote-->
         <p class="indexParagraph">
            “You have to remember something: Everybody pities the weak; jealousy you have to earn.” – Arnold Schwarzenegger
         </p>
         <!-- links to framewire,readme and database-->
         <div class="displayContainer">
            <div class="displayBox"><img src="./framewire/layout.png" alt="img1" class="homeImg"><a href="./framewire/layout.png" class="imgdis">layout</a></div>
            <div class="displayBox"><img src="./framewire/database.png" alt="img7" class="homeImg"><a href="./framewire/database.png" class="imgdis">database</a></div>
            <div class="displayBox1"><a href="./readme.html" class="imgdis">ReadMe</a></div>
            <div class="displayBox2"><p>links to stored Proceedure pages. Images of stored procedures at bottom of each page</p>
            <a href ="./membership.php">MemberShip</a>&nbsp;
            <a href ="./register.php">Registration</a>&nbsp;
            <a href ="./personalTraining.php">Personal Training</a><br><br>
            <a href ="./showJSONData.php">Show JSON</a>&nbsp;
            <a href ="./reflection.html"> Reflection</a>
         </div>
    
         </div>
      </div>
      <!-- PHP to add database connection and query results-->
      <?php
      include "createDatabase.php";

      $conn = buildDatabaseConnection();
      $dbname = nameDatabase("NaturalFitnessGoalstw4o", $flagstatus);

      $conn->select_db($dbname);
      $displayOption = "All";
      displayTable($conn, $displayOption);
      ?>
   </body>
</html>