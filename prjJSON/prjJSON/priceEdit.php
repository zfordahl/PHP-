<?php
session_start();
//session_destroy();

$counter = $_SESSION["counter"] ?? 0;
$counter = $counter + 1;
$_SESSION["counter"] = $counter;
if ($counter <= 1) {
    $helloMes = "Welcome!!";
    $message = "Page views:" . $counter;
} else {
    $helloMes = "Welcome Back!!";
    $message = "Page views:" . $counter;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src= "https://code.jquery.com/jquery-3.5.1.js"> 
    </script> 
    <title>JSON</title>
          <!-- 
         Name of file and purpose:
         Course name:CS235 Server-side Development
         Project: JSON
         Developer name: Zach Fordahl
         Email: fordahlz@csp.edu
         Date: 12/7/2023
         
         Future Revisions:
         Date:
         Person:
         What was done:
         -->

<style>
legend{
    text-align: center;
    font-size: 24px;
}
input[type=text], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  font-size: 15px;
}

button[type=submit] {
  width: 100%;
  background-color: #008CBA;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 24px;
}
label{
    font-size: 18px;
}
button[type=submit]:hover {
  background-color: black;
}

div {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}
table {
  border-collapse: collapse;
  width: 100%;
  font-size: 24px;
}

th, td {
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #D6EEEE;
}
h1{
    text-align: center;
    color:#008CBA;
    background-color: #f2f2f2;;
}
img{
  width: 500px;
  height: 500px;
}
</style>
</head>
<body>
<h1><?= $helloMes ?></h1>
<p><?= $message ?></p>

<?php
//get json file
$file = file_get_contents("priceData.json");
//push file to session variable
$_SESSION["file"] = urlencode(serialize(json_decode($file, true)));
//make it readable

$jsonObject = unserialize(urldecode($_SESSION["file"]));

//loop and add session variable

form($jsonObject, $counter);

//call the form
?>

<?php function form($jsonObject, $counter)
{
    //put this if statement in because I wanted the data in the form to reflect exactly what was in the display table. The
    //first time it populates it does that but then when you change elements it was on click behind the table. So create a second form
    //after first time log in to reflect the exact data
    if ($counter <= 1) {
        //checks if user count is at one

        echo "<div>";
        echo "<form method='POST' name='edit'>";
        echo "<fieldset>";
        echo "<legend>Product Editor</legend>";
        echo "<table id='tableform'style='width:100% ;border:1px solid black;'>";
        echo "<tr>";
        echo "<th><label for='ptype'>Product Type:</label></th>";
        echo "<th><label for='pri'>Price:</label></th>";
        echo "<th><label for='sku'>SKU:</label></th>";
        echo "<th><label for='des'>Description:</label></th>";
        echo "</tr>";
        //loops to add information to form
        foreach ($jsonObject as $obj) {
            $_SESSION["productType"] = $obj["productType"];
            $_SESSION["price"] = $obj["price"];
            $_SESSION["sku"] = $obj["sku"];
            $_SESSION["description"] = $obj["description"];
            echo "<tr><td>" .
                " <input type='text' id='ptype' name='ptype[]' value='" .
                $_SESSION["productType"] .
                "'>  " .
                "</td><td>" .
                " <input type='text' id='pri' name='pri[]' value='" .
                $_SESSION["price"] .
                "'>  " .
                "</td><td>" .
                " <input type='text' id='sku' name='sku[]' value='" .
                $_SESSION["sku"] .
                "'>  " .
                "</td><td>" .
                " <input type='text' id='des' name='des[]' value='" .
                $_SESSION["description"] .
                "'>" .
                "</td></tr>";
        }
        echo "</table>";
        echo "<button type='submit' name='Submit'>Save</button><br><br>";
        echo "</fieldset>";
        echo "</form>";
        echo "</div>";
    } else {
        // form after user get to second session
        echo "<div>";
        echo "<form method='POST' name='edit'>";
        echo "<fieldset>";
        echo "<legend>Product Editor</legend>";
        echo "<table id='tableform'style='width:100% ;border:1px solid black;'>";
        echo "<tr>";
        echo "<th><label for='ptype'>Product Type:</label></th>";
        echo "<th><label for='pri'>Price:</label></th>";
        echo "<th><label for='sku'>SKU:</label></th>";
        echo "<th><label for='des'>Description:</label></th>";
        echo "</tr>";
        $val = 0;
        //gets data from table and applies it to the form
        if (isset($_POST["ptype"])) {
            while ($val < sizeof($_POST["ptype"])) {
                echo "<tr><td>" .
                    " <input type='text' id='ptype' name='ptype[]' value='" .
                    $_POST["ptype"][$val] .
                    "'>  " .
                    "</td><td>" .
                    " <input type='text' id='pri' name='pri[]' value='" .
                    $_POST["pri"][$val] .
                    "'>  " .
                    "</td><td>" .
                    " <input type='text' id='sku' name='sku[]' value='" .
                    $_POST["sku"][$val] .
                    "'>  " .
                    "</td><td>" .
                    " <input type='text' id='des' name='des[]' value='" .
                    $_POST["des"][$val] .
                    "'>" .
                    "</td></tr>";
                $val++;
            }
            echo "</table>";
            echo "<button type='submit' name='Submit'>Save</button><br><br>";
            echo "</fieldset>";
            echo "</form>";
            echo "</div>";
        } else {
            //added here because if you first log in and would hit no buttons it would error because the second form looks to what was
            //populated from the post method. if nothing was placed in the post method the array would not loop correctly and error with null
            //pointer. Adding this else ensures this doesn't happen
            $counter = 1;
            form($jsonObject, $counter);
        }
    }
} ?>
     <?php //displays the table to show what the customer would be seeing and make sure you can see that the edit is working

