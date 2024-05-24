
<?php
session_start(); 
$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "anzeige_tbl";

// Create connection
$conn = new mysqli($servername, $username, $password, $database );
echo"<title>Login erfolgreich</title>";
                  
                  class Lesson {
              
                    public $Raum ;
                    public $Datum  ;
                    public $Fachlist = array();
                    public $Dozent ;
                    public $Thema;
                    public $Jahrganglist = array() ;
                    
                  
                    public function __construct($Raum, $Datum,$Dozent,$Thema) {
                      $this->Raum = $Raum;
                      $this->Datum = $Datum;   
                      $this->Dozent = $Dozent;
                      $this->Thema= $Thema;
                    
                      
                        
                  
                    
                  }
                  
                  }

                  
                   class Dozent {
                        public $Name; 
                        public $Id;
                        
                        
                        public function __construct($Name,$Id)
                        {
                          $this->Name = $Name;
                          $this->Id = $Id;   

                        }

                   }

                   class Thema{

                      public $Title;
                      public $Id;
                      public function __construct($Title,$Id)
                      {

                        $this->Title= $Title;
                        $this->Id = $Id;   

                      } }

                  class Raum {

                      public $Nummer;
                      public $Id; 
                      public function __construct($Nummer,$Id)
                      {

                        $this->Nummer= $Nummer;
                        $this->Id = $Id;   

                      }


                  }

                  class Datum {
                      public $Tag;
                      public $Monat;
                      public $Jahr;
                      public $Uhr;
                      public $Min;
                  }

                  class Jahrgang {
                    public $Jahrgang;
                    public $Id;
                    public function __construct($Jahrgang,$Id)
                    {

                      $this->Jahrgang= $Jahrgang;
                      $this->Id = $Id;   

                    }


                  }

                  class Fach{
                      public $Fach;
                      public $Id;
                      public function __construct($Fach,$Id)
                      {

                        $this->Fach= $Fach;
                        $this->Id = $Id;   

                      }
                  }


                   
                          $query = "SELECT*FROM dozenten; ";
                          
                          $result = $conn->query($query);

                          $listDozenten = array();

                          while ($row = $result->fetch_assoc()) 
                          {
                          
                            $DozentName =  $row["dozent_name"] ;
                            $DozentId =  $row["id"];
                            $tDozent = new Dozent($DozentName,$DozentId);
                            array_push($listDozenten,$tDozent)
                        ;
                              }

                              $query2 = "SELECT *FROM thema; ";

                              $result2 = $conn->query($query2);
                              $listThema = array();
                              
                            while ($row = $result2->fetch_assoc()) 
                            {
                            
                              $ThemaName =  $row["thema_name"] ;
                              $ThemaId =  $row["id"];
                              $tThema = new Thema($ThemaName,$ThemaId);
                              array_push($listThema,$tThema);

                            }
                          ;

                          
                          $query3 = "SELECT *FROM raum; ";
                          $result3 = $conn->query($query3);
                          $listRaum = array();
                          
                          
                          while ($row = $result3->fetch_assoc()) 
                  {
                  
                    $Raumnr =  $row["raumnr"] ;
                    $RaumId =  $row["id"];
                    $tRaum = new Raum($Raumnr,$RaumId);
                    array_push($listRaum,$tRaum)
                ;
                      }

                      $query4 = "SELECT * FROM `jahrgang`;";
                      $result4 = $conn->query($query4);
                      $listJahrgang = array();
                      while ($row = $result4->fetch_assoc()) 
                      {
                      
                        $Jahrgang =  $row["jahrgang_name"] ;
                        $JahrgangId =  $row["id"];
                        $tJahrgang = new Jahrgang($Jahrgang,$JahrgangId);
                        array_push($listJahrgang,$tJahrgang)
                    ;
                          }

                          $query5 = "SELECT * FROM `fach`;";
                      $result5 = $conn->query($query5);
                      $listFach = array();
                      while ($row = $result5->fetch_assoc()) 
                      {
                      
                        $Fach =  $row['fach_name'] ;
                        $FachId =  $row["id"];
                        $tFach = new Fach($Fach,$FachId);
                        array_push($listFach,$tFach);
                          }
                          $DozentVuoto = new Dozent("N.A","N.A");
                          array_unshift( $listDozenten, $DozentVuoto );
                          $ThemaVuoto = new Thema("N.A","N.A");
                          array_unshift( $listThema, $ThemaVuoto );
                          $RaumVuoto = new Raum("N.A","N.A");
                          array_unshift( $listRaum, $RaumVuoto );
                          $JahrgangVuoto = new Jahrgang("N.A","N.A");
                          array_unshift( $listJahrgang, $JahrgangVuoto );
                          $FachVuoto = new Fach("N.A","N.A");
                          array_unshift( $listFach, $FachVuoto);
                      


