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
           var comi = document.formulario.Comi.value; 
           var ced = document.formulario.Ced.value;
		   var nom = document.formulario.Nom.value;
		   var telef = document.formulario.Telf.value;
		   var cate = document.formulario.Cate.value;
             
           if (comi == '')
           {
                   alert("Nombre de la Comisi&oacute;n no debe estar en Blanco");
                   return false;
           }
		   
		   if (ced == '')
           {
                   alert("C&eacute;dula no debe estar en Blanco");
                   return false;
           }
		   if (nom == '')
           {
                   alert("Nombre del Representante no debe estar en Blanco");
                   return false;
           }
		    if (telef == '')
           {
                   alert("Telefono no debe estar en Blanco");
                   return false;
           }
    		    if (cate == 0)
           {
                   alert("Debe Seleccionar una Categor&iacute;a");
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
  <div id="contenido">
  
  <FORM METHOD="GET" action="tipoacrentes.php" onSubmit="return comprobar()" name="formulario">
  <?php
  
    include("ControlaBD.php");

	$con   = new ControlaBD();
	$idcon = $con->conectarSBD();
	$sel_bd= $con->select_BD("tf_comercializacion");
	?>

<table align="center" cellspacing="2" cellpadding="2" border="0" class="texto">
  <!--DWLayoutTable-->
            <tr>
			  <td>Nombre de la Comisi&oacute;n&nbsp;</td>
			  <td>
			      <input type="text" name="Comi" id="Comi" style="width:220px; height:22px">
				</td>
		    </tr>
			<tr>
			    <td>C&eacute;dula del Representante&nbsp;</td>
				 <td>
				<SELECT NAME="Nac" id="Nac" SIZE="0">
				<OPTION>V
				<OPTION>E
				<OPTION>J
				<OPTION>G
				</SELECT> -
			    <INPUT type="Text" name=Ced id="Ced"  style="WIDTH: 167px; HEIGHT: 22px"> 	
								
				</td>
			</tr>
			  <tr>
			  <td>Nombre del Representante&nbsp;</td>
			  <td>
			      <input type="text" name="Nom" id="Nom" style="width:220px; height:22px">
				</td>
		    </tr>
           <tr>
			  <td>Tel&eacute;fono&nbsp;</td>
			  <td>
			      <input type="text" name="Telf" id="Telf" style="width:220px; height:22px">
				</td>
		    </tr>
			<?php
			echo '<tr>
				<td>Categor&iacute;a</td>
			    <td valign="top">';
				    $result= $con->ejecutar("SELECT codcate,descrip FROM categoria",$idcon);
					if ($row = mysql_fetch_array($result)){ 
                        echo '<select name="Cate" id="Cate" style="WIDTH: 220px; HEIGHT: 22px" ><option value=0>Seleccione la Categor&iacute;a</option>';
                      do {
                       echo '<option value='.$row["codcate"].'>'.$row["descrip"].'</option>';
                      } while ($row = mysql_fetch_array($result)); 
                       echo '</select>';
					}
			
			 
			 $resulcontrato= $con->ejecutar("SELECT * FROM contrato where numero like '%E07%'",$idcon);
			 $canti = mysql_num_rows($resulcontrato);
			
    		if  ($canti==0){
			     $numEnte='E07'.'0001';
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
				$numEnte='E07'.$nuevonumero;
			
			}
			echo "<INPUT TYPE=hidden NAME=Num id=Num value='$numEnte'>"; 
			?>
			 <tr>
			  <td>Usuario&nbsp;</td>
			  <td>
			      <input type="text" name="Usu" id="Usu" style="width:220px; height:22px">
				</td>
		    </tr>
			<tr>
			  <td height="28" colspan="2" valign="top" align="center">
                <input name="button" type="submit" value="Registrar">
				</td>
		    </tr>	
			
			<tr>
			  <td height="28" colspan="2" valign="top" align="center">
              <div id = "DivDestino"></div>
				</td>
		    </tr>		
			
	</table>
		 
</form>
</div></div>
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