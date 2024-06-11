<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
      <title>dbfCreate</title>
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
   
   <style>
      table, th, td {
      border:1px solid black;
      }
   </style>
   </head>
   <body>
      <?php
      //pass the name of db to nameDatabase function and it sends message and passes variable back
      $dbname = nameDatabase("DatabaseTw");

      // Create connection buildDatabase connection creates connection with database
      $conn = buildDatabaseConnection();
      // checkDatabaseConnection verify connection and sends message
      checkDatabaseConnection($conn);
      //dropDatabase removed db with the same name
      dropDatabase($dbname);

      // Create database
      $sql = createDatabase($dbname);
      //check if database exist
      $flag = functionCheckIfDatabaseExists($conn, $sql, $dbname);
      runQuery($sql, "Creating " . $dbname, true);
      // Select the database
      $conn->select_db($dbname);

      /*******************************
       * Create the tables
       *******************************/
      // Create Table only if database exist and populates table
      if ($flag == true) {
          createTable();
          populateTable($conn, $sql);
      }

      //displayTable populates data from database to html table
      displayTable($conn);
      $conn->close();

      /********************************************
       * runQuery( ) - Execute a query and display message
       *    Parameters:  $sql         -  SQL String to be executed.
       *                 $msg         -  Text of message to display on success or error
       *     ___$msg___ successful.    Error when: __$msg_____ using SQL: ___$sql____.
       *                 $echoSuccess - boolean True=Display message on success
       ********************************************/
      function runQuery($sql, $msg, $echoSuccess)
      {
          global $conn;

          // run the query
          if ($conn->query($sql) === true) {
              if ($echoSuccess) {
                  echo $msg . " successful.<br />";
              }
          } else {
              echo "<strong>Error when: " .
                  $msg .
                  "</strong> using SQL: " .
                  $sql .
                  "<br />" .
                  $conn->error;
          }
      } // end of runQuery( )

      //Function to create a connection with database and returns the connection
      function buildDatabaseConnection()
      {
          $servername = "localhost";
          $username = "root";
          $password = "mysql";
          $connection = new mysqli($servername, $username, $password);
          return $connection;
      }
      //checdDatabaseConnection- verifies connection is correct and will tell you to check username,password and server name otherwise
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
      //dropDatabase looks at the database for name and drops db
      function dropDatabase(&$value)
      {
          $sql = "DROP DATABASE " . $value;
          runQuery($sql, "DROP " . $value, true);
      }

      //createdDatabase will create a db if one doesn't exist
      function createDatabase(&$value)
      {
          $createDatabase = "CREATE DATABASE " . $value;
          return $createDatabase;
      }

      //functioncheckIf database exist checks if it already exist and send message back that it was created or not
      function functionCheckIfDatabaseExists($connection, $sql, $dbname)
      {
          $flag = false;
          if ($connection->query($sql) === true) {
              $flag = true;
              echo "The database " .
                  $dbname .
                  " exists or was created successfully!<br />";
          } else {
              echo "Error creating database " .
                  $dbname .
                  ": " .
                  $connection->error;
              echo "<br />";
          }
          return $flag;
      }
      //creatTabe creates all the dase tables
      function createTable()
      {
          $sql = "CREATE TABLE product (
                 productId INT AUTO_INCREMENT PRIMARY KEY,
                 productName varchar(255),
                 price double,
                 color varchar(50),
                 productWebpage varchar(255),
                 manufacturer varchar(255),
                 manufacturerWebpage varchar(255),
                 departmentId int,
                 OnHandQty int); ";

          runQuery($sql, "Table:product", false);

          $sql = "CREATE TABLE department (
                 departmentId INT AUTO_INCREMENT PRIMARY KEY,
                 departmentType varchar(50))";

          runQuery($sql, "Table:department", false);

          $sql = "CREATE TABLE employee (
                     employeeId INT AUTO_INCREMENT PRIMARY KEY,
                     firstName varchar(100),
                     lastName varchar(100),
                     age int(3),
                     dateOfBirth date,
                     startDate date,
                     departmentId int)";
          runQuery($sql, "Table:employee", false);

          $sql = "ALTER TABLE employee 
                     ADD FOREIGN KEY (departmentId) REFERENCES department(departmentId);";
          runQuery(
              $sql,
              "Table:employee has been altered with foreign key",
              false
          );

          $sql = "ALTER TABLE product 
                     ADD FOREIGN KEY (departmentId) REFERENCES department(departmentId);";
          runQuery(
              $sql,
              "Table:product has been altered with foreign key",
              false
          );
      }
      //populateTable creates data entries
      function populateTable($conn, $sql)
      {
          $departmentArray = [["Bath"], ["Kitchen"], ["Bathroom"], ["Bedroom"]];

          foreach ($departmentArray as $department) {
              $sql =
                  "Insert INTO department(departmentId,departmentType)" .
                  "VALUES (NULL,'" .
                  $department[0] .
                  "')";
              runQuery($sql, "New record insert $department[0]", false);
          }

          $employeeArray = [
              ["Michael", null, 59, "1967-01-20", "2000-06-19", 1],
              ["John", "Fritz", 36, "1986-09-14", "2020-07-21", 2],
              ["Liz", "Tabor", 47, "1970-03-23", "2015-01-19", 3],
          ];

          foreach ($employeeArray as $employee) {
              $sql =
                  "Insert into employee(employeeId,firstName,lastName,age,dateOfBirth,startDate,departmentId)" .
                  "VALUES (NULL,'" .
                  $employee[0] .
                  "','" .
                  $employee[1] .
                  "','" .
                  $employee[2] .
                  "','" .
                  $employee[3] .
                  "','" .
                  $employee[4] .
                  "','" .
                  $employee[5] .
                  "')";

              runQuery($sql, "New record insert $employee[0]", false);
          }

          $productArray = [
              [
                  "Bath towel",
                  5.75,
                  "Black",
                  "http://MyStore.com/bathtowel.php",
                  "Cannon",
                  "http://cannonhomes.com/",
                  1,
                  75,
              ],
              [
                  "Wash cloth",
                  0.99,
                  "White",
                  "http://MyStore.com/washcloth.php",
                  null,
                  "http://cannonhomes.com/",
                  1,
                  225,
              ],
              [
                  "Shower curtain",
                  11.99,
                  "White",
                  "http://MyStore.com/showercurtain.php",
                  "LinenSpa",
                  "http://linenspa.com/",
                  1,
                  73,
              ],
              [
                  "Pantry Organizer",
                  3.99,
                  "Clear",
                  "http://MyStore.com/pantryorganizer.php",
                  "InterDesign",
                  "http://www.interdesignusa.com/",
                  2,
                  52,
              ],
              [
                  "Storage Jar",
                  5.99,
                  "Clear",
                  "http://MyStore.com/storagejar.php",
                  "InterDesign",
                  "http://www.interdesignusa.com/",
                  2,
                  18,
              ],
              [
                  "Firm pillow",
                  12.99,
                  "White",
                  "http://MyStore.com/firmpillow.php",
                  "InterDesign",
                  "http://www.interdesignusa.com/",
                  2,
                  24,
              ],
              [
                  "Comforter",
                  34.99,
                  null,
                  "http://MyStore.com/comforter.php",
                  "Cannon",
                  "http://cannonhomes.com/",
                  3,
                  12,
              ],
              [
                  "Rollaway bed",
                  249.99,
                  "Black",
                  "http://MyStore.com/rollawaybed.php",
                  "LinenSpa",
                  "http://linenspa.com/",
                  3,
                  3,
              ],
          ];

          foreach ($productArray as $product) {
              $sql =
                  "Insert into product(productId,productName,price,color,productWebpage,manufacturer,manufacturerWebpage,departmentId,OnHandQty)" .
                  "VALUES (NULL,'" .
                  $product[0] .
                  "','" .
                  $product[1] .
                  "','" .
                  $product[2] .
                  "','" .
                  $product[3] .
                  "','" .
                  $product[4] .
                  "','" .
                  $product[5] .
                  "','" .
                  $product[6] .
                  "','" .
                  $product[7] .
                  "')";

              runQuery($sql, "New record insert $product[0]", false);
          }
      }
      //nameDatbase creates name and sends message
      function nameDatabase($name)
      {
          echo "Database name selected is" . " " . $name;
          echo "<br/>";
          return $name;
      }
      ?>
      <?php //displaytable creates html header from data populated from table