?>


<!DOCTYPE html> 
<html lang="en">  

<head>  
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olympia2024</title>
    <style>
 body{
    font-size: 25px;
    background-color: rgb(162, 201, 201);
    font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    margin: 0; /* Rimuovi il margine predefinito del corpo della pagina */
            padding: 10px; 
 }

 #loginFields{
margin-top: 15%;
margin-left: 40%;


 }
 #btnLogin{
 background-color: black;
 color: white;

 transition :  width 2s,opacity 2s,background-color 2s, color 2s;}

 #btnLogin:hover {

background-color: gray;
color: black;




 }
 #appari {

  display : block;
  padding: 5px;
 }
 #appariFach{

display : block;
padding: 5px;
}

 
 #datum
 {
background-color: darkgray;
display : inline-block;
padding: 40px;
border-radius: 50px;
border-width: 5px;
border-style: solid;
border-color: black;
margin-top: 0%;

 }
 #fachBox {background-color: darkgray;
display : inline-block;
padding: 40px;
border-radius: 50px;
border-width: 5px;
border-style: solid;
border-color: black;
margin-top: 0%;
}
#jahrbox{
 
  background-color: darkgray;
display : inline-block;
padding: 40px;
border-radius: 50px;
border-width: 5px;
border-style: solid;
border-color: black;
margin-top: 0%;

}
#calendarPic

{
width: 120;
height:120;
}
 #professorPic{
  padding-top:20px;
  width: 120;
height:120;


}
#containerLesson{
background-color: darkgray;
border-radius: 50px;
display : inline-block;
padding: 40px;
border-width: 5px;
border-style: solid;
border-color: black;
margin-top: 0%;

}
#nascostofach
{
display:none;

}
#nascosto
{
display:none;

}
button{
  color:white;
  border-radius: 20px;
  background-color:black;
  padding :20px;
  font-size: 20;
  margin-top : 1%;
}

button:hover

{
  background-color:grey;

}
#bfw{

  margin-left: 85%;
}
  


    </style> 
</head>
</head>

<body>
<div><img id ="bfw" src="Bfw_logo.png"alt="Mia Immagine"></div>

<form method="post" action="insert_query.php">
          <div id = 'containerLesson'>      
          <label for='menu'>Dozent:</label>
          <select id='dozent' name='dozent' >
         
    <?php for ($i = 0; $i < count($listDozenten); $i++) {
        $tDozent = $listDozenten[$i]->Name;
    ?>
        <option value="<?php echo $tDozent; ?>"><?php echo $tDozent; ?></option>
    <?php } ?>
    </select>
    <br></br>
    <label for='thema'>Thema:</label>
    <select id='thema' name='thema' >
    <?php for ($i = 0; $i < count($listThema); $i++) {
        $tThema = $listThema[$i]->Title;
    ?>
        <option value="<?php echo $tThema; ?>"><?php echo $tThema; ?></option>
    <?php } ?>
    </select>
    <br></br>
    <label for='raum'>Raum:</label>
    <select id='raum' name='raum' >
    <?php for ($i = 0; $i < count($listRaum); $i++) {
        $tRaum = $listRaum[$i]->Nummer;
    ?>
        <option value="<?php echo $tRaum; ?>"><?php echo $tRaum; ?></option>
    <?php } ?>
    </select>
    <div class= "imgcont2">
