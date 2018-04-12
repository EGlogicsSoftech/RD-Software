<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Packing extends CI_Controller { 

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	//function use to redirect on the page with data when check login status//

	public function __construct()
        {
                parent::__construct();
                
                $this->load->helper('item');
                $this->load->library('excel');
        }
        
    public function PL_PDF($id)
		{
			$this->load->library('pdf');
			$this->data['title']="Packing List";
			$this->data['packing_list']=$this->db->get_where('packing_list',array('packing_id'=>$id))->row();
		
			$html=$this->load->view('packing/pl_pdf',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
	 
			$pdfFilePath ="PL-".$this->data['packing_list']->packing_num.".pdf";

			$pdf = $this->pdf->load();
			
			$pdf->WriteHTML($html,2);
			
			$pdf->Output($pdfFilePath, "D");
		}
		
	public function PL_EXCEL($id)
		{
			// $data['packing_list'] = $this->db->get_where('packing_list',array('packing_id'=>$id))->row();
// 			
// 			$this->RedirectToPageWithData('packing/pl_excel', $data, true);

			
			$data['packing_list'] = $this->db->get_where('packing_list',array('packing_id'=>$id))->row();
			$customer_data = GetCustomerData($data['packing_list']->cust_id);
			
			$shipping_data = GetPLShippingData($data['packing_list']->packing_id);
			
			$styleArray = array(
			'font'  => array(
				'size'  => 11,
				'name'  => 'Verdana'
			));
			
			$border = array(
				'borders' => array(
					'outline' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					),
				),
			);
			
			$allborder = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					),
				),
			);
			
			$bgcolor = array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'F2DCDB')
				)
			);
			
    		$this->excel->getActiveSheet()->getStyle("G2:J12")->applyFromArray($allborder);
    		$this->excel->getActiveSheet()->getStyle("A2:J12")->applyFromArray($bgcolor);
    		$this->excel->getActiveSheet()->getStyle("A2:I7")->applyFromArray($border);
    		$this->excel->getActiveSheet()->getStyle("A13:J18")->applyFromArray($border);
    		$this->excel->getActiveSheet()->getStyle("A19:J27")->applyFromArray($border);
			
			$this->excel->setActiveSheetIndex(0);
			//name the worksheet
			$this->excel->getActiveSheet()->setTitle('Packing List');
			//set cell A1 content with some text
			
			$this->excel->getActiveSheet()->mergeCells('A1:J1');
			$this->excel->getActiveSheet()->setCellValue('A1', 'Packing List');
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$this->excel->getActiveSheet()->setCellValue('A2', 'EXPORTER');
			$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			
			$this->excel->getActiveSheet()->setCellValue('A3', 'RICKSHAW DELIVERY (Est.2004)');
			$this->excel->getActiveSheet()->setCellValue('A4', 'C-31, SECTOR -7 NOIDA');
			$this->excel->getActiveSheet()->setCellValue('A5', 'UP 201301   -INDIA');
			$this->excel->getActiveSheet()->setCellValue('A6', 'PH: 0120-4350340');
			
			$this->excel->getActiveSheet()->mergeCells('G2:H2');
			$this->excel->getActiveSheet()->setCellValue('G2', 'Invoice No.& Date');
			$this->excel->getActiveSheet()->mergeCells('I2:J2');
			$this->excel->getActiveSheet()->mergeCells('I3:J3');
			$this->excel->getActiveSheet()->setCellValue('I2', 'Exporter ref. No.');
			$this->excel->getActiveSheet()->mergeCells('G3:H3');
			$this->excel->getActiveSheet()->setCellValue('G3', $data['packing_list']->packing_num );
			$this->excel->getActiveSheet()->mergeCells('G4:J4');
			$this->excel->getActiveSheet()->mergeCells('G4:G5');
			$this->excel->getActiveSheet()->setCellValue('G4', 'Buyer order & ref.');
			$this->excel->getActiveSheet()->mergeCells('G6:J6');
			$this->excel->getActiveSheet()->setCellValue('G6', 'Other References');
			$this->excel->getActiveSheet()->setCellValue('G7', 'IEC CODE NO. 0504070860');
			$this->excel->getActiveSheet()->mergeCells('G7:I7');
			$this->excel->getActiveSheet()->mergeCells('G8:I8');
			$this->excel->getActiveSheet()->mergeCells('G9:J9');
			$this->excel->getActiveSheet()->mergeCells('G10:J10');
			
			$this->excel->getActiveSheet()->setCellValue('G8', 'TIN NO.09465702772');
			$this->excel->getActiveSheet()->setCellValue('G9', 'Service Tax No. AAHFR1192BSD003');
			$this->excel->getActiveSheet()->setCellValue('G10', 'GSTIN No. 09AAHFR1192B1ZD');
			$this->excel->getActiveSheet()->setCellValue('G11', 'MENT  FOR EXPORT ONLY');
			$this->excel->getActiveSheet()->mergeCells('G11:J11');
			$this->excel->getActiveSheet()->mergeCells('G11:J12');
			$this->excel->getActiveSheet()->getStyle('G11')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('G11')->getFont()->setSize(16);
			
			$this->excel->getActiveSheet()->setCellValue('A13', 'CONSIGNEE:');
			$this->excel->getActiveSheet()->setCellValue('A14', $customer_data->name);
			$this->excel->getActiveSheet()->setCellValue('A15', $customer_data->cust_add);
			$this->excel->getActiveSheet()->setCellValue('A18', $customer_data->phone);
			
			$this->excel->getActiveSheet()->setCellValue('G13', 'Buyer (if other than consignee)');
			$this->excel->getActiveSheet()->setCellValue('G4', 'SAME AS CONSIGNEE');
			$this->excel->getActiveSheet()->setCellValue('G19', 'country of Origin of goods');
			$this->excel->getActiveSheet()->setCellValue('G20', 'India');
			
			$this->excel->getActiveSheet()->setCellValue('A21', 'Pre-carriage by');
			$this->excel->getActiveSheet()->setCellValue('A22', 'BY SEA');
			$this->excel->getActiveSheet()->setCellValue('A23', 'Vassel/Flight No');
			$this->excel->getActiveSheet()->setCellValue('A24', '');
			$this->excel->getActiveSheet()->setCellValue('A25', 'Port of Discharge  ');
			$this->excel->getActiveSheet()->setCellValue('A26', $shipping_data->pod);
			$this->excel->getActiveSheet()->setCellValue('C21', 'Place of Receipt by pre carrier ');
			$this->excel->getActiveSheet()->setCellValue('C22', 'NEW DELHI');
			$this->excel->getActiveSheet()->setCellValue('C23', 'Port of Loading');
			$this->excel->getActiveSheet()->setCellValue('C24', $shipping_data->pol);
			$this->excel->getActiveSheet()->setCellValue('C25', 'Final Destination');
			$this->excel->getActiveSheet()->setCellValue('C26', $shipping_data->fd);
			$this->excel->getActiveSheet()->setCellValue('G21', 'Country of Final Destination');
			$this->excel->getActiveSheet()->setCellValue('G22', 'USA');
			
			
			
			//$this->excel->getActiveSheet()->getStyle('A15:H15')->applyFromArray($border);
			$this->excel->getActiveSheet()->setCellValue('A28', 'Box NO.');
			$this->excel->getActiveSheet()->getStyle('A28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth("10");
			
			$this->excel->getActiveSheet()->setCellValue('B28', 'Item#');
			$this->excel->getActiveSheet()->getStyle('B28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("10");
			
			$this->excel->getActiveSheet()->setCellValue('C28', 'Customer Item#');
			$this->excel->getActiveSheet()->getStyle('C28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("10");
			
			$this->excel->getActiveSheet()->setCellValue('D28', 'HS Code');
			$this->excel->getActiveSheet()->getStyle('D28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("10");
			
			$this->excel->getActiveSheet()->setCellValue('E28', 'Description');
			$this->excel->getActiveSheet()->getStyle('E28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth("72");
			
			$this->excel->getActiveSheet()->setCellValue('F28', 'Qty');
			$this->excel->getActiveSheet()->getStyle('F28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth("9");
			
			$this->excel->getActiveSheet()->setCellValue('G28', 'Gross Weight (Kg)');
			$this->excel->getActiveSheet()->getStyle('G28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth("9");
			
			$this->excel->getActiveSheet()->setCellValue('H28', ' Net Weight (Kg)');
			$this->excel->getActiveSheet()->getStyle('H28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth("9");
			
			$this->excel->getActiveSheet()->setCellValue('I28', 'PI#');
			$this->excel->getActiveSheet()->getStyle('I28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth("20");
			
			$this->excel->getActiveSheet()->setCellValue('J28', 'Category');
			$this->excel->getActiveSheet()->getStyle('J28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth("20");
			
			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setName('Logo');
			$objDrawing->setDescription('Logo');
			//Path to signature .jpg file
			$objDrawing->setPath('./admin/img/RIKSHAW_DELIVERY.png');
			$objDrawing->setOffsetX(20);                     //setOffsetX works properly
			$objDrawing->setOffsetY(8);                     //setOffsetX works properly
			$objDrawing->setCoordinates('E2');             //set image to cell E38
			$objDrawing->setHeight(35);                     //signature height
			$objDrawing->setWorksheet($this->excel->getActiveSheet());  //save
			
			//var_dump($data);
			$packingitems = GetPackingItem( $data['packing_list']->packing_id );
			
			//$row_num = count($sup_po_items);
			//$rs = $this->db->get('countries');
			$exceldata="";
			$exceldata1="";
			$i=29;
			
			foreach ($packingitems as $row){
				// var_dump($row);
// 				die();
				$item_img = GetItemData( $row['item_id'] )->ITEM_IMAGE;
				$itemUnitID = GetItemData( $row['item_id'] )->ITEM_UNIT;
				$item_cat = Get_Item_Category_Name( GetItemData( $row['item_id'] )->CATEGORY_NAME );
				
				$color = GetCustomerData( $row['customer_id'] )->color;
				
				$this->excel->getActiveSheet()->getStyle('I'.$i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB($color);
				
				$exceldata1[] = array('box_no' => $row['box_num'], 'item' => GetItemData( $row['item_id'] )->ITEM_CODE, 'customer_item' => CPIItemdata( $row['cust_pi'], $row['item_id'] )->customer_item_code, 'hs_code' => GetItemData( $row['item_id'] )->HSN_CODE, 'description' => GetItemData( $row['item_id'] )->ITEM_DESC, 'qty' => $row['qty'], 'gross_weight' => $row['gross_weight'], 'net_weight' => $row['qty_per_box'] * GetItemData( $row['item_id'] )->NET_WEIGHT, 'PI' => CPIdata( $row['cust_pi'] )->pi_num, 'category' => $item_cat);
				//$exceldata[] = $row;
			$i++;}
			$start_row = 28;
			$total_row = count($exceldata1);
			
			$x_row = $start_row + $total_row + 1;
			$x1_row = $x_row+1;
			$x2_row = $x1_row+1;
			$x3_row = $x1_row+3;
			
			$this->excel->getActiveSheet()->getStyle("A28:J".$x_row)->applyFromArray($allborder);
			
			//Fill data 
			$this->excel->getActiveSheet()->fromArray($exceldata1, null, 'A29');
		 
		 	$this->excel->getActiveSheet()->setCellValue('A'.$x1_row, 'We declare that this Invoice shows the actual price of goods.');
			$this->excel->getActiveSheet()->setCellValue('A'.$x2_row, 'Described and that all particulars are true and correct.');
			
			$this->excel->getActiveSheet()->setCellValue('G'.$x2_row, 'Signature & Date');
		 	$this->excel->getActiveSheet()->getStyle('G'.$x2_row)->getFont()->setBold(true);
			
			
			$this->excel->getActiveSheet()->getStyle("A1:J".$x3_row)->applyFromArray($border);
		 
			$this->excel->getActiveSheet()->getStyle('A29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('B29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('C29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 	$this->excel->getActiveSheet()->getStyle('D29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('E29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('F29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 	$this->excel->getActiveSheet()->getStyle('G29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 	$this->excel->getActiveSheet()->getStyle('H29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			// $objDrawing = new PHPExcel_Worksheet_Drawing();
// 			$objDrawing->setName('Customer Signature');
// 			$objDrawing->setDescription('Customer Signature');
// 			//Path to signature .jpg file
// 			$objDrawing->setPath('http://ims.eglogics.website/uploads/item_images/31110.png');
// 			$objDrawing->setOffsetX(8);                     //setOffsetX works properly
// 			$objDrawing->setCoordinates('E38');             //set image to cell E38
// 			$objDrawing->setHeight(75);                     //signature height  
// 			$objDrawing->setWorksheet($this->excel->getActiveSheet());  //save
			
			$filename='Packing-List-'.$data['packing_list']->packing_num.'.xls'; //save our workbook as this file name
			header('Content-Type: application/octet-stream'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache
			
			

			//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
			//if you want to save it as .XLSX Excel 2007 format
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
			//force user to download the Excel file without writing it to server's HD
			$objWriter->save('php://output');
			
	  	}
	  	
	public function Custom_PL_EXCEL($id)
		{
			// $data['packing_list'] = $this->db->get_where('packing_list',array('packing_id'=>$id))->row();
// 			
// 			$this->RedirectToPageWithData('packing/pl_excel', $data, true);

			
			$data['packing_list'] = $this->db->get_where('packing_list',array('packing_id'=>$id))->row();
			$customer_data = GetCustomerData($data['packing_list']->cust_id);
			$shipping_data = GetPLShippingData($data['packing_list']->packing_id);
			
			$styleArray = array(
			'font'  => array(
				'size'  => 11,
				'name'  => 'Verdana'
			));
			
			$border = array(
				'borders' => array(
					'outline' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					),
				),
			);
			
			$allborder = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					),
				),
			);
			
			$bgcolor = array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'F2DCDB')
				)
			);
			
    		$this->excel->getActiveSheet()->getStyle("G2:J12")->applyFromArray($allborder);
    		$this->excel->getActiveSheet()->getStyle("A2:J12")->applyFromArray($bgcolor);
    		$this->excel->getActiveSheet()->getStyle("A2:I7")->applyFromArray($border);
    		$this->excel->getActiveSheet()->getStyle("A13:J18")->applyFromArray($border);
    		$this->excel->getActiveSheet()->getStyle("A19:J27")->applyFromArray($border);
			
			$this->excel->setActiveSheetIndex(0);
			//name the worksheet
			$this->excel->getActiveSheet()->setTitle('Custom Packing List');
			//set cell A1 content with some text
			
			$this->excel->getActiveSheet()->mergeCells('A1:J1');
			$this->excel->getActiveSheet()->setCellValue('A1', 'Custom Packing List');
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$this->excel->getActiveSheet()->setCellValue('A2', 'EXPORTER');
			$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			
			$this->excel->getActiveSheet()->setCellValue('A3', 'RICKSHAW DELIVERY (Est.2004)');
			$this->excel->getActiveSheet()->setCellValue('A4', 'C-31, SECTOR -7 NOIDA');
			$this->excel->getActiveSheet()->setCellValue('A5', 'UP 201301   -INDIA');
			$this->excel->getActiveSheet()->setCellValue('A6', 'PH: 0120-4350340');
			
			$this->excel->getActiveSheet()->mergeCells('G2:H2');
			$this->excel->getActiveSheet()->setCellValue('G2', 'Invoice No.& Date');
			$this->excel->getActiveSheet()->mergeCells('I2:J2');
			$this->excel->getActiveSheet()->mergeCells('I3:J3');
			$this->excel->getActiveSheet()->setCellValue('I2', 'Exporter ref. No.');
			$this->excel->getActiveSheet()->mergeCells('G3:H3');
			$this->excel->getActiveSheet()->setCellValue('G3', $data['packing_list']->packing_num );
			$this->excel->getActiveSheet()->mergeCells('G4:J4');
			$this->excel->getActiveSheet()->mergeCells('G4:G5');
			$this->excel->getActiveSheet()->setCellValue('G4', 'Buyer order & ref.');
			$this->excel->getActiveSheet()->mergeCells('G6:J6');
			$this->excel->getActiveSheet()->setCellValue('G6', 'Other References');
			$this->excel->getActiveSheet()->setCellValue('G7', 'IEC CODE NO. 0504070860');
			$this->excel->getActiveSheet()->mergeCells('G7:I7');
			$this->excel->getActiveSheet()->mergeCells('G8:I8');
			$this->excel->getActiveSheet()->mergeCells('G9:J9');
			$this->excel->getActiveSheet()->mergeCells('G10:J10');
			
			$this->excel->getActiveSheet()->setCellValue('G8', 'TIN NO.09465702772');
			$this->excel->getActiveSheet()->setCellValue('G9', 'Service Tax No. AAHFR1192BSD003');
			$this->excel->getActiveSheet()->setCellValue('G10', 'GSTIN No. 09AAHFR1192B1ZD');
			$this->excel->getActiveSheet()->setCellValue('G11', 'MENT  FOR EXPORT ONLY');
			$this->excel->getActiveSheet()->mergeCells('G11:J11');
			$this->excel->getActiveSheet()->mergeCells('G11:J12');
			$this->excel->getActiveSheet()->getStyle('G11')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('G11')->getFont()->setSize(16);
			
			$this->excel->getActiveSheet()->setCellValue('A13', 'CONSIGNEE:');
			$this->excel->getActiveSheet()->setCellValue('A14', $customer_data->name);
			$this->excel->getActiveSheet()->setCellValue('A15', $customer_data->cust_add);
			$this->excel->getActiveSheet()->setCellValue('A18', $customer_data->phone);
			
			$this->excel->getActiveSheet()->setCellValue('G13', 'Buyer (if other than consignee)');
			$this->excel->getActiveSheet()->setCellValue('G4', 'SAME AS CONSIGNEE');
			$this->excel->getActiveSheet()->setCellValue('G19', 'country of Origin of goods');
			$this->excel->getActiveSheet()->setCellValue('G20', 'India');
			
			$this->excel->getActiveSheet()->setCellValue('A21', 'Pre-carriage by');
			$this->excel->getActiveSheet()->setCellValue('A22', 'BY SEA');
			$this->excel->getActiveSheet()->setCellValue('A23', 'Vassel/Flight No');
			$this->excel->getActiveSheet()->setCellValue('A24', '');
			$this->excel->getActiveSheet()->setCellValue('A25', 'Port of Discharge  ');
			$this->excel->getActiveSheet()->setCellValue('A26', $shipping_data->pod);
			$this->excel->getActiveSheet()->setCellValue('C21', 'Place of Receipt by pre carrier ');
			$this->excel->getActiveSheet()->setCellValue('C22', 'NEW DELHI');
			$this->excel->getActiveSheet()->setCellValue('C23', 'Port of Loading');
			$this->excel->getActiveSheet()->setCellValue('C24', $shipping_data->pol);
			$this->excel->getActiveSheet()->setCellValue('C25', 'Final Destination');
			$this->excel->getActiveSheet()->setCellValue('C26', $shipping_data->fd);
			$this->excel->getActiveSheet()->setCellValue('G21', 'Country of Final Destination');
			$this->excel->getActiveSheet()->setCellValue('G22', 'USA');
			
			
			
			//$this->excel->getActiveSheet()->getStyle('A15:H15')->applyFromArray($border);
			$this->excel->getActiveSheet()->setCellValue('A28', 'Box NO.');
			$this->excel->getActiveSheet()->getStyle('A28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth("10");
			
			$this->excel->getActiveSheet()->setCellValue('B28', 'Item#');
			$this->excel->getActiveSheet()->getStyle('B28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("10");
			
			$this->excel->getActiveSheet()->setCellValue('C28', 'Customer Item#');
			$this->excel->getActiveSheet()->getStyle('C28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("10");
			
			$this->excel->getActiveSheet()->setCellValue('D28', 'HS Code');
			$this->excel->getActiveSheet()->getStyle('D28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("10");
			
			$this->excel->getActiveSheet()->setCellValue('E28', 'Description');
			$this->excel->getActiveSheet()->getStyle('E28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth("72");
			
			$this->excel->getActiveSheet()->setCellValue('F28', 'Qty');
			$this->excel->getActiveSheet()->getStyle('F28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth("9");
			
			$this->excel->getActiveSheet()->setCellValue('G28', 'Gross Weight (Kg)');
			$this->excel->getActiveSheet()->getStyle('G28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth("9");
			
			$this->excel->getActiveSheet()->setCellValue('H28', ' Net Weight (Kg)');
			$this->excel->getActiveSheet()->getStyle('H28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth("9");
			
			$this->excel->getActiveSheet()->setCellValue('I28', 'PI#');
			$this->excel->getActiveSheet()->getStyle('I28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth("20");
			
			$this->excel->getActiveSheet()->setCellValue('J28', 'Category');
			$this->excel->getActiveSheet()->getStyle('J28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth("20");
			
			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setName('Logo');
			$objDrawing->setDescription('Logo');
			//Path to signature .jpg file
			$objDrawing->setPath('./admin/img/RIKSHAW_DELIVERY.png');
			$objDrawing->setOffsetX(20);                     //setOffsetX works properly
			$objDrawing->setOffsetY(8);                     //setOffsetX works properly
			$objDrawing->setCoordinates('E2');             //set image to cell E38
			$objDrawing->setHeight(35);                     //signature height
			$objDrawing->setWorksheet($this->excel->getActiveSheet());  //save
			
			//var_dump($data);
			$packingitems = GetPackingItem( $data['packing_list']->packing_id );
			
			//$row_num = count($sup_po_items);
			//$rs = $this->db->get('countries');
			$exceldata="";
			$exceldata1="";
			$i=29;
			
			foreach ($packingitems as $row){
				// var_dump($row);
// 				die();
				$item_img = GetItemData( $row['item_id'] )->ITEM_IMAGE;
				$itemUnitID = GetItemData( $row['item_id'] )->ITEM_UNIT;
				$item_cat = Get_Item_Category_Name( GetItemData( $row['item_id'] )->CATEGORY_NAME );
				
				$color = GetCustomerData( $row['customer_id'] )->color;
				
				$this->excel->getActiveSheet()->getStyle('I'.$i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB($color);
				
				$exceldata1[] = array('box_no' => $row['box_num'], 'item' => GetItemData( $row['item_id'] )->ITEM_CODE, 'customer_item' => CPIItemdata( $row['cust_pi'], $row['item_id'] )->customer_item_code, 'hs_code' => GetItemData( $row['item_id'] )->HSN_CODE, 'description' => GetItemData( $row['item_id'] )->ITEM_CUSTOM_DESC, 'qty' => $row['qty'], 'gross_weight' => $row['gross_weight'], 'net_weight' => $row['qty_per_box'] * GetItemData( $row['item_id'] )->NET_WEIGHT, 'PI' => CPIdata( $row['cust_pi'] )->pi_num, 'category' => $item_cat);
				//$exceldata[] = $row;
			$i++;}
			$start_row = 28;
			$total_row = count($exceldata1);
			
			$x_row = $start_row + $total_row + 1;
			$x1_row = $x_row+1;
			$x2_row = $x1_row+1;
			$x3_row = $x1_row+3;
			
			$this->excel->getActiveSheet()->getStyle("A28:J".$x_row)->applyFromArray($allborder);
			
			//Fill data 
			$this->excel->getActiveSheet()->fromArray($exceldata1, null, 'A29');
		 
		 	$this->excel->getActiveSheet()->setCellValue('A'.$x1_row, 'We declare that this Invoice shows the actual price of goods.');
			$this->excel->getActiveSheet()->setCellValue('A'.$x2_row, 'Described and that all particulars are true and correct.');
			
			$this->excel->getActiveSheet()->setCellValue('G'.$x2_row, 'Signature & Date');
		 	$this->excel->getActiveSheet()->getStyle('G'.$x2_row)->getFont()->setBold(true);
			
			
			$this->excel->getActiveSheet()->getStyle("A1:J".$x3_row)->applyFromArray($border);
		 
			$this->excel->getActiveSheet()->getStyle('A29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('B29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('C29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 	$this->excel->getActiveSheet()->getStyle('D29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('E29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('F29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 	$this->excel->getActiveSheet()->getStyle('G29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 	$this->excel->getActiveSheet()->getStyle('H29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			// $objDrawing = new PHPExcel_Worksheet_Drawing();
// 			$objDrawing->setName('Customer Signature');
// 			$objDrawing->setDescription('Customer Signature');
// 			//Path to signature .jpg file
// 			$objDrawing->setPath('http://ims.eglogics.website/uploads/item_images/31110.png');
// 			$objDrawing->setOffsetX(8);                     //setOffsetX works properly
// 			$objDrawing->setCoordinates('E38');             //set image to cell E38
// 			$objDrawing->setHeight(75);                     //signature height  
// 			$objDrawing->setWorksheet($this->excel->getActiveSheet());  //save
			
			$filename='Custom-Packing-List-'.$data['packing_list']->packing_num.'.xls'; //save our workbook as this file name
			header('Content-Type: application/octet-stream'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache
			
			

			//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
			//if you want to save it as .XLSX Excel 2007 format
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
			//force user to download the Excel file without writing it to server's HD
			$objWriter->save('php://output');
			
	  	}
	  	
	 public function INVOICE_PDF($id)
		{
			$this->load->library('pdf');
			$this->data['title']="Invoice";
			$this->data['packing_list']=$this->db->get_where('packing_list',array('packing_id'=>$id))->row();
		
			$html=$this->load->view('packing/invoice_pdf',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
	 
			$pdfFilePath ="invoice/".$this->data['packing_list']->packing_num.".pdf";

			$pdf = $this->pdf->load();
			
			$pdf->WriteHTML($html,2);
			
			$pdf->Output($pdfFilePath, "D");
		}
		
	public function INVOICE_EXCEL($id)
		{
			// $data['packing_list'] = $this->db->get_where('packing_list',array('packing_id'=>$id))->row();
// 			
// 			$this->RedirectToPageWithData('packing/invoice_excel', $data, true);

			$data['packing_list'] = $this->db->get_where('packing_list',array('packing_id'=>$id))->row();
			$customer_data = GetCustomerData($data['packing_list']->cust_id);
			$shipping_data = GetPLShippingData($data['packing_list']->packing_id);
			
			$styleArray = array(
			'font'  => array(
				'size'  => 11,
				'name'  => 'Verdana'
			));
			
			$border = array(
				'borders' => array(
					'outline' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					),
				),
			);
			
			$allborder = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					),
				),
			);
			
			$bgcolor = array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'F2DCDB')
				)
			);
			
    		$this->excel->getActiveSheet()->getStyle("J2:M12")->applyFromArray($allborder);
    		$this->excel->getActiveSheet()->getStyle("A2:M12")->applyFromArray($bgcolor);
    		$this->excel->getActiveSheet()->getStyle("A2:I7")->applyFromArray($border);
			
			$this->excel->setActiveSheetIndex(0);
			//name the worksheet
			$this->excel->getActiveSheet()->setTitle('Invoice');
			//set cell A1 content with some text
			
			$this->excel->getActiveSheet()->mergeCells('A1:M1');
			$this->excel->getActiveSheet()->setCellValue('A1', 'Invoice');
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$this->excel->getActiveSheet()->setCellValue('A2', 'EXPORTER');
			$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			
			$this->excel->getActiveSheet()->setCellValue('A3', 'RICKSHAW DELIVERY (Est.2004)');
			$this->excel->getActiveSheet()->setCellValue('A4', 'C-31, SECTOR -7 NOIDA');
			$this->excel->getActiveSheet()->setCellValue('A5', 'UP 201301   -INDIA');
			$this->excel->getActiveSheet()->setCellValue('A6', 'PH: 0120-4350340');
			
			$this->excel->getActiveSheet()->mergeCells('J2:K2');
			$this->excel->getActiveSheet()->setCellValue('J2', 'Invoice No.& Date');
			$this->excel->getActiveSheet()->mergeCells('L2:M2');
			$this->excel->getActiveSheet()->mergeCells('L3:M3');
			$this->excel->getActiveSheet()->setCellValue('L2', 'Exporter ref. No.');
			$this->excel->getActiveSheet()->mergeCells('J3:K3');
			$this->excel->getActiveSheet()->setCellValue('J3', $data['packing_list']->packing_num );
			$this->excel->getActiveSheet()->mergeCells('J4:M4');
			$this->excel->getActiveSheet()->mergeCells('J4:J5');
			$this->excel->getActiveSheet()->setCellValue('J4', 'Buyer order & ref.');
			$this->excel->getActiveSheet()->mergeCells('J6:M6');
			$this->excel->getActiveSheet()->setCellValue('J6', 'Other References');
			$this->excel->getActiveSheet()->setCellValue('J7', 'IEC CODE NO. 0504070860');
			$this->excel->getActiveSheet()->mergeCells('J7:L7');
			$this->excel->getActiveSheet()->mergeCells('J8:L8');
			$this->excel->getActiveSheet()->mergeCells('J9:M9');
			$this->excel->getActiveSheet()->mergeCells('J10:M10');
			
			$this->excel->getActiveSheet()->setCellValue('J8', 'TIN NO.09465702772');
			$this->excel->getActiveSheet()->setCellValue('J9', 'Service Tax No. AAHFR1192BSD003');
			$this->excel->getActiveSheet()->setCellValue('J10', 'GSTIN No. 09AAHFR1192B1ZD');
			$this->excel->getActiveSheet()->setCellValue('J11', 'MENT  FOR EXPORT ONLY');
			$this->excel->getActiveSheet()->mergeCells('J11:M11');
			$this->excel->getActiveSheet()->mergeCells('J11:J12');
			$this->excel->getActiveSheet()->getStyle('J11')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('J11')->getFont()->setSize(16);
			
			$this->excel->getActiveSheet()->setCellValue('A13', 'CONSIGNEE:');
			$this->excel->getActiveSheet()->setCellValue('A14', $customer_data->name);
			$this->excel->getActiveSheet()->setCellValue('A15', $customer_data->cust_add);
			$this->excel->getActiveSheet()->setCellValue('A18', $customer_data->phone);
			
			$this->excel->getActiveSheet()->setCellValue('J13', 'Buyer (if other than consignee)');
			$this->excel->getActiveSheet()->setCellValue('J4', 'SAME AS CONSIGNEE');
			$this->excel->getActiveSheet()->setCellValue('J19', 'country of Origin of goods');
			$this->excel->getActiveSheet()->setCellValue('J20', 'India');
			
			$this->excel->getActiveSheet()->setCellValue('A21', 'Pre-carriage by');
			$this->excel->getActiveSheet()->setCellValue('A22', 'BY SEA');
			$this->excel->getActiveSheet()->setCellValue('A23', 'Vassel/Flight No');
			$this->excel->getActiveSheet()->setCellValue('A24', '');
			$this->excel->getActiveSheet()->setCellValue('A25', 'Port of Discharge  ');
			$this->excel->getActiveSheet()->setCellValue('A26', $shipping_data->pod);
			$this->excel->getActiveSheet()->setCellValue('C21', 'Place of Receipt by pre carrier ');
			$this->excel->getActiveSheet()->setCellValue('C22', 'NEW DELHI');
			$this->excel->getActiveSheet()->setCellValue('C23', 'Port of Loading');
			$this->excel->getActiveSheet()->setCellValue('C24', $shipping_data->pol);
			$this->excel->getActiveSheet()->setCellValue('C25', 'Final Destination');
			$this->excel->getActiveSheet()->setCellValue('C26', $shipping_data->fd);
			$this->excel->getActiveSheet()->setCellValue('J21', 'Country of Final Destination');
			$this->excel->getActiveSheet()->setCellValue('J22', 'USA');
			
			
			
			//$this->excel->getActiveSheet()->getStyle('A15:H15')->applyFromArray($border);
			$this->excel->getActiveSheet()->setCellValue('A28', 'Box NO.');
			$this->excel->getActiveSheet()->getStyle('A28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth("10");
			
			$this->excel->getActiveSheet()->setCellValue('B28', 'Item#');
			$this->excel->getActiveSheet()->getStyle('B28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("10");
			
			$this->excel->getActiveSheet()->setCellValue('C28', 'Customer Item#');
			$this->excel->getActiveSheet()->getStyle('C28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("10");
			
			$this->excel->getActiveSheet()->setCellValue('D28', 'HS Code');
			$this->excel->getActiveSheet()->getStyle('D28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("10");
			
			$this->excel->getActiveSheet()->setCellValue('E28', 'Description');
			$this->excel->getActiveSheet()->getStyle('E28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth("72");
			
			$this->excel->getActiveSheet()->setCellValue('F28', 'Nt. Wt. in Kg');
			$this->excel->getActiveSheet()->getStyle('F28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth("9");
			
			$this->excel->getActiveSheet()->setCellValue('G28', 'Qty');
			$this->excel->getActiveSheet()->getStyle('G28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth("9");
			
			$this->excel->getActiveSheet()->setCellValue('H28', 'Unit');
			$this->excel->getActiveSheet()->getStyle('H28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth("10");
			
			$this->excel->getActiveSheet()->setCellValue('I28', 'Purchase Price');
			$this->excel->getActiveSheet()->getStyle('I28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth("11");
			
			$this->excel->getActiveSheet()->setCellValue('J28', 'Rate $');
			$this->excel->getActiveSheet()->getStyle('J28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth("11");
			
			$this->excel->getActiveSheet()->setCellValue('K28', 'FOB  VALUE $');
			$this->excel->getActiveSheet()->getStyle('K28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth("14");
			
			$this->excel->getActiveSheet()->setCellValue('L28', 'PI#');
			$this->excel->getActiveSheet()->getStyle('L28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth("20");
			
			$this->excel->getActiveSheet()->setCellValue('M28', 'Category');
			$this->excel->getActiveSheet()->getStyle('M28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth("20");
			
			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setName('Logo');
			$objDrawing->setDescription('Logo');
			//Path to signature .jpg file
			$objDrawing->setPath('./admin/img/RIKSHAW_DELIVERY.png');
			$objDrawing->setOffsetX(20);                     //setOffsetX works properly
			$objDrawing->setOffsetY(8);                     //setOffsetX works properly
			$objDrawing->setCoordinates('E2');             //set image to cell E38
			$objDrawing->setHeight(35);                     //signature height
			$objDrawing->setWorksheet($this->excel->getActiveSheet());  //save
			
			//var_dump($data);
			$packingitems = GetPackingItem( $data['packing_list']->packing_id );
			
			//$row_num = count($sup_po_items);
			//$rs = $this->db->get('countries');
			$exceldata="";
			$exceldata1="";
			$total="";
			$gross="";
			$total_net="";
			$totalCBM="";
			
			$i=29;
			foreach ($packingitems as $row){
				//var_dump($row);
				//die();
				$item_img = GetItemData( $row['item_id'] )->ITEM_IMAGE;
				$itemUnitID = GetItemData( $row['item_id'] )->ITEM_UNIT;
				$item_cat = Get_Item_Category_Name( GetItemData( $row['item_id'] )->CATEGORY_NAME );
				
				$total = $total + $row['qty_per_box']*$row['price'];
				$gross = $gross + $row['gross_weight'];
				$net = $row['qty_per_box'] * GetItemData( $row['item_id'] )->NET_WEIGHT;
				$total_net = $total_net + $net;
				$outerID = GetItemData( $row['item_id'] )->OUTER_BOX;
				$itemCBM = $row['qty_per_box'] * GetOuterBoxData($outerID)->CBM;
				$totalCBM = $totalCBM + $itemCBM;
				$color = GetCustomerData( $row['customer_id'] )->color;
				
				$this->excel->getActiveSheet()->getStyle('L'.$i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB($color);
				
				$exceldata1[] = array('box_no' => $row['box_num'], 'item' => GetItemData( $row['item_id'] )->ITEM_CODE, 'customer_item' => CPIItemdata( $row['cust_pi'], $row['item_id'] )->customer_item_code, 'hs_code' => GetItemData( $row['item_id'] )->HSN_CODE, 'description' => GetItemData( $row['item_id'] )->ITEM_DESC, 'net_weight' => $row['qty_per_box'] * GetItemData( $row['item_id'] )->NET_WEIGHT, 'qty' => $row['qty'], 'unit' => GetItemUnit($itemUnitID), 'purchase_price' => GetItemData( $row['item_id'] )->PURCHASE_PRICE, 'rate' => '$ '.$row['price'], 'fob' => '$ '.$row['qty'] * $row['price'], 'PI' => CPIdata( $row['cust_pi'] )->pi_num, 'category' => $item_cat);
				//$exceldata[] = $row;
			$i++;}
			$start_row = 28;
			$total_row = count($exceldata1);
			
			$x_row = $start_row + $total_row + 1;
			$x1_row = $x_row+1;
			$x2_row = $x1_row+1;
			$x3_row = $x2_row+1;
			$x4_row = $x3_row+1;
			$x5_row = $x4_row+1;
			$x6_row = $x5_row+1;
			
			$this->excel->getActiveSheet()->setCellValue('A27', 'No.of Packages : '.$total_row.' Boxes ');
			$this->excel->getActiveSheet()->getStyle("A13:M".$x_row)->applyFromArray($allborder);
			
			//Fill data 
			$this->excel->getActiveSheet()->fromArray($exceldata1, null, 'A29');
		 
		 	$this->excel->getActiveSheet()->setCellValue('J'.$x_row, 'Total');
		 	$this->excel->getActiveSheet()->getStyle('J'.$x_row)->getFont()->setBold(true);
		 	$this->excel->getActiveSheet()->setCellValue('K'.$x_row, '$ '.$total);
		 	$this->excel->getActiveSheet()->getStyle('K'.$x_row)->getFont()->setBold(true);
		 
		 	$this->excel->getActiveSheet()->setCellValue('A'.$x1_row, 'We declare that this Invoice shows the actual price of goods.');
			$this->excel->getActiveSheet()->setCellValue('A'.$x2_row, 'Described and that all particulars are true and correct.');
			
			$this->excel->getActiveSheet()->setCellValue('A'.$x3_row, 'No.of  Packages : '.$total_row.' Boxes');
			$this->excel->getActiveSheet()->getStyle('A'.$x3_row)->getFont()->setBold(true);
			
			$this->excel->getActiveSheet()->setCellValue('A'.$x4_row, 'Gross weight   : '.$gross.' Kg');
			$this->excel->getActiveSheet()->getStyle('A'.$x4_row)->getFont()->setBold(true);
			
			$this->excel->getActiveSheet()->setCellValue('L'.$x4_row, 'Signature & Date');
		 	$this->excel->getActiveSheet()->getStyle('L'.$x4_row)->getFont()->setBold(true);
			
			$this->excel->getActiveSheet()->setCellValue('A'.$x5_row, 'Net Weight   : '.$total_net.' Kg');
			$this->excel->getActiveSheet()->getStyle('A'.$x5_row)->getFont()->setBold(true);
			
			$this->excel->getActiveSheet()->setCellValue('A'.$x6_row, 'CBM : '.$totalCBM);
			$this->excel->getActiveSheet()->getStyle('A'.$x6_row)->getFont()->setBold(true);
			
			$this->excel->getActiveSheet()->getStyle("A1:M".$x6_row)->applyFromArray($border);
		 
			$this->excel->getActiveSheet()->getStyle('A29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('B29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('C29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 	$this->excel->getActiveSheet()->getStyle('D29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('E29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('F29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 	$this->excel->getActiveSheet()->getStyle('G29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 	$this->excel->getActiveSheet()->getStyle('H29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			// $objDrawing = new PHPExcel_Worksheet_Drawing();
// 			$objDrawing->setName('Customer Signature');
// 			$objDrawing->setDescription('Customer Signature');
// 			//Path to signature .jpg file
// 			$objDrawing->setPath('http://ims.eglogics.website/uploads/item_images/31110.png');
// 			$objDrawing->setOffsetX(8);                     //setOffsetX works properly
// 			$objDrawing->setCoordinates('E38');             //set image to cell E38
// 			$objDrawing->setHeight(75);                     //signature height  
// 			$objDrawing->setWorksheet($this->excel->getActiveSheet());  //save
			
			$filename='Invoice-'.$data['packing_list']->packing_num.'.xls'; //save our workbook as this file name
			header('Content-Type: application/octet-stream'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache
			
			

			//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
			//if you want to save it as .XLSX Excel 2007 format
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
			//force user to download the Excel file without writing it to server's HD
			$objWriter->save('php://output');
	  	}
	  	
	public function Dimension_Excel($id)
		{
			$dimension_box = $this->db->get_where('dimension_box',array('dimension_id'=>$id))->result_array();
			$dimension = $this->db->get_where('dimension',array('id'=>$id))->row();
			
			
			$styleArray = array(
			'font'  => array(
				'size'  => 11,
				'name'  => 'Verdana'
			));
			
			$border = array(
				'borders' => array(
					'outline' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					),
				),
			);
			
			$allborder = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					),
				),
			);
			
			$bgcolor = array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'F2DCDB')
				)
			);
			
    		$this->excel->setActiveSheetIndex(0);
			//name the worksheet
			$this->excel->getActiveSheet()->setTitle('Dimensions');
			//set cell A1 content with some text
			
			$this->excel->getActiveSheet()->mergeCells('A1:C1');
			$this->excel->getActiveSheet()->setCellValue('A1', 'Dimension of Boxes of '.$dimension->packing_no);
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			
			$this->excel->getActiveSheet()->setCellValue('A2', 'Inch');
			$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			
			$this->excel->getActiveSheet()->setCellValue('B2', 'No of Boxes');
			$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
			
			$this->excel->getActiveSheet()->setCellValue('C2', 'CBM');
			$this->excel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
			
			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setName('Logo');
			$objDrawing->setDescription('Logo');
			//Path to signature .jpg file
			$objDrawing->setPath('./admin/img/RIKSHAW_DELIVERY.png');
			$objDrawing->setOffsetX(20);                     //setOffsetX works properly
			$objDrawing->setOffsetY(8);                     //setOffsetX works properly
			$objDrawing->setCoordinates('D2');             //set image to cell E38
			$objDrawing->setHeight(35);                     //signature height
			$objDrawing->setWorksheet($this->excel->getActiveSheet());  //save
			
			$boxes = GetDimensionBox( $id );
			
			$exceldata1="";
			$tboxes="";
			$cbm="";
			
			foreach ($boxes as $row){
				
				$tboxes = $tboxes + $row['no_of_box'];
				$cbm = $cbm + $row['cbm'];
				$exceldata1[] = array('inch' => GetOuterBox( $row['outer_box_id'] ), 'no_of_box' => $row['no_of_box'], 'cbm' => $row['cbm']);
			
			}
			
			$this->excel->getActiveSheet()->fromArray($exceldata1, null, 'A3');
			
			$start_row = 3;
			$total_row = count($exceldata1);
			
			$x_row = $start_row + $total_row;
			 
			$this->excel->getActiveSheet()->getStyle("A1:C".$x_row)->applyFromArray($allborder);
			 
		 	$this->excel->getActiveSheet()->setCellValue('A'.$x_row, 'Total');
		 	$this->excel->getActiveSheet()->getStyle('A'.$x_row)->getFont()->setBold(true);
		 	
		 	$this->excel->getActiveSheet()->setCellValue('B'.$x_row, $tboxes);
		 	$this->excel->getActiveSheet()->getStyle('B'.$x_row)->getFont()->setBold(true);
		 	
		 	$this->excel->getActiveSheet()->setCellValue('C'.$x_row, $cbm);
		 	$this->excel->getActiveSheet()->getStyle('C'.$x_row)->getFont()->setBold(true);
		 
			$filename='Dimension-'.$id.'.xls'; //save our workbook as this file name
			header('Content-Type: application/octet-stream'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache
			
			//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
			//if you want to save it as .XLSX Excel 2007 format
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
			//force user to download the Excel file without writing it to server's HD
			$objWriter->save('php://output');
	  	}
	  	
	 public function CUSTOM_INVOICE_PDF($id)
		{
			$this->load->library('pdf');
			$this->data['title']="Custom Invoice";
			$this->data['packing_list']=$this->db->get_where('packing_list',array('packing_id'=>$id))->row();
		
			$html=$this->load->view('packing/custom_invoice_pdf',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
	 
			$pdfFilePath ="custom-invoice/".$this->data['packing_list']->packing_num.".pdf";

			$pdf = $this->pdf->load();
			
			$pdf->WriteHTML($html,2);
			
			$pdf->Output($pdfFilePath, "D");
		}
		
	// public function CUSTOM_INVOICE_EXCEL($id)
// 		{
// 			$data['packing_list'] = $this->db->get_where('packing_list',array('packing_id'=>$id))->row();
// 			
// 			$this->RedirectToPageWithData('packing/custom_invoice_excel', $data, true);
// 	  	}
	  	
	public function CUSTOM_INVOICE_EXCEL($id)
		{
			
			$data['packing_list'] = $this->db->get_where('packing_list',array('packing_id'=>$id))->row();
			$customer_data = GetCustomerData($data['packing_list']->cust_id);
			$shipping_data = GetPLShippingData($data['packing_list']->packing_id);
			
			
			$styleArray = array(
			'font'  => array(
				'size'  => 11,
				'name'  => 'Verdana'
			));
			
			$border = array(
				'borders' => array(
					'outline' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					),
				),
			);
			
			$allborder = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					),
				),
			);
			
			$bgcolor = array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'F2DCDB')
				)
			);
			
    		$this->excel->getActiveSheet()->getStyle("E2:H12")->applyFromArray($allborder);
    		$this->excel->getActiveSheet()->getStyle("A2:H12")->applyFromArray($bgcolor);
    		$this->excel->getActiveSheet()->getStyle("A2:D7")->applyFromArray($border);
			
			$this->excel->setActiveSheetIndex(0);
			//name the worksheet
			$this->excel->getActiveSheet()->setTitle('Custom Invoice');
			//set cell A1 content with some text
			
			$this->excel->getActiveSheet()->mergeCells('A1:H1');
			$this->excel->getActiveSheet()->setCellValue('A1', 'Invoice');
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$this->excel->getActiveSheet()->setCellValue('A2', 'EXPORTER');
			$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			
			$this->excel->getActiveSheet()->setCellValue('A3', 'RICKSHAW DELIVERY (Est.2004)');
			$this->excel->getActiveSheet()->setCellValue('A4', 'C-31, SECTOR -7 NOIDA');
			$this->excel->getActiveSheet()->setCellValue('A5', 'UP 201301   -INDIA');
			$this->excel->getActiveSheet()->setCellValue('A6', 'PH: 0120-4350340');
			
			$this->excel->getActiveSheet()->mergeCells('E2:F2');
			$this->excel->getActiveSheet()->setCellValue('E2', 'Invoice No.& Date');
			$this->excel->getActiveSheet()->mergeCells('G2:H2');
			$this->excel->getActiveSheet()->mergeCells('G3:H3');
			$this->excel->getActiveSheet()->setCellValue('G2', 'Exporter ref. No.');
			$this->excel->getActiveSheet()->mergeCells('E3:F3');
			$this->excel->getActiveSheet()->setCellValue('E3', $data['packing_list']->packing_num );
			$this->excel->getActiveSheet()->mergeCells('E4:H4');
			$this->excel->getActiveSheet()->mergeCells('E4:E5');
			$this->excel->getActiveSheet()->setCellValue('E4', 'Buyer order & ref.');
			$this->excel->getActiveSheet()->mergeCells('E6:H6');
			$this->excel->getActiveSheet()->setCellValue('E6', 'Other References');
			$this->excel->getActiveSheet()->setCellValue('E7', 'IEC CODE NO. 0504070860');
			$this->excel->getActiveSheet()->mergeCells('E7:G7');
			$this->excel->getActiveSheet()->mergeCells('E8:G8');
			$this->excel->getActiveSheet()->mergeCells('E9:H9');
			$this->excel->getActiveSheet()->mergeCells('E10:H10');
			
			$this->excel->getActiveSheet()->setCellValue('E8', 'TIN NO.09465702772');
			$this->excel->getActiveSheet()->setCellValue('E9', 'Service Tax No. AAHFR1192BSD003');
			$this->excel->getActiveSheet()->setCellValue('E10', 'GSTIN No. 09AAHFR1192B1ZD');
			$this->excel->getActiveSheet()->setCellValue('E11', 'MENT  FOR EXPORT ONLY');
			$this->excel->getActiveSheet()->mergeCells('E11:H11');
			$this->excel->getActiveSheet()->mergeCells('E11:E12');
			$this->excel->getActiveSheet()->getStyle('E11')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('E11')->getFont()->setSize(16);
			
			$this->excel->getActiveSheet()->setCellValue('A13', 'CONSIGNEE:');
			$this->excel->getActiveSheet()->setCellValue('A14', $customer_data->name);
			$this->excel->getActiveSheet()->setCellValue('A15', $customer_data->cust_add);
			$this->excel->getActiveSheet()->setCellValue('A18', $customer_data->phone);
			
			$this->excel->getActiveSheet()->setCellValue('E13', 'Buyer (if other than consignee)');
			$this->excel->getActiveSheet()->setCellValue('E14', 'SAME AS CONSIGNEE');
			$this->excel->getActiveSheet()->setCellValue('E19', 'country of Origin of goods');
			$this->excel->getActiveSheet()->setCellValue('E20', 'India');
			
			$this->excel->getActiveSheet()->setCellValue('A21', 'Pre-carriage by');
			$this->excel->getActiveSheet()->setCellValue('A22', 'BY SEA');
			$this->excel->getActiveSheet()->setCellValue('A23', 'Vassel/Flight No');
			$this->excel->getActiveSheet()->setCellValue('A24', '');
			$this->excel->getActiveSheet()->setCellValue('A25', 'Port of Discharge  ');
			$this->excel->getActiveSheet()->setCellValue('A26', $shipping_data->pod);
			$this->excel->getActiveSheet()->setCellValue('C21', 'Place of Receipt by pre carrier ');
			$this->excel->getActiveSheet()->setCellValue('C22', 'NEW DELHI');
			$this->excel->getActiveSheet()->setCellValue('C23', 'Port of Loading');
			$this->excel->getActiveSheet()->setCellValue('C24', $shipping_data->pol);
			$this->excel->getActiveSheet()->setCellValue('C25', 'Final Destination');
			$this->excel->getActiveSheet()->setCellValue('C26', $shipping_data->fd);
			$this->excel->getActiveSheet()->setCellValue('E21', 'Country of Final Destination');
			$this->excel->getActiveSheet()->setCellValue('E22', 'USA');
			
			
			
			//$this->excel->getActiveSheet()->getStyle('A15:H15')->applyFromArray($border);
			$this->excel->getActiveSheet()->setCellValue('A28', 'Box NO.');
			$this->excel->getActiveSheet()->getStyle('A28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth("10");
			
			$this->excel->getActiveSheet()->setCellValue('B28', 'HS Code');
			$this->excel->getActiveSheet()->getStyle('B28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("10");
			
			$this->excel->getActiveSheet()->setCellValue('C28', 'Description');
			$this->excel->getActiveSheet()->getStyle('C28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("72");
			
			$this->excel->getActiveSheet()->setCellValue('D28', 'Nt. Wt. in Kg');
			$this->excel->getActiveSheet()->getStyle('D28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("9");
			
			$this->excel->getActiveSheet()->setCellValue('E28', 'Qty');
			$this->excel->getActiveSheet()->getStyle('E28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth("9");
			
			$this->excel->getActiveSheet()->setCellValue('F28', 'Unit');
			$this->excel->getActiveSheet()->getStyle('F28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth("10");
			
			$this->excel->getActiveSheet()->setCellValue('G28', 'Rate $');
			$this->excel->getActiveSheet()->getStyle('G28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth("11");
			
			$this->excel->getActiveSheet()->setCellValue('H28', 'FOB  VALUE $');
			$this->excel->getActiveSheet()->getStyle('H28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth("14");
			
			$this->excel->getActiveSheet()->setCellValue('I28', 'Category');
			$this->excel->getActiveSheet()->getStyle('I28')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth("20");
			
			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setName('Logo');
			$objDrawing->setDescription('Logo');
			//Path to signature .jpg file
			$objDrawing->setPath('./admin/img/RIKSHAW_DELIVERY.png');
			$objDrawing->setOffsetX(50);                     //setOffsetX works properly
			$objDrawing->setOffsetY(8);                     //setOffsetX works properly
			$objDrawing->setCoordinates('C2');             //set image to cell E38
			$objDrawing->setHeight(35);                     //signature height
			$objDrawing->setWorksheet($this->excel->getActiveSheet());  //save
			
			//var_dump($data);
			$packingitems = GetPackingItem( $data['packing_list']->packing_id );
			
			//$row_num = count($sup_po_items);
			//$rs = $this->db->get('countries');
			$exceldata="";
			$exceldata1="";
			$total="";
			$gross="";
			$total_net="";
			$totalCBM="";
			
			$i=1;
			foreach ($packingitems as $row){
				//var_dump($row);
				//die();
				$item_img = GetItemData( $row['item_id'] )->ITEM_IMAGE;
				$itemUnitID = GetItemData( $row['item_id'] )->ITEM_UNIT;
				$item_cat = Get_Item_Category_Name( GetItemData( $row['item_id'] )->CATEGORY_NAME );
				
				$total = $total + $row['qty_per_box']*$row['price'];
				$gross = $gross + $row['gross_weight'];
				$net = $row['qty_per_box'] * GetItemData( $row['item_id'] )->NET_WEIGHT;
				$total_net = $total_net + $net;
				$outerID = GetItemData( $row['item_id'] )->OUTER_BOX;
				$itemCBM = $row['qty_per_box'] * GetOuterBoxData($outerID)->CBM;
				$totalCBM = $totalCBM + $itemCBM;
				
				$exceldata1[] = array('box_no' => $row['box_num'], 'hs_code' => GetItemData( $row['item_id'] )->HSN_CODE, 'description' => GetItemData( $row['item_id'] )->ITEM_CUSTOM_DESC, 'net_weight' => $row['qty_per_box'] * GetItemData( $row['item_id'] )->NET_WEIGHT, 'qty' => $row['qty'], 'unit' => GetItemUnit($itemUnitID), 'rate' => '$ '.$row['price'], 'fob' => '$ '.$row['qty'] * $row['price'], 'category' => $item_cat);
				//$exceldata[] = $row;
			$i++;}
			
			$start_row = 28;
			$total_row = count($exceldata1);
			
			$x_row = $start_row + $total_row + 1;
			$x1_row = $x_row+1;
			$x2_row = $x1_row+1;
			$x3_row = $x2_row+1;
			$x4_row = $x3_row+1;
			$x5_row = $x4_row+1;
			$x6_row = $x5_row+1;
			
			$this->excel->getActiveSheet()->setCellValue('A27', 'No.of Packages : '.$total_row.' Boxes ');
			$this->excel->getActiveSheet()->getStyle("A13:H".$x_row)->applyFromArray($allborder);
			
			//Fill data 
			$this->excel->getActiveSheet()->fromArray($exceldata1, null, 'A29');
		 
		 	$this->excel->getActiveSheet()->setCellValue('G'.$x_row, 'Total');
		 	$this->excel->getActiveSheet()->getStyle('G'.$x_row)->getFont()->setBold(true);
		 	$this->excel->getActiveSheet()->setCellValue('H'.$x_row, '$ '.$total);
		 	$this->excel->getActiveSheet()->getStyle('H'.$x_row)->getFont()->setBold(true);
		 
		 	$this->excel->getActiveSheet()->setCellValue('A'.$x1_row, 'We declare that this Invoice shows the actual price of goods.');
			$this->excel->getActiveSheet()->setCellValue('A'.$x2_row, 'Described and that all particulars are true and correct.');
			
			$this->excel->getActiveSheet()->setCellValue('A'.$x3_row, 'No.of  Packages : '.$total_row.' Boxes');
			$this->excel->getActiveSheet()->getStyle('A'.$x3_row)->getFont()->setBold(true);
			
			$this->excel->getActiveSheet()->setCellValue('A'.$x4_row, 'Gross weight   : '.$gross.' Kg');
			$this->excel->getActiveSheet()->getStyle('A'.$x4_row)->getFont()->setBold(true);
			
			$this->excel->getActiveSheet()->setCellValue('G'.$x4_row, 'Signature & Date');
		 	$this->excel->getActiveSheet()->getStyle('G'.$x4_row)->getFont()->setBold(true);
			
			$this->excel->getActiveSheet()->setCellValue('A'.$x5_row, 'Net Weight   : '.$total_net.' Kg');
			$this->excel->getActiveSheet()->getStyle('A'.$x5_row)->getFont()->setBold(true);
			
			$this->excel->getActiveSheet()->setCellValue('A'.$x6_row, 'CBM : '.$totalCBM);
			$this->excel->getActiveSheet()->getStyle('A'.$x6_row)->getFont()->setBold(true);
			
			$this->excel->getActiveSheet()->getStyle("A1:H".$x6_row)->applyFromArray($border);
		 
			$this->excel->getActiveSheet()->getStyle('A29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('B29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('C29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 	$this->excel->getActiveSheet()->getStyle('D29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('E29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('F29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 	$this->excel->getActiveSheet()->getStyle('G29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 	$this->excel->getActiveSheet()->getStyle('H29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			// $objDrawing = new PHPExcel_Worksheet_Drawing();
// 			$objDrawing->setName('Customer Signature');
// 			$objDrawing->setDescription('Customer Signature');
// 			//Path to signature .jpg file
// 			$objDrawing->setPath('http://ims.eglogics.website/uploads/item_images/31110.png');
// 			$objDrawing->setOffsetX(8);                     //setOffsetX works properly
// 			$objDrawing->setCoordinates('E38');             //set image to cell E38
// 			$objDrawing->setHeight(75);                     //signature height  
// 			$objDrawing->setWorksheet($this->excel->getActiveSheet());  //save
			
			$filename='Custom-invoice-'.$data['packing_list']->packing_num.'.xls'; //save our workbook as this file name
			header('Content-Type: application/octet-stream'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache
			
			

			//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
			//if you want to save it as .XLSX Excel 2007 format
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
			//force user to download the Excel file without writing it to server's HD
			$objWriter->save('php://output');
				 
		}
        
	public function RedirectToPageWithData($view,$data)
	{
	if($this->session->userdata('id')!="" and $this->session->userdata('user')!="" and $this->session->userdata('pass')!="")
		{
		$this->load->view($view,$data);
		}
		else
		{
		session_destroy();
		redirect(base_url(), 'refresh');
		}
	}	

	public function add_packing()
	{
		if( !is_UserAllowed('add_pl')){ header('Location: '.base_url().'admin/dashboard'); }
		
		$data['title']='Add Packing';
		$data['items']=GetItem();
		$data['packing_nos']= $this->db->get_where('stock_issue',array('status'=> 1))->result_array();
		$data['PN_from_Packing']= $this->db->get_where('packing_list')->result_array();
		$data['customers']= $this->db->get_where('customer',array('status'=>1, 'oceanic_client'=>0 ))->result_array();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('packing/add_packing',$data);
	}
	
	public function add_dimension()
	{
		if( !is_UserAllowed('add_dim')){ header('Location: '.base_url().'admin/dashboard'); }
		
		$data['title']='Add Dimension';
		$data['packing_nos']= $this->db->get_where('stock_issue',array('status'=> 1))->result_array();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('packing/add_dimension',$data);
	}
	
	public function view_dimension($id)
	{
		$data['title']='View Dimension'; 
		$data['dimension'] = $this->db->get_where('dimension',array('id'=>$id))->row();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('packing/view_dimension',$data);
	}
	
	public function dimension_list()
	{
		if( !is_UserAllowed('all_dim')){ header('Location: '.base_url().'admin/dashboard'); }

		$data['title']='Dimension List';
		$data['dimensions']=$this->db->get_where('dimension', array('status'=>1))->result_array();
		$this->RedirectToPageWithData('packing/all_dimension',$data);
	}
	
	public function view($id)
	{
		$data['title']='View Packing';
		$data['packing'] = $this->db->get_where('packing_list',array('id'=>$id))->row();
		$data['customers']= $this->db->get_where('customer',array('status'=>1, 'oceanic_client'=>1 ))->result_array();
		$data['customerpos']= $this->db->get_where('customer',array('status'=>1))->result_array();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('packing/view',$data);
	}
	
	public function Export_PDF($id)
		{
			$this->load->library('pdf');
			$this->data['title']="Shivam";
			$this->data['invoice']=$this->db->get_where('invoice',array('invoice_id'=>$id))->row();
		
			$html=$this->load->view('invoice/export_pdf',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
	 
			$pdfFilePath ="INVOICE-".GetInvoiceData( $this->data['invoice']->invoice_id )->invoice_num.".pdf";

			$pdf = $this->pdf->load();
			
			$pdf->WriteHTML($html,2);
			
			$pdf->Output($pdfFilePath, "D");
		}
		
	public function ExportEXL($id)
		{
			$data['packing'] = $this->db->get_where('packing_list',array('packing_id'=>$id))->row();
			
			$this->RedirectToPageWithData('packing/export_excel', $data, true);
			
	  	}	
	
	public function GetCPIByCustomer()
	{
	
		$pinos = GetCUSTpino($_POST['cid']);
		
		$html ='<option>Select Customer PI</option>';
		
		foreach($pinos as $pino)
		{	
			$html .='<option value="'.$pino['cust_pi_id'].'">'.$pino['pi_num'].'</option>';
		}
		
		echo $html; 
	}
	
	public function GetItembyCPI()
	{
		$items = $this->db->get_where('customer_pi_item',array('cust_pi_id'=>$_POST['pi_id']))->result_array();
		
		$html ='<option>Select Item</option>';
		
		foreach($items as $item)
		{	
			$html .='<option value="'.$item['item_id'].'">'.GetItemData( $item['item_id'])->ITEM_CODE .'</option>';
		}
		
		echo $html; 
	}
	
	public function GetqtyPriceofPIItem()
	{
		$invoiced_qty = invoiced_quantity($_POST['CPI'], $_POST['ItemID']);
		
		$items = $this->db->get_where('customer_pi_item',array('item_id'=>$_POST['ItemID'], 'cust_pi_id'=>$_POST['CPI']))->row();
		
		$qty = $items->qty; // - $invoiced_qty;
		
		$max_qty = $items->qty - $invoiced_qty;
		
		$data = array( 'qty'=>$qty, 'max'=>$max_qty, 'invoiced'=>$invoiced_qty, 'price'=>$items->price ); 
		
		$html = json_encode($data);
		
		echo $html; 
	}

	function SavePacking()
	{
		$created_by = $this->db->get_where('login',array('id'=>$this->session->userdata('id')))->row('id');
		
		$timestamp = $this->input->post('date');
		$date1 = strtr($timestamp, '/', '-');
		$inv_date = date('Y-m-d', strtotime($date1));
		
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('client','Client',  'required');
	    $this->form_validation->set_rules('date','Date',  'required');
	    $this->form_validation->set_rules('packing_no','Packing No',  'required');
	 	$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if( @$this->input->post('client') != 1 )
			{
				$this->form_validation->set_rules('packing_custpo','Customer',  'required');
			}

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
			{
				$this->add_packing();
			}
		else // passed validation proceed to post success logic
			{

				$data = array(
					'packing_id' => time(),
					'cust_id' => @$this->input->post('packing_custpo'),
					'created_by' => $created_by,
					'date' => @$inv_date,
					'packing_num' => @$this->input->post('packing_no')
				);
	
				$result = $this->Admin_model->SavePacking($data);
		
		if ($result == false) // the information has therefore been successfully saved in the db
			{
				$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
				redirect(base_url().'packing/add_packing');   // or whatever logic needs to occur
			}
		else
			{
				$this->session->set_flashdata('msg','<span class="text-green">New Packing List added successfully.</span>');
				redirect(base_url().'packing/view/'.$result);   // or whatever logic needs to occur	
			}
		
		}
	}
	
	function save_shipping()
	{
		if( !is_UserAllowed('update_shipping_info')){ header('Location: '.base_url().'admin/dashboard'); }
		
		$id = @$this->input->post('id');
		$packing_id = @$this->input->post('p_id');
		
		$data = array(
			'pl_id' => $packing_id,
			'pol' => @$this->input->post('pol'),
			'pod' => @$this->input->post('pod'),
			'fd' => @$this->input->post('fd')
		);
		
		$result = $this->Admin_model->SAVEnUPDATEShipping($data, $packing_id);
		
		if ($result == false) // the information has therefore been successfully saved in the db
			{
				//$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
				redirect(base_url().'packing/view/'.$id);   // or whatever logic needs to occur
			}
		else
			{
				//$this->session->set_flashdata('msg','<span class="text-green">Shipping Information has been updated successfully.</span>');
				redirect(base_url().'packing/view/'.$id);   // or whatever logic needs to occur	
			}
	}
	
	function SaveDimension()
	{
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
	    $this->form_validation->set_rules('packing_no','Packing No',  'required');
	 	$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
			{
				$this->add_dimension();
			}
		else // passed validation proceed to post success logic
			{

				$data = array( 'packing_no' => @$this->input->post('packing_no') );
	
				$result = $this->Admin_model->SaveDimensions($data);
		
		if ($result == false) // the information has therefore been successfully saved in the db
			{
				$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
				redirect(base_url().'packing/add_dimension');   // or whatever logic needs to occur
			}
		else
			{
				$this->session->set_flashdata('msg','<span class="text-green">Added successfully.</span>');
				redirect(base_url().'packing/view_dimension/'.$result);   // or whatever logic needs to occur	
			}
		
		}
	}
	
	function SaveDimensionBox($id)
	{
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
	    $this->form_validation->set_rules('box_size','Outer Box Size',  'required');
	    $this->form_validation->set_rules('no_of_box','Number of Box',  'required');
	    $this->form_validation->set_rules('cbm','CBM',  'required');
	 	$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
			{
				$this->view_dimension($id);
			}
		else // passed validation proceed to post success logic
			{

				$data = array( 
					'dimension_id' => $id,
					'outer_box_id' => @$this->input->post('box_size'), 
					'no_of_box' => @$this->input->post('no_of_box'),
					'cbm' => @$this->input->post('cbm')
				);
	
				$result = $this->Admin_model->SaveDimensionBoxes($data);
		
		if ($result == false) // the information has therefore been successfully saved in the db
			{
				$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
				redirect(base_url().'packing/view_dimension'.$id);   // or whatever logic needs to occur
			}
		else
			{
				$this->session->set_flashdata('msg','<span class="text-green">Added successfully.</span>');
				redirect(base_url().'packing/view_dimension/'.$id);   // or whatever logic needs to occur	
			}
		
		}
	}
	
	function SavePackingItem($id)
	{
		// $max_qty = @$this->input->post('max_qty');
// 		
// 		if($max_qty != 0)
// 			{
// 				$max_qty = $max_qty+1;
// 			}
		
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('cust_pi','Customer PI',  'required');
	    $this->form_validation->set_rules('item','Item',  'required');
	    $this->form_validation->set_rules('qty_per_box','Packed Quantity', 'required');
	 	$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
		{
		$this->view($id);
		}
		else // passed validation proceed to post success logic
		{

			$data = array(
						'packing_id' => @$this->input->post('packing_id'),
						'customer_id' => @$this->input->post('customer'),
						'cust_pi' => @$this->input->post('cust_pi'),
						'item_id' => @$this->input->post('item'),
						'qty' => @$this->input->post('qty'),
						'price' => @$this->input->post('pprunit'),
						'qty_per_box' => @$this->input->post('qty_per_box'),
						'gross_weight' => @$this->input->post('gross_weight'),
						'box_num' => @$this->input->post('box_num'),
						);
	
		$result = $this->Admin_model->SavePackingItem($data);
		
		if ($result == false) // the information has therefore been successfully saved in the db
			{
				$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
				redirect(base_url().'packing/view');   // or whatever logic needs to occur
			}
		else
			{
				$this->session->set_flashdata('msg','<span class="text-green">New Item added successfully.</span>');
				redirect(base_url().'packing/view/'.$id);   // or whatever logic needs to occur	
			}
		
		}
	}

	public function packing_list()
	{
		if( !is_UserAllowed('all_pl')){ header('Location: '.base_url().'admin/dashboard'); }
		
		$data['title']='Invoice List';
		$data['packings']=$this->db->order_by('updated_at', 'ASC')->get_where('packing_list')->result_array();
		$this->RedirectToPageWithData('packing/all_packing',$data);
	}

	public function get_item_by_customerPI()
	{
		$pi_id= $_POST['pi_id'];
		$items = $this->Admin_model->GetItemByCustomerPi($pi_id);
		
		$html ="<option value=''>Select Item</option>";

		foreach($items as $item)
			{
				$html .='<option value="'.$item['item_id'].'">'.GetITEMname( $item['item_id'] ).'</option>';
			}

		echo $html;	
	}
	
	public function update_box_no()
	{
		$value = $_POST['value'];	
		$iid = $_POST['iid'];
		
		$result = $this->Admin_model->update_box_no($iid,$value);
		
		if($result)
			{
				$data = json_encode($value);
				echo $data;
			}
	}
	
	public function edit_packing_item($id)
		{
			if( !is_UserAllowed('update_pl')){ header('Location: '.base_url().'admin/dashboard'); }
			
			$data['title']='Update Packing Item';
			$data['customers']= $this->db->get_where('customer',array('status'=>1, 'oceanic_client'=>1 ))->result_array();
			$data['packing_item']=$this->db->get_where('packing_list_item', array('id'=> $id))->row();
			$this->RedirectToPageWithData('packing/update_packing_item',$data);	
		}
		
	function UpdatePackingItem($id)
	{
		// $max_qty = @$this->input->post('max_qty');
// 		
// 		if($max_qty != 0)
// 			{
// 				$max_qty = $max_qty+1;
// 			}
	
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('cust_pi','Customer PI',  'required');
	    $this->form_validation->set_rules('item','Item',  'required');
	    $this->form_validation->set_rules('qty_per_box','Packed Quantity', 'required');
	 	$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
		{
		$this->edit_packing_item($id);
		}
		else // passed validation proceed to post success logic
		{

			$data = array(
						'packing_id' => @$this->input->post('packing_id'),
						'customer_id' => @$this->input->post('customer'),
						'cust_pi' => @$this->input->post('cust_pi'),
						'item_id' => @$this->input->post('item'),
						'qty' => @$this->input->post('qty'),
						'price' => @$this->input->post('pprunit'),
						'qty_per_box' => @$this->input->post('qty_per_box'),
						'gross_weight' => @$this->input->post('gross_weight'),
						'box_num' => @$this->input->post('box_num'),
						);
	
		$result = $this->Admin_model->UpdatePackingItem($id, $data);
		
		if ($result == false) // the information has therefore been successfully saved in the db
			{
				$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
				redirect(base_url().'packing/edit_packing_item');   // or whatever logic needs to occur
			}
		else
			{
				$this->session->set_flashdata('msg','<span class="text-green">New Item added successfully.</span>');
				redirect(base_url().'packing/edit_packing_item/'.$result);   // or whatever logic needs to occur	
			}
		
		}
	}
	
	function remove_dimension()
	{
		$id = $_POST['rowid'];
		
		$dimension_id = $this->db->get_where('dimension_box',array('ID'=> $id))->row('dimension_id');
		//$item_id = $this->db->get_where('dimension',array('id'=> $dimension_id))->row('id');
	
		$result = $this->Admin_model->RemoveDimensionBox($id);
		
		if($result)
			{
				$this->session->set_flashdata('msg','<span class="text-green">Row Removed successfully.</span>');
				redirect( base_url().'packing/view_dimension/'.$dimension_id );   // or whatever logic needs to occur	
			}
		else
			{
				$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
				redirect( base_url().'packing/view_dimension/');   // or whatever logic needs to occur		
		
			}
	}
	
	public function approve_packing()
	{
		if( !is_UserAllowed('approve_packing_list')){ header('Location: '.base_url().'admin/dashboard'); }
		
		$uid = $this->db->get_where('login',array('id'=>$this->session->userdata('id')))->row('id');
		
		$pid = $_POST['pid'];	
		
		$result = $this->Admin_model->ApprovePacking($pid, $uid);
		
		if($result)
			{
				$data = json_encode($result);
				echo $data;
			}
	}

}
