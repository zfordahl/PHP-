<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>membership</title>
      <link rel="stylesheet" href="style.css">
      <!-- 
         Name of file and purpose:
         Course name:CS235 Server-side Development
         Project: Midterm
         Developer name: Zach Fordahl
         Email: fordahlz@csp.edu
         Date: 11/11/2023
         
         Future Revisions:
         Date:
         Person:
         What was done:
         -->
   
<style>
table {
  font-family: arial, sans-serif;
  width: 40%;
  height:50%;
  padding-left: 70px;
  padding-top:40px;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}


fieldset{
    margin:2em 0;
    padding: 1em 2em;
    border:solid 1px #ccc;
    min-width: 200px;
    
}

legend {
    font-size: 1.25em;
    padding: 0 .25em;
    color:#999;
}

.checks label{
    display: block;
    margin-top: 1em;
}
</style>
</head>
   <!--Nav bar-->
   <body>
      <div class = "membership">
         <nav>
            <h2 class="logo"><a href ="./index.php">NaturalFitnessGoals</a></h2>
            <ul>
               <li><a href ="./personalTraining.php">Personal Training</a></li>
               <li><a href ="./membership.php">MemberShip</a></li>
               <li><a href ="./aboutUs.php">About Us</a></li>
               <li><a href ="./myAccount.php">My Account</a></li>
            </ul>
         </nav>
         <div class="container">
         <div class="PersonalTrainingBox">
            <!--Form to search for trainer schedules. Multiple drop list being used with database columns such as Training type, First name, Last name, and Date.
            Also included a checkbox and radio box to search by-->
               <form method="POST" class="PersonalTrainingForm"  autocomplete="off">
               
                    
      
                  <fieldset name="personalTrainingFieldSet">
                     <legend name ="personalTrainingLegend">
                        Membership
                     </legend>
            
                     <label for= "lstTrainingType">Training Type search</label>
                     <select name="lstTrainingType">
                    

                     <?php
                     //Calls createDatabase to get database connection and then queries schedule to get trainingType for dynamic drop down list
                     include "createDatabase.php";

                     $conn = buildDatabaseConnection();
                     $dbname = nameDatabase(
                         "NaturalFitnessGoalstw4o",
                         $flagstatus
                     );

                     $conn->select_db($dbname);

                     searchByTrainingType($conn);
                     //search function allows to pass the connection and then loops through the table to return results of query
                     function searchByTrainingType($conn)
                     {
                         $sql = "SELECT trainingType FROM `schedule`;";
                          
                         $query_results = mysqli_query($conn, $sql);
                    
                         echo "<option value= 'Selected'> Selected</option>";
                         if (mysqli_num_rows($query_results) > 0) {
                             foreach ($query_results as $trainingType) {
                                 echo "<option value'" .
                                     $trainingType["trainingType"] .
                                     "'>" .
                                     $trainingType["trainingType"] .
                                     "</option>";
                             }
                         }
                     }
                     ?>
                        
                     </select>
                     
                     <button type="submit" name="submitbutton">Submit</button><br>

                    <!-- Check box and radio box used in table to query database and return based on paramaters checked.-->
                 
                     <p>Would you like to be sign up for membership:</p>
                      <input type="checkbox" id="yes" name="chkCheckbox" value="Yes" checked>
                      <label for="yes"> Yes</label>
                      <input type="checkbox" id="no" name="chkCheckbox" value="No" selected>
                      <label for="no">No</label>
                     <button type="submit" name="submitbuttonfive">Submit</button><br>

                    <?php if (isset($_POST["submitbuttonfive"])) {
                        //use php to create dynamic option to check if user has account or not and then if yes passes info to if statment to bring up next set of form labels
                        $type = $_POST["chkCheckbox"];
                        if ($type == "Yes") {
                            echo "<p>Have you created an account yet?:</p>";
                            echo "<input type='checkbox' id='yes' name='chkCheckbox' value='Yes' checked>";
                            echo "<label for='yes'> Yes</label>";
                            echo "<input type='checkbox' id='no' name='chkCheckbox' value='No'>";
                            echo "<label for='no'>No</label>";
                            echo "<button type='submit' name='submitbuttonSix'>Submit</button><br>";
                        }
                    } ?>
                        <?php if (isset($_POST["submitbuttonSix"])) {
                            $type = $_POST["chkCheckbox"];
                            //use php to add text,radio and date options to form
                            if ($type == "Yes") {
                                echo "<label for='txtFname'>First name:</label><br>";
                                echo "<input type='text' id='txtFname' name='txtFname' value='John'><br>";
                                echo "<label for='txtLname'>Last name:</label><br>";
                                echo "<input type='text' id='txtLname' name='txtLname' value='Doe'><br>";

                                echo "<p>Please select your Training Type:</p>";
                                echo "<input type='radio' id='weights' name='optRadioButton' value='WeightLifting' checked>";
                                echo "<label for='weights'>Weight Lifting</label><br>";

                                echo "<input type='radio' id='cardio' name='optRadioButton' value='Cardio'>";
                                echo "<label for='cardio'>Cardio</label><br>";

                                echo "<input type='radio' id='swimming' name='optRadioButton' value='Swimming'>";
                                echo "<label for='swimming'>Swimming</label><br>";

                                echo "<input type='radio' id='crossfit' name='optRadioButton' value='CrossFit'>";
                                echo "<label for='crossfit'>CrossFit</label><br><br>";

                                echo "<label for='dttrainingDate'>Scheduled Date:</label>";
                                echo "<input type='date' id='dttrainingDate' name='dttrainingDate' value='2023-11-26'><br>";
                                echo "<button type='submit' name='submitbuttonfour'>Submit</button><br><br>";
                            }

                            if ($type == "No") {
                                echo "Create and account";
                            }
                        } ?>


                     
                  </fieldset>
               </form>

          
            </div>
            <?php
            //php to get dynamic dropdown list of training type
            if (isset($_POST["submitbutton"])) {
                $type = $_POST["lstTrainingType"];
               
                /*$sql = "SELECT * FROM `schedule` WHERE trainingType='$type' ";
                $query_results = mysqli_query($conn, $sql);
                displayTrainerSchedule($query_results);*/
                 //add in some prepared statements for security
                $sql = "SELECT * FROM `schedule` WHERE trainingType=? ";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                //checks to see if the delete returns a value
                echo "Failed";
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $type);
                //then it executes the statement
                mysqli_stmt_execute($stmt);
                //reuturns the results. Only needed if you are using it for a variable or paramater.
                $query_results = mysqli_stmt_get_result($stmt);
                displayTrainerSchedule($query_results);
                } 
            }
            if (isset($_POST["submitbuttonfour"])) {
                $firstName = htmlentities( $_POST["txtFname"]);
                $LastName =htmlentities( $_POST["txtLname"]);
                $type = $_POST["optRadioButton"];
                $datetype = $_POST["dttrainingDate"];
                $empfirstName = "";
                $emplastName = "";
                $employeeId = "";
                $SigninID = "";
                //checks to see if there is a signin id available
               // $sql = "SELECT `signinId` FROM `signin` WHERE firstName='$firstName' AND lastName='$LastName' ";*/
                //add in some prepared statements for security
               $sql = "SELECT `signinId` FROM `signin` WHERE  firstName=? AND lastName=? ";
               $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                //checks to see if the delete returns a value
                echo "Failed";
                } else {
                    mysqli_stmt_bind_param($stmt, "ss", $firstName,$LastName);
                //then it executes the statement
                mysqli_stmt_execute($stmt);
                //reuturns the results. Only needed if you are using it for a variable or paramater.
                $query_results = mysqli_stmt_get_result($stmt);
                } 
               
                //$query_results = mysqli_query($conn, $sql);
                if (mysqli_num_rows($query_results) > 0) {
                    foreach ($query_results as $results) {
                        $SigninID = $results["signinId"];
                    }
                }


                //checks schedule to see if type is listed
               /* $sql = "SELECT `empFirstName`,`empLastName`,`employeeId` FROM `schedule` WHERE trainingType='$type' ";*/
                //add in some prepared statements for security
               $sql = "SELECT `empFirstName`,`empLastName`,`employeeId` FROM `schedule` WHERE trainingType=? ";
               $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                //checks to see if the delete returns a value
                echo "Failed";
                } else {
                //i if it does then it takes the statment and binds the runnerID to the statement
                mysqli_stmt_bind_param($stmt, "s", $type);
                //then it executes the statement
                mysqli_stmt_execute($stmt);
                //reuturns the results. Only needed if you are using it for a variable or paramater.
                $query_results = mysqli_stmt_get_result($stmt);
                }     
                //$query_results = mysqli_query($conn, $sql);

                if (mysqli_num_rows($query_results) > 0) {
                    foreach ($query_results as $results) {
                        $empfirstName = $results["empFirstName"];
                        $emplastName = $results["empLastName"];
                        $employeeId = $results["employeeId"];
                    }
                    //inserts into schedule
                    
                    $sql =
                        "Insert into schedule(scheduleId,scheduleDate,employeeId,empFirstName,empLastName,memFirstName,memLastName,trainingType)" .
                        "VALUES (NULL,'" .
                        $datetype .
                        "','" .
                        $employeeId .
                        "','" .
                        $empfirstName .
                        "','" .
                        $emplastName .
                        "','" .
                        $firstName .
                        "','" .
                        $LastName .
                        "','" .
                        $type .
                        "')";
                    

                  
                    runQuery(
                        $sql,
                        "New record insert Schedule",
                        false,
                        $flagstatus
                    );

                    //$sql = "SELECT `membershipId` FROM `membership` WHERE membershipType='$type' ";
                   // $query_results = mysqli_query($conn, $sql);
                    //add in some prepared statements for security
                   $sql = "SELECT `membershipId` FROM `membership` WHERE membershipType=? ";
                   $stmt = mysqli_stmt_init($conn);
                   if (!mysqli_stmt_prepare($stmt, $sql)) {
                   //checks to see if the delete returns a value
                   echo "Failed";
                   } else {
                   //i if it does then it takes the statment and binds the runnerID to the statement
                   mysqli_stmt_bind_param($stmt, "s", $type);
                   //then it executes the statement
                   mysqli_stmt_execute($stmt);
                   //reuturns the results. Only needed if you are using it for a variable or paramater.
                   $query_results = mysqli_stmt_get_result($stmt);
                   }     

                    if (mysqli_num_rows($query_results) > 0) {
                        foreach ($query_results as $results) {
                            $membershipId = $results["membershipId"];
                        }
                    } else {
                        $membershipId = null;
                    }
                    //inserts into members
                    $sql =
                        "Insert into member(memberId,membershipId,signinId,firstName,lastName,startDate)" .
                        "VALUES (NULL,'" .
                        $membershipId .
                        "','" .
                        $SigninID .
                        "','" .
                        $firstName .
                        "','" .
                        $LastName .
                        "','" .
                        $datetype .
                        "')";

                    runQuery(
                        $sql,
                        "New record insert Member",
                        false,
                        $flagstatus
                    );
                }

               // $sql = "SELECT * FROM `schedule` WHERE memFirstName='$firstName' AND memLastName='$LastName'";
                //$query_results = mysqli_query($conn, $sql);
                //displayTrainerScheduleUpdate($query_results);

                //add in some prepared statements for security
                $sql = "SELECT * FROM `schedule` WHERE memFirstName=? AND memLastName=?";
                $stmt = mysqli_stmt_init($conn);
                   if (!mysqli_stmt_prepare($stmt, $sql)) {
                   //checks to see if the delete returns a value
                   echo "Failed";
                   } else {
                   //i if it does then it takes the statment and binds the runnerID to the statement
                   mysqli_stmt_bind_param($stmt, "ss", $firstName,$LastName);
                   //then it executes the statement
                   mysqli_stmt_execute($stmt);
                   //reuturns the results. Only needed if you are using it for a variable or paramater.
                   $query_results = mysqli_stmt_get_result($stmt);
                   displayTrainerScheduleUpdate($query_results);
                   }     

                
            }
            ?>

   <?php
   //displays schedule
   function displayTrainerSchedule($query_results)
   {
       echo "<table style='width:70%;'>";
       echo "<tr>";
       echo "<th colspan='6'>Schedule Table</th>";
       echo "</tr>";
       echo "<tr>";
       echo "<th>Dates Scheduled</th>";
       echo "<th>Employee FirstName</th>";
       echo "<th>Employee LastName</th>";
       echo "<th>Training Type</th>";
       echo "</tr>";
       $rowcount=mysqli_num_rows($query_results);
       if ($rowcount > 0) {
           foreach ($query_results as $results) {
               echo "<tr><td>" .
                   $results["scheduleDate"] .
                   "</td><td>" .
                   $results["empFirstName"] .
                   "</td><td>" .
                   $results["empLastName"] .
                   "</td><td>" .
                   $results["trainingType"] .
                   "</td></tr>";
           }
       }
       echo "</table>";
   }
   //displays updated schedule
   function displayTrainerScheduleUpdate($query_results)
   {
       echo "<table style='width:70%;'>";
       echo "<tr>";
       echo "<th colspan='4'>Schedule Table</th>";
       echo "</tr>";
       echo "<tr>";
       echo "<th>Dates Scheduled</th>";
       echo "<th>Employee FirstName</th>";
       echo "<th>Employee LastName</th>";
       echo "<th>Member FirstName</th>";
       echo "<th>Member LastName</th>";
       echo "<th>Training Type</th>";
       echo "</tr>";

       if (mysqli_num_rows($query_results) > 0) {
           foreach ($query_results as $results) {
               echo "<tr><td>" .
                   $results["scheduleDate"] .
                   "</td><td>" .
                   $results["empFirstName"] .
                   "</td><td>" .
                   $results["empLastName"] .
                   "</td><td>" .
                   $results["memFirstName"] .
                   "</td><td>" .
                   $results["memLastName"] .
                   "</td><td>" .
                   $results["trainingType"] .
                   "</td></tr>";
           }
       }
       echo "</table>";
   }
   ?>
         </div>
      </div>
      <img src="./graphic/insertIntoMembership.png" alt="Membership" width="400" height="400">
      <img src="./graphic/Demo showing stored procedure membership.png" alt="storedproceedure" width="400" height="400">
   </body>
</html>