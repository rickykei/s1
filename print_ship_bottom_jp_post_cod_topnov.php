<?php
header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: post-check=0, pre-check=0",false);
session_cache_limiter();
session_start();
require('config.php');  //this should the the absolute path to the config.php file 
require('functions.php'); //this should the the absolute path to the functions.php file - see the instrcutions for config.php above
if (allow_access(@Administrators) != "yes"){ //this is group name or username of the group or person that you wish to allow access to{                                                            // - please be advise that the Administrators Groups has access to all pages.
	include ('no_access.html'); //this should the the absolute path to the no_access.html file - see above
exit;
}

$invoice_no = $_GET['sale_ref'];
$addr_id = $_GET['addr_id'];

define('FPDF_FONTPATH','./pdf/font/');
//require('pdf/chinese.php');
require('pdf/mbfpdf.php');
class PDF extends MBFPDF
{

var $col=0;
//Ordinate of column start
var $y0;
var $header_title=array();

function Set_header_title($header_title)
{
	$this->header_title=$header_title;
}
function Body($invoice_no,$addr_id)
{
  $debt_row=getdebt_data($invoice_no);

	$order_row=getsale_data($invoice_no);
  	/* $order_detail=getsale_prod_data2($invoice_no);
  	$order_row = $order_detail['order']; */

	$ship_row= getship_data($invoice_no);
	$prod_row= getsprod_data($invoice_no);
	
	$addr_row=getAddr_data($addr_id);
	
	$office_addr=getOfficeAddress($addr_id); // Retrieve from address
	
	$addr_name=$addr_row["name"];
	$addr1=$addr_row["address1"];
	$addr2=$addr_row["address2"];
	$addr3=$addr_row["address3"];
	$post_acc_no=$addr_row["post_acc_no"];
	$post_acc_name=$addr_row["post_acc_name"];
	
	$sprod_price=$prod_row["sprod_price"];
	$sprod_unit=$prod_row["sprod_unit"];
	$sprod_sub=$sprod_price*$sprod_unit;
	$sprod_id=$prod_row["sprod_id"];
	
	/* $sub_total = number_format($sub_total + $sprod_sub,2,'.','');	
	$sale_discount=$order_row["sale_discount"];
	$sale_ship_fee=$order_row["sale_ship_fee"];
	$sale_tax=$order_row["sale_tax"];
	$total = number_format($sub_total-$sale_discount,2,'.','');
	$total_tax =$total * $sale_tax / 100; 
	$total_tax = number_format(round($total_tax, 0),2,'.','');
	//$total = number_format($total + $sale_ship_fee + total_tax,2,'.','');
	$total = number_format($total + $sale_ship_fee + total_tax,0,'.',''); */
	
	//$total = $order_detail['total'];
	$bal = getbal_data($invoice_no);
	$total = $bal['bal_pay'];
	
	// Format the diplay total
	$tmpTotal = $total;
	$totalArray = array();
	for($i = 0; $i < 7; $i++) {
		$divide = pow(10, (6-$i));
		$totalArray[$i] = ''.intval($tmpTotal / $divide);
		$tmpTotal = $tmpTotal % $divide;
	}
	for($i = 0; $i < 7; $i++) {
		if ($totalArray[$i] == 0) {
			$totalArray[$i] = '';
		}
		else {
			if ($i != 0) {
				$totalArray[$i-1] = iconv("UTF-8", 'euc-jp', '¥');
			}
			break;
		}
	}
	//var_dump($totalArray);

 $this->SetY(-2);
 
   $this->SetTextColor(0,0,0);
 
  $border=1;
  

	
	$this->SetFont(KOZMIN, '', 14);
	    

	$this->Cell(60,8,"",$border,0,'R',0);
	$this->Cell(80,8,"",$border,0,'L',0);
	//$this->Cell(40,8,"",$border,1,'L',0);
	$this->Cell(5,8,"",$border,0,'L',0);
	// 1st Total Amount
	for($i = 0; $i < 7; $i++) {
		$this->Cell(5,8,$totalArray[$i],$border,0,'L',0);
	}
	$this->Cell(1,8,"",$border,1,'L',0);

	// 2nd Total Amount
   	$this->Cell(60,8,"",$border,0,'R',0);
	$this->Cell(80,8,"",$border,0,'L',0);
	$this->Cell(5,8,"",$border,0,'L',0);
	for($i = 0; $i < 7; $i++) {
		$this->Cell(5,8,$totalArray[$i],$border,0,'L',0);
	}
 	$this->Cell(1,8,"",$border,1,'L',0);

   $this->Cell(193,10,'',$border,1,'R',0);
   
   $this->SetFont(KOZMIN, '',12);
	$this->Cell(173,8,"",$border,0,'R',0);
	$this->Cell(20,8,"",$border,1,'L',0);

  $this->SetFont(KOZMIN, '',16);
	$this->Cell(30,8,"",$border,0,'R',0);
	$this->Cell(85,8,$debt_row['debt_post_co'],$border,0,'L',0);
	$this->SetFont(KOZMIN, '',12);
	$this->Cell(40,8,$office_addr['address1'],$border,1,'L',0);
$this->SetFont(KOZMIN, '',12);
	$this->Ln(3);
	$this->Cell(25,8,"",$border,0,'R',0);
	$this->Cell(80,8,$debt_row['debt_cust_address1'],$border,0,'L',0);
	$this->Cell(60,8,$office_addr['address2'],$border,1,'L',0);

	$this->Cell(25,8,"",$border,0,'R',0);
	$this->Cell(80,8,$debt_row['debt_cust_address2'],$border,0,'L',0);
	$this->Cell(60,8,$office_addr['address3'],$border,1,'L',0);
//	$this->Ln(8);
 	$this->Cell(35,8,"",$border,0,'R',0);
	$this->Cell(65,8,$order_row['sale_name'],$border,0,'L',0);
	$this->Cell(5,8,"",$border,1,'L',0);
	
	$tel=0;
	 if ($debt_row['debt_tel']!='' or $debt_row['debt_mobile']!='') 
	 {
	 	$tel ="Tel:". $debt_row['debt_tel']." ". $debt_row['debt_mobile'];
	 }
	 	
 	$this->Cell(30,8,"",$border,0,'R',0);
	$this->Cell(70,8,$tel,$border,0,'L',0);
	$this->Cell(5,8,"",$border,1,'C',0);
$this->Ln(4);
	$this->Cell(35,8,"",$border,0,'R',0);
	//$this->Cell(100,8,$sprod_id,$border,0,'L',0);
	$this->Cell(100,8,$sprod_id.'-'.$order_row['sale_group'],$border,0,'L',0); // Product ID + Sales Group
	$this->Cell(5,8,"",$border,1,'C',0);
	
	// Product Name
	$this->SetFont(KOZMIN, '',7);
 	$this->SetXY(165, 65);
	$this->MultiCell(25,4,$prod_row['sprod_name'],$border,'L',0);
	
	// Print Date
	$this->SetFont(KOZMIN, '',7);
	$this->SetXY(200, 105);
	$this->Cell(15,4,date('Y m d'),$border,1,'L',0);
}
function Header()
{
	//Page header
	global $title;
	global $header_title;
	
	
	$w=$this->GetStringWidth($title);
	$this->SetX(0);
	$this->SetDrawColor(255,255,255);
	$this->SetFillColor(233,233,233);
	$this->SetTextColor(0,0,0);
	 
	$this->Ln(24);
 
}

function Footer()
{
	//Page footer
	$this->SetY(0);
 
	//$this->SetTextColor(128);
	//$this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
}






}

$pdf=new PDF('P','mm',array(245,128));

$pdf->SetTopMargin(-2);
$pdf->SetLeftMargin(0);
    $pdf->SetAutoPageBreak(true, 0);
  
$pdf->AddMBFont(KOZMIN, 'EUC-JP');
$pdf->AddMBFont(PGOTHIC, 'EUC-JP');
$pdf->SetFont(KOZMIN, '', 30);
//$pdf->AddBig5Font();
$title='dfsd';
$header_title=array();
$pdf->Body($invoice_no,$addr_id);
$pdf->SetAuthor('');

$filepath=''.$invoice_no.'.pdf';
//$pdf->Output($filepath);
$pdf->Output();

?>
