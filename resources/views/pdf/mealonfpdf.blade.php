@include('pdf/fpdf182/fpdf')
<?php

class PDF extends FPDF
{
protected $col = 0; // Current column
protected $y0;      // Ordinate of column start

function Header()
{
    global $title;
    $this->SetFont('Arial','B',15);
    $w = $this->GetStringWidth($title)+6;
    $this->SetX((210-$w)/2);
 
    //$this->SetLineWidth(1);
    $this->Cell($w,5,'',0,1,'C');
    //$this->Ln(10);
    // Save ordinate
    $this->y0 = $this->GetY();
}


function Footer()
{
    $this->SetY(-15);
    $this->SetFont('Arial','I',8);
    $this->SetTextColor(128);
    $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
}

function SetCol($col)
{
    // Set position at a given column
    $this->col = $col;
    $x = 10+$col*97.5;
    $this->SetLeftMargin($x);
    $this->SetX($x);
}

function AcceptPageBreak()
{
    if($this->col<1)
    {
        $this->SetCol($this->col+1);
        $this->SetY($this->y0);
        return false;
    }
    else
    {
        $this->SetCol(0);
        return true;
    }
}

function ChapterTitle($month1,$sum,$type,$meal_type)
{
    // Title
    $this->SetFont('Arial','',12);
    $this->SetFillColor(200,220,255);
    if($meal_type=='b'){
        $this->Cell(0,6,"Breakfast  Meal $type : $sum , Date : $month1",0,1,'L',true);
    }else if($meal_type=='l'){
        $this->Cell(0,6,"Lunch  Meal $type : $sum , Date : $month1",0,1,'L',true);
    }else{
        $this->Cell(0,6,"Dinner  Meal $type : $sum , Date : $month1",0,1,'L',true);
    }
   
    $this->Ln(4);
    // Save ordinate
    $this->y0 = $this->GetY();
}


function ChapterBody($data)
{
       // Read text file
       // Font
    $this->SetFont('Times','',12);
    // Output text in a 6 cm width column
    //$this->MultiCell(60,5,'');
   // $this->SetDrawColor(200,220,255);
    //$this->SetTextColor(200,220,255);

    foreach($data as $row){
$this->SetFont('Times','',11);
 
    $this->Cell(15,6,$row['card'],1,0 , 'L' );
    $this->Cell(16.5,6,$row['old_card'],1,0 , 'L' );
	$this->Cell(49.5,6,substr(strtoupper($row['name']),0,18),1,0 , 'L' );

    $this->Cell(16.5,6,'',1,1 , 'L' );
   
   }
	
    
}

function PrintChapter($month1,$sum,$data,$type,$meal_type)
{
    $this->AddPage();
    $this->ChapterTitle($month1,$sum,$type,$meal_type);
    $this->ChapterBody($data);
}
}

$pdf = new PDF();

$pdf->SetFont('Courier','',14);
$title = '20000 Leagues Under the Seas';
$title = 'SetPlan';
$pdf->SetTitle($title);
$pdf->SetAuthor('Jules Verne');
$pdf->PrintChapter($month1,$sum,$meal,$type,$meal_type);


$pdf->Output($file,'I');
exit;



?>