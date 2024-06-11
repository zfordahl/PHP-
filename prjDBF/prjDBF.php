<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>"> 
      <!-- 
         Name of file and purpose:
         Course name:CS235 Server-side Development
         Project: Display Data
         Developer name: Zach Fordahl
         Email: fordahlz@csp.edu
         Date: 11/7/2023
         
         Future Revisions:
         Date:
         Person:
         What was done:
         -->
    <title>Fetch Database data</title>
</head>
<body>
   <!--Create a html table that holds the product table information-->
   <table id ="databaseTable">
    <tr>
        <th>Product ID</th>
        <th>Product Name</th>
        <th>Price</th>
        <th>Color</th>
        <th>Product Webpage</th>
        <th>Manufacturer</th>
        <th>Manufacturer Webpage</th>
        <th>Department ID</th>
        <th>On Hand Qty</th>
        
    </tr>
   
    <!--This PHP code grabs information from the database and echos it out onto a html table to be displayed
    $conn builds connection with mysql database then runs select statement, pass information into a query to query the product 
    table and returns the columns in the product table, holds in an array and then loops through array and echos out to html table
    -->

    <?php
    $conn = mysqli_connect("localhost", "root", "mysql", "storedatabase");

    if ($conn->connect_error) {
        die("Connection failed" . $conn->connect_error);
    }

    $sql = "SELECT * FROM product;";

    $result = $conn->query($sql);
    /**Loops through results array and echos table information to build html table and add column information from sql database */
    if ($result->num_rows > 0) { 
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>";
            echo $row["productID"];
            echo "</td>";
            echo "<td>";
            echo $row["productName"];
            echo "</td>";
            echo "<td>";
            echo $row["price"];
            echo "</td>";
            echo "<td>";
            echo $row["color"];
            echo "</td>";
            echo "<td>";
            echo $row["productWebpage"];
            echo "</td>";
            echo "<td>";
            echo $row["manufacturer"];
            echo "</td>";
            echo "<td>";
            echo $row["manufacturerWebpage"];
            echo "</td>";
            echo "<td>";
            echo $row["departmentID"];
            echo "</td>";
            echo "<td>";
            echo $row["OnHandQty"];

            echo "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 Results";
    }

    mysqli_close($conn);

    ?>
    <!--Creates a HTML Form with a droplist that is populated from the product table IDs. Then passes that product ID to a php --Create
     Method that queries the employee table and department table by the department ID-->
     <form action="<?php $self; ?>"
            method="POST"
            name="frmDelete">
            <fieldset id="fieldsetDelete">
               <legend>Get Product ID</legend>
               <label for="lstItem">Select Product ID to search:</label>
               <select name="lstItem" size="1">
    <!--HTML form is dynamic by using PHP to look to the product table and return the product ID. Then loop the results to a drop lst
     So any changes made to the table will automatically reflect on the lst
    -->
    <?php

    //build the connection and make sure its active
    $conn = mysqli_connect("localhost", "root", "mysql", "storedatabase");

    if ($conn->connect_error) {
        die("Connection failed" . $conn->connect_error);
    }
    //select statement to get information from product table and send results to array 
    $sql = "SELECT * FROM product;";

    $result = $conn->query($sql);
    //looping through product ID and also adding an all option to look at entire table
    if ($result) {
        echo "<option> All </option>";
        while ($rowl = mysqli_fetch_array($result)) {
            $id = $rowl["productID"];

            echo "<option> $id </option>";
        }
    }
    ?>
   </select>
   <input type='hidden' name='hiddenFlag' id='hiddenFlag' value='99' />
               <br /><br />
               <input name="btnSubmit" type="submit" value="search" />
            </fieldset>
         </form>

<?php
// get value from form list and pass product id too if else, then return department id
//once getting department ID can pass that to other tables to return foreign key relations ship
$val = $_POST["lstItem"];
if ($val == "1000") {
    $val2 = 1;
} elseif ($val == "1001") {
    $val2 = 1;
} elseif ($val == "1002") {
    $val2 = 1;
} elseif ($val == "1003") {
    $val2 = 2;
} elseif ($val == "1004") {
    $val2 = 2;
} elseif ($val == "1005") {
    $val2 = 2;
} elseif ($val == "1006") {
    $val2 = 3;
} elseif ($val == "1007") {
    $val2 = 3;
}
//display returns results for department table and displaytwo return results for employee table
display($val2);
displaytwo($val2);
/** Display function builds connection with database, calls department table and looks for results from department ID
 * If selecting all it will return the entire table or if you choose to pick specific ID it will return the row that have that ID
 */
