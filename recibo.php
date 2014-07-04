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
	$this->Cell(30,10, htmlentities('República Bolivariana de Venezuela'),0,0,'C');
	//Salto de l�nea
	$this->Ln(5);
	$this->Cell(190,10,'Gobernación del Estado Lara',0,0,'C');
	$this->Ln(5);
	$this->Cell(190,10,'Cabudare - Estado Lara',0,0,'C');
	$this->Ln(5);
	$this->Cell(190,10,'Corporación de Turismo del Estado Lara',0,0,'C');
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
    include("ControlaBD.php");
    $nume=$_GET["No"];
	$con   = new ControlaBD();
	$idcon = $con->conectarSBD();
	$sel_bd= $con->select_BD("tf_comercializacion");
	
	$this->SetFont('Arial','IB',15);
	$this->Cell(190,10,'ANEXO A',0,0,'C');
	$this->Ln(10);
	$this->SetFont('Arial','IB',10);
	$this->Cell(190,10,'CONTRATO No. '.$nume,0,0,'C');
	$this->Ln(5);
	$this->Cell(190,10,date("d / m / Y"),0,0,'C');
	$this->Ln(20);

	//Colores, ancho de l�nea y fuente en negrita
	$this->SetFillColor(255,255,255);
	$this->SetTextColor(0,0,0);
	$this->SetDrawColor(128,0,0);
	$this->SetLineWidth(.2);
	$this->SetFont('Arial','B',8);
	
	
	//Cabecera
	$w=array(20,40,40,30,30);
	$nomrespo=$_GET["Nom"];
    $cedrespo=$_GET["Rif"];
	
	//$letra = substr($cedrespo, 1);
    $letra=$cedrespo[0];   // 456789
	
	$direc=$_GET["Dir"];
	$prod=$_GET["Pro"];
	$ramo=$_GET["Ram"];
	
	$this->Cell($w[0],6,'Arrendatario ',0,'L');
	$this->Cell($w[1],6,'',0,'L');
	$this->Cell($w[2],6,':   '.$nomrespo,0,'L');		
	$this->Ln();		
	$this->Cell($w[0],6,'Rif/Cédula     ',0,'L');
	$this->Cell($w[1],6,'',0,'L');
	$this->Cell($w[2],6,':   '.$cedrespo,0,'L');
	$this->Ln();		
	$this->Cell($w[0],6,'Dirección     ',0,'L');
	$this->Cell($w[1],6,'',0,'L');
	$this->Cell($w[2],6,':   '.$direc,0,'L');
		

	if ($letra=='G' or $letra=='J'){
	    $empre= $con->ejecutar("SELECT telf,replegal,cedrepre,cargo FROM empresa WHERE rif='$cedrespo'",$idcon);
		$row2=mysql_fetch_array($empre);
		$this->Ln();	
		$this->Cell($w[0],6,'Telefono     ',0,'L');
	    $this->Cell($w[1],6,'',0,'L');
	    $this->Cell($w[2],6,':   '.$row2[telf],0,'L');
	    $this->Ln();	
		$this->Cell($w[0],6,'Representante Legal     ',0,'L');
	    $this->Cell($w[1],6,'',0,'L');
	    $this->Cell($w[2],6,':   '.$row2[replegal],0,'L');
	    $this->Ln();		
		$this->Cell($w[0],6,'Cédula del Representante     ',0,'L');
	    $this->Cell($w[1],6,'',0,'L');
	    $this->Cell($w[2],6,':   '.$row2[cedrepre],0,'L');
	    $this->Ln();	
		$this->Cell($w[0],6,'Cargo     ',0,'L');
	    $this->Cell($w[1],6,'',0,'L');
	    $this->Cell($w[2],6,':   '.$row2[cargo],0,'L');
	 //   $this->Ln();	
	}
	
	$this->Ln();	
	$this->Cell($w[0],6,'Ramo     ',0,'L');
	$this->Cell($w[1],6,'',0,'L');
	$this->Cell($w[2],6,':   '.$ramo,0,'L');
	$this->Ln();		
	$this->Cell($w[0],6,'Productos a Comercializar     ',0,'L');
	$this->Cell($w[1],6,'',0,'L');
	$this->Cell($w[2],6,':   '.$prod,0,'L');
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
	//$ubic=$_GET["Ubi"];
	$total=$_GET["Tot"];
		
	$separar_cadena = explode(',',$stand);
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
	$nrodepos=$_GET["NroB"];
    $banco=$_GET["Ba"];
	$mondepo=$_GET["MoB"];
	$resta=$total-$mondepo;
	$this->Ln(5);
	$tota = number_format($total,2,',','.'); 
	$this->Cell($w[2],6,'Total Comercializado ',0,'L');		
	$this->Cell($w[3],6,':   '.$tota,0,'L');
	$this->Ln();		
	$this->Cell($w[2],6,'Total Metros Cuadrados',0,'L');		
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
/*	$this->Cell($w[0],6,'',0,'L');
	$this->Cell($w[1],6,$nrodepos,1,'L');
	$this->Cell($w[2],6,$banco,1,'L');
	$totamonto = number_format($mondepo,2,',','.'); 
	$this->Cell($w[3],6,$totamonto,1,'L');
	$totaresta = number_format($resta,2,',','.'); 
	$this->Cell($w[4],6,$totaresta,1,'L');*/
	$nume=$_GET["No"];
	$tran= $con->ejecutar("SELECT nrocheque,banco,monto FROM transacciones WHERE nrocontrato='$nume'",$idcon);
 while ($fila2 = mysql_fetch_array($tran)) {
    $this->Cell($w[0],6,' ',0,'L');
	$this->Cell($w[1],6,$fila2[nrocheque],1,'L');
	//echo cambiaf_a_normal($fila->fecha);
	//$this->Cell($w[2],6,cambiaf_a_normal($fila2[fecha]),1,'L');
	$this->Cell($w[2],6,$fila2[banco],1,'L');
	$to = number_format($fila2[monto],2,',','.');
	$total=$total-$fila2[monto];
	$this->Cell($w[3],6,$to,1,'L');
	$totaresta = number_format($total,2,',','.'); 
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
	$this->Cell(90,10,$nomrespo,0,0,'C');
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
	$this->Cell(20,10,'Login',0,0,'C');
	$this->Cell(30,10,':'.'   '.$_GET["Usu"],0,0,'C');
	$this->Ln(5);
	$this->Cell(20,10,'Password',0,0,'C');
	$this->Cell(30,10,':   '.$_GET["Cla"],0,0,'C');
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
    $this->Cell(50,10,'Comisión de Acreditación',0,0,'C');
	
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


$pdf->Output('reporte_empresa.pdf','I'); //para que muestre la opcion de descargar el reporte

?>
<?php
 }else
{
    Header ("location: index.php"); 
}
?>