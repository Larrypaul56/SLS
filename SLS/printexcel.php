<?php
error_reporting(E_ALL); ini_set('display_errors', 'on');
//connect to db
require_once('db_connection.php');
//set filename
// $title.$filename="List Of Applicants.xls";
define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once dirname(__FILE__) . '\Classes\PHPExcel.php';


// Create new PHPExcel object
echo date('H:i:s') , " Create new PHPExcel object" , EOL;
$objPHPExcel = new PHPExcel();

// Set document properties
echo date('H:i:s') , " Set document properties" , EOL;
$objPHPExcel->getProperties()->setCreator("Admin")
							 ->setLastModifiedBy("Student Leave System")
							 ->setTitle("APPLICATIONS REPORT");
							
//set font size for the whole document
//$objPHPExcel->getActiveSheet()->getStyle("F1:G1")->getFont()->setSize(16);//for some cells
$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
// Add some data
echo date('H:i:s') , " Add some data" , EOL;
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1', $org)
->setCellValue('A2', 'Admission Number'.$pz)
->setCellValue('A3','Full Name')
->setCellValue('B3','Date Start')
->setCellValue('C3','Date End')
->setCellValue('D3','Reason')
->setCellValue('E3','Status');
//align right
 $style = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );
$objPHPExcel->getActiveSheet()->getStyle("A1:J1")->applyFromArray($style);
//align center
$stylecenter = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );
$objPHPExcel->getActiveSheet()->getStyle("A2:J2")->applyFromArray($style);
//bold
$objPHPExcel->getActiveSheet()->getStyle('A3:J3')->getFont()->setBold(true);
//look for results and display them
// $sql="SELECT DISTINCT(regno),course,semister,stid,regno FROM results where course='$coz' AND semister>='$sem1' AND semister<='$sem' AND year='$yr' group by regno order by regno";
	$result=mysqli_query($conn,"SELECT * FROM application join users on application.user_id=users.user_id") ;
	$k=1;
	$dz=1;
	$row=4;
	while($rows=mysqli_fetch_array($result))
	{
			//Data
			 $coll="LIST OF APPLICATIONS";
			 $pz=ucwords(ucfirst(strtolower($pz)));
			 $coz_nm=ucwords(ucfirst(strtolower($coz_nm)));
             $adm=$rows['admission_number'];
             $fn=$rows['full_name'];
             $ds=$rows['date_start'];
             $de=$rows['date_end'];
             $rsn=$rows['reason'];
             $stat=$rows['status'];
			 //$dis=$ca.'-'.$final.'-'.$total.'-'.$level1;
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$row, $examyear);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$row, $coll);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$row, $regno);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$row, $regyear);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$row, $fname);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$row, $nta);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$row, $pz);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$row, $coz_nm);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$row, $class );
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$row, '');
			$row++;
			}
	//set auto width in cells
	foreach(range('A','J') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
        ->setAutoSize(true);
}
foreach(range('A3','J3') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
        ->setAutoSize(true);
}
//applyborders
$applyborders = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
$objPHPExcel->getActiveSheet()->getStyle('A3:J3')->applyFromArray($applyborders);
//$objPHPExcel->getActiveSheet()->getStyle('A7:J7')->applyFromArray($applyborders);
//$objPHPExcel->getActiveSheet()->getStyle('A8:J8')->applyFromArray($applyborders);//
//unset($styleArray);
$objPHPExcel->getActiveSheet()->getStyle(
    'A4:' . 
    $objPHPExcel->getActiveSheet()->getHighestColumn() . 
    $objPHPExcel->getActiveSheet()->getHighestRow()
)->applyFromArray($applyborders);

//merge cells
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:J1');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:J2');




// Rename worksheet
echo date('H:i:s') , " Rename worksheet" , EOL;
$objPHPExcel->getActiveSheet()->setTitle('Certificates');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

ob_end_clean();
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename='.$filename);
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>
