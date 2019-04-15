<?php require_once('../Connections/connec.php');
//echo $_SESSION['MM_NomAfil'];

	
/*prueba php kargar turnos en array bd y borrado!!!! ok!!!!!
mysql_select_db($database_connec, $connec);
	$query_turnos = "SELECT * FROM tbl_turnospprev";
	$turnos = mysql_query($query_turnos, $connec) or die(mysql_error());
	$row_turnos = mysql_fetch_assoc($turnos); 
	$totalRows_turnos = mysql_num_rows($turnos);
	
do{		
    
	echo '<br><br><br><br><br>'.$query_turnos;
	echo 'Prestador'.$row_turnos['npres'].'<br>'.'TURNO'.$row_turnos['turno'];

	
		//var horejillas=['13:00','13:30','14:00','14:30','15:00','15:30'];
		//turno lunes 15 de febrero 15hrs!

		$turnosokupas= $row_turnos['turno'];
		$diaokupa = substr($turnosokupas, 8 , 2);
		$mesokupa = substr($turnosokupas, 5 , 2);
		$anhookupa = substr($turnosokupas, 0 , 4);
		$horaokupa = substr($turnosokupas, -8, 5 );

echo $horaokupa;
echo "<br>";

$horas=array ("'13:00'","'13:30'","'14:00'","'14:30'","'15:00'","'15:30'","'16:00'","'16:30'","'17:00'"); 
			//$index = array_search("'14:00'", $horas);
			$index = array_search("'".$horaokupa."'", $horas);
			echo $index;
			if ($index!==false)
			//unset($horas[$index]);
			array_splice($horas, $index, 1);
			
for($i=0; $i<count($horas); $i++)
      {
      //saco el valor de cada elemento
	  echo $horas[$i];
	  echo "<br>";
	  //$kalendar="['".implode(',',$horas)."']";
	  //$kalendar="['".$horas[$i]."']";
	    $kalendar="['".$horas[0]."',".$horas[1]."',".$horas[2]."',".$horas[3]."',".$horas[4]."',".$horas[5]."',".$horas[6]."',".$horas[7]."]";
      }
	  
	  $kalendar="\"['".$horas[0]."',".$horas[1]."',".$horas[2]."',".$horas[3]."',".$horas[4]."']\"";
	  echo $kalendar;
	  $kalendartotal;
	  //$kalendar="['14:30', '15:30']";

}while($row_turnos = mysql_fetch_assoc($turnos));*/


//Comprobar si es afiliado
if ($_SESSION['MM_Username'] != "" ){
	Verificar_Sesion($_SESSION['MM_Username']);
	$nom=$_SESSION['MM_Username'];
	//echo 'username='.$nom;
	$nombre=$_SESSION['MM_NomAfil'];
	//echo 'nomafi='.$nombre;
	$tipodoku=$_SESSION['MM_TipDoc'];
	//echo 'tipodoku'.$tipodoku;

}else{
	header('Location: index.php');
}

if (isset($_SESSION['MM_NomAfil']) != "") {
  $valor = 1;
}else{
  $valor = 0;
}


mysql_select_db($database_connec, $connec);
	$query_ConsultaFuncion = sprintf("SELECT * FROM tbl_afiliado WHERE nrodoc=$nom and tipdoc=$tipodoku");
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion, $connec) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	$sub_prov = $row_ConsultaFuncion['subpro']; 
	$plan = $row_ConsultaFuncion['id_plan']; 
	$queess = $row_ConsultaFuncion['queess']; 
	mysql_free_result($ConsultaFuncion);	



//******************************************************************************************
//* 	  						 Conexión a la base de datos.  							   *
//******************************************************************************************

   global $database_connec, $connec;
   mysql_select_db($database_connec, $connec) or die(mysql_error());  

   $SQLconsulta_cartilla="SELECT * FROM tbl_fav WHERE afi=$nom and tipodok=$tipodoku";
   $consulta_cartilla = mysql_query($SQLconsulta_cartilla,$connec) or die(mysql_error());
   
   
     if (mysql_num_rows($consulta_cartilla) != 0){
  $registro_cartilla=mysql_fetch_assoc($consulta_cartilla);
  $id_pcia = $registro_cartilla['id_pcia'];
	}else{
	echo '<script language="JavaScript">alert ("Añada prestadores a su cartilla");window.close();</script>';  }
   
  ?>
 