function displayTable($conn)
      {
          $sql = "Select * from department;";
          $result = $conn->query($sql);
          echo "<h1>Department Table</h1>";
          echo "<table style='width:100%'id='tableStyle'>";
          echo "<tr>";
          echo "<th>DepartmentId</th>";
          echo "<th>DepartmentType</th>";
          echo "</tr>";
          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  echo "<tr><td>" .
                      $row["departmentId"] .
                      "</td><td>" .
                      $row["departmentType"] .
                      "</td></tr>";
              }
              echo "</table>";
          } else {
              echo "0 results";
          }

          $sql = "Select * from employee;";
          $result = $conn->query($sql);
          echo "<h1>Employee Table</h1>";
          echo "<table style='width:100%'id='tableStyle'>";
          echo "<tr>";
          echo "<th>EmployeeId</th>";
          echo "<th>FirstName</th>";
          echo "<th>LastName</th>";
          echo "<th>Age</th>";
          echo "<th>Date of Birth</th>";
          echo "<th>Hire Date</th>";
          echo "<th>DepartmentID</th>";
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
                      "</td></tr>";
              }
              echo "</table>";
          } else {
              echo "0 results";
          }

          $sql = "Select * from product;";
          $result = $conn->query($sql);

          echo "<h1>Product Table</h1>";
          echo "<table style='width:100%'id='tableStyle'>";
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
                      "</td></tr>";
              }
              echo "</table>";
          } else {
              echo "0 results";
          }
      } ?>
   </body>
</html>