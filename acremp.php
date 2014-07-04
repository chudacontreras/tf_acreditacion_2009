<?php
session_start();
if (array_key_exists('login',$_SESSION)){

include("ControlaBD.php");
include("util.php");

$con   = new ControlaBD();
$idcon = $con->conectarSBD();
$sel_bd= $con->select_BD("tf_comercializacion");


if ($_SESSION["tusu"] == 10){
    $busca = $_SESSION["rif"];

	
	
	$result2= $con->ejecutar("SELECT * FROM empresa where rif = '$busca'",$idcon);
	if ($row3 = mysql_fetch_array($result2)){
	   $rif = $row3["rif"];	
		
	}else{
		js_redireccion("error.php?msn=El RIF o C&eacute;dula es Incorrecto");exit;
	}
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
<div align="center">
      <strong>
	    <font face="Arial, Helvetica, sans-serif" size="4" color="#FF6600">
		          <br>
		          Registro de Acreditados<br><br>
		</font>
	</strong>
  </div>
   <FORM METHOD="POST"  action="guardaracr.php" name="formulario" enctype="multipart/form-data">
 <?php
	


				$result= $con->ejecutar("SELECT * FROM empresa where rif = '$rif'",$idcon);
				$row2 = mysql_fetch_array($result);
					$cate = $row2["categoria"];


?>
<table align="center" cellspacing="2" cellpadding="2" border="0" class="texto">
  <!--DWLayoutTable-->
  
			<tr>
			    <td>Nro de Contrato:&nbsp;</td>
			    <td>
				<?php
echo "echo viene de la primera consulta el rfi:"." ".$rif;	
				$result= $con->ejecutar("SELECT * FROM contrato where rif = '$rif'",$idcon);
echo "echo viene de la segunda consulta consulta el rfi:"." ".$row["numero"];
				if ($row = mysql_fetch_array($result)){ 
					echo '<select name= "cont" id="cont" style="WIDTH: 290px; HEIGHT: 22px" ><option value=0>Seleccione un Contrato</option>';
				  do {
				   echo '<option value='.$row["numero"].'>'.$row["numero"].'</option>';
				  } while ($row = mysql_fetch_array($result)); 
				   echo '</select>';
				}
				?>
				</td>
			</tr>           
			
			<tr>
			    <td>C&eacute;dula de Identidad:&nbsp;</td>
			    <td>
				<select name="nac" id="nac">
					<option>V</option>
					<option>E</option>
				</select>
		        &nbsp;-&nbsp;<input name="ced" type="text" id="ced"  style="WIDTH: 233px; HEIGHT: 22px" />
				</td>
			</tr>
			<tr>
			    <td>Nombres y Apellidos:&nbsp;</td>
			    <td>
				<input name="nom" type="text" id="nom"  style="WIDTH: 290px; HEIGHT: 22px" />
				</td>
			</tr>
			<tr>
			    <td>Tel&eacute;fono:&nbsp;</td>
			    <td>
				  <input name="cod" type="text" id="cod" maxlength="4" style="WIDTH: 40px; HEIGHT: 22px" />&nbsp;-&nbsp;
				  <input name="tel" type="text" id="tel" maxlength="7" style="WIDTH: 233px; HEIGHT: 22px" />		      
				</td>
			</tr>
			<tr>
			    <td>Tipo de Acreditaci&oacute;n:</td>
			    <td>
				<?php
				$result= $con->ejecutar("SELECT * FROM tipacr WHERE codcateg='$cate' and codtacr < 100 and descrip <> 'Invitado'",$idcon);
				if ($row3 = mysql_fetch_array($result)){
					echo '<select name="Cate" id="Cate" style="WIDTH: 290px; HEIGHT: 22px" ><option value=0>Seleccione un Tipo</option>';
				  do {
				   echo '<option value='.$row3["codtacr"].'>'.$row3["descrip"].'</option>';
				  } while ($row3 = mysql_fetch_array($result)); 
				   echo '</select>';
				}
				?>
				</td>
			</tr>			
			<tr>
			    <td>Fotograf&iacute;a:&nbsp;</td>
			    <td>
					<input name="archivo" type="file" size="29">
				</td>
			</tr>							
			 
					<tr>
			         <td height=35 colspan=4 valign=top align=center>
                     <br><input name="boton" type=submit value='Crear'>
				    </td>
		          </tr>
					<tr>
			         <td height=35 colspan=4 valign=top align=center>
                     <br>
					 <font face="Arial, Helvetica, sans-serif" size="1" color="#FF6600">
					 NOTA: La Imagen a subir debe ser de formato "jpg" y no mayor a 40 Kb.
					 </font>
				    </td>
		          </tr>				  
  </table>

	
</form>
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


