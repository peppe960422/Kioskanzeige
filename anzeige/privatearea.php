<?php

session_start(); 
$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "anzeige_tbl";

// Create connection
$conn = new mysqli($servername, $username, $password, $database );
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
else{
        if (isset($_POST['username']) && isset($_POST['password'])) 
        {
         
          $username = mysqli_real_escape_string($conn, $_POST['username']);
          $password = mysqli_real_escape_string($conn, $_POST['password']);
          $HTMLusername =  $_POST['username'];
          $_SESSION['username'] =  $HTMLusername;
          $query = "SELECT * FROM `login_accounts` WHERE login_accounts.username like '$username' AND login_accounts.password like '$password'";
          
          // Esegui la query
          $result = $conn->query($query);

          // Verifica se ci sono risultati
          if ($result->num_rows < 1) {
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
                <p>username oder kennwort falsh eingegeben</p>
                  <button><a href='login.html'>Click hier</a></button>
                  </body>
                  </div>
                  </html>
                  
                
              ";
              } 
              else
              {header("Location: selectmenu copy 3.php");
                exit;}  }
              else {}
      
                
            }
             
                  
              
                

              

  
  
  
  
  
  
              
  
  
  
  
  
   ?>
