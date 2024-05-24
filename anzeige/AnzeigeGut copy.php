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
  public $Uhr;

  public function __construct($Raum, $Datum,$Dozent,$ThemaBeschreibung,$ThemaTitle,$Idlesson,) {
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
  $arrayUhr = array();
  array_push($arrayDatum,$arrayDatumT[8],$arrayDatumT[9],'/',
            $arrayDatumT[5],$arrayDatumT[6],'/',
            $arrayDatumT[0],$arrayDatumT[1],$arrayDatumT[2],$arrayDatumT[3]);
  array_push($arrayUhr, 
            $arrayDatumT[11],$arrayDatumT[12],':',$arrayDatumT[14],$arrayDatumT[15]);

  $Datum = implode($arrayDatum);
  $lista_box[$i]->Datum = $Datum;
  $Uhr = implode($arrayUhr);
  $lista_box[$i]->Uhr = $Uhr;

 }

 $numerobox = count($lista_box);
 $boxPerPagina = 3;
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
 

  margin-left: 0%;
  
  


  }
#h2{
  color:black;
  padding:5px;
  font-size : 50px;

  }
#paragraf{

  color: black;
  padding:5px;
  font-size : 60px;

  }
  #paragraf,#h2
  {
  display: inline-block;margin-top: 0%;}


#titlebox1{
  color: black;
  padding:40px;
  font-size: 60px;

  }

  #titlebox0{
  color: black;
  padding:40px;
  font-size: 60px;

  }
  .right {text-align: right;}


#evento0{

  background-color: rgb(0, 218, 94,0.7);
  border: #6ddba6;
  border-radius: 30px;
  border-width: 5px;
  margin-left: 0%;
  /* margin-top:40px ; */
  border-color:rgb(31, 40, 39,0,5) ;
  padding : 20px;


  }
#evento1{

  background-color: rgb(63, 146, 214) ;
  border: #6ddba6;
  border-radius: 30px;
  border-width: 5px;
  margin-left: 0%;
  /* margin-top:40px ; */
  padding : 20px;
  


  }
#rat{
  margin-left:2.5%;
  width:110px;
  height:150px;
 

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

    margin-left: 37%;
padding-top: 0px;
margin-top: 0%;
height: 130px;
width: 300px;
  }

.imgcont{

  display: flex;
}
.transition-effect {
    transition: opacity 0.5s ease;
    opacity: 0;
}

    #hour {
    font-size: 150px;
    }
    #minute {
      font-size: 150px ;
    }
    #second {
      font-size :150px;
    }

#orologio {
margin-top : 0;
margin-left:1000px;
  display:flex;
}
#intestazione{

display: flex;
padding :40px;

}


.parent {
  display: grid;
    grid-template-rows: 40% 20% 40%; 
    grid-template-columns: 30% 20% 50%; 
    width: 100vw;
    height:10vw;
    padding:0px;
    margin-top: 0px;

}


.child:nth-child(1) {
  grid-row : 1 ;
  grid-column:1;
  margin-top: -3%;
  display: inline-block;
}

.child:nth-child(2) {
  grid-row : 3 ;
  grid-column:1;

  display: inline-block;
}

.child:nth-child(3) {
  grid-row : 3 ;
  grid-column:2;

}
.child:nth-child(4) {
  grid-row : 1 ;
  grid-column:3;
  width: auto	;
  height: auto;
  padding :30px;
}
.child:nth-child(5) {
  grid-row : 3 ;
  grid-column:3;
  width: auto	;
  height: auto;
  padding :30px;
}


  
</style>
</head>

<body> <div id="intestazione" >
  <div class= "imgcont">

  
  <img id ="rat" src="kisspng-graffiti-street-art-canvas-print-artist-grafitti-5acdd8369eb312.4614248715234396706501.png"alt="Mia Immagine">
  </div>
<div  id="orologio">
   <div id="hour">00</div>
   <div id = "second">:</div>
    <div id="minute">00</div>
</div>

  <img id ="bfw" src="Bfw_logo.png"alt="bfw Immagine" >

