<?php
session_start();
if (array_key_exists('login',$_SESSION)){
  include("util.php");
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="text.css" type="text/css">
<script language="javascript">
   function comprobar()
   {
           var rif = document.formu.Rif.value; 
           var nombre = document.formu.Nom.value;
		   var direc = document.formu.Dir.value;
		   var telef = document.formu.Tel.value;
		   var repre = document.formu.NomRep.value;
		   var cedrepre = document.formu.CedRep.value;
		   var cate = document.formu.Cate.value;
             
           if (rif == '')
           {
                   alert("Rif o C&eacute;dula no debe estar en Blanco");
                   return false;
           }
		   
		   if (nombre == '')
           {
                   alert("Nombre no debe estar en Blanco");
                   return false;
           }
		   if (direc == '')
           {
                   alert("Direcci&oacute;n no debe estar en Blanco");
                   return false;
           }
		   if (repre == '')
           {
                   alert("Representante legal no debe estar en Blanco");
                   return false;
           }
		    if (cedrepre == '')
           {
                   alert("C&eacute;dula del Representante no debe estar en Blanco");
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
  
					
  <td height="600px" bgcolor="#DADADA" width="100">
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
	<div class="tabConte" id="tabConte">
	
  <?php

	include("ControlaBD.php");

	$con   = new ControlaBD();
	$idcon = $con->conectarSBD();
	$sel_bd= $con->select_BD("tf_comercializacion");

	    $nacionalidad = $_GET["Nac"];
	    $cedula = $_GET["Rif"];
		$dato=$nacionalidad.$cedula; 
	if ($cedula == ""){
   echo 'Cedula o Rif no debe estar en blanco';

   }
 	else{
	
	  if ($nacionalidad=="J" or $nacionalidad=="G" ){
	
		$dato=$nacionalidad.$cedula; //Concatenar tipo con numero  	
		$result= $con->ejecutar("SELECT rif,nombre,direccion,telf,replegal,cedrepre,regismercan,fecharegis,nrotomo,cargo,categoria,retensoriva FROM empresa WHERE rif='$dato'",$idcon);
		$num_rows=mysql_num_rows($result);
		$row=mysql_fetch_array($result);
		
		$fecharegistro= explode('-',$row['fecharegis']);

	  if ($num_rows==1){
		
				echo ' <FORM METHOD="GET" action="contrato.php">
				<table align="center" cellspacing="2" cellpadding="2" border="0" class="texto">
				 <tr>
				<td>
				<input name="Nac" type="hidden" id="Nac"  style="WIDTH: 220px; HEIGHT: 22px" value="';echo $nacionalidad.'"/>
				</td>
				</tr>
				 <tr>
				<td>Cedula/Rif:&nbsp;</td>
				<td>
				<input name="Rif" type="text" id="Rif"  style="WIDTH: 220px; HEIGHT: 22px" value="'.$row['rif'].'" readonly="yes" />
				</td>
				</tr>
				<tr>
				<td>Nombre:&nbsp;</td>
				<td>
				<input name="Nom" type="text" id="Nom"  style="WIDTH: 220px; HEIGHT: 22px" value="'.$row['nombre'].'" readonly="yes"/>
				</td>
				</tr>
					<tr>
						<td>Domicilio:&nbsp;</td>
						<td><INPUT type="Text" name=Dir id="Dir" style="WIDTH: 220px; HEIGHT: 22px" value="'.$row['direccion'].'" readonly="yes" /></td>
					</tr>
					<tr>
						<td>Tel&eacute;fono:&nbsp;</td>
						<td><INPUT type="Text" name=Tel id="Tel" style="WIDTH: 220px; HEIGHT: 22px" value="'.$row['telf'].'" readonly="yes"/></td>
					</tr>
					
					<tr>
						<td>Registro Mercantil:&nbsp;</td>
						<td><INPUT type="Text" name=Regis id="Regis" style="WIDTH: 220px; HEIGHT: 22px" value="'.$row['regismercan'].'" readonly="yes" /></td>
					</tr>
					<tr>
						<td>Fecha Registro:&nbsp;</td>
						<td>
						<select name="dia" class="texto1" id="dia">
                           <option>'.$fecharegistro[2].'</option>
						</select>';
		               $result= $con->ejecutar("SELECT nro,descrip FROM mes Where nro=$fecharegistro[1] ",$idcon);
   		               $fila = mysql_fetch_array($result);
                       echo' 
						  <select name= "mes" id="mes" class="texto1"><option value='.$fila["nro"].'>'.$fila["descrip"].'</option>
</select>';

		  
							echo' <select name="a" class="texto1" id="a">
						   <option>'.$fecharegistro[0].'</option>
							 </select>
						
						
						</td>
					</tr>
					
					<tr>
						<td>Nro. Tomo:&nbsp;</td>
						<td><INPUT type="Text" name=Tom id="Tom" style="WIDTH: 220px; HEIGHT: 22px" value="'.$row['nrotomo'].'" readonly="yes" /></td>
					</tr>
					
					<tr>
						<td>Representante Legal:&nbsp;</td>
						<td><INPUT type="Text" name=NomRep id="NomRep" style="WIDTH: 220px; HEIGHT: 22px" value="'.$row['replegal'].'" readonly="yes" /></td>
					</tr>
					<tr>
						<td>C&eacute;dula del Representante:&nbsp;</td>
						<td><INPUT type="Text" name=CedRep id="CedRep" style="WIDTH: 220px; HEIGHT: 22px" value="'.$row['cedrepre'].'" readonly="yes" /></td>
					</tr>
					<tr>
						<td>Cargo:&nbsp;</td>
						<td><INPUT type="Text" name=Car id="Car" style="WIDTH: 220px; HEIGHT: 22px" value="'.$row['cargo'].'" readonly="yes" /></td>
					</tr>';
					
		/*		echo'	<tr>
					<td>Agente Retensor IVA</td>';
					if ($row['retensoriva']==1){
					   echo '<td><input type=checkbox name=IVA id=IVA checked="checked" disabled="disabled">';
					   } else{
					   echo '<td><input type=checkbox name=IVA id=IVA disabled="disabled">';
					  }*/
					echo '</td>
					</tr>
					<tr>
					<td>
					</td>
					<td>
					<input name="Cate" type="hidden" id="Cate" value="'.$row['categoria'].'"/>
					<input name="button" type="submit" value="Generar Contrato"></td>
					</tr>
					</table>
					</form>';				
			}
		else{
		$dato=$nacionalidad.$cedula; //Concatenar tipo con numero  	
		$result= $con->ejecutar("SELECT rif FROM empresa WHERE rif='$dato'",$idcon);
		$num_rows=mysql_num_rows($result);
		$rowva=mysql_fetch_array($result);
			echo ' <FORM METHOD="GET" name="formu" action="regempre.php" onsubmit="return comprobar()">
			<table align="center" cellspacing="2" cellpadding="2" border="0" class="texto">
			 <tr>
				<td>
				<input name="Nac" type="hidden" id="Nac"  style="WIDTH: 220px; HEIGHT: 22px" value="';
		echo $nacionalidad.'"/>
				</td>
				</tr>
				 <tr>
				<td>Cedula/Rif:&nbsp;</td>
				<td>
				<input name="Rif" type="text" id="Rif"  style="WIDTH: 220px; HEIGHT: 22px" value="';
		echo $dato.'" readonly="yes"/>
				</td>
				</tr>
				<tr>
				<td>Nombre:&nbsp;</td>
				<td>
				<input name="Nom" type="text" id="Nom"  style="WIDTH: 220px; HEIGHT: 22px"/>
				</td>
				</tr>
					<tr>
						<td>Direcci&oacute;n:&nbsp;</td>
						<td><INPUT type="Text" name=Dir id="Dir" style="WIDTH: 220px; HEIGHT: 22px"/></td>
					</tr>
					<tr>
						<td>Tel&eacute;fono:&nbsp;</td>
						<td><INPUT type="Text" name=Tel id="Tel" style="WIDTH: 220px; HEIGHT: 22px"/></td>
					</tr>
					<tr>
						<td>Registro Mercantil:&nbsp;</td>
						<td><INPUT type="Text" name=Regis id="Regis" style="WIDTH: 220px; HEIGHT: 22px"/></td>
					</tr>
					<tr>
						<td>Fecha Registro:&nbsp;</td>
						<td> <select name="dia" class="texto1" id="dia">
								<option value="-">D&iacute;a</option>
								<option value="01">01</option>
								<option value="02">02</option>
								<option value="03">03</option>
								<option value="04">04</option>
								<option value="05">05</option>
								<option value="06">06</option>
								<option value="07">07</option>
								<option value="08">08</option>
								<option value="09">09</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
								<option value="13">13</option>
								<option value="14">14</option>
								<option value="15">15</option>
								<option value="16">16</option>
								<option value="17">17</option>
								<option value="18">18</option>
								<option value="19">19</option>
								<option value="20">20</option>
								<option value="21">21</option>
								<option value="22">22</option>
								<option value="23">23</option>
								<option value="24">24</option>
								<option value="25">25</option>
								<option value="26">26</option>
								<option value="27">27</option>
								<option value="28">28</option>
								<option value="29">29</option>
								<option value="30">30</option>
								<option value="31">31</option>
							  </select>
							   <select name="mes" class="texto1" id="mes">
								<option value="-" selected="selected">Mes</option>
								<option value="1">Enero</option>
								<option value="2">Febrero</option>
								<option value="3">Marzo</option>
								<option value="4">Abril</option>
								<option value="5">Mayo</option>
								<option value="6">Junio</option>
								<option value="7">Julio</option>
								<option value="8">Agosto</option>
								<option value="9">Septiembre</option>
								<option value="10">Octubre</option>
								<option value="11">Noviembre</option>
								<option value="12">Diciembre</option>
							  </select>';
		 
		 $result= $con->ejecutar("SELECT an FROM anno",$idcon);
					if ($row = mysql_fetch_array($result)){ 
                        echo '<select name= "a" id="a" class="texto1"><option>A&ntilde;o</option>';
                      do {
                       echo '<option>'.$row["an"].'</option>';
                      } while ($row = mysql_fetch_array($result)); 
                       echo '</select>';
					}
		 
		 	echo '</td>
					</tr>
					
					<tr>
						<td>Nro. Tomo:&nbsp;</td>
						<td><INPUT type="Text" name=Tom id="Tom" style="WIDTH: 220px; HEIGHT: 22px" /></td>
					</tr>
					<tr>
						<td>Representante Legal:&nbsp;</td>
						<td><INPUT type="Text" name=NomRep id="NomRep" style="WIDTH: 220px; HEIGHT: 22px" /></td>
					</tr>
					<tr>
						<td>C&eacute;dula del Representante:&nbsp;</td>
						<td><INPUT type="Text" name=CedRep id="CedRep" style="WIDTH: 220px; HEIGHT: 22px"/></td>
					</tr>
					<tr>
						<td>Cargo:&nbsp;</td>
						<td><INPUT type="Text" name=Car id="Car" style="WIDTH: 220px; HEIGHT: 22px" /></td>
					</tr>';
					
			echo '<tr>
				<td>Categoria</td>
			    <td valign="top">';
				    $result= $con->ejecutar("SELECT codcate,descrip FROM categoria",$idcon);
					if ($row = mysql_fetch_array($result)){ 
                        echo '<select name= "Cate" id="Cate" style="WIDTH: 220px; HEIGHT: 22px" ><option value=0>Seleccione la Categoria</option>';
                      do {
                       echo '<option value='.$row["codcate"].'>'.$row["descrip"].'</option>';
                      } while ($row = mysql_fetch_array($result)); 
                       echo '</select>';
					}
		   
		   
		/*	echo '</td>
			</tr>				
					
					<tr>
					<td>Agente Retensor IVA</td>
					<td><input type=checkbox name=IVA id=IVA>
					</td>
					</tr>*/
				echo '	<tr>
					<td>
					</td>
					<td><input name="button" type="submit" value="Registrar"></td>
					</tr>
					</table>
					</form>';
					
					
			}
	}else{
	//*******************PARA PERSONA NATURAL*********************************************
	  js_redireccion("consulnatu.php?Nac=$nacionalidad&Ced=$cedula");
			}
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