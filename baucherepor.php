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
	$this->Image('cortulara.jpg',10,10,30);
	$this->Image('gobernacion.jpg',180,8,15);
	//Arial bold 15
	$this->SetFont('Arial','B',8);
	//Movernos a la derecha
	$this->Cell(80);
	//T�tulo
	$this->Cell(30,10,'REPORTE DE VOUCHER RECIBIDOS',0,0,'C');
	$this->Ln();
	$fecha1=$_POST["dia"].'-'.$_POST["mes"].'-'.$_POST["a"];
	$fecha2=$_POST["idia"].'-'.$_POST["imes"].'-'.$_POST["ia"];
	if ($fecha2=='-----'){
		$fecha2=$fecha1;
		$this->Cell(190,10,'DEL'.' '. $fecha1,0,0,'C');
	}else{
	$this->Cell(190,10,'DEL'.' '. $fecha1.' '.'AL'.' '.$fecha2,0,0,'C');
	}
	//Salto de l�nea
	$this->Ln(30);
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
	$w=array(40,20,40,45,20,20);
	//Cabeceras
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C');
	$this->Ln();
	//Datos

}

//Tabla coloreada
function FancyTable($header)
{
	//Colores, ancho de l�nea y fuente en negrita
	$this->SetFillColor(255,0,0);
	$this->SetTextColor(255);
	$this->SetDrawColor(128,0,0);
	$this->SetLineWidth(.3);
	$this->SetFont('','B');
	//Cabecera
	$w=array(30,30,30,40,30);
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C',1);
	$this->Ln();
	//Restauraci�n de colores y fuentes
	$this->SetFillColor(224,235,255);
	$this->SetTextColor(0);
	$this->SetFont('');
	//Datos
	$fill=0;
	$fecha1=$_POST["a"].'-'.$_POST["mes"].'-'.$_POST["dia"];
	$fecha2=$_POST["ia"].'-'.$_POST["imes"].'-'.$_POST["idia"];
	if ($fecha2=='-----'){
		$fecha2=$fecha1;
	}
	
	include("ControlaBD.php");

	$con   = new ControlaBD();
	$idcon = $con->conectarSBD();
	$sel_bd= $con->select_BD("tf_comercializacion");
	$result= $con->ejecutar("SELECT nrocontrato,nrocheque,banco,fecha,monto FROM transacciones WHERE fecha>='$fecha1' and fecha<='$fecha2' ",$idcon);
	$acuntotal=0;
    while ($fila = mysql_fetch_array($result)) {
	 $this->Cell($w[0],6,$fila[nrocontrato],1,'L');
     $this->Cell($w[1],6,$fila[nrocheque],1,'L');
	 $this->Cell($w[2],6,$fila[banco],1,'L');
	 $fechare= explode('-',$fila[fecha]);
	$fecha=$fechare[2]."-".$fechare[1]."-".$fechare[0];
	 $this->Cell($w[3],6,$fecha,1,'L');
	 	$monto = number_format($fila[monto],2,',','.'); 
	 $this->Cell($w[4],6,$monto,1,'L');
	 $this->Ln();
	  $acuntotal=$acuntotal+$fila[monto];
    }
	 $this->Cell($w[0],6,' ',1,'L');
     $this->Cell($w[1],6,' ',1,'L');
	 $this->Cell($w[2],6,' ',1,'L');
	 $this->Cell($w[3],6,'Total Cobrado',1,'L');
 	$totalco = number_format($acuntotal,2,',','.'); 
	 $this->Cell($w[4],6,$totalco,1,'L');
	 $result= $con->ejecutar("SELECT numero,rif,stand,total,resta FROM contrato WHERE fecha>='$fecha1' and fecha<='$fecha2' and numero like '%LTF09%'",$idcon);
    while ($fila = mysql_fetch_array($result)) {
	 $acunresta=$acunresta+$fila[resta];
	}
	 $this->Ln();
	 $this->Cell($w[0],6,' ',1,'L');
	 $this->Cell($w[1],6,' ',1,'L');
     $this->Cell($w[2],6,' ',1,'L');
	 $this->Cell($w[3],6,'Total por Cobrar',1,'L');
	 $totalres = number_format($acunresta,2,',','.'); 
	 $this->Cell($w[4],6,$totalres,1,'L');
}
}


$pdf=new PDF();
$header=array('N. Contrato','N. Deposito','Banco','Fecha','Monto');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',8);
$pdf->FancyTable($header);
$pdf->Output('reporte_empresa.pdf','I'); //para que muestre la opcion de descargar el reporte

?>
<?php
 }else
{
    Header ("location: index.php"); 
}
?>
