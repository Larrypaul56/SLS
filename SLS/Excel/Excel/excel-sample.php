<?php
error_reporting(E_ALL); ini_set('display_errors', 'Off');
//connect to db
require_once('connection.php');
//set filename
$title.$filename="Students Eligible for Certificates.xls";
define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/./Classes/PHPExcel.php';


// Create new PHPExcel object
echo date('H:i:s') , " Create new PHPExcel object" , EOL;
$objPHPExcel = new PHPExcel();

// Set document properties
echo date('H:i:s') , " Set document properties" , EOL;
$objPHPExcel->getProperties()->setCreator("Library System")
							 ->setLastModifiedBy("Library System")
							 ->setTitle("ATC-NACTE REPORT")
							 ->setSubject("ATC-NACTE REPORT")
							 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
							 ->setKeywords("office PHPExcel php")
							 ->setCategory("Test result file");
//set font size for the whole document
//$objPHPExcel->getActiveSheet()->getStyle("F1:G1")->getFont()->setSize(16);//for some cells
$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
// Add some data
echo date('H:i:s') , " Add some data" , EOL;
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1', $org)
->setCellValue('A2', 'CANDIDATES ELIGIBLE FOR '.$coz_nm .' CERTIFICATES OF '.$pz)
->setCellValue('A3','userId')
->setCellValue('B3','userName')
->setCellValue('C3','userEmail')
->setCellValue('D3','userAddress')
->setCellValue('E3','houseNo')
->setCellValue('F3','userRole');
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
//look for results and display them
$sql="SELECT * FROM users";
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
			 //$dis=$ca.'-'.$final.'-'.$total.'-'.$level1;
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$row, $rows['id']);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$row, $rows['fullname']);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$row, $rows['email']);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$row, $rows['address']);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$row, $rows['houseNo']);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$row, $rows['role']);
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
