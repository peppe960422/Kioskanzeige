<?php 
session_start(); 
if (isset($_SESSION['username'])){
$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "anzeige_tbl";

// Create connection
$conn = new mysqli($servername, $username, $password, $database );
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $newThema = $_POST['newthema'];

  echo $newThema;
 $query = "INSERT INTO `thema`(`thema_name`, `thema_beschreibung`) VALUES ('$newThema','$newThema');";
 $conn->query($query); 

 echo" <!DOCTYPE html> 
 <html lang='en'>  

 <head>  
   <meta charset='UTF-8'>
   <meta http-equiv='X-UA-Compatible' content='IE=edge'>
   <meta name='viewport' content='width=device-width, initial-scale=1.0'>
   <title>Fehler beim login</title>
   <style>
   body{
   font-size: 25px;
   background-color: rgb(162, 201, 201);
   font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
 }


button{
background-color: black;
color: white;

transition :  width 2s,opacity 2s,background-color 2s, color 2s;}

button:hover {

background-color: gray;
color: black;

} 
#box{

   margin-top:15%;
   margin-left:30%;
   

}
</style></head>
<body>
<div id='box'>
 <p>Die Werte wurden in die Datenbank eingegeben. Klicken Sie auf die Schaltfläche, um zurückzugehen</p>
   <button><a href='selectmenu copy 3.php'>Click hier</a></button>
   </body>
   </div>
   </html>
   
 
";

}

else {

  echo "!*!*! fick dich !*!*!";



}}