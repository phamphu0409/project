<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();
if(isset($_GET['cancel']))
		  {
mysqli_query($con,"update appointment set doctorStatus='0' where id ='".$_GET['id']."'");
                  $_SESSION['msg']="Appointment canceled !!";
		  }
?>
<?php
require('../../tfpdf/tfpdf.php');
require("include/config.php");

$pdf = new tFPDF();
$pdf->AddPage("0");
// $pdf->SetFont('Arial','B',16);
$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
$pdf->SetFont('DejaVu','',15);

$pdf->SetFillColor(193,229,252);


$sql=mysqli_query($con,"select users.fullName as fname, appointment.*
from appointment
join users on users.id = appointment.userId
where appointment.doctorId = '".$_SESSION['id']."'
");
$cnt=1;


$pdf->Write(10,'Hóa đơn của bạn gồm có:');
$pdf->Ln(10);
$width_cell=array(10,40,40,40,40,50,51);
$pdf->Cell($width_cell[0],10,'ID',1,0,'C',true);
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
    $pdf->Cell($width_cell[2],10,$row['fname'],1,0,'C',$fill);    
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