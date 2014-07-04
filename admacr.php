<?php
/**************************************************************
    ELIMINA/CAMBIA STATUS DE ACREDITADO - SOLO ADMINISTRADOR
**************************************************************/
session_start();
if (array_key_exists('login',$_SESSION)){
include("ControlaBD.php");

$rif = $_SESSION['rif'];
	
	$mio = $_GET['nro'];
	
	$con   = new ControlaBD();
	$idcon = $con->conectarSBD();
	$sel_bd= $con->select_BD("tf_comercializacion");
	
	$ced = $_POST['Nac'].$_POST['Rif'];
?>

<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="text.css" type="text/css">
<script language="javascript">
   function comprobar(){
   
		if(confirm('&iquest;Est&#063; seguro de ELIMINAR el registro&#063;')){
		   this.form.submit();
		}else{return false;}   
	}
   function comprobar2(){
   
		if(confirm('&iquest;Est&#063; seguro de CAMABIAR EL STAUTS del registro&#063;')){
		   this.form.submit();
		}else{return false;}   
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
  <td height="600px" bgcolor="#DADADA" valign="top"> 
  				<br><br>
				<div align="center"><strong>
						<font face="Arial, Helvetica, sans-serif" size="4" color="#FF6600">
								  <br>Comisi&oacute;n de Acreditaci&oacute;n<br></font>
								  <font face="Arial, Helvetica, sans-serif" size="3" color="#FF6600">
								  Acreditados<br>
								  </font>
								  <br>
					</strong>	
				  </div>	
			  <table width="90%" border="0" class="texto" align="center">
			  <form name="frm1" action="modacr.php" method="post">
<?php
			 $result2= $con->ejecutar("SELECT * FROM acreditado where cedula = '$ced'",$idcon);		  
             if($row2 = mysql_fetch_array($result2)){
			 echo "	
			  <tr>
			  	<td width='25%' rowspan='6' align='center'><img src='".$row2['foto']."' height='100px'></td>
				<td width='15%'>Nombres:</td>
				<td width='60%'><input type='text' readonly='yes' size='45' value='".$row2['nombre']."'>	  </td>
			  </tr>
			  <tr>
				<td>C&eacute;dula:</td>
				<td><input type='text' readonly='yes' size='45' value='".$row2['cedula']."'> </td>
			  </tr>
			  <tr>
				<td>Tipo:</td>";
				$tipo = $row2['tipacr'];
			    $result3= $con->ejecutar("SELECT * FROM tipacr where codtacr = $tipo",$idcon);
                $row3 = mysql_fetch_array($result3) ;			
				echo "<td><input type='text' readonly='yes' size='45' value='".$row3['descrip']."'></td>";
				echo "
				</tr>
			  <tr>
				<td>Contrato</td>
				<td><input type='text' readonly='yes' size='45' value='".$row2['contrato']."'></td>
			  </tr> 
			  <tr>
				<td>Status</td>";
				if ($row2['estatus'] == 1){$s = 'Por Imprimir';}elseif($row2['estatus'] == 2){$s='Bloqueada';}else{$s='Eliminada';}
				echo"
				<td><input type='text' readonly='yes' size='45' value='".$s."'></td>
			  </tr>			  
			  <tr>
				<td>Usuario</td>
				<td><input type='text' readonly='yes' size='45' value='".$row2['usuario']."'></td>
			  </tr>			  
			  <input type='hidden' name='nro' value='".$row2['id']."'>"
			  ?>
			  <tr>
				  <td colspan="3" align="center">			  
					  <br><br>
				  </td>
			  </tr>	
			  <tr>
				  <td colspan="3" align="center">			  
					  <table width="100%">
					  <tr>
						  <td colspan="3" align="center">			  
							  <input type="submit" name="boton" value="Cambiar Status" id="Cambiar" onClick="return comprobar2()">
							  <input type="submit" name="boton" value="Eliminar" id="Eliminar" onClick="return comprobar()">
						  </td>			  				  
					  </tr>
					  </table>
				  </td>
			  </tr>

			  </form>
			  <?php
			  }else{
			  echo "
			  <tr>
				<td colspan='2' align='center'>
				No existen Registros...
				</td>
			  </tr>";			  
			  }
			  ?>
		</table>
		</td></tr>
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
