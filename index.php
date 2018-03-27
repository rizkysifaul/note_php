<?php
// memanggil library FPDF
require('fpdf.php');
// intance object dan memberikan pengaturan halaman PDF
#$a = 1;

for ($a=4; $a<5; $a++){
	$pdf = new FPDF('l','mm','A4');
// membuat halaman baru
	$pdf->AddPage();
// setting jenis font yang akan digunakan
	$pdf->SetFont('Arial','B',16);
// mencetak string
	$pdf->Cell(190,7,'NOTA SEDERHANA',0,1,'C');
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(190,7,'BULAN JANUARI 2018',0,1,'C');

// Memberikan space kebawah agar tidak terlalu rapat
	$pdf->Cell(10,7,'',0,1);

	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(20,6,'NOTA',1,0);
	$pdf->Cell(20,6,'TGL',1,0);
	$pdf->Cell(75,6,'BARANG',1,0);
	$pdf->Cell(35,6,'HARGA DPP JUAL',1,0);
	$pdf->Cell(20,6,'QTY JUAL',1,0);
	$pdf->Cell(35,6,'JUMLAH DPP JUAL',1,1);
#$pdf->Cell(35,6,'TOTAL',2,1);

	$pdf->SetFont('Arial','',10);

	include 'koneksi.php';
	$mahasiswa = mysqli_query($connect, "select * from hasil where nota = $a");
	while ($row = mysqli_fetch_array($mahasiswa)){
    	$pdf->Cell(20,6,$row['NOTA'],1,0);
    	$pdf->Cell(20,6,$row['TGL'],1,0);
    	$pdf->Cell(75,6,$row['BARANG'],1,0);
    	$pdf->Cell(35,6,$row['HARGA_DPP_JUAL'],1,0);
    	$pdf->Cell(20,6,$row['QTY_JUAL'],1,0);
    	$pdf->Cell(35,6,$row['JUMLAH_DPP_JUAL'],1,1);
    #$pdf->Cell(35,6,'TOTAL',2,1);
	}
	$mahasiswa2 = mysqli_query($connect, "select sum(JUMLAH_DPP_JUAL) as sum_val from hasil where nota = $a");
	$row = mysqli_fetch_assoc($mahasiswa2);
	$sum = $row['sum_val'];
	$pdf->Cell(20,6,'TOTAL',2,0);
	$pdf->Cell(20,6,'',2,0);
	$pdf->Cell(75,6,'',2,0);
	$pdf->Cell(35,6,'',2,0);
	$pdf->Cell(20,6,'',2,0);
	$pdf->Cell(35,6,$sum,2,1);
	$pdf->Output();
}

$pdf->Output();
?>