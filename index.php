<?php require_once('../Connections/connec.php'); ?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
  header('Location: fav.php');
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['NroDoc'])) {
  $loginUsername=$_POST['NroDoc'];
  $password=$_POST['TipDoc'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "pprev.php";
  //$MM_redirectLoginFailed = "afiliados.php" ;
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_connec, $connec);
  
  $LoginRS__query=sprintf("SELECT nrodoc, tipdoc, nomafi, apeafi, id_plan, subplan FROM tbl_afiliado WHERE nrodoc=%s AND tipdoc=%s",
    GetSQLValueString($loginUsername, "int"), GetSQLValueString($password, "int")); 
   
  $LoginRS = mysql_query($LoginRS__query, $connec) or die(mysql_error());
  $rowLoginRS = mysql_fetch_assoc($LoginRS);
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	 
    $_SESSION['MM_TipDoc'] = $rowLoginRS['tipdoc'];
	$_SESSION['MM_NomAfil'] = $rowLoginRS['nomafi']." ".$rowLoginRS['apeafi'];
	$_SESSION['MM_IdPlan'] = $rowLoginRS['id_plan'];
	/* 03-02-2015 se agrega la variable para el subplan - utilizado en cartilla de farmacias - Monotributo */ 
	$_SESSION['MM_SubPlan'] = $rowLoginRS['subplan'];
	/* 03-02-2015 fin */ 
	Verificar_Sesion($_SESSION['MM_Username']);
	interface_contador_afiliados(); /* Cuento los accesos de Afiliados */
    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }  else {
  ?>
     <script type="text/javascript">		
alert("El nº de afiliado no existe");	
/*window.location.reload( false );*/
window.location.href="index.php";
        </script>
	<?php
    
  }
}

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>



 
<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
  	<title>Turnos Programas Preventivos</title>
    <meta name="OSSEG OBRA SOCIAL DEL SEGURO" content="OSSEG OBRA SOCIAL DEL SEGURO">
    <meta name="Obra Social Seguro, OSSEG, Cartilla Médica" content="Your keywords">
    <meta name="Fernando Cruz, Raúl Legal, OSSEG SISTEMAS" content="Fernando Cruz">
    
    <link rel='stylesheet prefetch' href='http://cdn.materialdesignicons.com/1.1.70/css/materialdesignicons.min.css'>
<link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Roboto:300'>

        <link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/segment.css" />
<link href='http://fonts.googleapis.com/css?family=Lato:400' rel='stylesheet' type='text/css'>


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
    <h1></h1><i class="mdi mdi-chevron-down"></i></div>  
    
    
    
    
  <div id="content">
    <div class="overlay"></div>
    
    <!--<div id="floater-position">
      <div id="add-contact-floater" class="floater control style-bg hidden"><i class="mdi mdi-plus"></i></div>          
      <div id="chat-floater" class="floater control style-bg hidden"><i class="mdi mdi-comment-text-outline"></i></div>   
    </div>-->
    
    
    <div class="cardlogin menu">
      <div class="header">
      <img src="js/screen/avt.png">
        <h3>Turnos Programas Preventivos</h3>
      </div>
      <div class="content">
             
        <div class="i-group">
    <form name="acceso-afiliado" method="POST" action="<?php echo $loginFormAction; ?>">
    <input name="NroDoc" type="text" id="NroDoc" value=""><span class="bar"></span>
    <label>Nº de Documento</label>
     <br>
      <select name="TipDoc" id="TipDoc" class="segment-select">
      
                  <option value="4">D.N.I.</option>
                  <option value="3">C.E.</option>
                  <option value="2">L.C.</option>
                  <option value="1">L.E.</option>
      </select>
      
      <br><br>
      <input class="btn-container" type="submit" value="INGRESAR" style="margin-left: 0px;"><span class="bar"></span>
      <br> <br>         
              
    </form>
     
        
        </div>        
        <br />       
        
       <!-- <div class="center"><canvas id="colorpick" width="250" height="220" ></canvas></div>-->                        
      </div>
    </div> 
     <div class="list-text">
    
    
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>

 
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
    

   
    
    <div class="btn-container">
      <span class="btn cancel">Cancelar</span>
      <span class="btn save" onclick="cita()">Guardar</a></span>      
    </div>
    
    </div>
 
</div>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/jquery.js"></script>
<script src="js/indexlogin.js"></script>

  <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="js/segment.js"></script>
  <script type="text/javascript">
      jQuery(function ($){
           $(".segment-select").Segment();
      });
  </script>
  <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<script type="text/javascript">/*
google_ad_client = "ca-pub-2783044520727903";
/* jQuery_demo */
/*google_ad_slot = "2780937993";
google_ad_width = 728;
google_ad_height = 90;*/
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>

  </body>
</html>
