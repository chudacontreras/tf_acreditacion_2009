<?php 
  
 function js_redireccion($pagina){
  	 echo "<script language='JavaScript' type='text/JavaScript'>";
	 echo "window.location.href='$pagina';";
	 echo "</script>";
 }
 
 function js_msgbox($msg){
  	 echo "<script language='JavaScript' type='text/JavaScript'>";
	 echo "alert('$msg');";
	 echo "</script>";
 }

 function rompe_frame($pagina){
  	 echo "<script language='JavaScript' type='text/JavaScript'>";
	 echo " if (self.parent.frames.length != 0)";
	 echo " self.parent.location=document.location.href='$pagina';";	 
	 echo "</script>";
 }

 function pagina_atras($cantidad){
  	 echo "<script language='JavaScript' type='text/JavaScript'>";
	 echo "self.history.back('$cantidad')";
	 echo "</script>";
 }
////////////////////////////////////////////////////

//Convierte fecha de mysql a normal

////////////////////////////////////////////////////

function cambiaf_a_normal($fecha){

    ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);

    $lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1];

    return $lafecha;

} 



////////////////////////////////////////////////////

//Convierte fecha de normal a mysql

////////////////////////////////////////////////////

function cambiaf_a_mysql($fecha){

    ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);

    $lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1];

    return $lafecha;

} 

?>