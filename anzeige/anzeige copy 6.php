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

$query = "SELECT d.dozent_name ,l.id , t.thema_name, 
                t.thema_beschreibung , r.raumnr, l.datum 
                FROM lesson l 
                INNER JOIN dozenten d ON l.id_dozent = d.id 
                INNER JOIN thema t ON l.id_thema = t.id 
                INNER JOIN raum r ON l.id_raum = r.id 
                WHERE DATE(datum) = CURDATE() OR DATE(datum) = DATE_ADD(CURDATE(), INTERVAL 1 DAY)
                ORDER BY l.datum ;"
          ;


$result = $conn->query($query);

class Anzeige_Box {
 
  public $Raum ;
  public $Datum  ;
  public $Fachlist = array();
  public $Dozent  ;
  public $ThemaBeschreibung;
  public $ThemaTitle;
  public $Jahrganglist = array() ;
  public $Idlesson;

  public function __construct($Raum, $Datum,$Dozent,$ThemaBeschreibung,$ThemaTitle,$Idlesson) {
    $this->Raum = $Raum;
    $this->Datum = $Datum;   
    $this->Dozent = $Dozent;
    $this->ThemaBeschreibung = $ThemaBeschreibung;
    $this->ThemaTitle = $ThemaTitle;
    $this->Idlesson= $Idlesson;
    
    
    

   
}

}
$lista_box = array();

while ($row = $result->fetch_assoc()) 
 { $box = new Anzeige_Box(
  $row["raumnr"] , 
  $row["datum"],  
  $row["dozent_name"],
   $row["thema_beschreibung"],
   $row["thema_name"],
   $row["id"]  
  
  );
  array_push($lista_box, $box);
  

}

$listaFach = array();
$listaJahr = array();

class Fach {

public $Idlesson;
public $Fach;

public function __construct($Idlesson,$Fach){

$this->Idlesson = $Idlesson;
$this->Fach= $Fach;
 
}

}
class Jahrgang {
  public $Jahrgang;
  public $Idlesson;
  public function __construct($Idlesson,$Jahrgang){
    $this->Idlesson = $Idlesson;
    $this->Jahrgang = $Jahrgang;

  }

  
}



$query2 = "SELECT f.fach_name,l.id 
FROM lesson l 
INNER JOIN fach_lesson fl ON l.id = fl.id_lesson 
INNER JOIN fach f ON fl.id_fach = f.id;"

;

$result2 = $conn->query($query2);

while ($row = $result2->fetch_assoc()) 
 { $tFach = new Fach(
  $row["id"] , 
  $row["fach_name"],  

  
  );
  array_push($listaFach,$tFach );
  

}

for ($i= 0 ; $i < count($lista_box);$i++){
for($j = 0 ;$j < count($listaFach);$j++){
if ($lista_box[$i]->Idlesson == $listaFach[$j]->Idlesson){

  $lista_box[$i]->Fachlist[] = $listaFach[$j]->Fach;
  


}


}


}

$query3= "SELECT j.jahrgang_name,l.id 
          FROM lesson l 
          INNER JOIN jahrgang_lesson jl ON l.id = jl.lesson_id 
          INNER JOIN jahrgang j ON jl.jahrgang_id = j.id;";
          
          
$result3 = $conn->query($query3);
while ($row = $result3->fetch_assoc()) 
 { $tJahr = new Jahrgang(
  $row["id"] , 
  $row["jahrgang_name"],  
  
  );
  array_push($listaJahr,$tJahr);
  

}
for ($i= 0 ; $i < count($lista_box);$i++){
  for($j = 0 ;$j < count($listaJahr);$j++){
  if ($lista_box[$i]->Idlesson == $listaJahr[$j]->Idlesson){
  
    
    $lista_box[$i]->Jahrganglist[] = $listaJahr[$j]->Jahrgang;
  
  
  }
  
  
  }
  
  
  }

 for ($i= 0 ; $i < count($lista_box);$i++)
 {
  $Datum = $lista_box[$i]->Datum;
  $arrayDatumT= str_split($Datum);
  $arrayDatum = array ();
  array_push($arrayDatum,$arrayDatumT[8],$arrayDatumT[9],'/',
            $arrayDatumT[5],$arrayDatumT[6],'/',
            $arrayDatumT[0],$arrayDatumT[1],$arrayDatumT[2],$arrayDatumT[3],' ',
            $arrayDatumT[11],$arrayDatumT[12],':',$arrayDatumT[14],$arrayDatumT[15]);

  $Datum = implode($arrayDatum);
  $lista_box[$i]->Datum = $Datum;


 }

 $numerobox = count($lista_box);
 $boxPerPagina = 2;
 $pagine = ceil($numerobox/$boxPerPagina);