<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
  	<title>Cartillas M&eacute;dicas</title>
      <meta name="OSSEG OBRA SOCIAL DEL SEGURO" content="OSSEG OBRA SOCIAL DEL SEGURO">
    <meta name="Obra Social Seguro, OSSEG, Cartilla Médica" content="Your keywords">
    <meta name="Fernando Cruz, Raúl Legal, OSSEG SISTEMAS" content="Fernando Cruz">
    
    <link rel='stylesheet prefetch' href='http://cdn.materialdesignicons.com/1.1.70/css/materialdesignicons.min.css'>
<link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Roboto:300'>

        <link rel="stylesheet" href="css/style.css">

 <link rel="stylesheet" type="text/css" href="js/jquery.datetimepicker.css"/>

<style type="text/css">
.custom-date-style {
	background-color: red !important;
}
</style>
    
  </head>

  <body>

     <style id="dynamic-styles"></style>
<div id="hangout">  
  <div id="head" class="style-bg"> <i class="mdi mdi-arrow-left"></i> <i class="mdi mdi-fullscreen-exit"></i> 
  
<!--  <i class="mdi mdi-menu"></i> -->    
    <h1><?php echo $_SESSION['MM_NomAfil']?> <i class="mdi mdi-email"></i></h1><i class="mdi mdi-chevron-down"></i></div>  
    
    
    
    
  <div id="content">
    <div class="overlay"></div>
    
    <!--<div id="floater-position">
      <div id="add-contact-floater" class="floater control style-bg hidden"><i class="mdi mdi-plus"></i></div>          
      <div id="chat-floater" class="floater control style-bg hidden"><i class="mdi mdi-comment-text-outline"></i></div>   
    </div>-->
    
    
    <div class="card menu">
      <div class="header">
      <img src="http://s8.postimg.org/76bg2es2t/index.png" />
        <h3><?php echo $_SESSION['MM_NomAfil']; ?></h3>
      </div>
      <div class="content">
      <script type="text/javascript">
    		function editmail(){
			 //alert ("email");
   			 var email=document.getElementById("emailo").value;
			 //alert (email);			
			 var salv=""+"../addemail.php?email="+email+"&afi="+ <?php echo $nom ?> +"&tip="+ <?php echo $tipodoku ?>;    			
				window.open(salv, "_self");
   			}
      </script>
        
        <div class="i-group">
    <form name="new-mail" method="POST" action="">
    <input type="text" id="emailo" value=""><span class="bar"></span>
    <label><?php if ($registro_cartilla['mail']==NULL){
		echo 'Añada su email';
		}else{
			 echo $registro_cartilla['mail'];}?></label>
    </form>
      <div class="btn-container">
      <span class="btn cancel">Cancelar</span>
      <span class="btn save" onclick="editmail()" style="margin-left: 10px;">Guardar</span>      
      </div> 
        
        </div>        
        <br />       
        
       <!-- <div class="center"><canvas id="colorpick" width="250" height="220" ></canvas></div>-->                        
      </div>
    </div> 
    <div class="list-account">
      <div class="meta-bar"><input class="nostyle search-filter" type="text" placeholder="buscar" /></div>
    <ul class="list mat-ripple">      

<li>
<span class='name'>Dra. Fabiana Rico</span><br><span class='tel'><i class='mdi mdi-hospital'></i>
<span class='tel'>Prevención gineco-mamaria</i>
</li>

<li>
<span class='name'>Dra. Ana Chertkoff</span><br><span class='tel'><i class='mdi mdi-hospital'></i>
<span class='tel'>Prevención gineco-mamaria</i>
</li>

