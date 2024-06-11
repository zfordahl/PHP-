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
    table, th, td {
      border:1px solid black;
    }
   </style>
   </head>
   <body>
      <?php
      //pass the name of db to nameDatabase function and it sends message and passes variable back Also to turn logs on or of you need to set $dbflag =True for logs on and false for logs off
      $flagstatus = false;
      $dbname = nameDatabase("NaturalFitnessGoalTest", $flagstatus);

      // Create connection buildDatabase connection creates connection with database
      $conn = buildDatabaseConnection();
      // checkDatabaseConnection verify connection and sends message
      checkDatabaseConnection($conn);
      //dropDatabase removed db with the same name
      // dropDatabase($dbname, $flagstatus);

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
      //$displayOption = "All";
      displayTable($conn, $displayOption);
      $conn->close();

      /********************************************
       * runQuery( ) - Execute a query and display message
       *    Parameters:  $sql         -  SQL String to be executed.
       *                 $msg         -  Text of message to display on success or error
       *     ___$msg___ successful.    Error when: __$msg_____ using SQL: ___$sql____.
       *                 $echoSuccess - boolean True=Display message on success
       ********************************************/
      function runQuery($sql, $msg, $echoSuccess, $flagstatus)
      {
          global $conn;

          // run the query
          if ($conn->query($sql) === true) {
              if ($flagstatus == true) {
                  if ($echoSuccess) {
                      echo $msg . " successful.<br />";
                  }
              }
          } else {
              if ($flagstatus == true) {
                  echo "<strong>Error when: " .
                      $msg .
                      "</strong> using SQL: " .
                      $sql .
                      "<br />" .
                      $conn->error;
              }
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
      function dropDatabase(&$value, $flagstatus)
      {
          $sql = "DROP DATABASE " . $value;
          runQuery($sql, "DROP " . $value, false, $flagstatus);
      }

      //createdDatabase will create a db if one doesn't exist
      function createDatabase(&$value)
      {
          $createDatabase = "CREATE DATABASE " . $value;
          return $createDatabase;
      }

      //functioncheckIf database exist checks if it already exist and send message back that it was created or not
      function functionCheckIfDatabaseExists(
          $connection,
          $sql,
          $dbname,
          $flagcheck
      ) {
          $flag = false;
          if ($connection->query($sql) === true) {
              if ($flagcheck == true) {
                  $flag = true;
                  echo "The database " .
                      $dbname .
                      " exists or was created successfully!<br />";
              }
              $flag = true;
              return $flag;
          } else {
              if ($flagcheck == true) {
                  echo "Error creating database " .
                      $dbname .
                      ": " .
                      $connection->error;
                  echo "<br />";
              }
          }
          return $flag;
      }
      //creatTabe creates all the dase tables
      function createTable($flagstatus)
      {
          $sql = "CREATE TABLE membership (
                 membershipId INT AUTO_INCREMENT PRIMARY KEY,
                 membershipType varchar(255),
                 startDate date,
                 endDate date
                 )";

          runQuery($sql, "Table:membership", false, $flagstatus);

          $sql = "CREATE TABLE signin (
            signinId INT AUTO_INCREMENT PRIMARY KEY,
            userName varchar(255),
            firstName varchar(255),
            lastName varchar(255),
            password varchar(255))";
          runQuery($sql, "Table:signin", false, $flagstatus);

          $sql = "CREATE TABLE member (
            memberId INT AUTO_INCREMENT PRIMARY KEY,
            membershipId int,
            signinId int,
            firstName varchar(255),
            lastName varchar(255),
            startDate date,
            FOREIGN KEY(signinId) REFERENCES signin(signinId),
            FOREIGN KEY(membershipId) REFERENCES membership(membershipId)); ";

          runQuery($sql, "Table:member", false, $flagstatus);

          $sql = "CREATE TABLE employee (
                     employeeId INT AUTO_INCREMENT PRIMARY KEY,
                     firstName varchar(255),
                     lastName varchar(255),
                     signinId int,
                     startDate date,
                     title varchar(255),
                     FOREIGN KEY(signinId) REFERENCES signin(signinId))";
          runQuery($sql, "Table:employee", false, $flagstatus);

          $sql = "CREATE TABLE schedule (
            scheduleId INT AUTO_INCREMENT PRIMARY KEY,
            employeeId int,
            scheduleDate date,
            empFirstName varchar(255),
            empLastName varchar(255),
            memFirstName varchar(255),
            memLastName varchar(255),
            trainingType varchar(255),
            
            FOREIGN KEY(employeeId) REFERENCES employee(employeeId))";
          runQuery($sql, "Table:employee", false, $flagstatus);
          /**CREATE PROCEDUER AREA */
          $sql =
              "CREATE PROCEDURE `insertIntoSignIn`(IN `uName` VARCHAR(255), IN `fName` VARCHAR(255), IN `lName` VARCHAR(255), IN `pWord` VARCHAR(255)) NOT DETERMINISTIC CONTAINS SQL SQL SECURITY DEFINER BEGIN Insert into signin(signinId,userName,firstName,lastName,password) values(NULL,uName,fName,lName,pWord); END";
          runQuery(
              $sql,
              "Create Procedure:InsertIntoSignin",
              false,
              $flagstatus
          );
          $sql =
              "CREATE PROCEDURE `insertIntoMembership`(IN `membtype` VARCHAR(255), IN `startDate` DATE, IN `endDate` DATE) NOT DETERMINISTIC CONTAINS SQL SQL SECURITY DEFINER BEGIN Insert INTO membership(membershipId,membershipType,startDate,endDate) VALUES(NULL,membtype,startDate,endDate); END;";
          runQuery(
              $sql,
              "Create Procedure:InsertIntoMembership",
              false,
              $flagstatus
          );
          $sql =
              "CREATE PROCEDURE `insertIntoEmployee`(IN `empfName` VARCHAR(255), IN `emplName` VARCHAR(255), IN `startDate` DATE, IN `empTitle` VARCHAR(255)) NOT DETERMINISTIC CONTAINS SQL SQL SECURITY DEFINER BEGIN Insert into employee(employeeId ,firstName,lastName,startDate,title) VALUES(NULL,empfName,emplName,startDate,empTitle); END;";
          runQuery(
              $sql,
              "Create Procedure:InsertIntoEmployee",
              false,
              $flagstatus
          );
          $sql =
              "CREATE PROCEDURE `insertIntoMember`(IN `fName` VARCHAR(255), IN `lName` VARCHAR(255), IN `sDate` DATE) NOT DETERMINISTIC CONTAINS SQL SQL SECURITY DEFINER BEGIN Insert into member(memberId,firstName,lastName,startDate) values(NULL,fName,lName,sDate); end;";
          runQuery(
              $sql,
              "Create Procedure:InsertIntoMember",
              false,
              $flagstatus
          );
          $sql =
              "CREATE PROCEDURE `insertIntoschedule`(IN `schDt` DATE, IN `empfName` VARCHAR(255), IN `emplName` VARCHAR(255), IN `memfName` VARCHAR(255), IN `memlname` VARCHAR(255), IN `tType` VARCHAR(255)) NOT DETERMINISTIC CONTAINS SQL SQL SECURITY DEFINER BEGIN Insert into schedule(scheduleId ,scheduleDate,empFirstName,empLastName,memFirstName,memLastName,trainingType) VALUES(NULL,schDt,empfName,emplName,memfName,memlname,tType); end;";
          runQuery(
              $sql,
              "Create Procedure:InsertIntoSchedule",
              false,
              $flagstatus
          );
          $sql =
              "CREATE PROCEDURE `selectAllFromSchedule`() NOT DETERMINISTIC CONTAINS SQL SQL SECURITY DEFINER BEGIN Select * from schedule; End;";
          runQuery(
              $sql,
              "Create Procedure:SelectAllFromSchedule",
              false,
              $flagstatus
          );
      }
      //populateTable creates data entries
      function populateTable($conn, $sql, $flagstatus)
      {
          $membershipArray = [
              ["CrossFit", "2020-01-20", "2022-06-21"],
              ["WeightLifting", "2022-09-21", "2022-09-21"],
              ["Swimming", "2010-08-20", "2022-06-21"],
              ["Biking", "2020-01-20", "2022-06-21"],
          ];

          foreach ($membershipArray as $membership) {
              /*
              $sql =
                  "Insert INTO membership(membershipId,membershipType,startDate,endDate)" .
                  "VALUES (NULL,'" .
                  $membership[0] .
                  "','" .
                  $membership[1] .
                  "','" .
                  $membership[2] .
                  "')";*/
              $sql = "CALL `insertIntoMembership`('$membership[0]', '$membership[1]', '$membership[2]')";
              runQuery(
                  $sql,
                  "New record insert $membership[0]",
                  false,
                  $flagstatus
              );
          }

          $signInIdArray = [
              ["mikeJohnson", "Mike", "Johnson", "jj1983"],
              ["LoriJ", "Lori", "Ridley", "Ajridley"],
              ["zford", "David", "Feord", "zFeord"],
              ["kford", "Coco", "Feord", "kFeord"],
              ["kford", "Coco", "Feord", "bob"],
              ["hparker", "Hank", "Parker", "hparker"],
              ["bbean", "Beth", "Bean", "bbeab"],
              ["tnelson", "Tim", "Nelson", "tnelson"],
              ["lpeterson", "Larry", "Peterson", "lpeterson"],
          ];

          foreach ($signInIdArray as $signInId) {
              /*
              $sql =
                  "Insert into signin(signinId,userName,firstName,lastName,password)" .
                  "VALUES (NULL,'" .
                  $signInId[0] .
                  "','" .
                  $signInId[1] .
                  "','" .
                  $signInId[2] .
                  "','" .
                  $signInId[3] .
                  "')";*/
              $sql = "CALL `insertIntoSignIn`('$signInId[0]', '$signInId[1]', '$signInId[2]', '$signInId[3]')";

              runQuery(
                  $sql,
                  "New record insert $signInId[0]",
                  false,
                  $flagstatus
              );
          }

          $employeeArray = [
              ["Hank", "Parker", "2020-01-20", "Trainer"],
              ["Beth", "Bean", "2020-01-20", "Trainer"],
              ["Tim", "Nelson", "2020-01-20", "Owner"],
              ["Larry", "Peterson", "2020-01-20", "Instructor"],
          ];

          foreach ($employeeArray as $employee) {
              /*$sql =
                  "Insert into employee(employeeId ,firstName,lastName,startDate,title)" .
                  "VALUES (NULL,'" .
                  $employee[0] .
                  "','" .
                  $employee[1] .
                  "','" .
                  $employee[2] .
                  "','" .
                  $employee[3] .
                  "')";*/
              $sql = "CALL `insertIntoEmployee`('$employee[0]', '$employee[1]', '$employee[2]', '$employee[3]');";

              runQuery(
                  $sql,
                  "New record insert $employee[0]",
                  false,
                  $flagstatus
              );
          }
          //getSigninId queries signin id for user and passes id to correct table to populate foreign key

          // loops through and get list of all employees first and last name and then passes to method getsigninId.
          // getsigninID gets signin id from signin table and set signin id to the table employee
          $sql = "Select * from employee;";
          $result = $conn->query($sql);

          while ($row = $result->fetch_assoc()) {
              getSigninid(
                  $conn,
                  "employee",
                  $row["firstName"],
                  $row["lastName"]
              );
          }

          $memberArray = [
              ["Mike", "Johnson", "2022-01-20"],
              ["Lori", "Ridley", "2015-01-20"],
              ["David", "Feord", "2018-01-20"],
              ["Coco", "Feord", "2020-01-20"],
              ["Hank", "Parker", "2010-01-20"],
              ["Beth", "Bean", "2000-01-20"],
              ["Tim", "Nelson", "2017-01-20"],
              ["Larry", "Peterson", "2005-01-20"],
          ];

          foreach ($memberArray as $member) {
              /* $sql =
                  "Insert into member(memberId,firstName,lastName,startDate)" .
                  "VALUES (NULL,'" .
                  $member[0] .
                  "','" .
                  $member[1] .
                  "','" .
                  $member[2] .
                  "')";*/
              $sql = "CALL `insertIntoMember`('$member[0]', '$member[1]', '$member[2]');";

              runQuery(
                  $sql,
                  "New record insert $member[0]",
                  false,
                  $flagstatus
              );
          }

          $memberSignInArray = [
              ["Mike", "Johnson"],
              ["Lori", "Ridley"],
              ["David", "Feord"],
              ["Coco", "Feord"],
              ["Hank", "Parker"],
              ["Beth", "Bean"],
              ["Tim", "Nelson"],
              ["Larry", "Peterson"],
          ];
          foreach ($memberSignInArray as $memberSignin) {
              getSigninid($conn, "member", $memberSignin[0], $memberSignin[1]);
          }

          $scheduleArray = [
              [
                  "2023-11-10",
                  "Hank",
                  "Parker",
                  "Mike",
                  "Johnson",
                  "WeightLifting",
              ],
              ["2023-11-10", "Beth", "Bean", "Lori", "Ridley", "Cardio"],
              ["2023-11-10", "Tim", "Nelson", "David", "Feord", "CrossFit"],
              ["2023-11-10", "Larry", "Peterson", "Coco", "Feord", "Swimming"],
          ];

          foreach ($scheduleArray as $schedule) {
              /* $sql =
                  "Insert into schedule(scheduleId ,scheduleDate,empFirstName,empLastName,memFirstName,memLastName,trainingType)" .
                  "VALUES (NULL,'" .
                  $schedule[0] .
                  "','" .
                  $schedule[1] .
                  "','" .
                  $schedule[2] .
                  "','" .
                  $schedule[3] .
                  "','" .
                  $schedule[4] .
                  "','" .
                  $schedule[5] .
                  "')";*/
              $sql = "CALL `insertIntoschedule`('$schedule[0]', '$schedule[1]', '$schedule[2]', '$schedule[3]', '$schedule[4]', '$schedule[5]');";
              runQuery(
                  $sql,
                  "New record insert $schedule[0]",
                  false,
                  $flagstatus
              );
          }
          //schedule query
          $sql = "Select * from schedule;";
          //$sql="CALL `selectAllFromSchedule`();";
          $result = $conn->query($sql);

          while ($row = $result->fetch_assoc()) {
              setEmployeeId(
                  $conn,
                  "schedule",
                  $row["empFirstName"],
                  $row["empLastName"]
              );
          }
          //member query
          $sql = "Select * from member;";
          $result = $conn->query($sql);

          while ($row = $result->fetch_assoc()) {
              if (
                  $row["firstName"] == "Mike" ||
                  $row["firstName"] == "Lori" ||
                  $row["firstName"] == "David"
              ) {
                  setMembershipId(
                      $conn,
                      "member",
                      $row["firstName"],
                      $row["lastName"],
                      "WeightLifting"
                  );
              } elseif (
                  $row["firstName"] == "Coco" ||
                  $row["firstName"] == "Hank"
              ) {
                  setMembershipId(
                      $conn,
                      "member",
                      $row["firstName"],
                      $row["lastName"],
                      "CrossFit"
                  );
              } else {
                  setMembershipId(
                      $conn,
                      "member",
                      $row["firstName"],
                      $row["lastName"],
                      "Swimming"
                  );
              }
          }
      }
      //Allows you to update membership id in member table by type of membership and searching for member by name
      function setMembershipId($conn, $table, $firstName, $lastName, $type)
      {
          $sql = "update member
        set membershipId=(select membershipId from membership where membershipType='$type')
        where firstName='$firstName' and lastName='$lastName';";
          $conn->query($sql);
      }
      //Allows you to update employeeId by table name and search by first and last name
      function setEmployeeId($conn, $table, $firstName, $lastName)
      {
          $sql = "update $table
         set employeeId=(select employeeId from employee where firstName='$firstName' and lastName='$lastName')
         where empFirstName='$firstName' and empLastName='$lastName';";
          $conn->query($sql);
      }
      //Allows you to add signinID to update table by name and search by user
      function getSigninid($conn, $table, $first, $last)
      {
          $sql = "update $table
         set signinId=(select signinId from signin where firstName='$first' and lastName='$last')
         where firstName='$first' and lastName='$last';";
          $conn->query($sql);
      }

      function flagStatus($flagstatus)
      {
          return $flagstatus;
      }

      //nameDatbase creates name and sends message
      function nameDatabase($name, $flagstatus)
      {
          $flag = $flagstatus;
          if ($flag == true) {
              echo "Database name selected is" . " " . $name;
              echo "<br/>";
              return $name;
          }
          return $name;
      }
      ?>
      <?php //This method allows register to add users to sign in table
      function insertIntoSignIn(
          $username,
          $firstname,
          $lastname,
          $password,
          $flagstatus,
          $conn
      ) {
          $username = urldecode($username); //decode the encoded pword and uname
          $password = urldecode($password);
          /*
           $sql=" CALL `insertIntoSignIn`('$username', '$firstname', '$lastname', '$password');";*/
          $sql = " CALL `insertIntoSignIn`(?, ?, ?, ?);";
          $stmt = mysqli_stmt_init($conn);
          if (!mysqli_stmt_prepare($stmt, $sql)) {
              //checks to see if the delete returns a value
              echo "Failed";
          } else {
              mysqli_stmt_bind_param(
                  $stmt,
                  "ssss",
                  $username,
                  $firstname,
                  $lastname,
                  $password
              );
              //then it executes the statement
              mysqli_stmt_execute($stmt);
              //reuturns the results. Only needed if you are using it for a variable or paramater.
              $query_results = mysqli_stmt_get_result($stmt);

              /*
    $sql = "Insert into signin(signinId,userName,firstName,lastName,password)" .
    "VALUES (NULL,'" .  $username ."','" .$firstname ."','" .$lastname."','" . $password ."')";*/

              runQuery($sql, "New record insert Signin", false, $flagstatus);
          }
      } ?>
      <?php
      function ifUserNameExist($conn, $username)
      {
          $flag = false;

          // $sql= "SELECT `userName` FROM `signin` WHERE userName='$username' ";
          // $query_results = mysqli_query($conn, $sql);
          $sql = "SELECT `userName` FROM `signin` WHERE userName=? ";
          $stmt = mysqli_stmt_init($conn);
          if (!mysqli_stmt_prepare($stmt, $sql)) {
              //checks to see if the delete returns a value
              echo "Failed";
          } else {
              mysqli_stmt_bind_param($stmt, "s", $username);
              //then it executes the statement
              mysqli_stmt_execute($stmt);
              //reuturns the results. Only needed if you are using it for a variable or paramater.
              $query_results = mysqli_stmt_get_result($stmt);
              if (mysqli_num_rows($query_results) > 0) {
                  $flag = true;
              }
              return $flag;
          }
      }
      function ifFirstnameAndLastNameExist()
      {
      }
      ?>
      <?php //displaytable creates html header from data populated from table


      /** display table and the if else allow you to pick which table you want or all of them. You just pass 1-5 or All */
      function displayTable($conn, $tableOpton)
      {
          if ($tableOpton == "1") {
              displayMembershipTable($conn);
          } elseif ($tableOpton == "2") {
              displayEmployeeTable($conn);
          } elseif ($tableOpton == "3") {
              displayMemberTable($conn);
          } elseif ($tableOpton == "4") {
              displaySchedule($conn);
          } elseif ($tableOpton == "5") {
              displaySigninTable($conn);
          } elseif ($tableOpton == "All") {
              displayMembershipTable($conn);
              displayEmployeeTable($conn);
              displayMemberTable($conn);
              displaySchedule($conn);
              displaySigninTable($conn);
          }
      }
      function displayMembershipTable($conn)
      {
          $sql = "Select * from membership;";
          $result = $conn->query($sql);
          echo "<h1>Membership Table</h1>";
          echo "<table style='width:100%'id='tableStyle'>";
          echo "<tr>";
          echo "<th>MemberShipId</th>";
          echo "<th>MemberShipType</th>";
          echo "<th>StartDate</th>";
          echo "<th>EndDate</th>";
          echo "</tr>";
          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  echo "<tr><td>" .
                      $row["membershipId"] .
                      "</td><td>" .
                      $row["membershipType"] .
                      "</td><td>" .
                      $row["startDate"] .
                      "</td><td>" .
                      $row["endDate"] .
                      "</td></tr>";
              }
              echo "</table>";
          } else {
              echo "0 results";
          }
      } //display membershiptable

      function displayEmployeeTable($conn)
      {
          $sql = "Select * from employee;";
          $result = $conn->query($sql);
          echo "<h1>Employee Table</h1>";
          echo "<table style='width:100%'id='tableStyle'>";
          echo "<tr>";
          echo "<th>EmployeeId</th>";
          echo "<th>FirstName</th>";
          echo "<th>LastName</th>";
          echo "<th>SignInID</th>";
          echo "<th>StartDate</th>";
          echo "<th>Title</th>";
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
                      $row["signinId"] .
                      "</td><td>" .
                      $row["startDate"] .
                      "</td><td>" .
                      $row["title"] .
                      "</td></tr>";
              }
              echo "</table>";
          } else {
              echo "0 results";
          }
      }

      function displayMemberTable($conn)
      {
          $sql = "Select * from member;";
          $result = $conn->query($sql);

          echo "<h1>Member Table</h1>";
          echo "<table style='width:100%'id='tableStyle'>";
          echo "<tr>";
          echo "<th>MemberId</th>";
          echo "<th>MembershipId</th>";
          echo "<th>SignInId</th>";
          echo "<th>FirstName</th>";
          echo "<th>LastName</th>";
          echo "<th>StartDate</th>";
          echo "</tr>";

          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  echo "<tr><td>" .
                      $row["memberId"] .
                      "</td><td>" .
                      $row["membershipId"] .
                      "</td><td>" .
                      $row["signinId"] .
                      "</td><td>" .
                      $row["firstName"] .
                      "</td><td>" .
                      $row["lastName"] .
                      "</td><td>" .
                      $row["startDate"] .
                      "</td></tr>";
              }
              echo "</table>";
          } else {
              echo "0 results";
          }
      } //display members

      function displaySchedule($conn)
      {
          $sql = "Select * from schedule;";
          $result = $conn->query($sql);

          echo "<h1>Schedule Table</h1>";
          echo "<table style='width:100%'id='tableStyle'>";
          echo "<tr>";
          echo "<th>ScheduleId</th>";
          echo "<th>EmployeeId</th>";
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
          } else {
              echo "0 results";
          }
      } //display schedule

      function displaySigninTable($conn)
      {
          $sql = "Select * from signin;";
          $result = $conn->query($sql);

          echo "<h1>SignIn Table</h1>";
          echo "<table style='width:100%'id='tableStyle'>";
          echo "<tr>";
          echo "<th>SigninId</th>";
          echo "<th>UserName</th>";
          echo "<th>FirstName</th>";
          echo "<th>LastName</th>";
          echo "<th>Password</th>";
          echo "</tr>";

          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  echo "<tr><td>" .
                      $row["signinId"] .
                      "</td><td>" .
                      $row["userName"] .
                      "</td><td>" .
                      $row["firstName"] .
                      "</td><td>" .
                      $row["lastName"] .
                      "</td><td>" .
                      $row["password"] .
                      "</td></tr>";
              }
              echo "</table>";
          } else {
              echo "0 results";
          }
      }
      ?>
   </body>
</html>