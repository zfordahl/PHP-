
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <script src= "https://code.jquery.com/jquery-3.5.1.js"> </script>
      <title>JSON DATA</title>
      <link rel="stylesheet" href="style.css">
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
   
<style>
table {
  font-family: arial, sans-serif;
  width: 40%;
  height:50%;
  padding-left: 70px;
  padding-top:40px;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}


h3{
    padding-left: 20px;
    color:white;
}
a{
    padding-left: 20px;
    color:white;}
</style>
</head>

<body>
      <!--Nav bar-->
      <div class = "aboutUs">
         <nav>
            <h2 class="logo"><a href ="./index.php">NaturalFitnessGoals</a></h2>
            <ul>
               <li><a href ="./personalTraining.php">Personal Training</a></li>
               <li><a href ="./membership.php">MemberShip</a></li>
               <li><a href ="./aboutUs.php">About Us</a></li>
               <li><a href ="./myAccount.php">My Account</a></li>
            </ul>
         </nav>
<!-- Use AJAX to extract data from data.json file and push to html table-->

<table id='table'> 
            <!-- HEADING FORMATION -->
            <tr> 
               
                <th>First Name</th> 
                <th>Last Name</th> 
                <th>Start Date</th> 
                <th>Title</th> 
            </tr> 
         
<script>   
//AJAX grabs data from data from data.json and then loops through file. Then createds html td, responsive to changes made in the json file     
   $(document).ready(function () { 
  
//call the JSON file
  $.getJSON("data.json",  
          function (data) { 
      var empInfo = ''; 

    //loop through data 
      $.each(data, function (key, dataValue) { 

          empInfo += '<tr>'; 

          empInfo += '<td>' +  
          dataValue.firstName + '</td>'; 

          empInfo += '<td>' +  
          dataValue.lastName + '</td>';

          empInfo += '<td>' +  
          dataValue.startDate + '</td>'; 

          empInfo += '<td>' +  
          dataValue.title + '</td>'; 

          empInfo += '</tr>'; 
      }); 
        
      //Insert into table  
      $('#table').append(empInfo); 
  }); 
}); 

</script> 
</table>

</body>
<footer>
<?php
//team name and hyper link
echo "<br><br><br><br><br>";
echo "<h3>Team Name:Zach Fordahl</h3>";
echo "<a href='https://naturalfitnessgoals.com/'>NaturalFitnessGoals.com</a>";
?>
</footer>
</html>