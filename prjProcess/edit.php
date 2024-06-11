<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
         <!-- 
         Name of file and purpose:
         Course name:CS235 Server-side Development
         Project: Software Design Project
         Developer name: Zach Fordahl
         Email: fordahlz@csp.edu
         Date: 11/26/2023
         
         Future Revisions:
         Date:
         Person:
         What was done:
         -->

<style>
    nav{
    background: #0082e6;
    height: 80px;
    width: 100%;
}
label.logo{
    color: white;
    font-size:35px;
    line-height: 80px;
    padding:0 100px;
    font-weight: bold;
}
nav ul{
    float: right;
    margin-right: 20px;
}

nav ul li{
    display:inline-block;
    line-height: 80px;
    margin: 0 5px;


}
nav ul li a{
    color:white;
    font-size: 17px;
    text-transform: uppercase;
    list-style: none;
    text-decoration: none;
    padding: 7px 13px;
    border-radius: 3;

}

a.active, a:hover{
    background: #1b9bff;
    transition: .5s;
}

.displayTable{
    width: 100%;
    height: auto;
    border: 2px solid black;
}

.tableChangeControl{
    display: flex;
    border: 10px solid #0082e6;
    height: auto;
    justify-content: space-around;
    align-items: center;
    flex-wrap: wrap;
}
table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  text-align: left;
  padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
  background-color: #0082e6;
  color: white;
}
#deletedHeader{
   color:#0082e6;
}
</style>
</head>
<body>
<!-- nav bar with logo information-->
<nav>
<label class= "logo"> Zach Fordahl | Software Design Project | Date:<?php echo date("m/d/y")?></label>
    
    <ul>
    <li><a href="./presentation.php">Home</a></li>
        <li><a href="./index.php">Users View</a></li>
        <li><a href="./edit.php">Edit Page</a></li>
        
        
    </ul>
</nav>
<!---->
<div class ="displayTable">

<?php
include "dbfCreate.php";
//Changes name of database

$dbname = nameDatabase("EditDatabase", $flagstatus);
$flagstatus = false;
//$dbname = nameDatabase("NaturalFitnessGoalstw4o",$flagstatus);

// Create connection buildDatabase connection creates connection with database
$conn = buildDatabaseConnection();
// checkDatabaseConnection verify connection and sends message
checkDatabaseConnection($conn);
//dropDatabase removed db with the same name
//dropDatabase($dbname, $flagstatus);

// Create database
$sql = createDatabase($dbname);
//check if database exist
global $flagstatus;
$flagstatus = false;

$flag = functionCheckIfDatabaseExists($conn, $sql, $dbname, $flagstatus);
runQuery($sql, "Creating " . $dbname, false, $flagstatus);
// Select the database
$conn->select_db($dbname);

/*******************************
 * Create the tables
 *******************************/
// Create Table only if database exist and populates table
if ($flag == true) {
    createTable($flagstatus);
    populateTable($conn, $sql, $flagstatus);
}

//displayTable
global $displayOption;
$displayOption = "4";
global $flag;
/**
 * ***************************************Display edit table Data***********************************************
 */
displayTable($conn, $displayOption);
?>
</div>
<!---->
<div class ="tableChangeControl">
<?php
/**
 * ***************************************Gets ID from edit table when button clicked on either update or insert***********************************************
 */
if (isset($_GET["insertId"]) || isset($_GET["UpdateId"])) {
    if (isset($_POST["btnsubmit"])) {
        $date = $_POST["dtDate"];
        $employeeId = $empfirstname = $_POST["txtfname"];
        $emplastname = $_POST["txtlname"];
        $sql = "SELECT `employeeId` FROM `employee` WHERE  `firstName`='$empfirstname' AND `lastName`='$emplastname'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $employeeId = $row["employeeId"];
            }
        }
        $memfirstname = $_POST["txtmemfname"];
        $memlastname = $_POST["txtmemlname"];
        $type = $_POST["txttype"];

        $sql =
            "Insert into schedule(scheduleId,employeeId,scheduleDate,empFirstName,empLastName,memFirstName,memLastName,trainingType)" .
            "VALUES (NULL,'" .
            $employeeId .
            "','" .
            $date .
            "','" .
            $empfirstname .
            "','" .
            $emplastname .
            "','" .
            $memfirstname .
            "','" .
            $memlastname .
            "','" .
            $type .
            "')";

        $query_results = mysqli_query($conn, $sql);
    }
}

if (isset($_POST["chkCheckboxMultipleDeleteBtn"])) {
    echo "test";
    $data = $_POST["chkCheckboxDelete"];
    $extract = implode(",", $data);
    echo $extract;
}
if (isset($_GET["deleteId"])) {
    deleteRecord($conn);
}
/**
 * ***************************************Deletes record***********************************************
 */
function deleteRecord($conn)
{
    if (isset($_GET["deleteId"])) {
        $schId = $_GET["deleteId"];
        //add a revert here possibly
        echo "<form method='post'>";
        echo "<p>Are you sure you want to delete?</p>";
        echo " <input type='checkbox' id='yes' name='chkCheckbox' value='Yes'>";
        echo "<label for='yes'> Yes</label>";
        echo " <input type='checkbox' id='no' name='chkCheckbox' value='No'>";
        echo "<label for='no'> No</label>";
        echo "<button for='Submit' name='btnsubmitval'>Submit </button>";
        echo "</form>";
        echo "<br><br>";

        if (isset($_POST["btnsubmitval"])) {
            $answer = $_POST["chkCheckbox"];

            if ($answer == "Yes") {
                getRecord($schId, $conn);
                $sql = "DELETE FROM `schedule` WHERE scheduleId =$schId";
                $results = mysqli_query($conn, $sql);

                if ($results) {
                    echo "<h1 id='deletedHeader'>Deleted</h1>";
                }
            } else {
                echo "<h1 id='deletedHeader'>Not Deleted</h1>";
            }
        }
    }
}
/**
 * ***************************************Display Record when delete is called***********************************************
 */
