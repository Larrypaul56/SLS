<?php
require('./Classes/fpdf/fpdf.php');
require_once('db_connection.php');

class PDF extends FPDF
{
function WordWrap(&$text, $maxwidth)
{
    $text = trim($text);
    if ($text==='')
        return 0;
    $space = $this->GetStringWidth(' ');
    $lines = explode("\n", $text);
    $text = '';
    $count = 0;

    foreach ($lines as $line)
    {
        $words = preg_split('/ +/', $line);
        $width = 0;

        foreach ($words as $word)
        {
            $wordwidth = $this->GetStringWidth($word);
            if ($wordwidth > $maxwidth)
            {
                // Word is too long, we cut it
                for($i=0; $i<strlen($word); $i++)
                {
                    $wordwidth = $this->GetStringWidth(substr($word, $i, 1));
                    if($width + $wordwidth <= $maxwidth)
                    {
                        $width += $wordwidth;
                        $text .= substr($word, $i, 1);
                    }
                    else
                    {
                        $width = $wordwidth;
                        $text = rtrim($text)."\n".substr($word, $i, 1);
                        $count++;
                    }
                }
            }
            elseif($width + $wordwidth <= $maxwidth)
            {
                $width += $wordwidth + $space;
                $text .= $word.' ';
            }
            else
            {
                $width = $wordwidth + $space;
                $text = rtrim($text)."\n".$word.' ';
                $count++;
            }
        }
        $text = rtrim($text)."\n";
        $count++;
    }
    $text = rtrim($text);
    return $count;
}
}
#dont edit below here
$pdf=new FPDF();

$pdf->AddPage();
$pdf->SetFont('arial','B',12);
$pdf->Cell(80);
$pdf->Cell(30,10,'List Of Applications','B',0,'C');
$pdf->Ln(15);
$pdf->SetDrawColor(156,112,78);
$pdf->SetFillColor(210);
$pdf->SetFont('arial','B',12);
$w=[10,40,40,30,30,40,40,20];
$pdf->Cell($w[0],9,'App No','B',0,'',true);
// $pdf->Cell($w[0],8,$rw['application_id'],'1',0,'',true);
// $pdf->Cell($w[1],10,'Admission Number','B',0,'C',true);
$pdf->Cell($w[2],10,'Full Name','B',0,'C',true);
$pdf->Cell($w[3],9,'Date Start','B',0,'C',true);
$pdf->Cell($w[4],9,'Date End','B',0,'C',true);
// $pdf->Cell($w[5],9,'Reason','B',0,'C',true);
$pdf->Cell($w[6],9,'Current Status','B',0,'C',true);
$pdf->Ln();
$pdf->SetFont('arial','',12);
$sql="SELECT * FROM application join users on application.user_id=users.user_id";
     $w=[10,40,40,30,30,40,40,20];
$qr=mysqli_query($conn,$sql);
while($rw=mysqli_fetch_assoc($qr)){
    $rsn=$rw['reason'];
    $pdf->Cell($w[0],8,$rw['application_id'],'1',0,'',true);
    // $pdf->Cell($w[1],8,$rw['user_id'],'1',0,'',true);
    $pdf->Cell($w[2],8,$rw['full_name'],'1',0,'',true);
    $pdf->Cell($w[3],8,$rw['date_start'],'1',0,'',true);
    $pdf->Cell($w[4],8,$rw['date_end'],'1',0,'',true);
    // $pdf->Cell($w[5],8, Wordwrap($rsn),'1',0,'',true);
    $pdf->Cell($w[6],8,$rw['status'],'1',0,'',true);

    $pdf->Ln();
}

$pdf->Output();
?>
