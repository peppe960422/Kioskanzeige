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
    
    $Dozent = $_POST['dozent'];
    $Thema = $_POST['thema'];
    $Raum = $_POST['raum'];
    $Jahr = $_POST['jahr'];
    $Monat = $_POST['monat'];
    $Tag = $_POST['tag'];
    $Uhr = $_POST['uhr'];
    $Minuten = $_POST['minuten'];
    $Jahrgang = $_POST['jahrgang'];
    $Jahrgang1 = $_POST['jahrgang1'];
    $Jahrgang2 = $_POST['jahrgang2'];
    $Jahrgang3 = $_POST['jahrgang3'];
    $Fach = $_POST['fach'];
    $Fach1 = $_POST['fach1'];
    $Fach2 = $_POST['fach2'];
    $Fach3 = $_POST['fach3'];
    
    $JargangArray = array();
    $FachArray = array();

    array_push($JargangArray,$Jahrgang,$Jahrgang1,$Jahrgang2,$Jahrgang3);
    array_push($FachArray,$Fach,$Fach1,$Fach2,$Fach3);


    

  $data_sql = date("Y-m-d H:i:s", strtotime("$Jahr-$Monat-$Tag $Uhr:$Minuten"));
  $Raum = intval($Raum);

  if ($Dozent == 'N.A'||$Thema ==  'N.A' || $Raum == 'N.A')
  {

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
                <p>!!!Dozent ,Thema oder Raum müssen ein wert haben!!!</p>
                  <button><a href='selectmenu copy 2.php'>Click hier</a></button>
                  </body>
                  </div>
                  </html>
                  
                
              ";

  }
  else{

$querydozent = "SELECT id FROM `dozenten` WHERE dozenten.dozent_name ='$Dozent';";
$querythema = "SELECT id FROM `thema` WHERE thema.thema_name ='$Thema';";
$queryraum = "SELECT id FROM `raum` WHERE raum.raumnr =$Raum;";

$result = $conn->query($querydozent);
while ($row = $result->fetch_assoc()) 
{  
  $idDozent =  $row["id"];
    }
$result = $conn->query($querythema); 
while ($row = $result->fetch_assoc()) 
{  
  $idThema =  $row["id"];
    }
$result =$conn->query($queryraum); 
while ($row = $result->fetch_assoc()) 
{  
  $idRaum =  $row["id"];
    }


$queryLesson = "INSERT INTO `lesson`( `id_dozent`, `id_thema`, `id_raum`, `datum`) VALUES ('$idDozent','$idThema','$idRaum','$data_sql');";
$conn->query($queryLesson); 

$queryFindid = "SELECT * FROM `lesson` ORDER BY id DESC LIMIT 1;";
        $result_lesson = $conn->query($queryFindid);
        $row_lesson = $result_lesson->fetch_assoc();
        $idLesson = $row_lesson["id"];
       

$FachIdarray = array();

for($j = 0 ; $j < count($FachArray); $j++)
{
  if ($FachArray[$j] != "N.A"){
  $queryFindIdFach= "SELECT `id`, `fach_name` FROM `fach` WHERE `fach_name`= '$FachArray[$j]';";
  $result = $conn->query($queryFindIdFach);
  while ($row = $result->fetch_assoc()) 
{  
  $tIdFach =  $row["id"];
    
}

array_push($FachIdarray, $tIdFach);
  } else {}

}

for($k = 0 ; $k < count($FachIdarray);$k++){
$queryInsertFach = "INSERT INTO `fach_lesson`(`id_fach`, `id_lesson`) VALUES ('$FachIdarray[$k]','$idLesson');";
$conn->query($queryInsertFach);
}

$JahrgangIdarray = array();


for($i = 0 ; $i < count($JargangArray); $i++)
{
  if ($JargangArray[$i] != "N.A"){
  $queryFindIdJahrgang= "SELECT `id`, `jahrgang_name` FROM `jahrgang` WHERE `jahrgang_name`= '$JargangArray[$i]';";
  $result = $conn->query($queryFindIdJahrgang);
  while ($row = $result->fetch_assoc()) 
{  
  $tIdJahrgang =  $row["id"];
    
}
array_push($JahrgangIdarray , $tIdJahrgang);}
else{}}


for($k = 0 ; $k < count($JahrgangIdarray);$k++){
 $queryInsertJahr = "INSERT INTO `jahrgang_lesson`( `jahrgang_id`, `lesson_id`) VALUES ('$JahrgangIdarray[$k]','$idLesson')";
 $conn->query($queryInsertJahr);
  }

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
    <script>var evento = 'neuladen';
    window.parent.postMessage(evento, 'http://127.0.0.1/anzeige/AnzeigeGut%20copy.php');
    </html>
    
  
";


}}}
else { echo "!!!Sie haben keine berechtigung!!! !!!PERMISSION DENIED!!!";}

?>