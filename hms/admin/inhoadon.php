<?php
require('../../tfpdf/tfpdf.php');
require("include/config.php");

$pdf = new tFPDF();
$pdf->AddPage("0");
// $pdf->SetFont('Arial','B',16);
$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
$pdf->SetFont('DejaVu','',15);

$pdf->SetFillColor(193,229,252);

$sql=mysqli_query($con,"select doctors.doctorName as docname,users.fullName as pname,appointment.*  from appointment join doctors on doctors.id=appointment.doctorId join users on users.id=appointment.userId ");
$cnt=1;

$pdf->Write(10,'Hóa đơn của bạn gồm có:');
$pdf->Ln(10);
$width_cell=array(10,30,40,40,40,50,51);
$pdf->Cell($width_cell[0],10,'ID',1,0,'C',true);
$pdf->Cell($width_cell[1],10,'Tên Bác Sĩ',1,0,'C',true);
$pdf->Cell($width_cell[2],10,'Tên Bệnh Nhân',1,0,'C',true);
$pdf->Cell($width_cell[3],10,'Chuyên Ngành',1,0,'C',true);
$pdf->Cell($width_cell[4],10,'Chi Phí Tư Vấn',1,0,'C',true);
$pdf->Cell($width_cell[5],10,'Ngày Tạo Cuộc Hẹn',1,0,'C',true);
$pdf->Cell($width_cell[6],10,'Ngày Hẹn/Thời Gian',1,1,'C',true);

$pdf->SetFillColor(235,236,236);
$fill=false;

$i = 0;
while($row = mysqli_fetch_array($sql)){
    $i++;
    $pdf->Cell($width_cell[0],10,$i,1,0,'C',$fill);  
    $pdf->Cell($width_cell[1],10,$row['docname'],1,0,'C',$fill);
    $pdf->Cell($width_cell[2],10,$row['pname'],1,0,'C',$fill);    
    $pdf->Cell($width_cell[3],10,$row['doctorSpecialization'],1,0,'C',$fill); 
    $pdf->Cell($width_cell[4],10,$row['consultancyFees'],1,0,'C',$fill); 
    $pdf->Cell($width_cell[5],10,$row['appointmentDate'],1,0,'C',$fill); 
    $pdf->Cell($width_cell[6],10,$row['postingDate'],1,1,'C',$fill); 
    $fill = !$fill;

}
$pdf->Write(10,'Cám ơn bạn đã sử dụng dịch vụ của chúng tôi.');
$pdf->Ln(10);

$pdf->Output();
?>