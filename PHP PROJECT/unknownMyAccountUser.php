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
   </head>
   <body>
      <!--Nav bar-->
      <div class = "myAccount">
         <nav>
            <h2 class="logo"><a href ="./index.php">NaturalFitnessGoals</a></h2>
            <ul>
               <li><a href ="./personalTraining.html">Personal Training</a></li>
               <li><a href ="./membership.html">MemberShip</a></li>
               <li><a href ="./aboutUs.html">About Us</a></li>
               <li><a href ="./myAccount.html">My Account</a></li>
            </ul>
         </nav>
         <!--Started form to allow users to sign into site-->
         <div class="container">
            <h2>My Account</h2>
            <div class="myAccountBox">
                <h3>Incorrect Username or password entered</h3>
               <form method="POST" class="myAccountForm"  autocomplete="off">
                  <fieldset>
                     <legend>
                        Login
                     </legend>
                  <input type="text" placeholder="Enter Username" name="username" id="username" required>
                  <label for="password"><b>Password</b></label>
                  <input type="password" placeholder="Enter Password" name="password" id="password" required>
                  <button type="submit" name="submitbutton">Submit</button>
                  
                     <p>Did you forget your password<a href ="#">Password</a></p>
                     <p>Dont have an account<a href ="./register.php">Register</a></p>
                  </fieldset>
               </form>
            </div>
         </div>
         
      </div>
      <?php include "createDatabase.php"; 
      
            $conn = buildDatabaseConnection();
            $dbname = nameDatabase("NaturalFitnessGoalstw4o");

            $conn->select_db($dbname);

            if(isset($_POST["submitbutton"])){
               $username=$_POST["username"];
               $password=$_POST["password"];
               checkLogInCred($conn,$username, $password,$dbname);
             }
             
             function checkLogInCred($conn,$username, $password,$dbname){
             
                
                $sql= "SELECT `userName` ,`password` FROM `signin` WHERE userName='$username' ";
                $query_results = mysqli_query($conn, $sql);
                if(mysqli_num_rows($query_results)> 0){
                  foreach($query_results as $unam){
                   
                   if($unam['password'] ==$password){
                     echo $unam['userName'];
                     echo $unam['password'];

                     //This is where you would want to call another page
                     header('Location: membership.html');
                     exit();
                     
                   }
                    else{

                     echo "Incorrect password";
                    }
                    }
                     

                  }

                
                else{
                  echo "No Results";
                }
               
             }
      ?>
   </body>
</html>
