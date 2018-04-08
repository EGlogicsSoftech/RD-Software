<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Supplier extends CI_Controller {

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

	public function view($id)
	{
		$data['title']='View Supplier';
		$data['supplier']=$this->db->get_where('supplier',array('ID'=>$id))->row();
		$this->RedirectToPageWithData('supplier/view_supplier',$data);
	}

	public function add()
	{
		if( !is_UserAllowed('add_supplier')){ header('Location: '.base_url().'admin/dashboard'); }

		$data['title']='Add Supplier';
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('supplier/add_supplier',$data);
	}

	public function Export_PDF($id)
		{
			$this->load->library('pdf');
			$this->data['title']="Shivam";
			$this->data['supplier_po']=$this->db->get_where('supplier_po',array('ID'=>$id))->row();
			//$html = 'aasdf';
			$html=$this->load->view('supplier/export_pdf',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.

			$pdfFilePath ="SPO-".$this->data['supplier_po']->po_num.".pdf";

			$pdf = $this->pdf->load();

			$pdf->WriteHTML($html,2);

			$pdf->Output($pdfFilePath, "D");
		}

	// public function Export_EXCEL($id)
// 		{
// 			$data['supplier_po'] = $this->db->get_where('supplier_po',array('ID'=>$id))->row();
//
// 			$this->RedirectToPageWithData('supplier/export_excel', $data, true);
// 	  	}

	public function Export_EXCEL($id)
		{

			$data['supplier_po'] = $this->db->get_where('supplier_po',array('ID'=>$id))->row();

			$sup_data = GetSupplierData($data['supplier_po']->sup_id);

			$FormatedDate = date("F jS, Y", strtotime($data['supplier_po']->created_at));

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

    		$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray($styleArray);

    		$this->excel->getActiveSheet()->getStyle("A1:H6")->applyFromArray($border);
    		$this->excel->getActiveSheet()->getStyle("A7:H14")->applyFromArray($border);

			$this->excel->setActiveSheetIndex(0);
			//name the worksheet
			$this->excel->getActiveSheet()->setTitle('Purchase Order');
			//set cell A1 content with some text
			$this->excel->getActiveSheet()->setCellValue('A1', 'RICKSHAW DELIVERY (Est.2004)');
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

			$this->excel->getActiveSheet()->setCellValue('A3', 'C - 31, Sector - 7, Noida - 201 301 U P');
			$this->excel->getActiveSheet()->setCellValue('A4', 'PH :0120 - 4350340 / 4260511');
			$this->excel->getActiveSheet()->setCellValue('A5', 'E-mail: purchasem@rickshawdelivery.com / operationm@rickshaedelivery.com / oceanic@oceaniclink.com');
			$this->excel->getActiveSheet()->setCellValue('A6', 'GSTIN NO.  09AAHFR1192B1ZD');
			$this->excel->getActiveSheet()->getStyle('A6')->getFont()->setSize(14);
			$this->excel->getActiveSheet()->getStyle('A6')->getFont()->setBold(true);
			//$this->excel->getActiveSheet()->getStyle('A6')->getFont()->setName('Arial');

			//$this->excel->getActiveSheet()->setCellValue('B8', '25% Advance and Rest before delivery of Goods');

			$this->excel->getActiveSheet()->mergeCells('E1:H1');
			$this->excel->getActiveSheet()->setCellValue('E1', 'Purchase Order');
			$this->excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(16);
			$this->excel->getActiveSheet()->getStyle('E1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FABF8F');

			// $this->excel->getActiveSheet()->setCellValue('D6', 'Proforma');
// 			$this->excel->getActiveSheet()->getStyle('D6')->getFont()->setBold(true);
// 			$this->excel->getActiveSheet()->getStyle('D6')->getFont()->setSize(18);

			$this->excel->getActiveSheet()->mergeCells('E3:F3');
			$this->excel->getActiveSheet()->mergeCells('E4:F4');
			$this->excel->getActiveSheet()->setCellValue('E3', 'Date');
			$this->excel->getActiveSheet()->setCellValue('E4', $FormatedDate);
			$this->excel->getActiveSheet()->getStyle('E3')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('E3:F3')->applyFromArray($border);

			$this->excel->getActiveSheet()->mergeCells('G3:H3');
			$this->excel->getActiveSheet()->mergeCells('G4:H4');
			$this->excel->getActiveSheet()->setCellValue('G3', 'P.O.NO.');
			$this->excel->getActiveSheet()->setCellValue('G4', $data['supplier_po']->po_num);
			$this->excel->getActiveSheet()->getStyle('G3')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('G3:H3')->applyFromArray($border);
			$this->excel->getActiveSheet()->getStyle('E4:F4')->applyFromArray($border);
			$this->excel->getActiveSheet()->getStyle('G4:H4')->applyFromArray($border);

			$this->excel->getActiveSheet()->setCellValue('A8', $sup_data->supplier_name);
			$this->excel->getActiveSheet()->setCellValue('A9', $sup_data->full_add);
			$this->excel->getActiveSheet()->setCellValue('A10', $sup_data->mobile);
			$this->excel->getActiveSheet()->setCellValue('A13', 'We are pleased to place the order as detailed below.  Supply as per the terms &');
			$this->excel->getActiveSheet()->setCellValue('A14', 'condition mentioned below the order :-');


			// $this->excel->getActiveSheet()->setCellValue('F8', 'Email:');
// 			$this->excel->getActiveSheet()->getStyle('F8')->getFont()->setBold(true);
// 			$this->excel->getActiveSheet()->setCellValue('F10', 'General Instruction/Packaging');
// 			$this->excel->getActiveSheet()->getStyle('F10')->getFont()->setBold(true);
// 			$this->excel->getActiveSheet()->setCellValue('F11', 'Made In India Label & Marketing Card');
// 			$this->excel->getActiveSheet()->getStyle('F11')->getFont()->setBold(true);

			$this->excel->getActiveSheet()->getStyle('A15:H15')->applyFromArray($border);
			$this->excel->getActiveSheet()->setCellValue('A15', 'Sr #');
			$this->excel->getActiveSheet()->getStyle('A15')->getFont()->setBold(true);

			$this->excel->getActiveSheet()->setCellValue('B15', 'Picture');
			$this->excel->getActiveSheet()->getStyle('B15')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("15");

			$this->excel->getActiveSheet()->setCellValue('C15', 'Item#');
			$this->excel->getActiveSheet()->getStyle('C15')->getFont()->setBold(true);

			$this->excel->getActiveSheet()->setCellValue('D15', 'Description');
			$this->excel->getActiveSheet()->getStyle('D15')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("20");

			$this->excel->getActiveSheet()->setCellValue('E15', 'Qty');
			$this->excel->getActiveSheet()->getStyle('E15')->getFont()->setBold(true);

			$this->excel->getActiveSheet()->setCellValue('F15', 'Unit');
			$this->excel->getActiveSheet()->getStyle('F15')->getFont()->setBold(true);

			$this->excel->getActiveSheet()->setCellValue('G15', 'Rate');
			$this->excel->getActiveSheet()->getStyle('G15')->getFont()->setBold(true);

			$this->excel->getActiveSheet()->setCellValue('H15', 'Amount');
			$this->excel->getActiveSheet()->getStyle('H15')->getFont()->setBold(true);

			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setName('Logo');
			$objDrawing->setDescription('Logo');
			//Path to signature .jpg file
			$objDrawing->setPath('./admin/img/RIKSHAW_DELIVERY.png');
			$objDrawing->setOffsetX(10);                     //setOffsetX works properly
			$objDrawing->setOffsetY(8);                     //setOffsetX works properly
			$objDrawing->setCoordinates('D1');             //set image to cell E38
			$objDrawing->setHeight(35);                     //signature height
			$objDrawing->setWorksheet($this->excel->getActiveSheet());  //save

			//merge cell A1 until C1
			//$this->excel->getActiveSheet()->mergeCells('A1:C1');
			//set aligment to center for that merged cell (A1 to C1)
			//$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			//make the font become bold

		   // 	for($col = ord('A'); $col <= ord('H'); $col++){ //set column dimension $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
//
// 				//change the font size
// 				$this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(11);
// 				//$this->excel->getActiveSheet()->getStyle(chr($col))->applyFromArray($border);
// 				$this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// 			}

			//var_dump($data);
			$sup_po_items = GetSupPOItem( $data['supplier_po']->sup_po_id );

			//$row_num = count($sup_po_items);
			//$rs = $this->db->get('countries');
			$exceldata="";
			$exceldata1="";
			$total="";

			$i=1;
			$j=16;
			foreach ($sup_po_items as $row){

				$item_img = GetItemData( $row['item_id'] )->ITEM_IMAGE;
				$itemUnitID = GetItemData( $row['item_id'] )->ITEM_UNIT;

				$total = $total + $row['qty']*$row['price'];

				$exceldata1[] = array('sno' => $i, 'picture' => '', 'item' => GetItemData( $row['item_id'] )->ITEM_CODE,'description' => GetItemData( $row['item_id'] )->ITEM_DESC,'qty' => $row['qty'], 'unit' => GetItemUnit($itemUnitID), 'rate' => $row['price'], 'amount' => $row['qty']*$row['price']);

				//$exceldata[] = $row;

				$this->excel->getActiveSheet()->getRowDimension($j)->setRowHeight(95);
				$this->excel->getActiveSheet()->getStyle('B'.$j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$objDrawing = new PHPExcel_Worksheet_Drawing();
				$objDrawing->setName('Customer Signature');
				$objDrawing->setDescription('Customer Signature');
				//Path to signature .jpg file
				$img_path = './uploads/item_images/'.$item_img;

				if(file_exists($img_path))
					{
						$img = $img_path;
					}
				else
					{
						$img = './uploads/no-image-available.jpg';
					}

				$objDrawing->setPath($img);
				$objDrawing->setOffsetX(8);                     //setOffsetX works properly
				$objDrawing->setOffsetY(8);                     //setOffsetX works properly
				$objDrawing->setCoordinates('B'.$j);             //set image to cell E38
				$objDrawing->setHeight(75);                     //signature height
				$objDrawing->setWorksheet($this->excel->getActiveSheet());  //saveRIKSHAW_DELIVERY

			$i++; $j++; }

			$start_row = 16;
			$total_row = count($exceldata1);

			$x_row = $start_row + $total_row + 1;
			$x1_row = $x_row+1;
			$x2_row = $x1_row+1;
			$x3_row = $x2_row+1;
			$x4_row = $x3_row+1;
			$x5_row = $x4_row+1;
			$x6_row = $x5_row+2;
			$x7_row = $x6_row+3;
			$x8_row = $x7_row+2;

			//Fill data
			$this->excel->getActiveSheet()->fromArray($exceldata1, null, 'A16');

			$this->excel->getActiveSheet()->getStyle('A15:H'.$x_row)->getAlignment()->setWrapText(true);
			$this->excel->getActiveSheet()->getStyle('A15:H'.$x_row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('A15:H'.$x_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle("A15:H".$x_row)->applyFromArray($allborder);

		 	$this->excel->getActiveSheet()->setCellValue('A'.$x1_row, 'Terms & Conditions');
		 	$this->excel->getActiveSheet()->getStyle('A'.$x1_row)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->setCellValue('A'.$x2_row, 'The above material shall be sent to our Noida Office at C 31 Sector 7 Noida 201 301 ');
			$this->excel->getActiveSheet()->setCellValue('A'.$x3_row, '# All the materials must be delivered in one lot only. No part consignment will be accepted');
			$this->excel->getActiveSheet()->setCellValue('A'.$x4_row, '# If the delivery is made after the due date, _____% will be deducted against late supply.');
			$this->excel->getActiveSheet()->setCellValue('A'.$x5_row, '# Please mention our Order # and date  on your challan/bill without fail. ');

			$this->excel->getActiveSheet()->setCellValue('G'.$x_row, 'Total');
			$this->excel->getActiveSheet()->getStyle('G'.$x_row)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->setCellValue('H'.$x_row, $total);
			$this->excel->getActiveSheet()->getStyle('H'.$x_row)->getFont()->setBold(true);


		 	$this->excel->getActiveSheet()->setCellValue('F'.$x6_row, 'For RICKSHAW DELIVERY');
		 	$this->excel->getActiveSheet()->getStyle('F'.$x6_row)->getFont()->setBold(true);

		 	$this->excel->getActiveSheet()->setCellValue('A'.$x7_row, 'Suppliers Signature ___________________');
		 	$this->excel->getActiveSheet()->getStyle('A'.$x7_row)->getFont()->setBold(true);

		 	$this->excel->getActiveSheet()->setCellValue('F'.$x7_row, 'Authorised Signatory');
		 	$this->excel->getActiveSheet()->getStyle('F'.$x7_row)->getFont()->setBold(true);

		 	$this->excel->getActiveSheet()->setCellValue('A'.$x8_row, 'Return the second copy of this order  duly signed and stamped.');
		 	$this->excel->getActiveSheet()->getStyle('A'.$x8_row)->getFont()->setBold(true);

		 	$this->excel->getActiveSheet()->getStyle("A1:H".$x8_row)->applyFromArray($border);

			$this->excel->getActiveSheet()->getStyle('A16:H'.$x_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			// $objDrawing = new PHPExcel_Worksheet_Drawing();
// 			$objDrawing->setName('Customer Signature');
// 			$objDrawing->setDescription('Customer Signature');
// 			//Path to signature .jpg file
// 			$objDrawing->setPath('http://ims.eglogics.website/uploads/item_images/31110.png');
// 			$objDrawing->setOffsetX(8);                     //setOffsetX works properly
// 			$objDrawing->setCoordinates('E38');             //set image to cell E38
// 			$objDrawing->setHeight(75);                     //signature height
// 			$objDrawing->setWorksheet($this->excel->getActiveSheet());  //save

			$filename='SPI_'.$data['supplier_po']->po_num.'.xls'; //save our workbook as this file name
			header('Content-Type: application/octet-stream'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache



			//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
			//if you want to save it as .XLSX Excel 2007 format
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
			//force user to download the Excel file without writing it to server's HD
			$objWriter->save('php://output');

		}

	function save_supplier()
	{
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('supplier_name','name',  'required');
		$this->form_validation->set_rules('supplier_code','code',  'required');
		$this->form_validation->set_rules('gstin_no','GSTIN No',  'required');
		$this->form_validation->set_rules('pan_no','Pan No',  'required');
		//$this->form_validation->set_rules('email','email',  'required|valid_email');
		$this->form_validation->set_rules('mobile','mobile',  'required|regex_match[/^[0-9]{10}$/]');
		//$this->form_validation->set_rules('phone','phone',  'required|regex_match[/^[0-9]{10}$/]');
		$this->form_validation->set_rules('contact_person','contact person',  'required|alpha');
		//$this->form_validation->set_rules('supplier_desc','description',  'required');
		$this->form_validation->set_rules('state','State',  'required');
	    $this->form_validation->set_rules('full_add','Full Address',  'required');
		$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

	if($this->form_validation->run() == FALSE) // validation hasn't been passed
		{
		$this->add();
		}
		else // passed validation proceed to post success logic
		{
		// build array for the model
		$SupplierData = array(
						'supplier_name' => @$this->input->post('supplier_name'),
						'supplier_code' => @$this->input->post('supplier_code'),
						'gstin_no' => @$this->input->post('gstin_no'),
						'pan_no' => @$this->input->post('pan_no'),
						'email' => @$this->input->post('email'),
						'mobile' => @$this->input->post('mobile'),
						'phone' => @$this->input->post('phone'),
						'contact_person' => @$this->input->post('contact_person'),
						'full_add' => @$this->input->post('full_add'),
						'state' => @$this->input->post('state'),
						'supplier_desc' => @$this->input->post('supplier_desc'),
						'status' => '1'
					);

		// run insert model to write data to db
		$result = $this->Admin_model->SaveSupplier($SupplierData);
		if ($result == false) // the information has therefore been successfully saved in the db
			{
			$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
			redirect(base_url().'supplier/add');   // or whatever logic needs to occur
			}
			else
			{
			$this->session->set_flashdata('msg','<span class="text-green">New supplier added successfully.</span>');
			redirect(base_url().'supplier/add');   // or whatever logic needs to occur
			}
		}
	}

	public function manage_supplier($sid)
	{
		if( !is_UserAllowed('update_supplier')){ header('Location: '.base_url().'admin/dashboard'); }

		$data['title']='Manage Supplier';
		$data['page_heading']='Manage Supplier';
		$data['form_heading']='Update Supplier Information';
		$data['msg']=$this->session->flashdata('msg');
		$data['suppliers']=$this->db->get_where('supplier',array('id'=>$sid))->row();
		$this->RedirectToPageWithData('supplier/manage_supplier',$data);
	}

	function edit_supplier($sid)
	{
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('supplier_name','name',  'required');
		$this->form_validation->set_rules('supplier_code','code',  'required');
		$this->form_validation->set_rules('gstin_no','GSTIN No',  'required');
		$this->form_validation->set_rules('pan_no','Pan No',  'required');
		//$this->form_validation->set_rules('email','email',  'required|valid_email');
		$this->form_validation->set_rules('mobile','mobile',  'required|regex_match[/^[0-9]{10}$/]');
		//$this->form_validation->set_rules('phone','phone',  'required|regex_match[/^[0-9]{10}$/]');
		$this->form_validation->set_rules('contact_person','contact person',  'required|alpha');
		//$this->form_validation->set_rules('supplier_desc','description',  'required');
		$this->form_validation->set_rules('state','State',  'required');
	    $this->form_validation->set_rules('full_add','Full Address',  'required');
		$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
		{
		$this->manage_supplier($sid);
		}
		else // passed validation proceed to post success logic
		{
		// build array for the model
		$SupplierData = array(
			'supplier_name' => @$this->input->post('supplier_name'),
			'supplier_code' => @$this->input->post('supplier_code'),
			'gstin_no' => @$this->input->post('gstin_no'),
			'pan_no' => @$this->input->post('pan_no'),
			'email' => @$this->input->post('email'),
			'mobile' => @$this->input->post('mobile'),
			'phone' => @$this->input->post('phone'),
			'contact_person' => @$this->input->post('contact_person'),
			'full_add' => @$this->input->post('full_add'),
			'state' => @$this->input->post('state'),
			'supplier_desc' => @$this->input->post('supplier_desc'),
			'status' => '1'
		);

		// run insert model to write data to db
		$result=$this->Admin_model->EditSupplier($sid, $SupplierData);
		if ($result == false) // the information has therefore been successfully saved in the db
			{
			$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
			redirect(base_url().'supplier/manage_supplier/'.$result );   // or whatever logic needs to occur
			}
			else
			{
			$this->session->set_flashdata('msg','<span class="text-green">Supplier information updated successfully.</span>');
			redirect(base_url().'supplier/manage_supplier/'.$result );   // or whatever logic needs to occur
			}
		}
	}

	public function add_supplier_po()
	{
		if( !is_UserAllowed('add_spo')){ header('Location: '.base_url().'admin/dashboard'); }

		$data['title']='Add Supplier P.O';
		$data['suppliers'] = GetAllSupplier();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('supplier/add_supplier_po',$data);
	}

	public function view_supplier_po($id)
	{
		$data['title']='View Supplier PO';
		$data['supplier_po']=$this->db->get_where('supplier_po',array('ID'=>$id))->row();
		$data['sup_po_items']= $this->db->get_where('supplier_po_item',array('id'=>$id))->result_array();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('supplier/view_supplier_po',$data);
	}

	public function edit_supplier_po($id)
	{
		$data['title']='Manage Supplier Po';
		$data['page_heading']='Manage Supplier PO';
		$data['form_heading']='Update Supplier PO Information';
		$data['suppliers'] = GetAllSupplier();
		$data['supplier_po'] = $this->db->get_where('supplier_po',array('id'=>$id))->row();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('supplier/edit_supplier_po',$data);
	}

	function UpdateSupplierPO($id)
	{
		//$supplier_po_items = @$this->input->post('supplier_po_item');
		$timestamp = $this->input->post('delivery_date');
		$date1 = strtr($timestamp, '/', '-');
		$sup_date = date('Y-m-d', strtotime($date1));

		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('supplier_name','Supplier Name',  'required');
		$this->form_validation->set_rules('po','PO',  'required');
		$this->form_validation->set_rules('delivery_date','Date',  'required');
		$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
			{
				$this->edit_supplier_po($id);
			}
		else // passed validation proceed to post success logic
			{
				$POData = array(
					'sup_po_id' => time(),
					'sup_id' => @$this->input->post('supplier_name'),
					'po_num' => @$this->input->post('po'),
					'delivery_date' => @$sup_date
				);

				$result=$this->Admin_model->UpdateSupplierPO($id, $POData);

				if($result)
					{
						$this->session->set_flashdata('msg','<span class="text-green">New supplier P.O added successfully.</span>');
						redirect(base_url().'supplier/view_supplier_po/'.$result);
					}
				else
					{
						$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
 						redirect(base_url().'supplier/add_supplier_po');
					}
			}
	}

	function remove_sub_item()
	{
		$id = $_POST['rowid'];

		$parent_item_id = $this->db->get_where('supplier_po_item',array('ID'=> $id))->row('sup_po_id');
		$item_id = $this->db->get_where('supplier_po',array('sup_po_id'=> $parent_item_id))->row('id');

		$result = $this->Admin_model->RemoveSupplierSubItem($id);

		if($result)
			{
				$this->session->set_flashdata('msg','<span class="text-green">New Sub Item added successfully.</span>');
				redirect( base_url().'supplier/view_supplier_po/'.$item_id );   // or whatever logic needs to occur
			}
		else
			{
				$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
				redirect( base_url().'supplier/view_supplier_po/');   // or whatever logic needs to occur

			}
	}

	function SaveSupplierPO()
	{
		$supplier_po_items = @$this->input->post('supplier_po_item');

		$created_by = $this->db->get_where('login',array('id'=>$this->session->userdata('id')))->row('id');

		$timestamp = $this->input->post('delivery_date');
		$date1 = strtr($timestamp, '/', '-');
		$sup_date = date('Y-m-d', strtotime($date1));

		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('supplier_name','Supplier Name',  'required');
		$this->form_validation->set_rules('po','PO#',  'required|is_unique[supplier_po.po_num]');
		$this->form_validation->set_rules('delivery_date','Date',  'required');
		$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
			{
				$this->add_supplier_po();
			}
		else // passed validation proceed to post success logic
			{
				$POData = array(
					'sup_po_id' => time(),
					'sup_id' => @$this->input->post('supplier_name'),
					'po_num' => @$this->input->post('po'),
					'delivery_date' => @$sup_date,
					'created_by' => $created_by
				);

				$result=$this->Admin_model->SaveSupplierPO($POData);

				if($result)
					{
						$this->session->set_flashdata('msg','<span class="text-green">New supplier P.O added successfully.</span>');
						redirect(base_url().'supplier/view_supplier_po/'.$result);
					}
				else
					{
						$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
 						redirect(base_url().'supplier/add_supplier_po');
					}
			}
	}

	public function SaveItemToSuplier($id)
	{
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('item','Item Code',  'required');
		$this->form_validation->set_rules('ordered_qty','Ordered Qty',  'required');
		//$this->form_validation->set_rules('prc_epr_unt','Price Per Unit',  'required');
		$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
			{
				$this->view_supplier_po($id);
			}
		else // passed validation proceed to post success logic
			{
				$POItemData = array(
					'sup_po_id' => @$this->input->post('sup_po_id'),
					'item_id' => @$this->input->post('item'),
					'qty' => @$this->input->post('ordered_qty'),
					'price' => @$this->input->post('prc_epr_unt')
				);

				$result = $this->Admin_model->SaveSupplierPOItem($POItemData);
				$sup_po_id = $this->db->get_where('supplier_po_item',array('ID'=> $result))->row('sup_po_id');
				$suppo_id = $this->db->get_where('supplier_po',array('sup_po_id'=> $sup_po_id))->row('id');

				if($result)
					{
						$this->session->set_flashdata('msg','<span class="text-green">New supplier P.O added successfully.</span>');
						redirect(base_url().'supplier/view_supplier_po/'.$suppo_id);
					}
				else
					{
						$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
 						redirect(base_url().'supplier/view_supplier_po/'.$suppo_id);
					}
			}
	}

	public function all_list()
	{
		if( !is_UserAllowed('all_supplier')){ header('Location: '.base_url().'admin/dashboard'); }

		$data['title']='All Suppliers';
		$data['suppliers']=$this->db->get_where('supplier',array('status'=>'1'))->result_array();
		$this->RedirectToPageWithData('supplier/all_supplier',$data);
	}

	public function all_list_po()
	{
		if( !is_UserAllowed('all_spo')){ header('Location: '.base_url().'admin/dashboard'); }

		$data['title']='All Suppliers P.O';
		$data['supplier_pos']=$this->db->get_where('supplier_po')->result_array();
		$this->RedirectToPageWithData('supplier/all_supplier_po',$data);
	}

	public function getsup()
	{
		$sup_id= $_POST['sup_id'];
		$sup_items = $this->Admin_model->GetItemBySupplier($sup_id);

		$html ="<option value=''>Select Item</option>";

		foreach($sup_items as $sup_item)
			{
				$html .='<option value="'.$sup_item['ID'].'">'.$sup_item['ITEM_NAME'].'</option>';
			}

		echo $html;
	}

	// Get Suplier Purchase Price OnChange Select
	public function GetPricebyItemID()
	{
		$item_id = $_POST['item_id'];

		$Pprice = $this->db->get_where('item',array('ITEM_ID'=>$item_id, 'STATUS'=>1))->row('PURCHASE_PRICE');

		echo $Pprice;
	}

	public function getStock()
	{
		$item_id= $_POST['item_id'];
		$stocks = $this->Admin_model->GetItemByStockEntry($item_id);
		echo $stocks;
	}

	public function updateQTY()
	{
		$price = $_POST['price'];
		$qty = $_POST['qty'];
		$row_id = $_POST['row_id'];

		$amount = $price * $qty;

		$result = $this->Admin_model->UpdateSupplierSubItem($row_id, $qty, $amount);

		if($result)
			{
				echo $amount;
			}
	}

	public function approveSPO($sid)
		{
			if( !is_UserAllowed('approve_spo')){ header('Location: '.base_url().'admin/dashboard'); }

			$uid = $this->db->get_where('login',array('id'=>$this->session->userdata('id')))->row('id');

			$result = $this->Admin_model->ApproveSPO($sid, $uid);

			if ($result == false)
					{
						$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
						redirect(base_url().'supplier/view_supplier_po/'.$result);   // or whatever logic needs to occur
					}
				else
					{
						$this->session->set_flashdata('msg','<span class="text-green">Item added successfully.</span>');
						redirect(base_url().'supplier/view_supplier_po/'.$result);   // or whatever logic needs to occur
					}

		}

}
