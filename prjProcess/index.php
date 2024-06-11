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
    /*nav bar*/
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
/*table*/
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
</style>
</head>

<body>

<nav>
    
<label class= "logo"> Zach Fordahl | Software Design Project | Date:<?php echo date("m/d/y")?></label>
    
    <ul>
    <li><a href="./presentation.php">Home</a></li>
        <li><a href="./index.php">Users View</a></li>
        <li><a href="./edit.php">Edit Page</a></li>
        
        
    </ul>
</nav>
<div class ="displayTable">

<?php
include "dbfCreate.php";
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

//displayTable populates data from database to html table
global $displayOption;
$displayOption = "5";
global $flag;

displayScheduleUser($conn);
?>
</div>
    
</body>
</html>