function display()
     {
         $file = file_get_contents("priceData.json");
         $_SESSION["file"] = urlencode(serialize(json_decode($file, true)));
         // $obj =json_decode( $file,true);
         global $obj;
         $obj = unserialize(urldecode($_SESSION["file"]));
         echo "<h1>Customer View without AJAX</h1>";
         echo "<table style='width:100% ;border:1px solid black;'>";
         echo "<tr>";
         echo "<th>Product Type</th>";
         echo "<th>Price</th>";
         echo "<th>SKU</th>";
         echo "<th>Description</th>";

         echo "</tr>";
         foreach ($obj as $product) {
             echo "<tr><td>" .
                 $product["productType"] .
                 "</td><td>" .
                 $product["price"] .
                 "</td><td>" .
                 $product["sku"] .
                 "</td><td>" .
                 $product["description"] .
                 "</td></tr>";
         }

         echo "</table>";
         // unset($_SESSION['file']);
         //edit($obj);
     } ?>



<?php
//post method adds to session method then is used for the forms above
if (isset($_POST["Submit"])) {
    $_SESSION["productType"] = $_POST["ptype"];

    $_SESSION["price"] = $_POST["pri"];

    $_SESSION["sku"] = $_POST["sku"];

    $_SESSION["description"] = $_POST["des"];

    $counter = 0;
    $pet = [];

    //loops through and adds elements to the JSON array then copys to the session
    while ($counter < sizeof($_SESSION["productType"])) {
        $_SESSION["file"] = [
            "productType" => $_SESSION["productType"][$counter],
            "price" => doubleval($_SESSION["price"][$counter]),
            "sku" => intval($_SESSION["sku"][$counter]),
            "description" => $_SESSION["description"][$counter],
        ];
        //Copy session to the JSON method to be encoded and sent to the JSON file
        $pet[] = $_SESSION["file"];
        //$ret= json_encode($test);
        // file_put_contents("priceData.json",$ret,FILE_APPEND);
        $counter++;
    }
    //encodes and sends info to JSON file to be used again
    $json = json_encode($pet);
    file_put_contents("priceData.json", $json);

    // display();
}
display();
?>
    <p>
    What is AJAX?
    A software that makes web applications more responsive to users.  When users interact with a web application without AJAX the page needs to be refreshed to see the changes. When web applications use AJAX, the system will respond in the background without the system needing to refresh. <br><br>
    You do not need to have a static JSON file to use it on PHP. You for example can place JSON inside a script tag on an HTML file and use it like that, rather than grab it from an external JSON file. You then can manipulate it with AJAX or with PHP just like you would if you called a JSON file. <br><br>

    Algorithm showing steps involved Using JSON getting data from the database and then responding to JSON data using AJAX.<br>
      <ol>
        <li>You would first create PHP to build a connection to the database. </li>
        <li>You can then create a select statement and grab the data from the database.</li>
        <li>Then create a JSON array and a while loop to pass the data from the database to the JSON array.</li>
        <li>Use the json_encode function to convert the array to readable format.</li>
        <li>Then you would create an AJAX script to pull the data from the JSON array and populate it to the area on the PHP file you want it to show.  </li>
        
      </ol>
      <img src="./flowchart.png" alt="flowchart">
    </p>
    <h1>Customer View with AJAX</h1>
    <table id='table' style='width:100% ;border:1px solid black;'> 
            <!-- HEADING FORMATION -->
            <tr> 
                <th>Product Type</th> 
                <th>Price</th> 
                <th>SKU</th> 
                <th>Description</th> 
            </tr> 
           
  <script>        
   $(document).ready(function () { 
  
//call the JSON file
  $.getJSON("./priceData.json",  
          function (data) { 
      var productInfo = ''; 

    //loop through data 
      $.each(data, function (key, dataValue) { 

          productInfo += '<tr>'; 
          productInfo += '<td>' +  
          dataValue.productType + '</td>'; 

          productInfo += '<td>' +  
          dataValue.price + '</td>'; 

          productInfo += '<td>' +  
          dataValue.sku + '</td>'; 

          productInfo += '<td>' +  
          dataValue.description + '</td>'; 

          productInfo += '</tr>'; 
      }); 
        
      //Insert into table  
      $('#table').append(productInfo); 
  }); 
}); 
</script> 
    </table>
</body>
</html>