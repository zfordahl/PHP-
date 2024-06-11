<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>dbfjoin</title>
    <!-- 
         Name of file and purpose:
         Course name:CS235 Server-side Development
         Project: Week 3 project
         Developer name: Zach Fordahl
         Email: fordahlz@csp.edu
         Date: 11/14/2023
         
         Future Revisions:
         Date:
         Person:
         What was done:
         -->
</head>
<body>
    <p>
        <ol>
        <li>Inner Join: Returns rows when there is a match in both tables. This would be useful when when you are only looking for data that is in both tables.</li>
        <li>Right Join: Returns all rows from the right table, even if there are no matches in the left table. This is useful when you need all records from the right table
        no matter if there are matches in the left. </li>
        <li>Left Join: Returns all rows from the left table, even if there are no matches in the right table. This is useful when you need all records from the left table
        no matter if there are matches in the right. </li>
</ol>
    </p>
<?php
$conn = buildDatabaseConnection();
// checkDatabaseConnection verify connection and sends message
checkDatabaseConnection($conn);
//db name
$dbname = "departmentStoreDatabase";
//send connection to db to get database
$conn->select_db($dbname);
//display table uses join gets data from mysql and then creates table on html
displayTable($conn);

//establish connection
function buildDatabaseConnection()
{
    $servername = "localhost";
    $username = "root";
    $password = "mysql";
    $dbname = "departmentStoreDatabase";
    $connection = new mysqli($servername, $username, $password, $dbname);
    return $connection;
}
//check connection for errors
function checkDatabaseConnection(&$connection)
{
    $flag = false;
    if ($connection->connect_error) {
        $flag = true;
        echo "Check buildDatabase variables: Servername,Username and password.";
        echo "<br/>";
        die("Connection failed: " . $connection->connect_error);
    }
    return $flag;
}
//display take and queries database with right,left and inner join and displays data to a html table
function displayTable($conn)
{
    //right join
    $sql = "SELECT *
        FROM employee
        RIGHT JOIN product
        ON employee.departmentId = product.departmentId;";
    $result = $conn->query($sql);
    echo "<br/>";
    echo "<table style='width:100%'id='tableStyle'>";
    echo "<tr><th colspan='16'style ='text-align:center'><h2>Right Join</h2></th></tr>";
    echo "<tr><th colspan='16'style ='text-align:center'><pre>SELECT *
        FROM employee
        RIGHT JOIN product
        ON employee.departmentId = product.departmentId;</pre></th></tr>";
    echo "<tr>";
    echo "<th>EmployeeId</th>";
    echo "<th>FirstName</th>";
    echo "<th>LastName</th>";
    echo "<th>Age</th>";
    echo "<th>Date of Birth</th>";
    echo "<th>Start Date</th>";
    echo "<th>DepartmentId</th>";
    echo "<th>ProductId</th>";
    echo "<th>ProductName</th>";
    echo "<th>Price</th>";
    echo "<th>Color</th>";
    echo "<th>Product Webpage</th>";
    echo "<th>Manufacturer</th>";
    echo "<th>Manufacturer Webpage</th>";
    echo "<th>DepartmentId</th>";
    echo "<th>On Hand Qty</th>";
    echo "</tr>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" .
                $row["employeeId"] .
                "</td><td>" .
                $row["firstName"] .
                "</td><td>" .
                $row["lastName"] .
                "</td><td>" .
                $row["age"] .
                "</td><td>" .
                $row["dateOfBirth"] .
                "</td><td>" .
                $row["startDate"] .
                "</td><td>" .
                $row["departmentId"] .
                "</td><td>" .
                $row["productId"] .
                "</td><td>" .
                $row["productName"] .
                "</td><td>" .
                $row["price"] .
                "</td><td>" .
                $row["color"] .
                "</td><td>" .
                $row["productWebpage"] .
                "</td><td>" .
                $row["manufacturer"] .
                "</td><td>" .
                $row["manufacturerWebpage"] .
                "</td><td>" .
                $row["departmentId"] .
                "</td><td>" .
                $row["OnHandQty"] .
                "</td></tr>";
        }
        echo "</table>";
        echo "<br/>";
    } else {
        echo "0 results";
    }
    //left join
    $sql = "SELECT *
     FROM product
     left JOIN department
     ON product.departmentId = department.departmentId;";
    $result = $conn->query($sql);
    echo "<br/>";
    echo "<table style='width:100%'id='tableStyle'>";
    echo "<tr><th colspan='11'style ='text-align:center'><h2>Left Join</h2></th></tr>";
    echo "<tr><th colspan='11'style ='text-align:center'><pre>SELECT *
        FROM product
        left JOIN department
        ON product.departmentId = department.departmentId;</pre></th></tr>";
    echo "<tr>";
    echo "<th>ProductId</th>";
    echo "<th>ProductName</th>";
    echo "<th>Price</th>";
    echo "<th>Color</th>";
    echo "<th>Product Webpage</th>";
    echo "<th>Manufacturer</th>";
    echo "<th>Manufacturer Webpage</th>";
    echo "<th>DepartmentId</th>";
    echo "<th>On Hand QTY</th>";
    echo "<th>DepartmentId</th>";
    echo "<th>Department Type</th>";
    echo "</tr>";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" .
                $row["productId"] .
                "</td><td>" .
                $row["productName"] .
                "</td><td>" .
                $row["price"] .
                "</td><td>" .
                $row["color"] .
                "</td><td>" .
                $row["productWebpage"] .
                "</td><td>" .
                $row["manufacturer"] .
                "</td><td>" .
                $row["manufacturerWebpage"] .
                "</td><td>" .
                $row["departmentId"] .
                "</td><td>" .
                $row["OnHandQty"] .
                "</td><td>" .
                $row["departmentId"] .
                "</td><td>" .
                $row["departmentType"] .
                "</td></tr>";
        }
        echo "</table>";
        echo "<br/>";
        echo "<br/>";
    } else {
        echo "0 results";
    }
    //inner join
    $sql = "SELECT *
        FROM product
        JOIN department
        ON product.departmentId = department.departmentId
        join employee
        on product.departmentId =employee.departmentId;";
    $result = $conn->query($sql);

    echo "<table style='width:100%'id='tableStyle'>";
    echo "<tr><th colspan='18'style ='text-align:center'><h2>Join All Tables</h2></th></tr>";
    echo "<tr><th colspan='18'style ='text-align:center'><pre>SELECT *
        FROM product
        JOIN department
        ON product.departmentId = department.departmentId
        join employee
        on product.departmentId =employee.departmentId;</pre></th></tr>";
    echo "<tr>";
    echo "<th>ProductId</th>";
    echo "<th>ProductName</th>";
    echo "<th>Price</th>";
    echo "<th>Color</th>";
    echo "<th>Product Webpage</th>";
    echo "<th>Manufacturer</th>";
    echo "<th>Manufacturer Webpage</th>";
    echo "<th>DepartmentId</th>";
    echo "<th> On Hand QTY</th>";
    echo "<th>DepartmentId</th>";
    echo "<th> departmentType</th>";
    echo "<th> EmployeeID</th>";
    echo "<th> FirstName</th>";
    echo "<th> LastName</th>";
    echo "<th> age</th>";
    echo "<th> Date Of Birth</th>";
    echo "<th> Start Date</th>";
    echo "<th> DepartmentID</th>";
    echo "</tr>";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" .
                $row["productId"] .
                "</td><td>" .
                $row["productName"] .
                "</td><td>" .
                $row["price"] .
                "</td><td>" .
                $row["color"] .
                "</td><td>" .
                $row["productWebpage"] .
                "</td><td>" .
                $row["manufacturer"] .
                "</td><td>" .
                $row["manufacturerWebpage"] .
                "</td><td>" .
                $row["departmentId"] .
                "</td><td>" .
                $row["OnHandQty"] .
                "</td><td>" .
                $row["departmentId"] .
                "</td><td>" .
                $row["departmentType"] .
                "</td><td>" .
                $row["employeeId"] .
                "</td><td>" .
                $row["firstName"] .
                "</td><td>" .
                $row["lastName"] .
                "</td><td>" .
                $row["age"] .
                "</td><td>" .
                $row["dateOfBirth"] .
                "</td><td>" .
                $row["startDate"] .
                "</td><td>" .
                $row["departmentId"] .
                "</td></tr>";
        }
        echo "</table>";
        echo "<br/>";
        echo "<br/>";
    } else {
        echo "0 results";
    }
}
?>
</body>
</html>