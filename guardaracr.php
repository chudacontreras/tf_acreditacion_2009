<?php
session_start();
if (array_key_exists('login',$_SESSION)){
include("ControlaBD.php");
include("util.php");
	$rif=$_SESSION['rif'];
	$con   = new ControlaBD();
	$idcon = $con->conectarSBD();
	$sel_bd= $con->select_BD("tf_comercializacion");
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

// Validaciones basicas
	if (!is_numeric($_POST['ced'])){js_redireccion("error.php?msn=N&uacute,mero de C&eacute;dula Inv&aacute;lido");exit;}
	if ($_POST['nom'] == '' || $_POST['nom'] == ' '){js_redireccion("error.php?msn=El campo nombre no puede estar en blanco");exit;}
	if (!is_numeric($_POST['cod'])){js_redireccion("error.php?msn=C&oacute;digo de &Aacute;rea Inv&aacute;lido");exit;}
	if (!is_numeric($_POST['tel'])){js_redireccion("error.php?msn=N&uacute;mero de Tel&eacute;fono Inv&aacute;lid");exit;}
	if ($_POST['cont'] == '0'){js_redireccion("error.php?msn=Debe seleccionar un N&uacute;mero de Contrato");exit;}
	if ($_POST['Cate'] == 0){js_redireccion("error.php?msn=Debe seleccionar un tipo de Acreditaci&oacute;n");exit;}
	
	$cedula = $_POST['ced'];
	$ced= $_POST['nac'].$cedula;
	$cont = $_POST['cont'];
	$Cate = $_POST['Cate'];
	
// validacion de existencia	
		$result= $con->ejecutar("SELECT * FROM acreditado where cedula = '$ced'",$idcon);	
		if (mysql_num_rows($result) != 0){js_redireccion("error.php?msn=La C&eacute;dula N&uacute;mero: ".$ced.", ya est&aacute; registrada");exit;}	
	//exit;
// validacion del tipo de acreditacion	
		//tipo de acreditacion
		$result= $con->ejecutar("SELECT * FROM cantacredita where nrocontrato = '$cont' and tipoacre = '$Cate'",$idcon);	
		if (mysql_num_rows($result) <= 0){js_redireccion("error.php?msn=No le corresponde este tipo de Acreditaci&oacute;n");exit;}
		$nro =  mysql_fetch_array($result);
		$cant = $nro["cant"];
		
		//cantidad de acreditaciones del tipo correspondiente
		$result2= $con->ejecutar("SELECT * FROM acreditado where contrato = '$cont' and tipacr = $Cate",$idcon);	
		
		if (mysql_num_rows($result2) >= $cant){
			js_redireccion("error.php?msn=Ha excedido el n&uacute;mero de Acreditaciones para el Tipo Seleccionado");exit;}
		$cant = $result["cant"];
		//Codigo de Barras
		$i = strlen($_POST['ced']);
		$campo = $_POST['ced'];
	   while ($i<8)
	   {
		  $campo = "0".$campo;
		  $i++;
	   } 		
		$CB = $campo.rand(5000, 9000);
		
		// Codigo Visible
		$CV = $campo;
		$CV = str_replace('0','F',$CV);
		$CV = str_replace('1','G',$CV);
		$CV = str_replace('2','A',$CV);
		$CV = str_replace('5','H',$CV);
		$CV = str_replace('7','J',$CV);
		$CV = str_replace('8','M',$CV);
		$CV = str_replace('9','K',$CV);
		$CV = "LTF".rand(10, 90).$CV;
		// Si no existe la carpeta de la empresa la creo
		if (!file_exists("fotos/".$_SESSION["rif"])){	
		   $content = "fotos/".$_SESSION["rif"];
		   $dirmake = mkdir("$content");
		}   
		$extension = explode(".",$archivo_name);
		$num = count($extension)-1;
		if(strtoupper($extension[$num]) == "JPG") // pregunto si el archivo es JPG
			{
			if($archivo_size < 40000) // pregunto si el archivo es menor que 40 Kb
			{
			if(!copy($archivo, "fotos/".$_SESSION["rif"]."/".$archivo_name)) // sube la imagen al server
			{
			js_redireccion("error.php?msn=Se produjo un error al intentar subir la imagen"); // sino la sube
			}
			else
			{
			if (file_exists("fotos/".$_SESSION["rif"]."/".$cedula.".jpg")){ // si la foto ya existe la elimino	
			   unlink("fotos/".$_SESSION["rif"]."/".$cedula.".jpg");
			} 			
			if (strtoupper($archivo_name) != $cedula.".JPG"){
				rename("fotos/".$_SESSION["rif"]."/".$archivo_name, "fotos/".$_SESSION["rif"]."/".$cedula.".jpg"); // renombro el archivo subido
            }
			// guardo el registro en la BD
			$hoy = date("Y-m-d");
			$rif=$_SESSION['rif'];
			$nom = strtoupper($_POST['nom']);
			$tele= $_POST['cod']."-".$_POST['tel'];
			$foto="fotos/".$_SESSION["rif"]."/".$cedula.".jpg";
			$strsql = "INSERT INTO acreditado (rif, cod_b, cod_v, cedula, nombre, telf, tipacr, foto, estatus, contrato, fecha_r, usuario) VALUES ('$rif','$CB','$CV','$ced','$nom','$tele',$Cate,'$foto',1,'$cont','$hoy','$login')";
			//echo $strsql; exit;
			$resultbusq = $con->ejecutar($strsql,$idcon);
			if ($resultbusq){					
			echo '<div align="center">
				  <strong>
					<font face="Arial, Helvetica, sans-serif" size="4" color="#FF6600">
							  <br>El Registro Guardado Exitosamente....
							  <br>
					</font>
				</strong>
			  </div>';
			}else{
				js_redireccion("error.php?msn=Error al guardar el registro");
				unlink("fotos/".$_SESSION["rif"]."/".$cedula.".jpg");}
			}
			}
			else
			{
			js_redireccion("error.php?msn=El archivo supera los 40 Kb");
			}
			}
			else
			{
			js_redireccion("error.php?msn=El formato de la imagen es inv&aacute;lido, solo se acepta JPG");
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
