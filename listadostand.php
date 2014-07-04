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
	$this->Cell(30,10,'LISTADO DE STAND',0,0,'C');
	$this->Ln(5);
	$this->Cell(190,10,date("d / m / Y"),0,0,'C');
	//Salto de l�nea
	$this->Ln(15);
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
//	$this->SetFillColor(1,1,1);
	$this->SetTextColor(255);
	//$this->SetDrawColor(128,0,0);
	$this->SetLineWidth(.3);
	$this->SetFont('','B');
	//Cabecera
	$w=array(50,50,50);
	//for($i=0;$i<count($header);$i++)
	//	$this->Cell($w[$i],7,$header[$i],1,0,'C',1);
	$this->Ln();
	//Restauraci�n de colores y fuentes
	$this->SetFillColor(255,255,255);
	$this->SetTextColor(0);
	$this->SetFont('');
	//Datos
	$fill=0;
	
	include("ControlaBD.php");

	$con   = new ControlaBD();
	$idcon = $con->conectarSBD();
	$sel_bd= $con->select_BD("tf_comercializacion");
	$result= $con->ejecutar("SELECT descrip,codubi FROM ubicacion",$idcon);


    while ($fila = mysql_fetch_array($result)) {
	  $this->SetFont('Arial','B',13);
	  $this->Cell(190,10,$fila[descrip],0,0,'C');
	  $this->Ln();  	 	
	  $this->SetFont('Arial','B',8);
	$resempre= $con->ejecutar("SELECT codstand,status FROM stand WHERE codubi='$fila[codubi]'",$idcon);
		$this->Cell($w[0],7,'',0,0,'C',1);	
	 for($i=1;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C',1);

		
		
	  $this->Ln();
	  while ($empr = mysql_fetch_array($resempre)) {
	  $this->Cell($w[0],6,'',0,'L');
	 	  $this->Cell($w[1],6,$empr[codstand],1,'L');
          $this->Cell($w[2],6,$empr[status],1,'L');
	  $this->Ln();
    }
  }
}}

$pdf=new PDF();
$header=array('','Cod. Stand','Status');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',8);
$pdf->FancyTable($header);
$pdf->Output('listado_stand.pdf','I'); //para que muestre la opcion de descargar el reporte

?>
<?php
 }else
{
    Header ("location: index.php"); 
}
?>

