@include('pdf/fpdf182/fpdf')
<?php




   
class PDF extends FPDF
{
function Header()
{
	
}	
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',12);
    // Page number
    $this->Cell(0,10,date('d-M-Y, h:i:sA').  ', Developed by ancovabd.com',0,0,'L');
    $this->Cell(0,10,date('d-M-Y, h:i:sA').  ', Developed by ancovabd.com',0,0,'R'); 
}
		
}	
				
   
			
   $pdf= new PDF('L','mm','A4');
   $pdf->AliasNbPages();     
   $pdf->AddPage();
   foreach($invoice as $row){

	  
                     $pdf->SetFont('Times','I','20'); 						  
					 $pdf->Cell(190,5,' ',0,1 , 'C' );  
                   
					$pdf->SetFont('Times','I','15');
					
                   
					
					$pdf->Cell(15,8, '','',0 , 'L' );
					$pdf->Cell(120,8,$hallinfo->hall_name,'',0, 'L' );
					$pdf->Cell(15,7, '','',0 , '' );
					$pdf->Cell(15,8, '','',0 , 'L' );
					$pdf->Cell(120,8,$hallinfo->hall_name,'',1 , 'L' );
					
					// $pdf->Image('image/dulogu.png',20,15,-250); // Left side image
					// $pdf->Image('image/dulogu.png',170,15,-250); // Right side image 
                    // $pdf->Image('image/dulogu.png',110,20,-250);
					//$pdf->Image('image/dulogu.png',260,20,-250);
					$pdf->SetFont('Times','I','12');
					     $pdf->Cell(15,6, '','',0 , 'L' ); 
                         $pdf->Cell(120,6,'University Of Dhaka','' ,0 , 'L' );
						 $pdf->Cell(15,7, '|','',0 , 'L' );
						 $pdf->Cell(15,6, '','',0 , 'L' ); 
                         $pdf->Cell(120,6,'University Of Dhaka','' ,1 , 'L' );
						 
						 
				 $pdf->SetFont('Times','I','12');
					     $pdf->Cell(15,6, '','',0 , 'L' ); 
                         $pdf->Cell(85,6,'Dhaka 1000','' ,0 , 'L' );
                         $pdf->Cell(35,6,'Manager Copy','' ,0 , 'L' );
						 $pdf->Cell(15,7, '','',0 , 'L' );
                         $pdf->Cell(15,6, '','',0 , 'L' ); 
                         $pdf->Cell(85,6,'Dhaka 1000','' ,0 , 'L' );
                         $pdf->Cell(35,6,'Student Copy','' ,1 , 'L' );

						 
                         
                	         
						 
             $pdf->Cell(170,10,' ','',1 , 'R' );
			 
			  $pdf->SetFont('Times','I','14');   
		      $pdf->Cell(50,10,'Student Information ','B' ,0 , 'L' );
			  $pdf->Cell(20,10, '','',0 , '' );
		      $pdf->Cell(45,10,'INVOICE ','B' ,0 , 'L' );
			  $pdf->Cell(15,7, '','',0 , '' );
			  $pdf->Cell(20,10, '','',0 , '' );
			  $pdf->Cell(50,10,'Student Information ','B' ,0 , 'L' );
			  $pdf->Cell(20,10, '','',0 , '' );
		      $pdf->Cell(45,10,'INVOICE ','B' ,0, 'L' );
			  $pdf->Cell(20,10, '','',1, '' );
		 							 
					  
				    $pdf->SetFont('Times','I','12'); 
					
                         
						 
					     $pdf->Cell(15,7, 'Name ',0,0 , 'L' );
						 $pdf->Cell(55,7, ': '.$row['name'],'0',0 , 'L' );
						 $pdf->Cell(25,7, 'Invoice ',0,0, 'L' );
						 $pdf->Cell(40,7, ': '.date('F-Y',strtotime($row['invoice_date'])). '-'.$row['invoice_section'],0,0, 'L' );
						 $pdf->Cell(15,7, '|','',0 , 'L' );
						 $pdf->Cell(15,7, 'Name ',0,0 , 'L' );
						 $pdf->Cell(55,7, ': '.$row['name'],'0',0 , 'L' );
						 $pdf->Cell(25,7, 'Invoice ',0,0, 'L' );
						 $pdf->Cell(40,7, ': '.date('F-Y',strtotime($row['invoice_date'])),0,1, 'L' );
				          
						 $pdf->Cell(15,7, 'Card No',0,0 , 'L' );
						 $pdf->Cell(55,7, ': '.$row['card'],'0',0 , 'L' );
						 $pdf->Cell(25,7, 'Invoice ID',0,0, 'L' );
						 $pdf->Cell(40,7, ': '.$row['id'],0,0, 'L' );
						 $pdf->Cell(15,7, '','',0 , '' );
						 $pdf->Cell(15,7, 'Card No',0,0 , 'L' );
						 $pdf->Cell(55,7, ': '.$row['card'],'0',0 , 'L' );
						 $pdf->Cell(25,7, 'Invoice ID',0,0, 'L' );
						 $pdf->Cell(40,7, ': '.$row['id'],0,1, 'L' );
						 
					
						 
						 $pdf->Cell(15,7, 'Phone',0,0 , 'L' );
						 $pdf->Cell(55,7, ': '.$row['phone'],'0',0 , 'L' );
						 $pdf->Cell(25,7, '',0,0, 'L' );
					$pdf->SetFont('Times','I','9'); 	 
						 $pdf->Cell(40,7, '',0,0, 'L' );
					 $pdf->SetFont('Times','I','12');
					      $pdf->Cell(15,7, '','',0 , '' );
 						  $pdf->Cell(15,7, 'Phone',0,0 , 'L' );
						  $pdf->Cell(55,7, ': '.$row['phone'],'0',0 , 'L' );
						  $pdf->Cell(25,7, '',0,0, 'L' );
					 $pdf->SetFont('Times','I','9'); 	 
						 $pdf->Cell(40,7, ' ',0,1, 'L' );



                  $pdf->SetFont('Times','I','12');
                         $pdf->Cell(35,7, '1st Payment ',0,0 , 'L' );
                         if($row['payment_status1'] ==1){
                             $pdf->Cell(35,7, ': Paid','0',0 , 'L' );
                         }else{
                             $pdf->Cell(35,7, ': Unpaid','0',0 , 'L' );
                         }
						 $pdf->Cell(15,7, ' Time',0,0, 'L' );
					$pdf->SetFont('Times','I','9'); 	 
						 $pdf->Cell(50,7, ': '.$row['payment_time1'],0,0, 'L' );
					$pdf->SetFont('Times','I','12');
					      $pdf->Cell(15,7, '','',0 , '' );
                          $pdf->Cell(35,7, '1st Payment ',0,0 , 'L' );
                          if($row['payment_status1'] ==1){
                              $pdf->Cell(35,7, ': Paid','0',0 , 'L' );
                          }else{
                              $pdf->Cell(35,7, ': Unpaid','0',0 , 'L' );
                          }
						 $pdf->Cell(15,7, 'Time',0,0, 'L' );
					$pdf->SetFont('Times','I','9'); 	 
						 $pdf->Cell(50,7, ': '.$row['payment_time1'],0,1, 'L' );



                   //2nd paymen

                     $pdf->SetFont('Times','I','12');
                     $pdf->Cell(35,7, '2nd Payment ',0,0 , 'L' );
                         if($row['payment_status2'] ==1){
                             $pdf->Cell(35,7, ': Paid','0',0 , 'L' );
                         }else{
                             $pdf->Cell(35,7, ': Unpaid','0',0 , 'L' );
                         }
						 $pdf->Cell(15,7, ' Time',0,0, 'L' );
					$pdf->SetFont('Times','I','9'); 	 
						 $pdf->Cell(50,7, ': '.$row['payment_time2'],0,0, 'L' );
					$pdf->SetFont('Times','I','12');
					      $pdf->Cell(15,7, '','',0 , '' );
                          $pdf->Cell(35,7, '2nd Payment ',0,0 , 'L' );
                          if($row['payment_status2'] ==1){
                              $pdf->Cell(35,7, ': Paid','0',0 , 'L' );
                          }else{
                              $pdf->Cell(35,7, ': Unpaid','0',0 , 'L' );
                          }
						 $pdf->Cell(15,7, 'Time',0,0, 'L' );
					$pdf->SetFont('Times','I','9'); 	 
						 $pdf->Cell(50,7, ': '.$row['payment_time2'],0,1, 'L' );              
						 
						 					                    
                      
                       

                          
                    $pdf->Cell(190,5,' ','',1 , 'C' );						  
					
                    $pdf->SetFont('Times','I','12');

					     $pdf->Cell(15,5, 'Serial',1,0 , 'C' );
						 $pdf->Cell(80,5, 'Description',1,0 , 'L' );
						 $pdf->Cell(30,5, 'Amount',1,0 , 'R' );
						 $pdf->Cell(25,5, '','',0 , '' );
						 $pdf->Cell(15,5, 'Serial',1,0 , 'C' );
						 $pdf->Cell(80,5, 'Description',1,0 , 'L' );
						 $pdf->Cell(30,5, 'Amount',1,1 , 'R' ); 
						 
						 
						 $pdf->Cell(15,5, '1',1,0 , 'C' );
						 $pdf->Cell(80,5, 'Previous Reserve Amount',1,0 , 'L' );
						 $pdf->Cell(30,5, $row['pre_reserve_amount'].' TK',1,0 , 'R' );
						 $pdf->Cell(25,5, '','',0 , '' );
						 $pdf->Cell(15,5, '1',1,0 , 'C' );
						 $pdf->Cell(80,5, 'Previous Reserve Amount',1,0 , 'L' );
						 $pdf->Cell(30,5, $row['pre_reserve_amount'].' TK',1,1 , 'R' );
						 
						 $pdf->Cell(15,5, '2',1,0 , 'C' );
						 $pdf->Cell(80,5, ' Previous Refund Amount',1,0 , 'L' );
						 $pdf->Cell(30,5, $row['pre_refund'].' TK',1,0 , 'R' );
						 $pdf->Cell(25,5, '|','',0 , 'C' );
						 $pdf->Cell(15,5, '2',1,0 , 'C' );
						 $pdf->Cell(80,5, ' Previous Refund Amount',1,0 , 'L' );
						 $pdf->Cell(30,5, $row['pre_refund'].' TK',1,1, 'R' );
						 
						 $pdf->Cell(15,5, '3',1,0 , 'C' );
						 $pdf->Cell(80,5, 'Previous Due Amount',1,0 , 'L' );
						 $pdf->Cell(30,5, $row['pre_monthdue'].' TK',1,0 , 'R' );
						 $pdf->Cell(25,5, '','',0 , '' );
						 $pdf->Cell(15,5, '3',1,0 , 'C' );
						 $pdf->Cell(80,5, 'Previous Due Amount',1,0 , 'L' );
						 $pdf->Cell(30,5, $row['pre_monthdue'].' TK',1,1 , 'R' );

						 
						 $pdf->Cell(15,5, '4',1,0 , 'C' );
						 $pdf->Cell(80,5, 'Total Budget Amount',1,0 , 'L' );
						 $pdf->Cell(30,5, $row['cur_total_amount'].' TK',1,0 , 'R' );
						 $pdf->Cell(25,5, '','',0 , '' );
						 $pdf->Cell(15,5, '3',1,0 , 'C' );
						 $pdf->Cell(80,5, 'Total Budget Amount',1,0 , 'L' );
						 $pdf->Cell(30,5, $row['cur_total_amount'].' TK',1,1 , 'R' );


						 
						 $pdf->Cell(15,5, '5',1,0 , 'C' );
						 $pdf->Cell(80,5, 'Inactive Meal Amount',1,0 , 'L' );
						 $pdf->Cell(30,5, $row['inmeal_amount'].' TK',1,0 , 'R' );
						 $pdf->Cell(25,5, '','',0 , '' );
						 $pdf->Cell(15,5, '5',1,0 , 'C' );
						 $pdf->Cell(80,5, 'Inactive Meal Amount',1,0 , 'L' );
						 $pdf->Cell(30,5, $row['inmeal_amount'].' TK',1,1 , 'R' );


						 
						 $pdf->Cell(15,5, '6',1,0 , 'C' );
						 $pdf->Cell(80,5, 'Payable Amount',1,0 , 'L' );
						 $pdf->Cell(30,5, $row['payble_amount'].' TK',1,0 , 'R' );
						 $pdf->Cell(25,5, '','',0 , '' );
						 $pdf->Cell(15,5, '6',1,0 , 'C' );
						 $pdf->Cell(80,5, 'Payable Amount',1,0 , 'L' );
						 $pdf->Cell(30,5, $row['payble_amount'].' TK',1,1 , 'R' );


                         $pdf->Cell(15,5, '7',1,0 , 'C' );
						 $pdf->Cell(80,5, '1st Payable Amount',1,0 , 'L' );
						 $pdf->Cell(30,5, $row['payble_amount1'].' TK',1,0 , 'R' );
						 $pdf->Cell(25,5, '','',0 , '' );
						 $pdf->Cell(15,5, '7',1,0 , 'C' );
						 $pdf->Cell(80,5, '1st Payable Amount',1,0 , 'L' );
						 $pdf->Cell(30,5, $row['payble_amount1'].' TK',1,1 , 'R' );


                         $pdf->Cell(15,5, '8',1,0 , 'C' );
						 $pdf->Cell(80,5, '2nd Payable Amount',1,0 , 'L' );
						 $pdf->Cell(30,5, $row['payble_amount2'].' TK',1,0 , 'R' );
						 $pdf->Cell(25,5, '','',0 , '' );
						 $pdf->Cell(15,5, '8',1,0 , 'C' );
						 $pdf->Cell(80,5, '2nd Payable Amount',1,0 , 'L' );
						 $pdf->Cell(30,5, $row['payble_amount2'].' TK',1,1 , 'R' );
						 
					
						 										                         
						
						$pdf->Cell(190,30,' ','',1 , 'C' );		
						 
						 
						$pdf->Cell(40,7, 'Student Signature','',0 , 'C' );	
						$pdf->Cell(95,7, 'Manager Signature','',0 , 'C' );
                        $pdf->Cell(25,7, '','',0 , '' );
						$pdf->Cell(40,7, 'Student Signature','',0 , 'C' );	
						$pdf->Cell(95,7, 'Manager Signature','',1 , 'C' );
						 
						 
             }		
					 
					  $pdf->Output("invoice-".$row['id'],'I');  
					   exit;
            	
					

?>