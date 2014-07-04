<?php
session_start();
if (array_key_exists('login',$_SESSION)){
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="text.css" type="text/css">
<script language="javascript">
   function comprobar()
   {
           var rif = document.formulario.Rif.value; 
           var nombre = document.formulario.Nom.value;
		   var direc = document.formulario.Dir.value;
		   var telef = document.formulario.Tel.value;
		   var cate = document.formulario.Cate.value;
             
           if (rif == '')
           {
                   alert("Rif o C�dula no debe estar en Blanco");
                   return false;
           }
		   
		   if (nombre == '')
           {
                   alert("Nombre no debe estar en Blanco");
                   return false;
           }
		   if (direc == '')
           {
                   alert("Direcci�n no debe estar en Blanco");
                   return false;
           }
		    if (telef == '')
           {
                   alert("Telefono no debe estar en Blanco");
                   return false;
           }
    		    if (cate == 0)
           {
                   alert("Debe Seleccionar una Categor�a");
                   return false;
           } 
           return true;
   }
   </script>
</head>

<body bgcolor="#CCCCCC" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr> 
    <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="D00C0C">
        <tr bgcolor="#FF6600"> 
          <td bgcolor="#FFFFFF"><? include("cintillo.html"); ?></td>
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
  
					
  <td height="600px" bgcolor="#DADADA" width="100">
  <div class="tabConte" id="tabConte">
	<div align="center">
      <strong>
	    <font face="Arial, Helvetica, sans-serif">
		   <span>
		     <font size="4">
			   <font color="#FF6600">
		          <br>Modificar Empresas
		          <br>
			   </font>
			 </font>
		</span>
		</font>
	</strong>
  </div>
	
	
  <?php
    include("util.php");
	include("ControlaBD.php");

	$con   = new ControlaBD();
	$idcon = $con->conectarSBD();
	$sel_bd= $con->select_BD("tf_comercializacion");

	    $nacionalidad = $_GET["Nac"];
	    $cedula = $_GET["Ced"];
		$dato=$nacionalidad.$cedula; 
		
	 if($nacionalidad=='V' or $nacionalidad=='E'){
	    if(!is_numeric($cedula)){
		   js_redireccion("error.php?msn=Cedula Invalida, Contiene Caracteres");
		}
	 }
		
	
		$result= $con->ejecutar("SELECT rif,nombre,direccion,telf,replegal,cedrepre,categoria,retensoriva FROM empresa WHERE rif='$dato'",$idcon);
		$num_rows=mysql_num_rows($result);
		$row=mysql_fetch_array($result);
		//$dato=urlencode($row['rif']);
		
	  if ($num_rows==1){
		
				echo ' <FORM METHOD="GET" name="formulario" action="regempreM.php" onsubmit="return comprobar()">
				<table>
				 <tr>
				<td>
				<input name="Nac" type="hidden" id="Nac"  style="WIDTH: 290px; HEIGHT: 22px" value="';
		echo $nacionalidad.'"/>
				</td>
				</tr>
				 <tr>
				<td>Cedula/Rif:&nbsp;</td>
				<td>
				<input name="Rif" type="text" id="Rif"  style="WIDTH: 290px; HEIGHT: 22px" value="'.$row['rif'].'" readonly="yes" />
				</td>
				</tr>
				<tr>
				<td>Nombre:&nbsp;</td>
				<td>
				<input name="Nom" type="text" id="Nom"  style="WIDTH: 290px; HEIGHT: 22px" value="'.$row['nombre'].'"/>
				</td>
				</tr>
					<tr>
						<td>Direcci&oacute;n:&nbsp;</td>
						<td><INPUT type="Text" name=Dir id="Dir" style="WIDTH: 290px; HEIGHT: 22px" value="'.$row['direccion'].'"/></td>
					</tr>
					<tr>
						<td>Tel&eacute;fono:&nbsp;</td>
						<td><INPUT type="Text" name=Tel id="Tel" style="WIDTH: 290px; HEIGHT: 22px" value="'.$row['telf'].'"/></td>
					</tr>
				<tr>'; 
				echo'</td>
					</tr>
					<tr>
					<td>
					</td>
					<td>
					<input name="Cate" type="hidden" id="Cate" value="'.$row['categoria'].'"/>
					<input name="button" type="submit" value="Modificar"></td>
					</tr>
					</table>
					</form>';				
			}
		else{
	          echo "La Empresa No existe";				
					
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
