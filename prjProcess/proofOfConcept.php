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
</head>
<body>
    <h1>proof of concept</h1>

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
displayScheduleExample($conn);
///display with mass delete,insert,Update,single delete
function displayScheduleExample($conn)
{
    $sql = "Select * from schedule;";
    $result = $conn->query($sql);

    echo "<form  method='post'>";
    echo "<table style='width:100%'id='tableStyle'>";
    echo "<tr><th colspan='12'><h1 id='schtable'>Edit Schedule Table</h1></th></tr>";
    echo "<tr>";
    echo "<th>ScheduleId</th>";
    echo "<th>EmployeeId</th>";
    echo "<th>ScheduleDate</th>";
    echo "<th>Employee FirstName</th>";
    echo "<th>Employee LastName</th>";
    echo "<th>Member FirstName</th>";
    echo "<th>Member LastName</th>";
    echo "<th>Training Type</th>";
    echo "<th colspan='2'> Change Controls</th>";
    echo "<th><button type='submit' name ='delete' id='delete' value='Delete Record'>Delete Multiple Records</button></th>";
    echo "<th><button><a href='?insertId=1'>Insert</a></button></th>";
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
                "</td><td>" .
                "<button><a href='?UpdateId=" .
                $row["scheduleId"] .
                ".'?EmployeeId='" .
                $row["employeeId"] .
                "'>Update</a></button>" .
                "</td><td>" .
                "<button><a href='?deleteId=" .
                $row["scheduleId"] .
                "'>Delete</a></button>" .
                "</td><td>" .
                "<input type='checkbox' name='checkboxId[]' value=" .
                $row["scheduleId"] .
                ">" .
                "</td></tr>";
        }
        echo "</table>";
        echo "</form>";
    } else {
        echo "0 results";
    }

    if (isset($_POST["delete"])) {
        $result = $_POST["checkboxId"];

        foreach ($result as $deleteId) {
            echo "<h3> ID's to del " . $deleteId . "</h3>";
        }
    }
} //display schedule

if (
    isset($_GET["insertId"]) ||
    isset($_GET["UpdateId"]) ||
    isset($_GET["deleteId"])
) {
    echo "<form><fieldset><legend>Form</legend><h3>Populate from from update, Insert or delete. To simulate populate form. </h3></fieldset></form>";
}
displayScheduleUserExampe($conn);

function displayScheduleUserExampe($conn)
{
    $sql = "Select * from schedule;";
    $result = $conn->query($sql);

    echo "<table style='width:100%'id='tableStyle'>";
    echo "<tr><th colspan='6'><h1 id='schtable'>Schedule Table</h1></th></tr>";
    echo "<tr>";
    echo "<th>ScheduleDate</th>";
    echo "<th>Employee FirstName</th>";
    echo "<th>Employee LastName</th>";
    echo "<th>Member FirstName</th>";
    echo "<th>Member LastName</th>";
    echo "<th>Training Type</th>";
    echo "</tr>";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" .
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
    } else {
        echo "0 results";
    }
}

//display schedule
?>

</body>
</html>