<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>myAccount</title>
      <link rel="stylesheet" href="style.css">
      <!-- 
         Name of file and purpose:
         Course name:CS235 Server-side Development
         Project: Midterm
         Developer name: Zach Fordahl
         Email: fordahlz@csp.edu
         Date: 11/16/2023
         
         Future Revisions:
         Date:10/17/2023
         Person:Zach
         What was done:Added form
         -->
  
   <style>
    fieldset{
    margin:2em 0;
    padding: 1em 2em;
    border:solid 1px #ccc;
    min-width: 100px;
    height: 70%;
    
    
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
      <div class = "myAccount">
         <nav>
            <h2 class="logo"><a href ="./index.php">NaturalFitnessGoals</a></h2>
            <ul>
               <li><a href ="./personalTraining.php">Personal Training</a></li>
               <li><a href ="./membership.php">MemberShip</a></li>
               <li><a href ="./aboutUs.php">About Us</a></li>
               <li><a href ="./myAccount.php">My Account</a></li>
            </ul>
         </nav>
         <!--Started form to allow users to sign into site-->
         <div class="container">
            
            <div class="myAccountBox">
               <form method="POST" class="myAccountForm"  autocomplete="off">
               <?php
               include "createDatabase.php";
               //create db connection
               $conn = buildDatabaseConnection();
               $flag = false;
               $dbname = nameDatabase("NaturalFitnessGoalstw4o", $flagstatus);

               $conn->select_db($dbname);
               //takes on form username, password once submit hit
               if (isset($_POST["btnSubmitbutton"])) {
                   $username = mysqli_real_escape_string(
                       $conn,
                       $_POST["txtUsername"]
                   );
                   $password = mysqli_real_escape_string(
                       $conn,
                       $_POST["txtPassword"]
                   );

                   checkLogInCred($conn, $username, $password, $dbname);
               }
               //function to check username against signin page
               function checkLogInCred($conn, $username, $password, $dbname)
               {
                   /*$sql = "SELECT `userName` ,`password` FROM `signin` WHERE userName='$username' ";
                    $query_results = mysqli_query($conn, $sql);*/
                   $sql =
                       "SELECT `userName` ,`password` FROM `signin` WHERE userName=? ";
                   $stmt = mysqli_stmt_init($conn);
                   if (!mysqli_stmt_prepare($stmt, $sql)) {
                       //checks to see if the delete returns a value
                       echo "Failed";
                   } else {
                       mysqli_stmt_bind_param($stmt, "s", $username);
                       //then it executes the statement
                       mysqli_stmt_execute($stmt);
                       //reuturns the results. Only needed if you are using it for a variable or paramater.
                       $query_results = mysqli_stmt_get_result($stmt);
                   }
                   if (mysqli_num_rows($query_results) > 0) {
                       foreach ($query_results as $unam) {
                           if ($unam["password"] == $password) {
                               echo $unam["userName"];
                               echo $unam["password"];

                               //This is where you would want to call another page
                               header("Location: membership.html");
                               exit();
                           } else {
                               echo "<h3>Incorrect Password</h3>";
                           }
                       }
                   } else {
                       echo "<h4>Incorrect UserName or Password</h4>";
                   }
                   //form for username password
               }
               ?>
                  <fieldset>
                     <legend>
                        Login
                     </legend>
                     <label for="txtUsername"><b>Username</b></label>
                  <input type="text" placeholder="Enter Username" name="txtUsername" id="txtUsername" required><br>
                  <label for="txtPassword"><b>Password</b></label>
                  <input type="Password" placeholder="Enter Password" name="txtPassword" id="txtPassword" required>
                  <button type="submit" name="btnSubmitbutton">Submit</button>
                  
                     <p>Did you forget your password<a href ="#">Password</a></p>
                     <p>Dont have an account<a href ="./register.php">Register</a></p>
                  </fieldset>
               </form>
            </div>
         </div>
         
      </div>
      
   </body>
</html>
