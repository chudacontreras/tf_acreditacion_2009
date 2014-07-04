<?php
session_start();
if (array_key_exists('login',$_SESSION)){
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="text.css" type="text/css">
<script language="JavaScript">
function Validar()
   {
      var Cate = document.formu.Cate.value; 
	  var Pro = document.formu.Pro.value; 
  	  var Ram = document.formu.Ram.value; 
	  
      if(Pro==""){
         alert("Debe Registrar productos a Comercializar");
		 return false;
      }
	   if(Ram==""){
         alert("Debe Registrar el Ramo");
		 return false;
      }
	  if(Cate=="0"){
         alert("Debe Seleccionar una Categoria");
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
	    <font face="Arial, Helvetica, sans-serif">
		   <span>
		     <font size="4">
			   <font color="#FF6600">
		          <br>Registro de Empresas
		          <br>
			   </font>
			 </font>
		</span>
		</font>
	</strong>
  </div>

		<FORM METHOD="GET" action="ubicastan.php" name="formu" onSubmit="return Validar()">
		<?php

			include("ControlaBD.php");
		
			$con   = new ControlaBD();
			$idcon = $con->conectarSBD();
			$sel_bd= $con->select_BD("tf_comercializacion");
	  ?>
		<table width=550 border=0 align=center>
		  <!--DWLayoutTable-->
			<tr>
				<td width="165" height="21" valign="top">Rif/Cedula</td>
				<td width="372" valign="top"><?php
                    echo "<input name='Rif' id='Rif' value='".$_GET['Rif']."' type='text' style='WIDTH: 290px; HEIGHT: 22px' readonly='yes'/>"; 
                    ?>				</td>
			</tr>
			<tr>
				<td height="21" valign="top">Nombre de la Empresa</td>
				<td valign="top">
			    <?php
                    echo "<input name='Nom' id='Nom' value='".$_GET['Nom']."' type='text' style='WIDTH: 290px; HEIGHT: 22px' readonly='yes'/>"; 
                    ?>				</td>
			</tr>
			<tr>
				<td height="21" valign="top">Direcci&oacute;n</td>
				<td valign="top">
			     <?php
                    echo "<input name='Dir' id='Dir' value='".$_GET['Dir']."' type='text' style='WIDTH: 290px; HEIGHT: 22px' readonly='yes'/>"; 
                 ?>				</td>
			</tr>
			<tr>
				<td height="21" valign="top">Productos a Comercializar</td>
				<td valign="top"><?php
                    echo " <input type=hidden name='tipo' id='tipo' value='0'>
					<input name='Pro' id='Pro' type='text' style='WIDTH: 290px; HEIGHT: 22px' value='".$_GET['Pro']."'/>"; 
                 ?>				 </td>
			</tr>
			<tr>
				<td height="21" valign="top">Ramo</td>
				<td valign="top"><?php
                    echo " <input type=hidden name='tipo' id='tipo' value='0'><input type=hidden name='Cate' id='tipo' value='".$_GET['Cate']."'>
					<input name='Ram' id='Ram' type='text' style='WIDTH: 290px; HEIGHT: 22px' value='".$_GET['Ram']."'/>"; 
                 ?>				 </td>
			</tr><?php
			/*
			<tr>
				<td>Categoria</td>
			    <td valign="top">
				    $result= $con->ejecutar("SELECT codcate,descrip FROM categoria",$idcon);
					if ($row = mysql_fetch_array($result)){ 
                        echo '<select name= "Cate" id="Cate" style="WIDTH: 290px; HEIGHT: 22px" ><option value=0>Seleccione la Categoria</option>';
                      do {
                       echo '<option value='.$row["codcate"].'>'.$row["descrip"].'</option>';
                      } while ($row = mysql_fetch_array($result)); 
                       echo '</select>';
					}
		       
				</td>
			</tr> */?>
			<tr>
					<td height="0">					</td>
					<td></td>
					</tr>
			<tr>
			  <td height="26" colspan="2" valign="top" align="center"><input name="button" type="submit" value="Ver Stand Disponibles"/></td>
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