<li>
<span class='name'>Dra. Inés Samper</span><br><span class='tel'><i class='mdi mdi-hospital'></i>
<span class='tel'>Prevención gineco-mamaria</i>
</li>
    </ul> 
    
    </div>
    <div class="list-text">
    
    
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>

  <!-- <script type="text/javascript">
      $("li").click(function ()
      {
		  alert ("123");
        navigator.geolocation.getCurrentPosition(ubicacion,error);		
      });
 
     function ubicacion(posicion)
      {
		  
        var contenedor = document.getElementById("mapa");
 
        var latitud = posicion.coords.latitude;
        var longitud = posicion.coords.longitude;
        var precision = posicion.coords.accuracy;
		var grad = posicion.coords.timestamp;
 
          //alert("Lat="+latitud+" - Long="+longitud+" - Precision="+precision+" - Grados="+grad);
		  window.open('https://www.google.com.ar/maps/place/'+latitud+longitud, '_self');
       }
 
      function error(error)
       {
         if(error.code == 0)
            alert("Error Desconocido");
         else if(error.code == 1)
             alert("No fue posible contactarte");
         else if(error.code == 2)
            alert("No hay una ubicacion disponible");
         else if(error.code == 3)
            alert("Tiempo agotado");
        else 
            alert("Error Desconocido");
        }
    </script>
    
    
    <script type="application/javascript">
        // solicitud por ajax para obtener el json con la ip
		
        $.post("http://jsonip.appspot.com/",function(data){
            $("#ip").html("Chipirónnnn, tu ip es: "+data.ip);
        },"json");
    </script>-->
    
    </div>
    <div class="list-phone">
      <div class="meta-bar"><input class="nostyle search-filter" type="text" placeholder="buscar" /></div>
     <ul class="list mat-ripple">  
      <?php   
	  
   global $database_connec, $connec;
   mysql_select_db($database_connec, $connec) or die(mysql_error());  

   $SQLconsulta_cartilla="SELECT * FROM tbl_fav WHERE afi=$nom and tipodok=$tipodoku";
   $consulta_cartilla = mysql_query($SQLconsulta_cartilla,$connec) or die(mysql_error());
   
 
	   
  do {
	  
	//While($registro_cartilla=mysql_fetch_assoc($consulta_cartilla)){
   if ($registro_cartilla['cita'] != NULL){
   $hoy = date('Y-m-d h:i:s');
   $date = $registro_cartilla['cita'];
	
   
   if (($registro_cartilla['cita']) <= $hoy){
	//echo 'menor';
	$nada='';
	$presttem = $registro_cartilla['prest'];
 	$updateSQL = sprintf("UPDATE tbl_fav SET cita=%s WHERE prest=%s and afi=%s and tipodok=%s",	
	GetSQLValueString($nada, "int"),
	GetSQLValueString($presttem, "text"),		
	GetSQLValueString($nom, "int"),	
	GetSQLValueString($tipodoku, "int"));

  mysql_select_db($database_connec, $connec);
  $Result1 = mysql_query($updateSQL, $connec) or die(mysql_error());
  //echo 'konsult'.$updateSQL;
   }
		?>
			<li>
            <div class='content-container'>
            <span class='name'><?php echo utf8_encode($registro_cartilla['prest']) ?>
            </span><span class='phone'><?php echo utf8_encode($registro_cartilla['tel']) ?>
            </span></div><span class='time'><i class="mdi mdi-calendar-clock"></i><?php echo ' '. htmlentities($registro_cartilla['cita']); ?></span></li>
		<?php  }            
  } while ($registro_cartilla=mysql_fetch_assoc($consulta_cartilla));
    mysql_free_result($consulta_cartilla); // Liberar memoria usada por consulta.
	//echo $SQLconsulta_cartilla;		