?>



<!DOCTYPE html> 
<html lang="en">  

<head>  
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olympia2024</title>
    <style> 
    body {

      background-color:rgb(141, 168, 164);
      font-family: system-ui;


      }
#h1 {
  position: absolute;
  color: rgb(141, 168, 164);
  text-shadow: 2px 2px 4px #333;
  
  margin-top: 0%;
  font-size:100px;
  padding-top: 0px;
  }
#id1{ 


  margin-top: 0%;




  } 


  
.form-group{
 
  font: size 50px;
  margin-left: 2%;
  
  


  }
#h2{
  color:black;
  padding:5px;
  font-size : 30px;

  }
#paragraf{

  color: black;
  padding:0px;
  font-size : 30px;

  }
  @keyframes appari{
    0%{ text-shadow: 0 0 3px darkblue;}
    50% { text-shadow: 0 0 30px darkblue;}
    100% { text-shadow: 0 0 3px darkblue;}   }
#titlebox1{
  color: black;
  padding-right:140px;
  font-size: 40px;
  animation :appari 2s infinite;
  }
  @keyframes appari2{
    0%{ text-shadow: 0 0 3px darkgreen;}
    50% { text-shadow: 0 0 30px darkgreen;}
    100% { text-shadow: 0 0 3px darkgreen;}   }
  #titlebox0{
  color: black;
  padding-right:140px;
  font-size: 40px;
  animation :appari2 2s infinite;
  }


.evento0{

  background-color: rgb(0, 218, 94,0.7);
  border: #6ddba6;
  border-radius: 30px;
  border-width: 5px;
  margin-left: 0%;
  /* margin-top:40px ; */
  border-color:rgb(31, 40, 39,0,5) ;
  padding : 0px;


  }
.evento1{

  background-color: rgb(63, 146, 214) ;
  border: #6ddba6;
  border-radius: 30px;
  border-width: 5px;
  margin-left: 0%;
  /* margin-top:40px ; */
  padding : 0px;


  }
#rat{
  margin-left:2.5%;
  width:70px;
  height:100px;
 

  }       
#innen1 {
  padding-top: 0px;
  background-color:rgba(31,40,39);
  background :linear-gradient(90deg, rgba(108, 189, 255) 0%, rgba(108, 189, 255) 55%, rgba(0, 120, 218) 100%);
  border-radius: 30px;
  padding:20px;



  }
#innen0 {
  padding-top: 0px;
  background-color: rgb(28, 69, 55);
  background :linear-gradient(90deg, rgba(102, 255, 168) 0%, rgba(50, 179, 106) 85%, rgba(50, 179, 106) 100%);
  border-radius: 30px;
  padding:20px;


  }

  #bfw{

    margin-left: 83%;
padding-top: 0px;
margin-top: 0%;
  }

.imgcont{

  display: flex;
}
.transition-effect {
    transition: opacity 0.5s ease;
    opacity: 0;
}
#orologio {
      position: relative;
      margin: auto;
      height: 40vw;
      width: 40vw;
      background: url(toppng.com-clock-face-without-hands-509x509.png) no-repeat;
      background-size: 100%;
    }
    #hour,
    #minute,
    #second {
      position: absolute;
      background: black;
      border-radius: 10px;
      transform-origin: bottom;
    }
    #hour {
      width: 1.8%;
      height: 25%;
      top: 25%;
      left: 48.85%;
      opacity: 0.8;
    }
    #minute {
      width: 1.6%;
      height: 30%;
      top: 19%;
      left: 48.9%;
      opacity: 0.8;
    }
    #second {
      width: 1%;
      height: 40%;
      top: 9%;
      left: 49.25%;
      opacity: 0.8;
    }

  

  
</style>
</head>

<body> 
  <div class= "imgcont">

  
  <img id ="rat" src="kisspng-graffiti-street-art-canvas-print-artist-grafitti-5acdd8369eb312.4614248715234396706501.png"alt="Mia Immagine">
  <img id ="bfw" src="Bfw_logo.png"alt="bfw Immagine">
