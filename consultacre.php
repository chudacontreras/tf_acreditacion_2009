<?php
session_start();
if (array_key_exists('login',$_SESSION)){
include("ControlaBD.php");

$rif = $_SESSION['rif'];
	
	$mio = $_GET['nro'];
	
	$con   = new ControlaBD();
	$idcon = $con->conectarSBD();
	$sel_bd= $con->select_BD("tf_comercializacion");
	
	$result= $con->ejecutar("SELECT * FROM empresa where rif = '$rif'",$idcon);	
	$row = mysql_fetch_array($result);
	$nombre = $row["nombre"];
?>

<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="text.css" type="text/css">
<script language="javascript">
   function comprobar(){
   
		if(confirm('�Est� seguro de ELIMINAR el registro?')){
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
								  <br><?php echo $nombre ?><br></font>
								  <font face="Arial, Helvetica, sans-serif" size="3" color="#FF6600">
								  Acreditados<br>
								  </font>
								  <br>
					</strong>	
				  </div>	
			  <table width="90%" border="0" class="texto" align="center">
			  <form name="frm1" action="operacion.php" method="post">
<?php
				if (!$_GET['nro']){
					$result2= $con->ejecutar("SELECT * FROM acreditado where rif = '$rif' ORDER BY id",$idcon);
					
				}else{
					$result2= $con->ejecutar("SELECT * FROM acreditado where id = $nro",$idcon);
				}			  
             if($row2 = mysql_fetch_array($result2)){
			 echo "	
			  <tr>
			  	<td width='25%' rowspan='4' align='center'><img src='".$row2['foto']."' height='100px'></td>
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
			  <input type='hidden' name='nro' value='".$row2['id']."'>"
			  ?>	
			  <tr>
				  <td colspan="3" align="center">
				      <br><br>					  
					  <input type="submit" name="boton" value="<<" id="<<">
					  <input type="submit" name="boton" value="<" id="<">
					  <input type="submit" name="boton" value="Eliminar" id="Eliminar" onClick="return comprobar()">
					  <input type="submit" name="boton" value=">" id=">">
					  <input type="submit" name="boton" value=">>" id=">>">
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