function display(&$value)
{
    echo "<h2>Department Table</h2>";
    echo "<table id ='databaseTable'>";
    echo "<tr>";
    echo "<th>Department Id</th>";
    echo "<th>Department Type</th>";
    echo "<th>Employee ID</th>";
    echo "</tr> ";
   // conn build to database
    $conn = mysqli_connect("localhost", "root", "mysql", "storedatabase");

    if ($conn->connect_error) {
        die("Connection failed" . $conn->connect_error);
    }
    // checks if all is returned from form or if not then it searches by department id value
    if ($_POST["lstItem"] != "All") {
        $sql = "SELECT * FROM department where departmentid='$value';";
    } else {
        $sql = "SELECT * FROM department;";
    }
    $result = $conn->query($sql);
    //builds html table with results of query
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>";
            echo $row["departmentID"];
            echo "</td>";
            echo "<td>";
            echo $row["departmentType"];
            echo "</td>";
            echo "<td>";
            echo $row["employeeID"];
            echo "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 Results";
    }
}

/** display two does same as display one but looks at employee table and searches by department ID of that employee
 * It also has an all or just one row option
 */

function displayTwo(&$value)
{
    echo "<h2>Employee Table</h2>";
    echo "<table id ='databaseTable'>";
    echo "<tr>";
    echo "<th>Employee Id</th>";
    echo "<th>First Name</th>";
    echo "<th>Last name</th>";
    echo "<th>Age</th>";
    echo "<th> Date of Birth</th>";
    echo "<th>Hire Date</th>";
    echo "<th>Department ID</th>";
    echo "</tr> ";
    // builds connection and looks to results from form. If form shows All then entire database is returned if not it searches by department ID
    $conn = mysqli_connect("localhost", "root", "mysql", "storedatabase");
    if ($conn->connect_error) {
        die("Connection failed" . $conn->connect_error);
    }
    if ($_POST["lstItem"] != "All") {
        $sql = "SELECT * FROM employee where departmentid='$value';";
    } else {
        $sql = "SELECT * FROM employee;";
    }
    $result = $conn->query($sql);
    //while loop to build html table
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>";
            echo $row["employeeID"];
            echo "</td>";
            echo "<td>";
            echo $row["firstName"];
            echo "</td>";
            echo "<td>";
            echo $row["lastName"];
            echo "<td>";
            echo $row["age"];
            echo "<td>";
            echo $row["dateOfBirth"];
            echo "</td>";
            echo "<td>";
            echo $row["startDate"];
            echo "</td>";
            echo "<td>";
            echo $row["departmentID"];

            echo "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 Results";
    }
}
//close database connection
mysqli_close($conn);
?>
<p>
<h3>Development stages for project two went as follows:</h3>    
<ol>
    <li>First, I brainstormed and devised an approach to tackle the project. 
     I wrote down on a piece of paper what needed to be done and what I thought 
     would be the best way of accomplishing the task.</li>
    <li>Second, I created a UML of the database, describing the different parts. 
        This is where I would try to figure out the primary and foreign key relationships,
         the datatypes, and the correct sizes needed.</li>
    <li>Third, I started building the database and linking the tables with the correct columns. </li>
    <li>Fourth, I added the data to the tables to populate the rows.</li>
    <li>Fifth, I wrote down on a piece of paper my approach to PHP, HTML, and CSS.</li>
    <li>Sixth, I started writing the software needed to bring the information from the database to the HTML file using PHP. </li>
    <li>Seventh, I reworked the software to make it more efficient and added the appropriate comments.</li>
    <li>Eight, I used HTML, CSS, and PHP validators to make sure the system was correct,
         along with Accessibility checkers to make sure it was done right. </li>
</ol>

</p>


</body>
</html>