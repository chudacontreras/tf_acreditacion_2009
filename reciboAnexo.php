<?php
session_start();
if (array_key_exists('login',$_SESSION)){
?>
<?
require('fpdf.php');

class PDF extends FPDF
{
//Cabecera de p�gina
function Header()
{
	//Logo
	$nume=$_GET["No"];
	$this->Image('cortulara.jpg',10,10,30);
	$this->Image('gobernacion.jpg',180,8,15);
	//Arial bold 15
	$this->SetFont('Arial','IB',10);
	//Movernos a la derecha
	$this->Cell(80);
	//T�tulo
	$this->Cell(30,10,'Rep&uacute;blica Bolivariana de Venezuela',0,0,'C');
	//Salto de l�nea
	$this->Ln(5);
	$this->Cell(190,10,'Gobernaci&oacute;n del Estado Lara',0,0,'C');
	$this->Ln(5);
	$this->Cell(190,10,'Cabudare - Estado Lara',0,0,'C');
	$this->Ln(5);
	$this->Cell(190,10,'Corporaci&oacute;n de Turismo del Estado Lara',0,0,'C');
	$this->Ln(5);
	$this->Cell(190,10,'CORTULARA.',0,0,'C');
	$this->Ln(10);
}

//Pie de p�gina
function Footer()
{
	//Posici�n: a 1,5 cm del final
	$this->SetY(-15);
	//Arial italic 8
	$this->SetFont('Arial','I',6);
	//N�mero de p�gina
	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}

//Cargar los datos
function LoadData($file)
{
	//Leer las l�neas del fichero
	$lines=file($file);
	$data=array();
	foreach($lines as $line)
		$data[]=explode(';',chop($line));
	return $data;
}

//Tabla simple
function BasicTable($header)
{
	//Cabecera
	foreach($header as $col)
		$this->Cell(40,7,$col,1);
	$this->Ln();
}

//Una tabla m�s completa
function ImprovedTable($header)
{
	//Anchuras de las columnas
	$w=array(10,40,20,40,25,20,20);
	//Cabeceras
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C');
	$this->Ln();
	//Datos

}
function PrintChapter($num,$title,$file)
{
	//A�adir cap�tulo
	$this->AddPage();
	$this->ChapterTitle(2,$title);
	$this->ChapterBody($file);
}



//Tabla coloreada
function FancyTable($header)
{
	//Colores, ancho de l�nea y fuente en negrita
	$this->SetFillColor(255,255,255);
	$this->SetTextColor(0,0,0);
	$this->SetDrawColor(128,0,0);
	$this->SetLineWidth(.2);
	$this->SetFont('','B');
	
	
	//Cabecera
	$w=array(20,40,40,30,30);
/*	$nomrespo=$_GET["Nom"];
    $cedrespo=$_GET["Rif"];
	$direc=$_GET["Dir"];
	$prod=$_GET["Pro"];*/
	
	include("ControlaBD.php");

	$con   = new ControlaBD();
	$idcon = $con->conectarSBD();
	$sel_bd= $con->select_BD("tf_comercializacion");
	
	$nume=$_GET["Cont"];
	
	$this->SetFont('Arial','IB',15);
	$this->Cell(190,10,'ANEXO A',0,0,'C');
	$this->Ln(10);
	$this->SetFont('Arial','IB',10);
	$this->Cell(190,10,'CONTRATO No. '.$nume,0,0,'C');
	$this->Ln(5);
	$this->Cell(190,10,date("d / m / Y"),0,0,'C');
	$this->Ln(20);
	
	$this->SetFillColor(255,255,255);
	$this->SetTextColor(0,0,0);
	$this->SetDrawColor(128,0,0);
	$this->SetLineWidth(.2);
	$this->SetFont('Arial','B',8);
	
	$result= $con->ejecutar("SELECT rif,stand,total,productos,ramo,fecha,resta FROM contrato WHERE numero='$nume'",$idcon);
	$contra = mysql_fetch_array($result);
	
	$result2= $con->ejecutar("SELECT rif,nombre,direccion,telf,replegal,cedrepre,cargo FROM empresa WHERE rif='$contra[rif]'",$idcon);
	$empre = mysql_fetch_array($result2);
	$letra2=$contra[rif];
	$letra=$letra2[0];  
	
	$this->Cell($w[0],6,'Arrendatario ',0,'L');
	$this->Cell($w[1],6,'',0,'L');
	$this->Cell($w[1],6,':   '.$empre[nombre],0,'L');		
	$this->Ln();		
	$this->Cell($w[0],6,'Rif/C&eacute;dula     ',0,'L');
	$this->Cell($w[1],6,'',0,'L');
	$this->Cell($w[1],6,':   '.$contra[rif],0,'L');
	$this->Ln();		
	$this->Cell($w[0],6,'Direcci&oacute;n     ',0,'L');
	$this->Cell($w[1],6,'',0,'L');
	$this->Cell($w[1],6,':   '.$empre[direccion],0,'L');
	if ($letra=='G' or $letra=='J'){
	   	$this->Ln();	
		$this->Cell($w[0],6,'Telefono     ',0,'L');
	    $this->Cell($w[1],6,'',0,'L');
	    $this->Cell($w[2],6,':   '.$empre[telf],0,'L');
	    $this->Ln();	
		$this->Cell($w[0],6,'Representante Legal     ',0,'L');
	    $this->Cell($w[1],6,'',0,'L');
	    $this->Cell($w[2],6,':   '.$empre[replegal],0,'L');
	    $this->Ln();		
		$this->Cell($w[0],6,'C&eacute;dula del Representante     ',0,'L');
	    $this->Cell($w[1],6,'',0,'L');
	    $this->Cell($w[2],6,':   '.$empre[cedrepre],0,'L');
	    $this->Ln();	
		$this->Cell($w[0],6,'Cargo     ',0,'L');
	    $this->Cell($w[1],6,'',0,'L');
	    $this->Cell($w[2],6,':   '.$empre[cargo],0,'L');
	 //   $this->Ln();	
	}
	$this->Ln();	
	$this->Cell($w[0],6,'Ramo     ',0,'L');
	$this->Cell($w[1],6,'',0,'L');
	$this->Cell($w[2],6,':   '.$contra[ramo],0,'L');
	$this->Ln();				
	$this->Cell($w[0],6,'Productos a Comercializar',0,'L');
	$this->Cell($w[1],6,'',0,'L');
	$this->Cell($w[1],6,':   '.$contra[productos],0,'L');
	$this->Ln(10);
	$this->Cell(190,10,'STAND CONTRATADOS',0,0,'C');
	$this->Ln(10);
	
  	$this->Cell($w[0],7,$header[0],0,0,'C',1);
	for($i=1;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C',1);
	$this->Ln();
	//Restauraci�n de colores y fuentes
	//$this->SetFillColor(224,235,255);
	$this->SetTextColor(0);
	$this->SetFont('');
	//Datos
	$fill=0;

	
	
	$stand=$_GET["Sta"];
	$ubic=$_GET["Ubi"];
	$total=$_GET["Tot"];
	$area=$_GET["Are"];
	
	$resubi= $con->ejecutar("SELECT costo,preventa,fechainicio,fechafin,metros FROM ubicacion WHERE codubi='$contra[ubica]'",$idcon);
	$ubi = mysql_fetch_array($resubi);
	
	if (($contra[fecha]>=$ubi[2]) and ($contra[fecha]<=$ubi[3])){
	    $valor=$ubi[1];
	}else{
		$valor=$ubi[0];
	}

	
	$separar_cadena = explode(',',$contra[stand]);
	$cantidadventa=count($separar_cadena);
	
	       		
   $area=0;   		
	 for($i=0;$i<count($separar_cadena); $i++){
		
		   $resu= $con->ejecutar("SELECT costo,codubi FROM stand WHERE codstand='$separar_cadena[$i]'",$idcon);
			$num_rows=mysql_num_rows($resu);
			$row=mysql_fetch_array($resu);
			$resubi= $con->ejecutar("SELECT costo,preventa,fechainicio,fechafin,metros,descrip FROM ubicacion WHERE codubi='$row[codubi]'",$idcon);
	       $ubi = mysql_fetch_array($resubi);
	       $area=$area+$ubi[metros];
			$fecha=date("Y-m-d", mktime(0, 0, 0, date("m") , date("d"), date("Y")));
			if (($fecha>=$ubi[2]) and ($fecha<=$ubi[3])){
				$valor=$ubi[1];
			}else{
				$valor=$ubi[0];
			}
			$this->Cell($w[0],6,'',0,'L');
			$this->Cell($w[1],6,$ubi[descrip],1,'L');
			$this->Cell($w[2],6,$separar_cadena[$i],1,'L');		
			if ($row[costo]!=0){
		 	$tot = number_format($row[costo],2,',','.'); 
       	     $this->Cell($w[3],6,$tot,1,'L');		
			}else{
		 	$tot = number_format($valor,2,',','.'); 
			 $this->Cell($w[3],6,$tot,1,'L');		
			}
			 $this->Cell($w[4],6,$ubi[4],1,'L');		
			$this->Ln();

	}
	/*$nrodepos=$_GET["NroB"];
    $banco=$_GET["Ba"];
	$mondepo=$_GET["MoB"];*/
	$this->Ln(20);
	$tota = number_format($total,2,',','.'); 
	$this->Cell($w[2],6,'Total Comercializado',0,'L');	
	$to1 = number_format($contra[total],2,',','.');	
	$this->Cell($w[3],6,':   '.$to1,0,'L');
	$this->Ln();		
	$this->Cell($w[2],6,'Total Metros Cuadrados ',0,'L');		
	$this->Cell($w[3],6,':   '.$area.' '.'Mts.',0,'L');
	$this->Ln(10);
	$this->Cell(190,10,'FORMA DE PAGO',0,0,'C');
	$this->Ln(10);
	$this->Cell($w[0],6,'',0,'L');
	$this->Cell($w[1],6,'Nro. Deposito',1,'L');
	$this->Cell($w[2],6,'Banco',1,'L');
	$this->Cell($w[3],6,'Monto',1,'L');
	$this->Cell($w[4],6,'Resta',1,'L');
	$this->Ln();
	$nume=$_GET["Cont"];
    $tran= $con->ejecutar("SELECT nrocheque,banco,monto,fecha FROM transacciones WHERE nrocontrato='$nume'",$idcon);
    while ($fila2 = mysql_fetch_array($tran)) {
    $this->Cell($w[0],6,' ',0,'L');
	$this->Cell($w[1],6,$fila2[nrocheque],1,'L');
	//echo cambiaf_a_normal($fila->fecha);
	//$this->Cell($w[2],6,cambiaf_a_normal($fila2[fecha]),1,'L');
	$this->Cell($w[2],6,$fila2[banco],1,'L');
	  
	$to = number_format($fila2[monto],2,',','.');
	$contra[total]=$contra[total]-$fila2[monto];
	$this->Cell($w[3],6,$to,1,'L');
	$totaresta = number_format($contra[total],2,',','.'); 
	$this->Cell($w[4],6,$totaresta,1,'L');
	$this->Ln();

    }

	$this->Ln(20);
	$this->SetFont('Arial','',6);
	$file = fopen('clausula.txt',"r");
    $buffer = fread($file,filesize('clausula.txt'));
	$txt=$buffer;
	$this->MultiCell(0,3,$txt);
    fclose($file);
	$this->AddPage();
    $this->Ln(10);
	$this->SetFont('Arial','',9);
	$this->Cell(30,10,'Sres.',0,0,'C');
	$this->Ln(5);
//	if ($letra=='G' or $letra=='J'){
	//  $this->Cell(50,10,$row2[replegal],0,0,'C');
	//}else{
	$this->Cell(80,10,$empre[nombre],0,0,'C');
//	}
	$this->Ln(5);
	$this->Cell(40,10,'Presente.-',0,0,'C');
	$this->Ln(5);
	$this->Ln(20);
	
	$this->SetFont('Arial','',8);
	
	$file = fopen('clave1.txt',"r");
	$buffer = fread($file,filesize('clave1.txt'));
	$txt=$buffer;
	$this->MultiCell(0,5,$txt);
	$this->Ln(5);
	
	$tranlogin= $con->ejecutar("SELECT usuario,clave FROM login WHERE usuario='$empre[rif]'",$idcon);
    $login = mysql_fetch_array($tranlogin);
	$this->Cell(20,10,'Login',0,0,'C');
	$this->Cell(30,10,':'.'   '.$login[usuario],0,0,'C');
	$this->Ln(5);
	$this->Cell(20,10,'Password',0,0,'C');
	$this->Cell(30,10,':   '.$login[clave],0,0,'C');
	$this->Ln(20);
	$file2 = fopen('clave2.txt',"r");
	$buffer2 = fread($file2,filesize('clave2.txt'));
	$txt2=$buffer2;
	$this->MultiCell(0,5,$txt2);
	fclose($file);
	fclose($file2);
	$this->Ln(20);
	$this->Cell(50,10,'Se despide Cordialmente,',0,0,'C');
	$this->Ln(10);
	$this->SetFont('Arial','B',8);
    $this->Cell(50,10,'Comisi&oacute;n de Acreditaci&oacute;n',0,0,'C');
	
		}
	}

$pdf=new PDF();
$header=array('','Pabellon','Stand','Costo','Mts.');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',8);
$pdf->FancyTable($header);

/*$cedrespo=$_GET["Rif"];
$letra=$cedrespo[0];  
$nomrespo=$_GET["Nom"];
$empre= $con->ejecutar("SELECT telf,replegal,cedrepre,cargo FROM empresa WHERE rif='$cedrespo'",$idcon);
$row=mysql_fetch_array($empre);*/


$pdf->Output('reporte_anexoa.pdf','I'); //para que muestre la opcion de descargar el reporte

?>
<?php
 }else
{
    Header ("location: index.php"); 
}
?>