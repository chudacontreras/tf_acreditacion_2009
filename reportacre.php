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
	$this->Cell(30,10,'REPORTE DE ACREDITACIONES',0,0,'C');
	$this->Ln();
	$this->Cell(190,10,date("d / m / Y"),0,0,'C');
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
	$w=array(45,45,25,20,20,20);
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C',1);
	$this->Ln();
	//Restauraci�n de colores y fuentes
	$this->SetFillColor(224,235,255);
	$this->SetTextColor(0);
	$this->SetFont('Arial','B',7);
	//Datos
	$fill=0;
	
	include("ControlaBD.php");

	$con   = new ControlaBD();
	$idcon = $con->conectarSBD();
	$sel_bd= $con->select_BD("tf_comercializacion");
	$this->Cell($w[0],6,'Empresas',1,'L');
	$result2= $con->ejecutar("SELECT sum(totalacred) as sumatotal FROM contrato  WHERE numero like '%FB07%'",$idcon);
    $fila2= mysql_fetch_array($result2);
	$this->Cell($w[1],6, $fila2[sumatotal],1,'L');
	
    $resregis= $con->ejecutar("SELECT count(rif) as contarregis FROM acreditado WHERE contrato like '%LTF09%' and  estatus='1'",$idcon);
	$regis = mysql_fetch_array($resregis);
	$this->Cell($w[2],6,$regis[contarregis],1,'L');
	
	 
   $resimpre= $con->ejecutar("SELECT count(rif) as contarimpre FROM acreditado  WHERE contrato like '%LTF09%' and  estatus='2'",$idcon);
   $impre = mysql_fetch_array($resimpre);
   $this->Cell($w[3],6,$impre[contarimpre],1,'L');

   $reselimi= $con->ejecutar("SELECT count(rif) as contarelimi FROM acreditado  WHERE contrato like '%LTF09%' and estatus='0'",$idcon);
   $elimi = mysql_fetch_array($reselimi);
   $this->Cell($w[4],6,$elimi[contarelimi],1,'L');

   $porregis=$fila2[sumatotal]-($regis[contarregis]+$elimi[contarelimi]);
   $this->Cell($w[5],6,$porregis,1,'L');
   $this->ln();
   
    $this->Cell($w[0],6,'Comisiones',1,'L');
	$result2= $con->ejecutar("SELECT sum(totalacred) as sumatotal FROM contrato  WHERE numero like '%E09%'",$idcon);
    $fila2= mysql_fetch_array($result2);
	$this->Cell($w[1],6, $fila2[sumatotal],1,'L');
	
	$resregis= $con->ejecutar("SELECT count(rif) as contarregis FROM acreditado WHERE contrato like '%E09%' and  estatus='1'",$idcon);
	$regis = mysql_fetch_array($resregis);
	
	
 //***para los casos de los rotativos**//
   $resregisR= $con->ejecutar("SELECT count(rif) as contarregisR FROM acrrot WHERE (estatus='2' OR estatus='1')",$idcon);
   $regisR = mysql_fetch_array($resregisR);
   $sumaregis=$regis[contarregis]+$regisR[contarregisR];
   //**Fin caso de los rotativos**//
   $TotalREgis=$TotalREgis+$sumaregis;
   $this->Cell($w[2],6,$sumaregis,1,'L');
   //$this->Cell($w[2],6,$sumaregis,1,'L');
   $resimpre= $con->ejecutar("SELECT count(rif) as contarimpre FROM acreditado WHERE estatus='2'",$idcon);
   $impre = mysql_fetch_array($resimpre);
  //***para los casos de los rotativos**//
   $resimpreR= $con->ejecutar("SELECT count(rif) as contarimpreR FROM acrrot WHERE estatus='2'",$idcon);
   $impreR = mysql_fetch_array($resimpreR);
  
  //**Fin caso de los rotativos**//
	
	
   $resimpre= $con->ejecutar("SELECT count(rif) as contarimpre FROM acreditado  WHERE contrato like '%E09%' and  estatus='2'",$idcon);
   $impre = mysql_fetch_array($resimpre);
   $sumaimpre=$impre[contarimpre]+$impreR[contarimpreR];
   $this->Cell($w[3],6, $sumaimpre,1,'L');

   $reselimi= $con->ejecutar("SELECT count(rif) as contarelimi FROM acreditado  WHERE contrato like '%E09%' and estatus='3'",$idcon);
   $elimi = mysql_fetch_array($reselimi);
   $reselimiR= $con->ejecutar("SELECT count(rif) as contarelimiR FROM acrrot  WHERE contrato like '%E09%' and estatus='3'",$idcon);
   $elimiR = mysql_fetch_array($reselimiR);
   $sumaeli=$elimi[contarelimi]+$elimiR[contarelimiR];
   $this->Cell($w[4],6,$sumaeli,1,'L');

   //$porregis=$fila2[sumatotal]-($regis[contarregis]+$elimi[contarelimi]);
    $porregis=$fila2[sumatotal]-($sumaregis+$sumaeli);
   $this->Cell($w[5],6,$porregis,1,'L');
 
    $this->ln();
   
    $this->Cell($w[0],6,'TOTAL GENERAL',1,'L');
	$result2= $con->ejecutar("SELECT sum(totalacred) as sumatotal FROM contrato",$idcon);
    $fila2= mysql_fetch_array($result2);
	$this->Cell($w[1],6, $fila2[sumatotal],1,'L');
	
    $resregis= $con->ejecutar("SELECT count(rif) as contarregis FROM acreditado WHERE  estatus='1'",$idcon);
	$regis = mysql_fetch_array($resregis);
	$resregisR= $con->ejecutar("SELECT count(rif) as contarregisR FROM acrrot WHERE (estatus='2' OR estatus='1')",$idcon);
    $regisR = mysql_fetch_array($resregisR);
    $sumaregis=$regis[contarregis]+$regisR[contarregisR];
	$this->Cell($w[2],6,$sumaregis,1,'L');
	
   $resimpre= $con->ejecutar("SELECT count(rif) as contarimpre FROM acreditado  WHERE  estatus='2'",$idcon);
   $impre = mysql_fetch_array($resimpre);
    $resimpreR= $con->ejecutar("SELECT count(rif) as contarimpreR FROM acrrot WHERE estatus='2'",$idcon);
   $impreR = mysql_fetch_array($resimpreR);
    $sumaimpre=$impre[contarimpre]+$impreR[contarimpreR];
   $this->Cell($w[3],6, $sumaimpre,1,'L');

   $reselimi= $con->ejecutar("SELECT count(rif) as contarelimi FROM acreditado  WHERE estatus='3'",$idcon);
   $elimi = mysql_fetch_array($reselimi);
   $reselimiR= $con->ejecutar("SELECT count(rif) as contarelimiR FROM acrrot  WHERE estatus='3'",$idcon);
   $elimiR = mysql_fetch_array($reselimiR);
   $sumaeli=$elimi[contarelimi]+$elimiR[contarelimiR];
   $this->Cell($w[4],6,$sumaeli,1,'L');

   //$porregis=$fila2[sumatotal]-($regis[contarregis]+$elimi[contarelimi]);
   $porregis=$fila2[sumatotal]-($sumaregis+$sumaeli);
   $this->Cell($w[5],6,$porregis,1,'L');
  

}
}



$pdf=new PDF();
$header=array('','Acreditaciones Otorgadas','Registradas','Impresas','Eliminadas','Por Registrar');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',8);
$pdf->FancyTable($header);
$pdf->Output('reporte_acreditacion.pdf','I'); //para que muestre la opcion de descargar el reporte

?>
<?php
 }else
{
    Header ("location: index.php"); 
}
?>