<img id ="professorPic" src="classroom-computer-icons-training-class-room-0b35bec72f49ee0b67aefc96d272b75e.png"alt="Immagine">
              </div>
    </div>
   
    <!-- <br></br> -->
          

          <div id = "datum" >
             <label for='menu'>Tag:</label>
            <select id='tag' name='tag' >

             <?php for ($Tag= 1; $Tag < 32;$Tag++)
                                  {?>
                                  
                                  <option value ="<?php echo strval($Tag);?>" ><?php echo strval($Tag);?></option>
                                  <?php } ?>

              </select>
              
              <label for='menu'>Monat:</label>
            <select id='monat' name='monat'>
              <?php for ($Monat= 1; $Monat < 13;$Monat++)
                                  {?>
                                  
                                  <option ><?php echo strval($Monat);?></option>
                                  <?php } ?>

              </select>

              <label for='menu'>Jahr:</label>
            <select id='jahr' name='jahr'>
                                  
              <?php for ($Jahr= 2024; $Jahr < 2065;$Jahr++)
                                  {?>
                                  
                                  <option ><?php echo strval($Jahr);?></option>
                                  <?php } ?>

              </select>
              <br></br>
              <label for='menu'>Uhr:</label>
            <select id='uhr' name='uhr'>
                                  
              <?php for ($Uhr= 0; $Uhr < 24;$Uhr++)
                                  {?>
                                  
                                  <option ><?php echo strval($Uhr);?></option>
                                  <?php } ?>

              </select>
              <label for='menu'> : </label>
            <select id='Minuten' name='minuten'>
                                  
              <?php for ($i= 0; $i < 60;$i++)
                                  {?>
                                  
                                  <option ><?php echo strval($i);?></option>
                                  <?php } ?>

              </select>
              <div class= "imgcont">
<img id ="calendarPic" src="—Pngtree—calendar time monthly calendar chart_5324170.png"alt="Mia Immagine">
              </div>
</div> 

<br> </br>
       
             <div id = "jahrbox">
              <label for='menu'>Jahrgang:</label>
            <select id='jahrgang' name='jahrgang'>";
                                  
              <?php for ($i= 0; $i < count($listJahrgang);$i++)
                                  {$tJahrgang =$listJahrgang[$i]->Jahrgang?>
                                  
                                  <option ><?php echo $tJahrgang;?></option>
                                  <?php } ?>

              </select>
              <div id = 'nascosto'>
             <?php for ($j = 1; $j <= 3; $j++) {
    echo "<select class='nascosto' name='jahrgang$j'>";
    for ($i = 0; $i < count($listJahrgang); $i++) {
        $tJahrgang = $listJahrgang[$i]->Jahrgang;
        echo "<option>{$tJahrgang}</option>";
    }
    echo "</select>";
}?> </select>
                                                      </div>
                                                      <button id="appari" type="button">+</button>   
                                                      
                                                      </div>

                                                      <div id = "fachBox">                                                      
            <label for='menu'>Fach:</label>
            <select id='fach' name='fach'>
              <?php for ($i= 0; $i < count($listFach);$i++)
                                  {$tFach =$listFach[$i]->Fach?>
                                  
                                  <option ><?php echo $tFach;?></option>
                                  <?php } ?>

              </select>
              <div id = 'nascostofach'>
              
        
                                 <?php for ($j = 1; $j <= 3; $j++) {
    echo "<select class='nascosto' name='fach$j'>";
    for ($i = 0; $i < count($listFach); $i++) {
        $tFach = $listFach[$i]->Fach;
        echo "<option>{$tFach}</option>";
    }
  echo "</select>";}?>

                                  
                                       
                                                      </div>
                                                     
              

                                                      <button id="appariFach" type="button">+</button>
            

              </div>
              
              <button type="submit">Senden >>></button>
                                  </form>
              
              
              
             
              
              
        <script>
document.getElementById('appari').addEventListener('click', function() {
    var div = document.getElementById('nascosto');
    if (div.style.display === 'none') {
        div.style.display = 'block';
    } else {
        div.style.display = 'none';
    }
});
document.getElementById('appariFach').addEventListener('click', function() {
    var div = document.getElementById('nascostofach');
    if (div.style.display === 'none') {
        div.style.display = 'block';
    } else {
        div.style.display = 'none';
    }
});
</script>

</body>
</html>