</div>

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
    
        <div  class="form-group transition-effect" id = <?php echo "evento$color";?> >
          
          
          <div class = "parent"id=>

                    <h2 id="titlebox<?php echo $color?>" class = "child"><?php echo $ThemaTitle =$lista_box[$i]->ThemaTitle; "$ThemaTitle";?></h2>
                  

       
                    <div id = <?php echo "innen$colorinside";?> class ="child">
                    <h3 id="h2">Dozent :</h3>
            
                    <p class="dozent"id = "paragraf" > <?php $Dozent =$lista_box[$i]->Dozent ;echo "  $Dozent";?></p>
                    </div>




    
                    <div id = <?php echo "innen$colorinside";?> class = "child">
                    <h3 id="h2">Raum :</h3>
                    
                    <p id = "paragraf"id="raum" ><?php $Raum = $lista_box[$i]->Raum; echo " NR $Raum";?></p>
                
                    </div>
                
                  
                    <div id = <?php echo "innen$colorinside";?> class = "child right">
                    <h3 id="h2">Datum :</h3>
                    <p class="datum" id = "paragraf"><?php   $Datum=$lista_box[$i]->Datum ;echo "  $Datum";?></p>
                    <h3 id="h2">Uhr :</h3>
                    <p class="uhr" id = "paragraf"><?php   $Uhr=$lista_box[$i]->Uhr ;echo " $Uhr";?></p>
                  </div>
                    



                    <div id = <?php echo "innen$colorinside";?> class = "child right">
                    
                    <h3 id="h2">Jahrgang</h3>
                    
                    <p id = "paragraf" ><?php $Jahrgang=$lista_box[$i]->Jahrganglist ;
                                                              for ($jJahr= 0 ; $jJahr < count($Jahrgang);$jJahr++){ echo " $Jahrgang[$jJahr]";}?></p>
                    <h3 id="h2">Fach</h3>
                    <p id = "paragraf" ><?php  ;$Fach=$lista_box[$i]->Fachlist;
                                                          for ($jFach= 0 ; $jFach < count($Fach);$jFach++){ echo " $Fach[$jFach] ";}?></p></div>
                                                          
          </div>
          </div>
  </div>
        <br> </br>
          
        <?php  }?>
     
   <script>  
     // Numero totale di pagine
     let pagine = <?php echo $pagine ?>;
      if (pagine > 1 ){
          let PrimoCiclo = true;
          let paginaAttuale = 0;
          let margineNegativo = -3;
          let divs = document.querySelectorAll(".form-group");
              for (let i = 0; i < divs.length; i++) {
              if ( i !== 0 && i % 3 === 0){

                var margineStr = margineNegativo.toString();
                margineStr = margineStr.concat("%");
                divs[i].style.marginTop = margineStr;
                margineNegativo =  margineNegativo-3
              }
              }



          function toggleDivs() {
              // Nascondi tutti i box
            let divs = document.querySelectorAll(".form-group");
              for (let i = 0; i < divs.length; i++) {
                divs[i].style.opacity = "0"; // Imposta l'opacità a 0
                  divs[i].style.display = "none"; // Imposta il display a none
              }

            
              let startIndex = paginaAttuale * 3;
              let endIndex = Math.min(startIndex + 3, divs.length);
            
              for (let i = startIndex; i < endIndex; i++) {
                divs[i].style.display = "flex"; // Imposta il display a flex
                  setTimeout(() => {
                      divs[i].style.opacity = "1"; // Dopo 50ms, imposta l'opacità a 1
                  }, 500);
              }

              
              paginaAttuale = (paginaAttuale + 1) % pagine;
              

          }

          var intervallo = setInterval(toggleDivs, 1000);

          setTimeout(function() {
              clearInterval(intervallo); // Prima fermiamo l'intervallo corrente
              intervallo = setInterval(toggleDivs, 13000); // Poi lo reimpostiamo con il nuovo intervallo
          }, 1000); // Dopo 5 secondi

        }
        else
        {

          let divs = document.querySelectorAll(".form-group");
          for (let i = 0; i < divs.length; i++) {divs[i].style.display = "flex";divs[i].style.opacity = "1";}

        }

        


setInterval(() => {
 
      d = new Date(); 
      ore = d.getHours();
      min = d.getMinutes();
      sec = d.getSeconds();
     
      if (min<10){  let zero = 0;
                    let zerostr = zero.toString(); 
                    let strMinOhneNull = min.toString(); 
        strM = zerostr.concat(strMinOhneNull);
      
      }else {

        strM =  min.toString(); 
      
      }
      var nodeH = document.createTextNode(ore.toString());
      
      var nodeM = document.createTextNode(strM);
   


      divOre = document.getElementById('hour');
      divOre.innerHTML = ""
      divMinuten = document.getElementById('minute');
      divMinuten.innerHTML = ""

      divOre.appendChild(nodeH);
      
      divMinuten.appendChild(nodeM);
   
      if (sec%2=== 0)
      {

       
        document.getElementById('second').style.color = 'black';
      }
      else {

        
        document.getElementById('second').style.color = 'rgb(141, 168, 164)';

      }




    }, 1000);

    setInterval(function() {
    location.reload();
}, 300000);


window.addEventListener("message", function(event) {
    if (event.origin === "http://127.0.0.1/anzeige/insert_query.php") {
        var evento = event.data;
        // Verifica se il messaggio ricevuto è l'evento che si desidera gestire
        if (evento === "neuladen") {
            // Esegui l'azione desiderata sulla Pagina A in risposta all'evento dalla Pagina B
            location.reload(); // Esempio: ricarica la pagina
        }
    }
});



</script>  
    


</body>

</html>
