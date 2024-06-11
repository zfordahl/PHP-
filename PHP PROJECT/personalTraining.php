<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>personalTraining</title>
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

/**Table style */
table {
  font-family: arial, sans-serif;
  width: 30%;
  height:50%;
  padding-left: 60px;
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
</style>
</head>
   <body>
    <!--personal training container to allow display flex with nav and logo-->
      <div class = "PersonalTraining">
         <nav>
            <h2 class="logo"><a href ="./index.php">NaturalFitnessGoals</a></h2>
            <ul>
               <li><a href ="./personalTraining.php">Personal Training</a></li>
               <li><a href ="./membership.php">MemberShip</a></li>
               <li><a href ="./aboutUs.php">About Us</a></li>
               <li><a href ="./myAccount.php">My Account</a></li>
            </ul>
         </nav>
          <!--container to allow display flex and form elements. Form will have dropdown list, check box, date,radio button-->
         <div class="container">
         
            <div class="PersonalTrainingBox">
               <form method="POST" class="PersonalTrainingForm"  autocomplete="off">
               
      
      
                  <fieldset name="personalTrainingFieldSet">
                     <legend name ="personalTrainingLegend">
                        Search Trainer Schedule
                     </legend>
  
                     <label for= "lstTrainingType">Training Type</label>
                     <select name="lstTrainingType">
                    
                    <!--Dynamic dropdown for Trainer name, and dates-->
                     <?php
                     include "createDatabase.php";

                     $conn = buildDatabaseConnection();
                     $dbname = nameDatabase(
                         "NaturalFitnessGoalstw4o",
                         $flagstatus
                     );

                     $conn->select_db($dbname);

                     searchByTrainingType($conn);
                     /** Function to search for trainer type */
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
                     
                     <button type="submit" name="btnsubmitbutton">Submit</button><br>


                     <label for= "lstEmployeFirstName"> First Name</label>
                     <select name="lstEmployeFirstName">
                    

                     <?php
                     $conn = buildDatabaseConnection();
                     $dbname = nameDatabase(
                         "NaturalFitnessGoalstw4o",
                         $flagstatus
                     );

                     $conn->select_db($dbname);

                     searchByEmployeeFirstName($conn);
                     /** Function to search for trainer first and last name*/
                     function searchByEmployeeFirstName($conn)
                     {
                         $sql = "SELECT empFirstName FROM `schedule`;";

                         $query_results = mysqli_query($conn, $sql);
                         echo "<option value= 'Selected'> Selected</option>";
                         if (mysqli_num_rows($query_results) > 0) {
                             foreach ($query_results as $trainingType) {
                                 echo "<option value'" .
                                     $trainingType["empFirstName"] .
                                     "'>" .
                                     $trainingType["empFirstName"] .
                                     "</option>";
                             }
                         }
                     }
                     ?>
                        
                     </select>
                     
                     <button type="submit" name="btnsubmitbuttonTwo">Submit</button>





                     <br><label for= "lstEmployeLastName">Last Name</label>
                     <select name="lstEmployeLastName">
                    

                     <?php
                     $conn = buildDatabaseConnection();
                     $dbname = nameDatabase(
                         "NaturalFitnessGoalstw4o",
                         $flagstatus
                     );

                     $conn->select_db($dbname);

                     searchByEmployeeLastName($conn);

                     function searchByEmployeeLastName($conn)
                     {
                         $sql = "SELECT empLastName FROM `schedule`;";
                         echo "<option value= 'Selected'> Selected</option>";

                         $query_results = mysqli_query($conn, $sql);
                         if (mysqli_num_rows($query_results) > 0) {
                             foreach ($query_results as $trainingType) {
                                 echo "<option value'" .
                                     $trainingType["empLastName"] .
                                     "'>" .
                                     $trainingType["empLastName"] .
                                     "</option>";
                             }
                         }
                     }
                     ?>
                        
                     </select>
                    
                     <button type="submit" name="btnsubmitbuttonThree">Submit</button><br>


                     <label for= "lstschDate">Date</label>
                     <select name="lstschDate">
                    

                     <?php
                     $conn = buildDatabaseConnection();
                     $dbname = nameDatabase(
                         "NaturalFitnessGoalstw4o",
                         $flagstatus
                     );

                     $conn->select_db($dbname);

                     searchByDate($conn);
                     /** Function to search for Date */
                     function searchByDate($conn)
                     {
                         $sql = "SELECT scheduleDate FROM `schedule`;";

                         $query_results = mysqli_query($conn, $sql);
                         echo "<option value= 'Selected'> Selected</option>";
                         if (mysqli_num_rows($query_results) > 0) {
                             foreach ($query_results as $trainingType) {
                                 echo "<option value'" .
                                     $trainingType["scheduleDate"] .
                                     "'>" .
                                     $trainingType["scheduleDate"] .
                                     "</option>";
                             }
                         }
                     }

/**Form to use radio and checkbox and date element */
?>
                     
                     </select>
                     
                     <button type="submit" name="btnsubmitbuttonFour">Submit</button>

                     <p>Please select your Training Type:</p>
                     <input type="radio" id="weights" name="opt" value="WeightLifting">
                     <label for="weights">Weight Lifting</label><br>
                    
                     <input type="radio" id="cardio" name="opt" value="Cardio">
                     <label for="cardio">Cardio</label><br>
                     
                     <input type="radio" id="swimming" name="opt" value="Swimming">
                     <label for="swimming">Swimming</label><br>
                   
                     <input type="radio" id="crossfit" name="opt" value="CrossFit">
                     <label for="crossfit">CrossFit</label>
                     
                     <p>Please select your Trainer:</p>
                      <input type="checkbox" id="weights" name="chk" value="WeightLifting" >
                      <label for="weights"> Hank Parker</label><br>
                      <input type="checkbox" id="cardio" name="chk" value="Cardio">
                      <label for="cardio">Beth Bean </label><br>
                      <input type="checkbox" id="swimming" name="chk" value="Swimming">
                      <label for="swimming">Larry Peterson </label><br>
                      <input type="checkbox" id="crossfit" name="chk" value="CrossFit">
                      <label for="crossfit"> Tim Nelson</label><br>

                     <button type="submit" name="btnsubmitbuttonfive">Submit</button>


                     
                  </fieldset>
               </form>

          
            </div>
            <?php
            /** Get button results and call functions*/

            /**Didn't add prepare statements to this because I don't believe it is needed with drop down list. Hackers aren't able to
             * pick anything besides what is in the list
             */
            if (isset($_POST["btnsubmitbutton"])) {
                $type = $_POST["lstTrainingType"];

                $sql = "SELECT * FROM `schedule` WHERE trainingType='$type' ";
                $query_results = mysqli_query($conn, $sql);

                displayTrainerSchedule($query_results);
            }
            if (isset($_POST["btnsubmitbuttonTwo"])) {
                $type = $_POST["lstEmployeFirstName"];

                $sql = "SELECT * FROM `schedule` WHERE empFirstName='$type' ";
                $query_results = mysqli_query($conn, $sql);
                displayTrainerSchedule($query_results);
            }

            if (isset($_POST["btnsubmitbuttonThree"])) {
                $type = $_POST["lstEmployeLastName"];

                $sql = "SELECT * FROM `schedule` WHERE empLastName='$type' ";
                $query_results = mysqli_query($conn, $sql);
                displayTrainerSchedule($query_results);
            }
            if (isset($_POST["btnsubmitbuttonFour"])) {
                $type = $_POST["lstschDate"];

                $sql = "SELECT * FROM `schedule` WHERE scheduleDate='$type' ";
                $query_results = mysqli_query($conn, $sql);
                displayTrainerSchedule($query_results);
            }

            if (isset($_POST["btnsubmitbuttonfive"])) {
                if (isset($_POST["opt"])) {
                    $type = $_POST["opt"];
                    $sql = "SELECT * FROM `schedule` WHERE trainingType='$type' ";
                    $query_results = mysqli_query($conn, $sql);
                    displayTrainerSchedule($query_results);
                } elseif (isset($_POST["chk"])) {
                    $type = $_POST["chk"];
                    $sql = "SELECT * FROM `schedule` WHERE trainingType='$type' ";
                    $query_results = mysqli_query($conn, $sql);
                    displayTrainerSchedule($query_results);
                }
            }

/** Function to Display */
?>

   <?php function displayTrainerSchedule($query_results)
   {
       echo "<table style='width:70%;'>";
       echo "<tr>";
       echo "<th colspan='4'>Schedule Table</th>";
       echo "</tr>";
       echo "<tr>";
       echo "<th>Schedule Date Available</th>";
       echo "<th>Employee FirstName</th>";
       echo "<th>Employee LastName</th>";
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
                   $results["trainingType"] .
                   "</td></tr>";
               // echo "FirstName:". $results["empFirstName"] ."LastName". $results["empLastName"];
           }
       }
       echo "</table>";
   } ?>
            
         </div>
      </div>
      <img src="./graphic/schexmp.png" alt="scheexp" width="400" height="400">
      <img src="./graphic/InsertIntoSchedule.png" alt="schedule" width="400" height="400">
      <br>
   </body>
</html>