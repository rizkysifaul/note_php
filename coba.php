<?php
require('fpdf.php');
$pdf = new FPDF('l','mm','A5');
include 'koneksi.php';
$mah = mysqli_query($connect, "select max(NOTA) as max_val from hasil");
$row = mysqli_fetch_assoc($mah);
$max = $row['max_val'];
$mantap = 1950;
$myarray = range(1,$max);

$pdf->SetFont('Arial','B',11);
foreach($myarray as $value){
	include 'koneksi.php';
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',12);
    $ve = $value + $mantap;
    $pdf->Cell(40,5,$ve);
    $mahas = mysqli_query($connect, "select * from hasil where nota = $value");
	$row = mysqli_fetch_assoc($mahas);
	#$sum = $row['sum_val'];


	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(130,7,'JANUARI 2018',0,1,'R');
	$pdf->Cell(30,7,'Nama ',0,0,'L');
	$pdf->Cell(30,7,': PT. ANGKASA MULYA TEKNIK',0,1,'L');
	$pdf->Cell(30,7,'NPWP/NPKP',0,0,'L');
	$pdf->Cell(30,7,': 02. 257. 129. 3. 607. 000',0,1,'L');
	$pdf->Cell(30,7,'Alamat',0,0,'L');
	$pdf->Cell(30,7,': Jl. Kedungdoro 157 Surabaya',0,1,'L');
	$pdf->Cell(30,7,'Tanggal PKP',0,0,'L');
	$pdf->Cell(30,7,': 03 - 10 - 2006',0,1,'L');

	$pdf->SetFont('Arial','B',10);
	#$pdf->Cell(190,7,'BULAN JANUARI 2018',0,1,'C');
// Memberikan space kebawah agar tidak terlalu rapat
	#$pdf->Cell(10,3,'',0,1);

	$pdf->SetFont('Arial','B',10);
	#$mahasiswa = mysqli_query($connect, "select * from hasil where nota = $value");
	#$row = mysqli_fetch_array($mahasiswa)
	#$pdf->Cell(190,7,'BULAN JANUARI 2018',0,1,'C');
	#$pdf->Cell(20,6,'NOTA',1,0);
	$pdf->Cell(10,6,'TGL',1,0);
	$pdf->Cell(85,6,'BARANG',1,0);
	$pdf->Cell(35,6,'HARGA DPP JUAL',1,0);
	$pdf->Cell(20,6,'QTY JUAL',1,0);
	$pdf->Cell(35,6,'JUMLAH DPP JUAL',1,1);
#$pdf->Cell(35,6,'TOTAL',2,1);

	$pdf->SetFont('Arial','',10);

	include 'koneksi.php';
	$mahasiswa = mysqli_query($connect, "select * from hasil where nota = $value");

	while ($row = mysqli_fetch_array($mahasiswa)){
    	#$pdf->Cell(20,6,$row['NOTA'],1,0);
    	$a = number_format($row['HARGA_DPP_JUAL'], 2, '.', ',');
    	$b = number_format($row['JUMLAH_DPP_JUAL'], 2, '.', ',');
    	$pdf->Cell(10,6,$row['TGL'],1,0);
    	$pdf->Cell(85,6,$row['BARANG'],1,0);
    	$pdf->Cell(35,6,$a,1,0,'R');
    	$pdf->Cell(20,6,$row['QTY_JUAL'],1,0,'R');
    	$pdf->Cell(35,6,$b,1,1,'R');
    #$pdf->Cell(35,6,'TOTAL',2,1);
	}
	$mahasiswa2 = mysqli_query($connect, "select sum(JUMLAH_DPP_JUAL) as sum_val from hasil where nota = $value");
	$row = mysqli_fetch_assoc($mahasiswa2);
	$sum = $row['sum_val'];
	$c = number_format($sum, 2, '.', ',');
	$pdf->Cell(150,6,'Dasar Pengenaan Pajak',1,0);
	#$pdf->Cell(20,6,'',2,0);
	$pdf->Cell(35,6,$c,1,1,'R');

	$mahasiswa3 = mysqli_query($connect, "select (sum(JUMLAH_DPP_JUAL))*0.1 as sum_val from hasil where nota = $value");
	$row = mysqli_fetch_assoc($mahasiswa3);
	$sum2 = $row['sum_val'];
	$d = number_format($sum2, 2, '.', ',');

	$pdf->Cell(150,6,'PPN 10% x Dasar Pengenaan Pajak',1,0);
	#$pdf->Cell(20,6,'',2,0);
	$pdf->Cell(35,6,$d,1,1,'R');

	$sum3 = $sum + $sum2 ;
	$e = number_format($sum3, 2, '.', ',');
	$pdf->Cell(150,6,'Jumlah',1,0);
	#$pdf->Cell(20,6,'',2,0);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(35,6,$e,1,1,'R');
}
$pdf->Output();
?>