function getRecord($schid, $conn)
{
    $sql = "Select * from schedule WHERE scheduleId =$schid;";
    $result = $conn->query($sql);

    echo "<table style='width:100%'id='tableStyle'>";
    echo "<tr><th colspan='11'><h1 id='schtable'>Schedule Table</h1></th></tr>";
    echo "<tr>";
    echo "<th>ScheduleId</th>";
    echo "<th>EmployeeId</th>";
    echo "<th>ScheduleDate</th>";
    echo "<th>Employee FirstName</th>";
    echo "<th>Employee LastName</th>";
    echo "<th>Member FirstName</th>";
    echo "<th>Member LastName</th>";
    echo "<th>Training Type</th>";
    echo "<th colspan='2'>Table Change Controls</th>";
    echo "<th>Insert</th>";
    echo "</tr>";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" .
                $row["scheduleId"] .
                "</td><td>" .
                $row["employeeId"] .
                "</td><td>" .
                $row["scheduleDate"] .
                "</td><td>" .
                $row["empFirstName"] .
                "</td><td>" .
                $row["empLastName"] .
                "</td><td>" .
                $row["memFirstName"] .
                "</td><td>" .
                $row["memLastName"] .
                "</td><td>" .
                $row["trainingType"] .
                "</td></tr>";
        }
        echo "</table>";
    }
}

//if(isset($_GET["UpdateId"])){
updateForm($conn);
//}

/**
 * ***************************************Update table***********************************************
 */
function updateForm($conn)
{
    if (isset($_GET["UpdateId"])) {
        $updateId = $_GET["UpdateId"];
        $sql = "Select * FROM `schedule` WHERE scheduleId =$updateId";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<br><br>";
                echo "<form method='post'>";
                echo "<fieldset>";
                echo "<legend>Update Training Schedule</legend>";
                echo "<tr><label for='dtDate'>Schedule Date:</label>";
                echo "<input type='date' id='dtDate' name='dtDate' value=" .
                    $row["scheduleDate"] .
                    "><br><br>";
                echo "<tr><label for='txtfname'>Employee First Name:</label>";
                echo "<input type='text' id='txtfname' name='txtfname' value=" .
                    $row["empFirstName"] .
                    "><br><br>";
                echo "<tr><label for='txtlname'>Employee Last Name:</label>";
                echo "<input type='text' id='txtlname' name='txtlname' value=" .
                    $row["empLastName"] .
                    "><br><br>";
                echo "<tr><label for='txtmemfname'>Gym Member First Name:</label>";
                echo "<input type='text' id='txtmemfname' name='txtmemfname' value=" .
                    $row["memFirstName"] .
                    "><br><br>";
                echo "<tr><label for='txtmemlname'>Gym Member Last Name:</label>";
                echo "<input type='text' id='txtmemlname' name='txtmemlname' value=" .
                    $row["memLastName"] .
                    "><br><br>";
                echo "<tr><label for='txttype'>Training Type:</label>";
                echo "<input type='text' id='txttype' name='txttype' value=" .
                    $row["trainingType"] .
                    "><br><br>";
                echo "<input type='submit' name='btnsubmit'>";
                echo "</fieldset>";
                echo "</form>";
            }
        }
    }
}

if (isset($_GET["insertId"])) {
    addTableEntry($conn);
}

/**
 * ***************************************Insert into table***********************************************
 */
function addTableEntry($conn)
{
    echo "<br><br>";
    echo "<form method='post'>";
    echo "<fieldset>";
    echo "<legend>Insert into Training Schedule</legend>";
    echo "<tr><label for='dtDate'>Schedule Date:</label>";
    echo "<input type='date' id='dtDate' name='dtDate' value='2023-11-10'><br><br>";
    echo "<tr><label for='txtfname'>Employee First Name:</label>";
    echo "<input type='text' id='txtfname' name='txtfname' value='Hank'><br><br>";
    echo "<tr><label for='txtlname'>Employee Last Name:</label>";
    echo "<input type='text' id='txtlname' name='txtlname' value='Parker'><br><br>";
    echo "<tr><label for='txtmemfname'>Gym Member First Name:</label>";
    echo "<input type='text' id='txtmemfname' name='txtmemfname' value='Brenda'><br><br>";
    echo "<tr><label for='txtmemlname'>Gym Member Last Name:</label>";
    echo "<input type='text' id='txtmemlname' name='txtmemlname' value='Hinke'><br><br>";
    echo "<tr><label for='txttype'>Training Type:</label>";
    echo "<input type='text' id='txttype' name='txttype' value='WeightLifting'><br><br>";
    echo "<input type='submit' name='btnsubmit'>";
    echo "</fieldset>";
    echo "</form>";
}
?>  
<!--DisplaySCheduleUser dispays data from what is on the index file to show changes when editing-->
<?php
global $displayOption;
$displayOption = "5";
global $flag;

displayScheduleUser($conn);
?>

</div>
    
</body>
</html>