<!--session_start()-Tells the server the session has started and helps with on-going actions from user to track
has to be hear above the head or get warning-->
<?php
   session_start( );
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <!--<link rel="stylesheet" href="style.css">-->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>"> 
      <!-- added echo_time() to try to prevent browser caching-->
      <!-- 
         Name of file and purpose:
         Course name:CS235 Server-side Development
         Project: Web Form
         Developer name: Zach Fordahl
         Email: fordahlz@csp.edu
         Date: 11/2/2023
         
         Future Revisions:
         Date:
         Person:
         What was done:
         -->
      <title>Pet Shop</title>
   </head>
   <body>
      <?php
         /**$_Server['php_self"] allows you to get csc code from the same page as you are using rather then calling an exterior page.
          * Ensures if you run the file it will call itself.
          * The if(array_key_exist )hidden flag checks to see if a hidden flag set and it is how it knows what to pass to on the switch.
          This function is to see if a specific value from the form exist example hiddenflag from both add and delete.
          */
            $self = $_SERVER['PHP_SELF'];
            
            if(array_key_exists('hiddenFlag', $_POST))
            {
             echo "<h2>Welcome back!</h2>";
            
             $submitFlag = $_POST['hiddenFlag'];
            // echo "DEBUG: hidSubmitFlag is: $submitFlag<br />";
             //echo "DEBUG: hidSubmitFlag is type of: " . gettype($submitFlag) . "<br />";
            // Get the array that was stored as a session variable
            
             $petStoreInvArr = unserialize(urldecode($_SESSION['serializedArray']));
            
         
             /** Switch that is called to add, delete or display it looks at the hidden value form object. Add form object
              * has value set to 01 and delete form object has value to 99 if switch sees these two it will pick one or the other 
              * if it sees nothing it will default to the display
              */
             switch($submitFlag)
             {
             case "01": addRecord( );
             break;
            
             case "99": deleteRecord( );
             break;
            
             default: display();
             }
            
            
            }
            
            
            else
            {
             echo "<h2>Welcome to the Pet Shop!</h2>";
             /** Created a fixed array to generate table entries to start the program */
             $petStoreInvArr = array( );
             $petStoreInvArr[0][0] ="1111";
             $petStoreInvArr[0][1] ="Sandy";
             $petStoreInvArr[0][2] ="200.00";
             $petStoreInvArr[0][3] ="Dog";
            
             $petStoreInvArr[1][0] ="2222";
             $petStoreInvArr[1][1] ="Meiko";
             $petStoreInvArr[1][2] ="500.00";
             $petStoreInvArr[1][3] ="Dog";
            
             $petStoreInvArr[2][0] ="3333";
             $petStoreInvArr[2][1] ="Crabby";
             $petStoreInvArr[2][2] ="10.00";
             $petStoreInvArr[2][3] ="Crab";
            
             
             $_SESSION['serializedArray'] = urlencode(serialize($petStoreInvArr));
            }
            
            /** add record looks at global array adds element animal id, name, price, type to the array and then sorts
             * array
             */
            function addRecord( )
            {
             global $petStoreInvArr;
             //telling PHP we want to access the global array petStoreInvArr by making global any changes will reflect to all areas in code
             
             $petStoreInvArr[ ] = array($_POST['txtAnimalId'],
             $_POST['txtAnimalName'],
             $_POST['txtAnimalPrice'],
             $_POST['txtAnimalType']);
            
             sort($petStoreInvArr);
            
             $_SESSION['serializedArray'] = urlencode(serialize($petStoreInvArr));
            } // end of addRecord( )
            
            /** delete record gets lstItem from delete html object and addes it to deleteMe global variable then 
             * users unset function to remove that element from array
             */
            function deleteRecord( )
            {
             global $petStoreInvArr;
             global $deleteMe;
             // Get the selected index from the lstItem
             $deleteMe = $_POST['lstItem'];
             // echo "DEBUG: \$deleteMe is: " . $_POST['lstItem'];
            
             // Remove the selected index from the array
             unset($petStoreInvArr[$deleteMe]);
            
             $_SESSION['serializedArray'] = urlencode(serialize($petStoreInvArr)); 
             //only string variables can be stored in $_session so serialize turns into long string
            } // end of deleteRecord( )
            
            /** display function create html table then loops through 2d array $petStoreInvArray and pulls out details from each row column
             * and adds it to the table to display on the URL
             */
            function display( )
            {
             global $petStoreInvArr;
             echo "<table border='1' id='petTable'>";
            
             // display the header
             echo "<tr>";
             echo "<th>Pet ID</th>";
             echo "<th>Pet Name</th>";
             echo "<th>Pet Cost</th>";
             echo "<th>Pet Type</th>";
             echo "</tr>";
            
             foreach($petStoreInvArr as $key => $record)
             {
             echo "<tr>";
            
             foreach($record as $key2 =>$value)
             {
             echo "<td>$value</td>";
             }
             echo "</tr>";
             }
            
             echo "</table>";
            
            } // end of display( )
            ?>
            <!-- end of PHP and start of HTML code. Header holds logo image and formsection holds add and delete form. Formsection is 
            created in a div to be able to style with flex-->
      <header>
         <img id= 'imgLogo' src="graphic/petshp.jpg" alt="imageLogo" />
      </header>
      <!--Calls PHP display to show table-->
      <?php display( ); ?>
      <div id="formSection">
         <!--Add form allows users to be able to ad Pet information such as ID,Name,Cost and type.
            It also has a hidden object that is passed to a switch. The switch looks for the hidden value of 01 and the case in the switch
            then knows where to pass to the correct method. The switch then calls the add method and adds the element to the 
            array-->
         <form action="<?php $self ?>"
            method="POST"
            name="frmAdd">
            <fieldset id="fieldsetAdd">
               <legend>Add Pet To Pet Shop Inventory</legend>
               <label for="txtAnimalId">Pet Id:</label>
               <input type="text" name="txtAnimalId" id="txtAnimalId" value="000" maxlength="6"/> 
               <!--max lenth to avoid very large id-->
               <br /><br />
               <label for="txtAnimalName">Pet Name:</label>
               <input type="text" name="txtAnimalName" id="txtAnimalName" value="Null" />
               <br /><br />
               <label for="txtAnimalPrice">Pet Cost:</label>
               <input type="text" name="txtAnimalPrice" id="txtAnimalPrice" value="Null" maxlength="7"  
               /> <!--Max length because price not greater then 1000.00-->
               <br /><br />
               <label for="txtAnimalType">Pet Type:</label>
               <input type="text" name="txtAnimalType" id="txtAnimalType" value="Null" size="5" />
               <br /><br />
               <input type='hidden' name='hiddenFlag' id='hiddenFlag' value='01' />
               <input name="btnSubmit" type="submit" value="Add Pet Into Inventory" />
            </fieldset>
         </form>
         <br /><br />
         <!-- The delete form removes elments from the array. It does this by passing the hidden value of 99 to the PHP switch.
            The case in the switch is then called and passes the information to the deleteRecord function. The delete records then
            removes the record from the array-->
         <!--The php call in the delete below is in place to dynamically show the elements that are in the array into the listbox. You
            can then choose the correct record you want to delete from the array based on the elements in the listbox.-->
         <form action="<?php $self ?>"
            method="POST"
            name="frmDelete">
            <fieldset id="fieldsetDelete">
               <legend>Remove Pet From Shop Inventory</legend>
               <label for="lstItem">Select Pet To Remove from Inventory:</label>
               <select name="lstItem" size="1">
               <?php
                  foreach($petStoreInvArr as $key => $lstAnimalRec)
                  {
                  
                  echo "<option value='" . $key . "'>" . $lstAnimalRec[1] . "</option>\n";
                  }
                  ?>
               </select>
               <input type='hidden' name='hiddenFlag' id='hiddenFlag' value='99' />
               <br /><br />
               <input name="btnSubmit" type="submit" value="Remove Pet From Inventory" />
            </fieldset>
         </form>
         </p>
      </div>
   </body>
</html>