?> 
    </ul> 
      
  <!--  <ul class="list mat-ripple">      
      <li><img src="http://lorempixel.com/100/100/people/1/">
        <div class="content-container">
          <span class="name">Angie</span>
          <span class="phone">000-555-28175</span>
          <span class="meta">Mobile</span>
        </div>
        <span class="time">
          2015-01-01 03:35
        </span>
         </li>      
      <li><img src="http://lorempixel.com/100/100/people/3/">
        <div class="content-container">
          <span class="name">Bert</span>
          <span class="phone">666-222-11433</span>
          <span class="meta">Main</span>
        </div>
        <span class="time">
          2015-01-01 03:35
        </span>
         </li>   
    </ul> -->
    </div>
    <div class="list-chat">
      <ul class="chat">
        <li>
        <img src="http://s8.postimg.org/76bg2es2t/index.png">
          <div class="message">o hai!</div>
        </li>
        <li>
        <img src="http://lorempixel.com/100/100/people/1/">
          <div class="message"></div>
        </li>
        <li>
        <img src="http://s8.postimg.org/76bg2es2t/index.png">
          <div class="message current">...</div>
        </li>
      </ul>
      <div class="meta-bar chat"><input class="nostyle chat-input" type="text" placeholder="Message..." /> <i class="mdi mdi-send"></i></div>
    </div>
    <ul class="nav control mat-ripple tiny">
      
      <li data-route=".list-account"><i class="mdi mdi-account-multiple"></i>
      </li><li data-route=".list-text"><i class="mdi mdi-comment-text"></i>
      </li><li data-route=".list-phone"><i class="mdi mdi-calendar"></i></li></ul>
    </div>  
  
  <div id="contact-modal" data-mode="add" class="card dialog">
    <h3>Add Contact</h3>
      <div class="i-group">
      <form name="new-user" method="POST" action="">
      <input type="hidden" id="new-user0" value="kaixo">
      <input type="text" id="new-user" value="hola"><span class="bar"></span>
      <label>Nombre</label>
      <script type="text/javascript">
    		function editpres(){
   			 var doc=document.getElementById("new-user").value;
			 var fav=document.getElementById("new-user0").value;
			 //var salv=""+"../editfav.php?pres="+doc+"&regi="+fav+"";
			 var salv=""+"../editfav.php?pres="+doc+"&regi="+fav+"&afi="+ <?php echo $nom ?> +"&tip="+ <?php echo $tipodoku ?>;    			
				window.open(salv, "_self");
   			}
    </script>
      </form>
      
   </div>
   
    
    <div class="btn-container">
      <span class="btn cancel">Cancelar</span>
      <span class="btn save" onclick="editpres()">Guardar</a></span>      
    </div>
    
      <div id="delete-modal" data-mode="delete" class="card dialog">
    <h3>Borrar Contacto</h3>
      <div class="i-group">
      <form name="delete" method="POST" action="">
      <input type="hidden" id="userb0" value="kaixo">
      <input type="text" id="userb" value="hola" readonly><span class="bar"></span>
      <label>Nombre del Prestador a Eliminar</label>
      <script type="text/javascript">
    		function borropres(){
   			 var doc=document.getElementById("userb0").value;
			 //var salv=""+"../editfav.php?pres="+doc+"&regi="+fav+"";
			 var borro=""+"../borrofav.php?pres="+doc+"&afi="+ <?php echo $nom ?> +"&tip="+ <?php echo $tipodoku ?>;    			
				window.open(borro, "_self");
   			}
    </script>
      </form>
      
   </div>
   
    
    <div class="btn-container">
      <span class="btn cancel">Cancelar</span>
      <span class="btn save" onclick="borropres()">Eliminar</a></span>      
    </div>
    
    </div>
 
 
      <div id="deletecita-modal" data-mode="deletecita" class="card dialog">
      <h3>Borrar Turno</h3>
      <div class="i-group">
      <form name="delete" method="POST" action="">
      <input type="text" id="userc0" value="kaixo">
      <input type="text" id="userc" value="hola" readonly><span class="bar"></span>
      <label>Turno a Eliminar</label>
      <script type="text/javascript">
    		function borroturno(){
   			 var doc=document.getElementById("userc0").value;
			 var cita=document.getElementById("userc").value;
			 //var salv=""+"../editfav.php?pres="+doc+"&regi="+fav+"";
			 var borro=""+"../borroturno.php?pres="+doc+"&cita="+cita+"&afi="+ <?php echo $nom ?> +"&tip="+ <?php echo $tipodoku ?>;    			
				window.open(borro, "_self");
   			}
    </script>
      </form>
      
   </div>
   
    
    <div class="btn-container">
      <span class="btn cancel">Cancelar</span>
      <span class="btn save" onclick="borroturno()">Eliminar</a></span>      
    </div>
        
    </div>
    
     <div id="calendar-modal" data-mode="calendar" class="card dialog" style="height:420px;">
    <h3>Citas</h3>
      <div class="i-group">
      <form name="date" method="POST" action="">
      <input type="hidden" id="user0" value="kaixo">
      <input type="text" id="user" value="hola" readonly><span class="bar"></span>
      <input type="text" id="datetimepicker3"/>
    <script type="text/javascript">
    		function cita(){
			 var dock=document.getElementById("user0").value;	
   			 var date=document.getElementById('datetimepicker3').value;
			 //alert (document.getElementById('datetimepicker3').value);
			 //var fav=document.getElementById("new-user0").value;
			var salvcita=""+"../adddatepprev.php?pres="+dock+"&cita="+date+"&afi="+ <?php echo $nom ?> +"&tip="+ <?php echo $tipodoku ?>;
    		window.open(salvcita, "_self");
   			}
    </script>

      </form>
      
   </div>
   
    
    <div class="btn-container"  name="salvo">
      <span class="btn cancel">Cancelar</span>
      <span class="btn save"onclick="cita()">Guardar</a></span>      
    </div>
    
    </div>
 
