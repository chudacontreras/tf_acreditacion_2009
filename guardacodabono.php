<?php
session_start();
if (array_key_exists('login',$_SESSION)){

function randomText($length) {
    $pattern = "1234567890abcdefghijklmnopqrstuvwxyz";
    for($i=0;$i<$length;$i++) {
      $key .= $pattern{rand(0,35)};
    }
    return $key;
}
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="text.css" type="text/css">
</head>

<body bgcolor="#CCCCCC" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr> 
    <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="D00C0C">
        <tr bgcolor="#FF6600"> 
          <td bgcolor="#FFFFFF"></td>
        </tr>
      </table>	</td>
  </tr>
  <tr> 
  <tr>
    <td height="3" colspan="2" bgcolor="#000000"><img src="images/spacer.gif" width="1" height="3"></td>
  </tr>
  <tr> 
	<td colspan="2">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="75%" height="19" align="left" bgcolor="#FF6600">
				<font color="#FFFFFF" size="1" face="Verdana, Arial, Helvetica, sans-serif">
				&nbsp;&nbsp;<strong>Bienvenido Sr(a) <? echo $_SESSION["usuario"] ?></strong>
				</font>	
			</td>
			<td width="25%" align="right" bgcolor="#FF6600">
				<font color="#FFFFFF" size="1" face="Verdana, Arial, Helvetica, sans-serif">
				<? echo date("d / m / Y"); ?>&nbsp;&nbsp;
				</font>
			</td>		
		</tr>	
		</table>
	</td>
  </tr>  
  <tr>
  <td height="600px" width="206" bgcolor="#E5E5E5">
   	<? include("menu.php"); ?>	
  </td>
  <td height="600px" bgcolor="#DADADA">
  <div class="tabConte" id="tabConte">
  
  <?php
    include("util.php"); // INCLUDE PARA LLAMAR A UNA PAGINA
	include("ControlaBD.php");

	$con   = new ControlaBD();
	$idcon = $con->conectarSBD();
	$sel_bd= $con->select_BD("tf_comercializacion");
	
	$desde = $_GET["des"];
	$hasta = $_GET["has"];

    for($j=$desde;$j<=$hasta; $j++){
	  //INICIO: GENERAR ID UN CORRELATIVO
	   $resulAbono= $con->ejecutar("SELECT * FROM abono",$idcon);
	   $canti = mysql_num_rows($resulAbono);

 		if  ($canti==0){
			$numabono='AB'.'00001';
		 }else{
            $numero=$canti+1;
			$num=$numero;
			$cifra=5;
			$Cifra_num=strlen($num);
			$nuevonumero="";
			for($i=$Cifra_num;$i<$cifra;$i++){
				$nuevonumero.=0;
			}
			$nuevonumero.=$num;
			$numabono='AB'.$nuevonumero;
	    }
	  //FIN: GENERAR ID UN CORRELATIVO
	  
  	  //INICIO: GENERAR CODIGO DE BARRA DE LOS ABONOS
	     $codigoB=$numabono.strtoupper(randomText(5));
   	  //FIN: GENERAR CODIGO DE BARRA DE LOS ABONOS
	  
	  	   $strsql = "INSERT INTO abono VALUES ('$numabono','$codigoB',0,'$usuario')";
	   $resultbusq = $con->ejecutar($strsql,$idcon);
	}
		
    if (!$resultbusq) {
		die('Error al Insertar:'. mysql_error());
	}else{
	 js_redireccion("error.php?msn=Abonos Creados Exitosamente");
	 exit;
	
	}

?>
  
  
  </div>
  </td>
  </tr>
  
  
  <tr> 
    <td height="19" colspan="2" align="center" bgcolor="#FF6600"><font color="#FFFFFF" size="1" face="Verdana, Arial, Helvetica, sans-serif">&copy;2009 Gobernacion del Estado Lara<br>
Desarrollado por la Dirección de Informatica (Unidad de Diseño y Desarro</font></td>
  </tr>
  <tr>
    <td height="3" colspan="2" bgcolor="#000000"><img src="images/spacer.gif" width="1" height="3"></td>
  </tr>
</table>
</body>
</html>
<?php
 }else
{
    Header ("location: index.php"); 
}
?>
