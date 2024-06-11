<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Register</title>
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
   
   <style>
    fieldset{
    margin:2em 0;
    padding: 1em 2em;
    border:solid 1px #ccc;
    min-width: 200px;
    height: 100%;
  
    
   }

   legend {
    font-size: 2.25em;
    padding: 0 .25em;
    color:#999;
   }

   </style>
   </head>
   <body>
      <!--Nav bar-->
      <div class ="NewUsers">
         <nav>
            <h2 class="logo"><a href ="./index.php">NaturalFitnessGoals</a></h2>
            <ul>
               <li><a href ="./personalTraining.php">Personal Training</a></li>
               <li><a href ="./membership.php">MemberShip</a></li>
               <li><a href ="./aboutUs.php">About Us</a></li>
               <li><a href ="./myAccount.php">My Account</a></li>
            </ul>
         </nav>
         <!--Adding form to allow users to create new account-->
         <div class="container">
            
            <div class="RegisterBox">
              <form  method="POST" class="myAccountForm" autocomplete="off">
              <?php
              include "createDatabase.php";
              $conn = buildDatabaseConnection();
              $flag = false;
              $dbname = nameDatabase("NaturalFitnessGoalstw4o", $flag);

              $conn->select_db($dbname);
              //takes post info from for and inserts in signin table
              if (isset($_POST["btnSubmitbutton"])) {
                  $firstname = htmlentities($_POST["txtFirstname"]);
                  $lastname = htmlentities($_POST["txtastname"]);
                  $username = urlencode(
                      mysqli_real_escape_string($conn, $_POST["txtUsername"])
                  );
                  $password = urlencode(
                      mysqli_real_escape_string($conn, $_POST["txtPassword"])
                  );

                  if (ifUserNameExist($conn, $username)) {
                      echo "<h4>Username:$username" . " Already Exists</h4>";
                  } else {
                      insertIntoSignIn(
                          $username,
                          $firstname,
                          $lastname,
                          $password,
                          $flagstatus,
                          $conn
                      );
                  }
                  //signin form
              }
              ?>
                <fieldset>
                  <legend>
                    Create an Account
                  </legend>
                  <label for="txtFirstname"><b>Firstname</b></label>
                  <input type="text" id="txtFirstname" name="txtFirstname" placeholder="FirstName" required><br>
                  <label for="txtastname"><b>Lastname</b></label>
                  <input type="text" id="txtastname" name="txtastname" placeholder="Lastname" required><br>
                  <label for="txtUsername"><b>Username</b></label>
                  <input type="text" placeholder="Enter Username" name="txtUsername" id="txtUsername" required><br>
                  <label for="txtPassword"><b>Password</b></label>
                  <input type="txtPassword" placeholder="Enter Password" name="txtPassword" id="txtPassword" required><br>
                  <button type="submit" name="btnSubmitbutton">Submit</button>
                  <p>Did you forget your password<a href ="#">Password</a></p>
                  <p>Have an account already<a href ="./myAccount.html">SignIn</a></p>
                
                </fieldset>
              </form>
              


            </div>
         </div>
      </div>
      <img src="./graphic/insertIntoSignin.png" alt="signin" width="400" height="400">
      <img src="./graphic/demo showing stored procedure signin.png" alt="storedproceedure" width="400" height="400"><br>

   </body>
</html>