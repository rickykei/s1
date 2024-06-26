<?php
	include_once('../security_check.php');
	include_once('../config.php');
	include_once('../functions.php');
	include_once('order_list_logic.php');
	
	/** Include path **/
	//ini_set('include_path', ini_get('include_path').';../Classes/');
	
	/** PHPExcel */
	include '../Classes/PHPExcel.php';
	
	$date_start = $_GET['date_start'];
	$date_end = $_GET['date_end'];
	$status = $_GET['status'];
	
	$isDisplayProductId = false;
	if ($companyDomain == DOMAIN_TOPNOV && $status == 'B') {
		$isDisplayProductId = true;
	}
	
	$result = genCSVByDate($date_start,$date_end,$status,$group2,$user_name,$isDisplayProductId);
	
	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();
	
	// Set properties
	$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
								 ->setLastModifiedBy("Maarten Balliauw")
								 ->setTitle("Office 2007 XLSX Test Document")
								 ->setSubject("Office 2007 XLSX Test Document")
								 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
								 ->setKeywords("office 2007 openxml php")
								 ->setCategory("Test result file");


	$sheet = $objPHPExcel->setActiveSheetIndex(0);

	// Header
	$i = 0;
	$sheet->setCellValueByColumnAndRow($i++, 1, 'Order date')
			->setCellValueByColumnAndRow($i++, 1, 'Auction ID')
			->setCellValueByColumnAndRow($i++, 1, 'Order Last Update Date')
			->setCellValueByColumnAndRow($i++, 1, 'Client Yahoo Id.')
			->setCellValueByColumnAndRow($i++, 1, 'Group')
			->setCellValueByColumnAndRow($i++, 1, 'Client email')
			->setCellValueByColumnAndRow($i++, 1, 'Client Name')
			->setCellValueByColumnAndRow($i++, 1, 'Note')
			->setCellValueByColumnAndRow($i++, 1, 'Client\'s Payment Name');
	//if ($isDisplayProductId) {
		$sheet->setCellValueByColumnAndRow($i++, 1, 'Product No.');
	//}
	$sheet->setCellValueByColumnAndRow($i++, 1, 'Price')
			->setCellValueByColumnAndRow($i++, 1, '顏色')
			->setCellValueByColumnAndRow($i++, 1, 'Qty')
			->setCellValueByColumnAndRow($i++, 1, 'Shipping')
			->setCellValueByColumnAndRow($i++, 1, 'Total')
			->setCellValueByColumnAndRow($i++, 1, 'Payment')
			->setCellValueByColumnAndRow($i++, 1, 'Return')
			->setCellValueByColumnAndRow($i++, 1, 'Shipping')
			->setCellValueByColumnAndRow($i++, 1, 'ShippingDate')
			->setCellValueByColumnAndRow($i++, 1, 'Remark');
	
	/* $sheet->setCellValue('A1', 'Order date')
			->setCellValue('B1', 'Auction ID')
			->setCellValue('C1', 'Client Yahoo Id.')
			->setCellValue('D1', 'Group')
			->setCellValue('E1', 'Client email')
			->setCellValue('F1', 'Client Name')
			->setCellValue('G1', 'Note')
			->setCellValue('H1', 'Client\'s Payment Name')
			->setCellValue('I1', 'Product No.')
			->setCellValue('J1', 'Price')
			->setCellValue('K1', 'Shipping')
			->setCellValue('L1', 'Total')
			->setCellValue('M1', 'Payment')
			->setCellValue('N1', 'Return')
			->setCellValue('O1', 'Shipping')
			->setCellValue('P1', 'Remark'); */
	
	if (!empty($result)) {
		$idx = 2;
		foreach ($result as $order) {
			$rowNo = $idx++;
			
			/* $sheet->getStyle('B'.$rowNo)->getAlignment()->setWrapText(true);
			$sheet->getStyle('G'.$rowNo)->getAlignment()->setWrapText(true);
			$sheet->getStyle('L'.$rowNo)->getAlignment()->setWrapText(true);
			$sheet->getStyle('N'.$rowNo)->getAlignment()->setWrapText(true); 
			
			$sheet->setCellValue('A'.$rowNo, conv($order['sale_date']))
				->setCellValue('B'.$rowNo, conv($order['sale_edit'].chr(13).chr(10).$order['sale_yahoo_id'].'('.$order['sale_dat'].')'))
				->setCellValue('C'.$rowNo, conv($order['sale_yahoo_id']))
				->setCellValue('D'.$rowNo, conv($order['sale_group']))
				->setCellValue('E'.$rowNo, conv($order['sale_email']))
				->setCellValue('F'.$rowNo, conv(($order['sale_name'])))
				->setCellValue('G'.$rowNo, conv(($order['debt_data'])))
				->setCellValue('H'.$rowNo, conv($order['debt_pay_name']))
				->setCellValue('I'.$rowNo, conv($order['sprod_id']))
				->setCellValue('J'.$rowNo, conv($order['cost_prod']))
				->setCellValue('K'.$rowNo, conv($order['sale_ship_fee']))
				->setCellValue('L'.$rowNo, conv($order['cost_total']))
				->setCellValue('M'.$rowNo, conv($order['bal_data']))
				->setCellValue('N'.$rowNo, conv($order['return_data']))
				->setCellValue('O'.$rowNo, conv($order['ship_data']))
				->setCellValue('P'.$rowNo, conv($order['remark']));*/
			
			$sheet->getStyleByColumnAndRow(1, $rowNo)->getAlignment()->setWrapText(true); // Auction ID
			$sheet->getStyle(6, $rowNo)->getAlignment()->setWrapText(true); // Note
			if (!$isDisplayProductId) {
				$sheet->getStyle(11, $rowNo)->getAlignment()->setWrapText(true); // Shipping
				$sheet->getStyle(13, $rowNo)->getAlignment()->setWrapText(true); // Payment
			}
			else {
				$sheet->getStyle(12, $rowNo)->getAlignment()->setWrapText(true); // Shipping
				$sheet->getStyle(14, $rowNo)->getAlignment()->setWrapText(true); // Payment
			}
			
			$i = 0;
			$sheet->setCellValueByColumnAndRow($i++, $rowNo, conv($order['sale_date']))
				->setCellValueByColumnAndRow($i++, $rowNo, conv($order['sale_edit'].chr(13).chr(10).$order['sale_yahoo_id']))
				->setCellValueByColumnAndRow($i++, $rowNo, conv($order['sale_dat']))
				->setCellValueByColumnAndRow($i++, $rowNo, conv($order['sale_yahoo_id']))
				->setCellValueByColumnAndRow($i++, $rowNo, conv($order['sale_group']))
				->setCellValueByColumnAndRow($i++, $rowNo, conv($order['sale_email']))
				->setCellValueByColumnAndRow($i++, $rowNo, conv(($order['sale_name'])))
				->setCellValueByColumnAndRow($i++, $rowNo, conv(($order['debt_data'])))
				->setCellValueByColumnAndRow($i++, $rowNo, conv($order['debt_pay_name']));
			
			//if ($isDisplayProductId) {
				$sheet->setCellValueByColumnAndRow($i++, $rowNo, conv($order['sprod_id']));
			//}
			
			$sheet->setCellValueByColumnAndRow($i++, $rowNo, conv($order['cost_prod']))
				->setCellValueByColumnAndRow($i++, $rowNo, conv($order['sprod_colour']))
				->setCellValueByColumnAndRow($i++, $rowNo, $order['sprod_unit'])
				->setCellValueByColumnAndRow($i++, $rowNo, $order['sale_ship_fee'])
				->setCellValueByColumnAndRow($i++, $rowNo, $order['cost_total'])
				->setCellValueByColumnAndRow($i++, $rowNo, conv($order['bal_data']))
				->setCellValueByColumnAndRow($i++, $rowNo, conv($order['return_data']))
				->setCellValueByColumnAndRow($i++, $rowNo, conv($order['ship_data']))
				->setCellValueByColumnAndRow($i++, $rowNo, conv($order['ship_date']))
				->setCellValueByColumnAndRow($i++, $rowNo, conv($order['remark']));
		}
	}
	
	// Rename sheet
	//$objPHPExcel->getActiveSheet()->setTitle('Simple');
	
	
	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	//$objPHPExcel->setActiveSheetIndex(0);
	
	
	// Redirect output to a client¡¦s web browser (Excel5)
	//header('Content-Type: application/vnd.ms-excel');
	header("Content-type:application/vnd.ms-excel;charset=euc");
	header('Content-Disposition: attachment;filename="order.xls"');
	header('Cache-Control: max-age=0');
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;
	
?>