</div>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/jquery.js"></script>
<script src="js/jquery.datetimepicker.js"></script>
<script src="js/index.js"></script>

<script type="text/javascript">



var logic = function( currentDateTime ){

var docky = user.value;
switch (docky) { 
	case 'Dra. Fabiana Rico': 

		
	if ((currentDateTime.getDay() == 1)||(currentDateTime.getDay() == 3)||(currentDateTime.getDay() == 5)){
		<?php	
	mysql_select_db($database_connec, $connec);
	$query_turnos = "SELECT * FROM tbl_turnospprev";
	$turnos = mysql_query($query_turnos, $connec) or die(mysql_error());
	$row_turnos = mysql_fetch_assoc($turnos); 
	$totalRows_turnos = mysql_num_rows($turnos);
	
	$horas=array ("'13:00'","'13:30'","'14:00'","'14:30'","'15:00'","'15:30'","'16:00'","'16:30'","'17:00'");
	
 		?>
		
		var diaokupa= currentDateTime.getDate();
		//alert (diaokupa);
		var anhookupa=currentDateTime.getFullYear();
		//alert (anhookupa);
		var mesokupa=currentDateTime.getMonth()+1;
		//alert (mesokupa);


		
<?php $kalendartotal="['13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00']";?>

			
			this.setOptions({
			timepicker: true,			
			//allowTimes: horas,
			allowTimes: <?php echo $kalendartotal; ?>,
			disabledDates: ['2016-02-11'],
			//disabledTimes: ['14:00'],
			disableDateTime: ['2016-02-03 14:00']
			});

<?php 	
	do{
  		$turnosokupas= $row_turnos['cita'];
		$diaokupa = substr($turnosokupas, 8 , 2);
		$mesokupa = substr($turnosokupas, 5 , 2);
		$anhookupa = substr($turnosokupas, 0 , 4);
		$horaokupa = substr($turnosokupas, -8, 5);
?>

if ((diaokupa == <?php echo $diaokupa ?> )&&(mesokupa == <?php echo $mesokupa ?>)&&(anhookupa == <?php echo $anhookupa ?>)){
		    <?php //$horas="['13:00','13:30','14:00','14:30', '15:30']"; 
			/*$horas0="'12:00'";
			$horas1="'12:30'";
			$horas2="'13:00'";*/
			//$kalendar="\"['".$horas[0]."',".$horas[1]."',".$horas[2]."',".$horas[3]."',".$horas[4]."']\"";
			//OK---------->$kalendar="[".$horas0.",".$horas1.",".$horas2."]";
			
			$index = array_search("'".$horaokupa."'", $horas);
			echo $index;
			if ($index!==false)
			array_splice($horas, $index, 1);
			$kalendar="[".$horas[0].",".$horas[1].",".$horas[2].",".$horas[3].",".$horas[4].",".$horas[5].",".$horas[6].",".$horas[7].",".$horas[8].",".$horas[9]."]"; 
			?>
			//horas=['13:00','13:30','14:00','14:30','15:30'];
			this.setOptions({
			timepicker: true,			
			//allowTimes: horas,
			allowTimes: <?php echo $kalendar; ?>,
			disabledDates: ['2016-02-11'],
			//disabledTimes: ['14:00'],
			disableDateTime: ['2016-02-03 14:00']
		    });
}			
<?php }while($row_turnos = mysql_fetch_assoc($turnos)); ?>


		$('#calendar-modal .btn-container').show();
		//alert ("docky"+user.value);
		/*alert ($('#calendar-modal .xdsoft_time').text());
		alert (allowTimes:[0]);
		
			/*allowTimes = jQuery.grep(allowTimes, function(value)){
				return value != '14:30';
				});*/ 	
}else{
		    this.setOptions({
			timepicker: false,			
			allowTimes:[]
		});
		$('#calendar-modal .btn-container').hide();
	}
break;
	case 'Dra. Ana Chertkoff': 

		
	if ((currentDateTime.getDay() == 1)){
		<?php	
	mysql_select_db($database_connec, $connec);
	$query_turnos = "SELECT * FROM tbl_turnospprev";
	$turnos = mysql_query($query_turnos, $connec) or die(mysql_error());
	$row_turnos = mysql_fetch_assoc($turnos); 
	$totalRows_turnos = mysql_num_rows($turnos);
	
	$horas=array ("'8:00'","'8:30'","'9:00'","'9:30'","'10:00'","'10:30'","'11:00'","'11:30'");
	
 		?>
		
		var diaokupa= currentDateTime.getDate();
		//alert (diaokupa);
		var anhookupa=currentDateTime.getFullYear();
		//alert (anhookupa);
		var mesokupa=currentDateTime.getMonth()+1;
		//alert (mesokupa);


		
<?php $kalendartotal="['8:00','8:30','9:00','9:30','10:00','10:30','11:00','11:30']";?>

			
			this.setOptions({
			timepicker: true,			
			//allowTimes: horas,
			allowTimes: <?php echo $kalendartotal; ?>,
			disabledDates: ['2016-02-11'],
			//disabledTimes: ['14:00'],
			disableDateTime: ['2016-02-03 14:00']
			});

<?php 	
	do{
  		$turnosokupas= $row_turnos['cita'];
		$diaokupa = substr($turnosokupas, 8 , 2);
		$mesokupa = substr($turnosokupas, 5 , 2);
		$anhookupa = substr($turnosokupas, 0 , 4);
		$horaokupa = substr($turnosokupas, -8, 5);
?>

if ((diaokupa == <?php echo $diaokupa ?> )&&(mesokupa == <?php echo $mesokupa ?>)&&(anhookupa == <?php echo $anhookupa ?>)){
		    <?php //$horas="['13:00','13:30','14:00','14:30', '15:30']"; 
			/*$horas0="'12:00'";
			$horas1="'12:30'";
			$horas2="'13:00'";*/
			//$kalendar="\"['".$horas[0]."',".$horas[1]."',".$horas[2]."',".$horas[3]."',".$horas[4]."']\"";
			//OK---------->$kalendar="[".$horas0.",".$horas1.",".$horas2."]";
			
			$index = array_search("'".$horaokupa."'", $horas);
			echo $index;
			if ($index!==false)
			array_splice($horas, $index, 1);
			$kalendar="[".$horas[0].",".$horas[1].",".$horas[2].",".$horas[3].",".$horas[4].",".$horas[5].",".$horas[6].",".$horas[7].",".$horas[8].",".$horas[9]."]"; 
			?>
			//horas=['13:00','13:30','14:00','14:30','15:30'];
			this.setOptions({
			timepicker: true,			
			//allowTimes: horas,
			allowTimes: <?php echo $kalendar; ?>,
			disabledDates: ['2016-02-11'],
			//disabledTimes: ['14:00'],
			disableDateTime: ['2016-02-03 14:00']
		    });
}			
<?php }while($row_turnos = mysql_fetch_assoc($turnos)); ?>


		$('#calendar-modal .btn-container').show();
		//alert ("docky"+user.value);
		/*alert ($('#calendar-modal .xdsoft_time').text());
		alert (allowTimes:[0]);
		
			/*allowTimes = jQuery.grep(allowTimes, function(value)){
				return value != '14:30';
				});*/
}else{
		    this.setOptions({
			timepicker: false,			
			allowTimes:[]
		});
		$('#calendar-modal .btn-container').hide();
	}
break;
	case 'Dra. Inés Samper': 

		
	if ((currentDateTime.getDay() == 2)){
		<?php	
	mysql_select_db($database_connec, $connec);
	$query_turnos = "SELECT * FROM tbl_turnospprev";
	$turnos = mysql_query($query_turnos, $connec) or die(mysql_error());
	$row_turnos = mysql_fetch_assoc($turnos); 
	$totalRows_turnos = mysql_num_rows($turnos);
	
	$horas=array ("'14:00'","'14:30'","'15:00'","'15:30'","'16:00'","'17:30'");
	
 		?>
		
		var diaokupa= currentDateTime.getDate();
		//alert (diaokupa);
		var anhookupa=currentDateTime.getFullYear();
		//alert (anhookupa);
		var mesokupa=currentDateTime.getMonth()+1;
		//alert (mesokupa);


		
<?php $kalendartotal="['13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00']";?>

			
			this.setOptions({
			timepicker: true,			
			//allowTimes: horas,
			allowTimes: <?php echo $kalendartotal; ?>,
			disabledDates: ['2016-02-11'],
			//disabledTimes: ['14:00'],
			disableDateTime: ['2016-02-03 14:00']
			});

<?php 	
	do{
  		$turnosokupas= $row_turnos['cita'];
		$diaokupa = substr($turnosokupas, 8 , 2);
		$mesokupa = substr($turnosokupas, 5 , 2);
		$anhookupa = substr($turnosokupas, 0 , 4);
		$horaokupa = substr($turnosokupas, -8, 5);
?>

if ((diaokupa == <?php echo $diaokupa ?> )&&(mesokupa == <?php echo $mesokupa ?>)&&(anhookupa == <?php echo $anhookupa ?>)){
		    <?php //$horas="['13:00','13:30','14:00','14:30', '15:30']"; 
			/*$horas0="'12:00'";
			$horas1="'12:30'";
			$horas2="'13:00'";*/
			//$kalendar="\"['".$horas[0]."',".$horas[1]."',".$horas[2]."',".$horas[3]."',".$horas[4]."']\"";
			//OK---------->$kalendar="[".$horas0.",".$horas1.",".$horas2."]";
			
			$index = array_search("'".$horaokupa."'", $horas);
			echo $index;
			if ($index!==false)
			array_splice($horas, $index, 1);
			$kalendar="[".$horas[0].",".$horas[1].",".$horas[2].",".$horas[3].",".$horas[4].",".$horas[5].",".$horas[6].",".$horas[7].",".$horas[8].",".$horas[9]."]"; 
			?>
			//horas=['13:00','13:30','14:00','14:30','15:30'];
			this.setOptions({
			timepicker: true,			
			//allowTimes: horas,
			allowTimes: <?php echo $kalendar; ?>,
			disabledDates: ['2016-02-11'],
			//disabledTimes: ['14:00'],
			disableDateTime: ['2016-02-03 14:00']
		    });
}			
<?php }while($row_turnos = mysql_fetch_assoc($turnos)); ?>


		$('#calendar-modal .btn-container').show();
		//alert ("docky"+user.value);
		/*alert ($('#calendar-modal .xdsoft_time').text());
		alert (allowTimes:[0]);
		
			/*allowTimes = jQuery.grep(allowTimes, function(value)){
				return value != '14:30';
				});*/
}else{
		    this.setOptions({
			timepicker: false,			
			allowTimes:[]
		});
		$('#calendar-modal .btn-container').hide();
	}
	
}

};


$('#datetimepicker3').datetimepicker({
	inline:true,
	onChangeDateTime:logic,
	onShow:logic
});

</script>
  </body>
</html>