</div>
<div class="form-group transition-effect" id="orologio">
   <div id="hour"></div>
    <div id="minute"></div>
    <div id="second"></div></div></div>

</div> 
</div>
<div class="form-group transition-effect" id="void"></div>

  <?php
 $posizione = 0 ;


 for ($i = 0;$i<count($lista_box);$i++) 
 {
    
    $posizione++;
    $color;
    $colorinside;
    if ($posizione % 2 == 0){

      $color= 0 ;
      $colorinside= 0;

    }else {

      
      $color = 1;
      $colorinside= 1;

    } ;?>
    
        <div class=<?php echo "evento$color";?> class="form-group transition-effect">
          
          
          <div class="form-group transition-effect" id=<?php echo "id$posizione";?>>
              <h2 id="titlebox<?php echo $color?>"><?php echo $ThemaTitle =$lista_box[$i]->ThemaTitle; "$ThemaTitle";?></h2>
              <div  id="allineamento">
              <h3 id="h2">Wo?</h3>
              <div id = <?php echo "innen$colorinside";?>>
              <p id = "paragraf"id="raum" ><?php $Raum = $lista_box[$i]->Raum; echo "Raum nr $Raum";?></p></div></div>

              <div  id="allineamento">

              <h3 id="h2">Wann?</h3>
              <div id = <?php echo "innen$colorinside";?>>
              <p class="datum" id = "paragraf"><?php   $Datum=$lista_box[$i]->Datum ;echo " Datum : $Datum";?></p></div></div>

              <div  id="allineamento">
              <h3 id="h2">Wen?</h3>
              <div id = <?php echo "innen$colorinside";?>>
              <p id = "paragraf"class="jahrgang" ><?php $Jahrgang=$lista_box[$i]->Jahrganglist ;
                                                        for ($jJahr= 0 ; $jJahr < count($Jahrgang);$jJahr++){ echo " $Jahrgang[$jJahr]";}?></p>
              <p class="fach"id = "paragraf" ><?php $Fach=$lista_box[$i]->Fachlist;
                                                    for ($jFach= 0 ; $jFach < count($Fach);$jFach++){ echo " $Fach[$jFach]";}?></p></div></div>

              <div  id="allineamento">

              <h3 id="h2">Was?</h3>
              <div id = <?php echo "innen$colorinside";?>>
              <p class="beschreibung_txt"id = "paragraf" ><?php $ThemaBeschreibung = $lista_box[$i]->ThemaBeschreibung; echo "$ThemaBeschreibung";?></p></div></div>

              <div  id="allineamento">

              <h3 id="h2">Wer?</h3>
              <div id = <?php echo "innen$colorinside";?>>
              <p class="dozent"id = "paragraf" > <?php $Dozent =$lista_box[$i]->Dozent ;echo " Dozent : $Dozent";?></p></div></div>
              
          </div>
        </div>
        <br> </br>
          
        <?php }?>
     
   <script>  
     // Numero totale di pagine
     let pagine = <?php echo $pagine ?>+1;
       
// Pagina attualmente visualizzata
let paginaAttuale = 0;

function toggleDivs() {
    // Nascondi tutti i box
   let divs = document.querySelectorAll(".form-group");
    for (let i = 0; i < divs.length; i++) {
      divs[i].style.opacity = "0"; // Imposta l'opacità a 0
        divs[i].style.display = "none"; // Imposta il display a none
    }

   
    let startIndex = paginaAttuale * 2;
    let endIndex = Math.min(startIndex + 2, divs.length);
  
    for (let i = startIndex; i < endIndex; i++) {
      divs[i].style.display = "flex"; // Imposta il display a flex
        setTimeout(() => {
            divs[i].style.opacity = "1"; // Dopo 50ms, imposta l'opacità a 1
        }, 500);
    }

    
    paginaAttuale = (paginaAttuale + 1) % pagine;

}

setInterval(toggleDivs, 10000);
setInterval(() => {
      d = new Date(); 
      ore = d.getHours();
      min = d.getMinutes();
      sec = d.getSeconds();
      ore_rotation = 30 * ore + min / 2; 
      min_rotation = 6 * min;
      sec_rotation = 6 * sec;

      document.getElementById('hour').style.transform = `rotate(${ore_rotation}deg)`;
      document.getElementById('minute').style.transform = `rotate(${min_rotation}deg)`;
      document.getElementById('second').style.transform = `rotate(${sec_rotation}deg)`;
    }, 1000);



</script>  
    


</body>

</html>
