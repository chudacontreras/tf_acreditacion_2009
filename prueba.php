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
    <div align="center">
      <strong>
	    <font face="Arial, Helvetica, sans-serif">
		   <span>
		     <font size="4">
			   <font color="#FF6600">
		          <br>Stand Disponibles para la Venta
		          <br>
			   </font>
			 </font>
		</span>
		</font>
	</strong>
  </div>
  </div>
  <div class="tabConte" id="tabConte">
  
  <?php
 include("ControlaBD.php");
 $con   = new ControlaBD();
 $idcon = $con->conectarSBD();
 $sel_bd= $con->select_BD("tf_comercializacion");
?>

  <FORM METHOD="GET" action="prueba2.php" name="formato">
<table align="center" cellspacing="2" cellpadding="2" border="0" class="texto">
  <!--DWLayoutTable-->
           <tr bgcolor="#E5E5E5">
				<th width="180">Venta</th>
				<th width="180">Codigo de Stand</th>
			</tr>
		<?php
			$dato=$_GET["q"];
			$otro=$_GET["Rif"];
			$prod=$_GET["Prod"];
			$ramo=$_GET["Ram"];
			$accion=$_GET["tipo"];
			$direc=$_GET["Dir"];
			$empre=$_GET["Nom"];
			
			$resulCosto= $con->ejecutar("SELECT costo,preventa,fechainicio,fechafin FROM ubicacion WHERE codubi='$dato'",$idcon);
			$fila0 = mysql_fetch_array($resulCosto);
			
			$fecha=date("Y-m-d", mktime(0, 0, 0, date("m") , date("d"), date("Y")));
			if (($fecha>=$fila0[2]) and ($fecha<=$fila0[3])){
			    $valor=$fila0[1];
				}else{
   				$valor=$fila0[0];
			}
			echo "<td><INPUT TYPE=hidden NAME=Cot id=Cot value='$valor'></td>"; 			
			echo "<td><INPUT TYPE=hidden NAME=produc id=produc value='$prod'></td>"; 	
			echo "<td><INPUT TYPE=hidden NAME=Ram id=Ram value='$ramo'></td>"; 	
			$resulStan= $con->ejecutar("SELECT codstand,status FROM Stand WHERE codubi='$dato' and status='Activo' ORDER BY codstand",$idcon);
				
					while ($fila = mysql_fetch_array($resulStan)) {
					   echo "<tr>";
					   echo "<td><input type=checkbox name=ckbox[] id=ckbox[] value=$fila[0]></td>"; 
					   echo "<td align=center>$fila[0]</td>";
					   echo "</tr>";
					}
			$num_rows=mysql_num_rows($resulStan);
			if ($num_rows>0){
			 echo "
			<tr>
			  <td height=35 colspan=2 valign=top align=center>
                <input name=button type=submit value='Realizar  Venta'>				
			  </td>
		    </tr>";	
			}else{
			 echo'<div align="center">
      <strong>
	    <font face="Arial, Helvetica, sans-serif">
		   <span>
		     <font size="2">
			   <font color="#FF6600">
		          <br>No hay Stand Disponibles para la venta
		          <br>
			   </font>
			 </font>
		</span>
		</font>
	</strong>
  </div>';
			}
			 $resulContra= $con->ejecutar("SELECT * FROM contrato",$idcon);
			 
			 $canti = mysql_num_rows($resulContra);
			
          if ($accion==0){
    		if  ($canti==0){
			     $numcontra='LTF09'.'0001';
			 }
			else{
            
			$numero=$canti+1;
			$num=$numero;
			$cifra=4;
			$Cifra_num=strlen($num);
			$nuevonumero="";
			for($i=$Cifra_num;$i<$cifra;$i++){
				$nuevonumero.=0;
			
			}
			$nuevonumero.=$num;
			$numcontra='LFT09'.$nuevonumero;



			}
		}else
		{
		$numcontra=$_GET["Cont"];
		}
			$fecha=date("Y-m-d", mktime(0, 0, 0, date("m") , date("d"), date("Y")));
			echo "<td><INPUT TYPE=hidden NAME=Cont id=Cont value='$numcontra'></td>"; 
			echo "<td><INPUT TYPE=hidden NAME=fecha id=fecha value='$fecha'></td>";
			echo "<td><INPUT TYPE=hidden NAME=Dir id=Dir value='$direc'></td>"; 
			echo "<td><INPUT TYPE=hidden NAME=Nom id=Nom value='$empre'></td>";
			echo "<td><INPUT TYPE=hidden NAME=Ubi id=Ubi value='$dato'></td>";
			echo "<td><INPUT TYPE=hidden NAME=Rif id=Rif value='$otro'></td>";
		?>
</table>

</form>
  </div>
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