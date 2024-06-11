<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="utf-8">
<!-- 
         Name of file and purpose:
         Course name:CS235 Server-side Development
         Project: Week 5 project
         Developer name: Hacker Defense
         Email: Fordalz@csp.edu
         Date: 11/30/2023
         
         Future Revisions:
         Date:
         Person:
         What was done:
         -->
 <title>Delete Data</title>
<link rel="stylesheet" type="text/css" href="registration.css">


</head>
<body>
<div id="frame">
   
   <h1>Delete Data</h1>

<?PHP
   // Set up connection constants
   // Using default username and password for AMPPS  
   define("SERVER_NAME",   "localhost");
   define("DBF_USER_NAME", "root");
   define("DBF_PASSWORD",  "mysql");
   define("DATABASE_NAME", "sunRun");
   // Global connection object
   $conn = NULL;

   // Link to external library file
   //echo "PATH (Current Working Directory): " . getcwd( ) . "sunRunLib.php" . "<br />";
   require_once(getcwd( ) . "/sunRunLib.php");   
   // Connect to database
   createConnection();

   //* 
   // Quickly empty a table using TRUNCATE
   $sql = "TRUNCATE TABLE runner";
   $result = $conn->query($sql);  
   echo "<p>Table: runner is now empty.</p>";

   $sql = "drop database sunRun";
   $result = $conn->query($sql);  

   /* */ 
?>
   <p>
      <strong>Need to rebuild the database and tables?</strong> Run sunRunCreate.php.
   </p>   
</div> <!-- end of #frame -->
</body>
</html>