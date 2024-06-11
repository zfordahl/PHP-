
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GetData</title>
            <!-- 
         Name of file and purpose:
         Course name:CS235 Server-side Development
         Project: Midterm
         Developer name: Zach Fordahl
         Email: fordahlz@csp.edu
         Date: 12/9/20203
         
         Future Revisions:
         Date:12/9/20203
         Person:Zach
         What was done:Added form
         -->
</head>
<body>

<?php
include "createDatabase.php";
//create db connection
//calls created database to get database connection and then grabs data from employee table
$conn = buildDatabaseConnection();
$flag = false;
$dbname = nameDatabase("NaturalFitnessGoalstw4o", $flagstatus);

$conn->select_db($dbname);
//select all employee
$sql = "SELECT * FROM `employee` ";
$query_results = mysqli_query($conn, $sql);
//loop through results and pushes to JSON array
if (mysqli_num_rows($query_results) > 0) {
    foreach ($query_results as $emp) {
        $JSON = [
            "employeeId" => $emp["employeeId"],
            "firstName" => $emp["firstName"],
            "lastName" => $emp["lastName"],
            "signinId" => $emp["signinId"],
            "startDate" => $emp["startDate"],
            "title" => $emp["title"],
        ];
        $JSONSEND[] = $JSON;
    }
}
//encode json data and pushes to data from database to json file
$transMittedData = json_encode($JSONSEND);
file_put_contents("data.json", $transMittedData);
?>
    
</body>
</html>
