<?php
session_start();
if (array_key_exists('login',$_SESSION)){

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
	include("ControlaBD.php");

	$con   = new ControlaBD();
	$idcon = $con->conectarSBD();
	$sel_bd= $con->select_BD("tf_comercializacion");
	
	    $contra = $_GET["Cont"];
		$tota = $_GET["tot"];
		$acum = $_GET["acum"];
	    $ncheque = $_GET["nro"];
	    $banco = $_GET["ban"];
	    $mont = $_GET["mon"];
		$fecha=date("Y-m-d", mktime(0, 0, 0, date("m") , date("d"), date("Y")));
//*****************************************
       if ($acum+$mont==$tota){
		   $resta=0;
		   $statu=3;
		}else{
		   $suma=$acum+$mont;
		   $resta=$tota-$suma;
		   $statu=2;
		}
    $resultbus= $con->ejecutar("SELECT * FROM transacciones WHERE nrocheque='$ncheque' and  nrocontrato='$contra'",$idcon);
	$num_rows=mysql_num_rows($resultbus);
	$row=mysql_fetch_array($resultbus);
	  if ($num_rows==1){
	    echo '<div align="center">
      <strong>
	    <font face="Arial, Helvetica, sans-serif">
		   <span>
		     <font size="4">
			   <font color="#FF6600">
		          <br>El N�mero de Voucher Invalido....
		          <br>
			   </font>
			 </font>
		</span>
		</font>
	</strong>
  </div>';
	  }
	  else{
    	$strtran = "INSERT INTO transacciones VALUES('$contra','$statu','$ncheque','$banco','$fecha','$mont')";
		$resultran = $con->ejecutar($strtran,$idcon);
		
		
	
		$str = "UPDATE contrato SET Statu='$statu',resta='$resta' WHERE  numero='$contra'";
		$result = $con->ejecutar($str,$idcon);
		
		
		echo '<div align="center">
      <strong>
	    <font face="Arial, Helvetica, sans-serif">
		   <span>
		     <font size="4">
			   <font color="#FF6600">
		          <br>El Registro insertado exitosamente....
		          <br>
			   </font>
			 </font>
		</span>
		</font>
	</strong>
  </div>';

		
			echo "<FORM METHOD='GET' action='recibo2.php' name='formato'>
            <table align='center'>
		          <tr>
		      <td>
			  <input type=hidden name='Cont' id='Cont' value='".$_GET["Cont"]."'>
	          <input name=button type=submit value='Generar Recibo'>
			  
		      </td>
			   <td>
			  
			  </td>
		         </tr>
		   </table>		   
		   
	   </form>";
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
