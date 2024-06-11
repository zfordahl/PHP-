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

<!--Style for this sheet added and style that all files use is in style.css-->
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
/**table style */
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
/**Container size and color  */
.presentationContainer{
    display: flex;
   
    height: 60vh;
    width: 100%;
    justify-content: space-around;
    align-items: center;
    flex-wrap: wrap;
}

/**Box size  */
.presentationBox{
    width: 18%;
    height: 85%;
    font-size: 1.25em;
    text-align: center;
    border-radius: 25px;
}
/**Box color  */
#pb1{
    background-color:#0082e6;
    color:white;
}

#pb2{
    background-color: #0082e6;
    color:white;
}
#pb3{
    background-color: #0082e6;
    color:white;
}
#pb4{
    background-color: #0082e6;
    color:white;
}
#pb5{
    background-color: #0082e6;
    color:white;
    
}
.presentationContainerBottom{
    display: flex;
   
    height: 800px;
    justify-content: space-around;
    align-items: center;
    flex-wrap: wrap;

}
.presentationBoxBottom{
   
    height: auto;
    font-size: 1.25em;
    text-align: center;
    border-radius: 25px;
}

#pb6 {
    background-color: #0082e6;
    color:white;
    width: 70%;
}
#pb7 {
    background-color: #0082e6;
    color:white;
    width: 25%;
}

#presentationTable{
  border-collapse: collapse;
  width: 100%;
}

#presentationTable th, td {
  text-align: left;
  padding: 8px;
  color:#0082e6
}
#presentationTable tr:nth-child(odd){background-color: white}{}

#presentationTable tr:nth-child(even){background-color: whitesmoke}

#presentationTable th {
  background-color: White;
  color: #0082e6;
}
#schduleTableExmple{
    text-align: center;
}

</style>
</head>
<body>
<!--Nav bar with logo information-->
<nav>
    <label class= "logo"> Zach Fordahl | Software Design Project | Date:<?php echo date("m/d/y")?></label>
    
    <ul>
        <li><a href="./presentation.php">Home</a></li>
        <li><a href="./index.php">Users View</a></li>
        <li><a href="./edit.php">Edit Page</a></li>
        
    </ul>
</nav>
<!--Presentation container is display box to hold information to be presented-->
<div class= "presentationContainer">
    <div class="presentationBox" id="pb1">
    <h4>Who is the Intended target using this application?</h4>
    <ul>
        <li><b>Employees</b> need to be able to easily update and remove data without being highly skilled with computers.</li>
        <li><b>Gym members</b> need to see changes quickly. </li>
    
    </ul>
<!--Boxs hold info about what to ask clients and there response-->
    </div>
    <div class="presentationBox" id="pb2">
    <h5>What would you like to have this application accomplish?</h5>
    
    <ul>
        
        <li><b>Allow Employees to</b> update table information.</li>
        <li><b>Allow Employees to</b> remove table entries.</li>
        <li><b>Update Gym Members</b> quickly and efficiently on schedule changes.</li>

    </ul>
    </div>
    <div class="presentationBox" id="pb3">
    <h5>When do you need this application completed?</h5>
    <ul>
        <li><b>November 26, 2023</b></li>
        
    </ul>
    </div>
    <div class="presentationBox" id="pb4">
    <h5>How simple does the use of this application need to be?</h5>
    <ul>
        <li> <b>Any Employee</b> should be able to use this application, no matter their computer skill level.</li>
        
    </ul>
    </div>

    <div class="presentationBox" id="pb5">
    <h5>Describe some challenges users have experienced with the current system.</h5>
    <ul>
        <li>Manual modification and time-consuming look-ups.</li>
        <li>Much time is needed to look up employee's schedules.</li>
        <li>Members can’t see updates right away.</li>
        <li>Because everyone’s schedule is always changing, the current system is slow and outdated.</li>
        
        
    </ul>
    </div>
</div>
<!--Proposed ideas to solve there problem-->
<div class= "presentationContainerBottom">
    <div class="presentationBoxBottom" id="pb6">
    <h5><b>Idea one:</b><br> The user will add data to an Excel file. 
    The system will then grab the data from the Excel file and then populate the data to an HTML table to allow users to see the changes made. 
    This version will limit the need to understand computers at a high level but will limit what a user can change. 
    This idea will be significantly cheaper and quicker to build but will be much less reliable and not as secure as idea two.</h5>


 <!--Table to show examples-->    
     <table id ='presentationTable'>
        <fieldset>
            <legend>Sample Data</legend>
             
                <tr>
                    <th>EmployeeId</th>
                    <th>Employee First Name</th>
                    <th>Employee Last Name</th>
                    <th>Member First Name</th>
                    <th>Member Last Name</th>
                    <th>Date</th>
                    <th>Membership Type</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Hank</td>
                    <td>Parker</td>
                    <td>Brenda</td>
                    <td>Hinke</td>
                    <td>2023-11-10</td>
                    <td>Weight lifting</td>
                    
                </tr>
                <tr>
                    <td>2</td>
                    <td>Beth</td>
                    <td>Bean</td>
                    <td>Brenda</td>
                    <td>Hinke</td>
                    <td>2023-11-19</td>
                    <td>Cardio</td>
                    
                </tr>
                <tr>
                    <td>3</td>
                    <td>Tim</td>
                    <td>Nelson</td>
                    <td>Brenda</td>
                    <td>Hinke</td>
                    <td>2023-11-15</td>
                    <td>CrossFit</td>
                    
                </tr>
                <tr>
                    <td>4</td>
                    <td>Larry</td>
                    <td>Peterson</td>
                    <td>Brenda</td>
                    <td>Hinke</td>
                    <td>2023-11-10</td>
                    <td>Swimming</td>
                    
                </tr>
            
        </fieldset>
     </table>
     
 
      <p> I believe idea one would offer an extremely simple approach to the problem. 
        It would be cheaper to create and be done much faster, but it does not, however, help as your company grows. 
        It will not be as reliable as option number two, and it will come with a greater number of potential user mistakes.
      
      </p>
      
    </div>
    <br><br><br><br>
    <div class="presentationBoxBottom" id="pb7">
    <h4><b>Idea two:</b><br>Allow users to insert, update, and delete records from a table.
     The Insert will be added via HTML form. The Update and delete will be populated alongside the display table. 
     If the user clicks on delete the record will be removed.
     If the user clicks on Update the data will automatically be pushed to a html form and the user can then update the information. 
    Once they click submit the table will then be updated and will reflect on the user's view table. 
    <a href ="./graphics/UserExample.png">Example of what Users might see</a>
    <a href ="./graphics/EditExample.png">Example of what Edit might be</a>
   


</h4>
<p> I believe option number two is the better of the two approaches. 
    It allows us to create a database and efficiently query the database. 
    If the company expands and needs the user of more tables, they can be easily created and added to the applications. 
    You also can use built-in functions that both PHP and SQL must help improve consistency and build the best and most secure system.

</p>

    </div>
   
</div>


</body>
</html>