<?php
error_reporting(E_ALL); ini_set('display_errors', 'ON');
//connect to db
require_once('db_connection.php');
//set filename
$title.$filename="ListOfApplicants.xls";
define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/Excel/Excel/Classes/PHPExcel.php';


// Create new PHPExcel object
echo date('H:i:s') , " Create new PHPExcel object" , EOL;
$objPHPExcel = new PHPExcel();

// Set document properties
echo date('H:i:s') , " Set document properties" , EOL;
$objPHPExcel->getProperties()->setCreator("Admin")
							 ->setLastModifiedBy("Admin")
							 ->setTitle("STUDENT LEAVE SYSTEM")
							 ->setSubject("STUDENT LEAVE SYSTEM")
							 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
							 ->setKeywords("office PHPExcel php")
							 ->setCategory("Test result file");
//set font size for the whole document
//$objPHPExcel->getActiveSheet()->getStyle("F1:G1")->getFont()->setSize(16);//for some cells
$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
// Add some data
echo date('H:i:s') , " Add some data" , EOL;
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1', 'STUDENT LEAVE SYSTEM')
->setCellValue('A2', 'LIST OF APPLICATIONS')
->setCellValue('A3','Admission Number')
->setCellValue('B3','Full Name')
->setCellValue('C3','Date Start')
->setCellValue('D3','Date End')
->setCellValue('E3','Reason')
->setCellValue('F3','Status');
// ->setCellValue('G3','userstatus');

//align right
 $style = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );
$objPHPExcel->getActiveSheet()->getStyle("A1:F1")->applyFromArray($style);
//align center
$stylecenter = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );
$objPHPExcel->getActiveSheet()->getStyle("A2:F2")->applyFromArray($style);
//bold
$objPHPExcel->getActiveSheet()->getStyle('A3:F3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getFont()->setBold(true);

//look for results and display them
$sql="SELECT * FROM application join users on application.user_id=users.user_id";
	$result=mysqli_query($conn,$sql);
	$k=1;
	$dz=1;
	$row=4;
	while($rows=mysqli_fetch_array($result))
	{
			//Data
			 $coll="Arusha Technical College";
			 $pz=ucwords(ucfirst(strtolower($pz)));
			 $coz_nm=ucwords(ucfirst(strtolower($coz_nm)));
			 $admno=$rows['user_id'];
			 $fn=$rows['full_name'];
			 $ds=$rows['date_start'];
			 $de=$rows['date_end'];
			 $rsn=$rows['reason'];
			 $stat=$rows['status'];
			 //$dis=$ca.'-'.$final.'-'.$total.'-'.$level1;
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$row, $admno);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$row,  $fn);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$row, $ds);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$row, $de);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$row, $rsn);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$row, $stat);
			// $objPHPExcel->getActiveSheet()->SetCellValue('G'.$row, $rows['activation']);

			$row++;
			}
	//set auto width in cells
	foreach(range('A','F') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
        ->setAutoSize(true);
}
foreach(range('A3','F3') as $columnID) {
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
$objPHPExcel->getActiveSheet()->getStyle('A3:F3')->applyFromArray($applyborders);
//$objPHPExcel->getActiveSheet()->getStyle('A7:J7')->applyFromArray($applyborders);
//$objPHPExcel->getActiveSheet()->getStyle('A8:J8')->applyFromArray($applyborders);//
//unset($styleArray);
$objPHPExcel->getActiveSheet()->getStyle(
    'A4:' . 
    $objPHPExcel->getActiveSheet()->getHighestColumn() . 
    $objPHPExcel->getActiveSheet()->getHighestRow()
)->applyFromArray($applyborders);

//merge cells
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:F1');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:F2');




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
