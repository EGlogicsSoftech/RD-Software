<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller {

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

	public function add()
	{
		if( !is_UserAllowed('add_customer')){ header('Location: '.base_url().'admin/dashboard'); }

		$data['title']='Add Customer';
		$data['customers']=$this->db->get_where('customer',array('status'=>1))->result_array();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('customer/add_customer',$data);
	}

	public function view($id)
	{
		$data['title']='View Customer';
		$data['customer']=$this->db->get_where('customer',array('id'=>$id))->row();
		$this->RedirectToPageWithData('customer/view_customer',$data);
	}

	public function Export_PDF($id)
		{
			$this->load->library('pdf');
			$this->data['title']="CPI";
			$this->data['customer_pi']=$this->db->get_where('customer_pi',array('cust_pi_id'=>$id))->row();

			$html=$this->load->view('customer/export_pdf',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.

	 		$pdfFilePath ="CPI-".$this->data['customer_pi']->pi_num.".pdf";

			$pdf = $this->pdf->load();

			$pdf->WriteHTML($html,2);

			$pdf->Output($pdfFilePath, "D");
		}

	// public function Export_EXCEL($id)
// 		{
// 			$data['customer_pi'] = $this->db->get_where('customer_pi',array('cust_pi_id'=>$id))->row();
//
// 			$this->RedirectToPageWithData('customer/export_excel', $data, true);
// 	  	}

	public function Export_EXCEL($id)
		{
			$data['customer_pi'] = $this->db->get_where('customer_pi',array('cust_pi_id'=>$id))->row();

			$customer_data = GetCustomerData($data['customer_pi']->cust_id);

			$FormatedDate = date("F jS, Y", strtotime($data['customer_pi']->created_at));

			$styleArray = array(
				'font'  => array(
					'size'  => 11,
					'name'  => 'Verdana'
				)
			);

			$allborder = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					),
				),
			);

    		$objPHPExcel = new PHPExcel();

    		$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray($styleArray);

			$this->excel->setActiveSheetIndex(0);
			//name the worksheet
			$this->excel->getActiveSheet()->setTitle('Proforma Invoice');
			//set cell A1 content with some text
			$this->excel->getActiveSheet()->setCellValue('A1', 'RICKSHAW DELIVERY (Est.2004)');
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

			$this->excel->getActiveSheet()->setCellValue('A2', 'C - 31, Sector - 7, Noida - 201 301 U P');
			$this->excel->getActiveSheet()->setCellValue('A3', 'PH :0120 - 4350340 / 4260511');
			$this->excel->getActiveSheet()->setCellValue('A4', 'E-mail: marketing@ rickshawdelivery.com / oceanic@oceaniclink.com');
			$this->excel->getActiveSheet()->setCellValue('A5', 'EPCH Membership No. EPCH/REG/27736/2008-09');
			$this->excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
			//$this->excel->getActiveSheet()->getStyle('A5')->getFont()->setName('Verdana');

			$this->excel->getActiveSheet()->setCellValue('B8', '25% Advance and Rest before delivery of Goods');

			$this->excel->getActiveSheet()->setCellValue('F5', 'PROFORMA INVOICE #');
			$this->excel->getActiveSheet()->getStyle('F5')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->setCellValue('G5', $data['customer_pi']->pi_num);

			$this->excel->getActiveSheet()->setCellValue('D6', 'Proforma');
			$this->excel->getActiveSheet()->getStyle('D6')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('D6')->getFont()->setSize(18);

			$this->excel->getActiveSheet()->setCellValue('F6', 'DATED:');
			$this->excel->getActiveSheet()->getStyle('F6')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->setCellValue('G6', $FormatedDate);
			$this->excel->getActiveSheet()->getStyle('G6')->getFont()->setBold(true);

			$this->excel->getActiveSheet()->setCellValue('F8', 'Email:');
			$this->excel->getActiveSheet()->getStyle('F8')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->setCellValue('G8', $customer_data->email);
			$this->excel->getActiveSheet()->setCellValue('F10', 'General Instruction/Packaging');
			$this->excel->getActiveSheet()->getStyle('F10')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->setCellValue('F11', 'Made In India Label & Marketing Card');
			$this->excel->getActiveSheet()->getStyle('F11')->getFont()->setBold(true);

			$this->excel->getActiveSheet()->setCellValue('A14', 'Item#');
			$this->excel->getActiveSheet()->getStyle('A14')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth("20");
			$this->excel->getActiveSheet()->setCellValue('B14', 'Pics');
			$this->excel->getActiveSheet()->getStyle('B14')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("15");
			$this->excel->getActiveSheet()->setCellValue('C14', 'Descriptions');
			$this->excel->getActiveSheet()->getStyle('C14')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("40");
			$this->excel->getActiveSheet()->setCellValue('D14', 'Units');
			$this->excel->getActiveSheet()->getStyle('D14')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->setCellValue('E14', 'Order Qty');
			$this->excel->getActiveSheet()->getStyle('E14')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->setCellValue('F14', 'Revised prices');
			$this->excel->getActiveSheet()->getStyle('F14')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->setCellValue('G14', 'Total Value USD');
			$this->excel->getActiveSheet()->getStyle('G14')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->setCellValue('H14', 'CBM');
			$this->excel->getActiveSheet()->getStyle('H14')->getFont()->setBold(true);


			$this->excel->getActiveSheet()->setCellValue('A7', 'BUYER NAME:');
			$this->excel->getActiveSheet()->setCellValue('B7', $customer_data->name);
			$this->excel->getActiveSheet()->setCellValue('A8', 'PAYMENT TERMS: ');
			$this->excel->getActiveSheet()->setCellValue('A9', 'PRICE TERMS: ');
			$this->excel->getActiveSheet()->setCellValue('B9', $customer_data->shipping_term);
			$this->excel->getActiveSheet()->setCellValue('A10', 'AMOUNT');
			$this->excel->getActiveSheet()->setCellValue('A11', 'DEPOSIT');
			$this->excel->getActiveSheet()->setCellValue('A12', 'CURRENCY:');
			$this->excel->getActiveSheet()->setCellValue('B12', '$ USD');

			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setName('Logo');
			$objDrawing->setDescription('Logo');
			//Path to signature .jpg file
			$objDrawing->setPath('./admin/img/RIKSHAW_DELIVERY.png');
			$objDrawing->setOffsetX(100);                     //setOffsetX works properly
			$objDrawing->setOffsetY(8);                     //setOffsetX works properly
			$objDrawing->setCoordinates('C1');             //set image to cell E38
			$objDrawing->setHeight(35);                     //signature height
			$objDrawing->setWorksheet($this->excel->getActiveSheet());  //save

			//merge cell A1 until C1
			//$this->excel->getActiveSheet()->mergeCells('A1:C1');
			//set aligment to center for that merged cell (A1 to C1)
			//$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			//make the font become bold


		   	for($col = ord('A'); $col <= ord('C'); $col++){ //set column dimension $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
				//change the font size
				$this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);

				$this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}

			//var_dump($data);
			$cust_pi_items = GetCustPIItem( $data['customer_pi']->cust_pi_id );
			//$rs = $this->db->get('countries');
			$exceldata="";
			$exceldata1="";
			$amount="";
			$i=15;
			$totalCBM = 0;

			foreach ($cust_pi_items as $row){
				//var_dump($row);

				$item_img = GetItemData( $row['item_id'] )->ITEM_IMAGE;
				$itemUnitID = GetItemData( $row['item_id'] )->ITEM_UNIT;
				$amount = $amount + $row['qty']*$row['price'];

				$QtyMstrBox = GetItemData( $row['item_id'] )->OUTER_BOX_QTY;
				$outerBoxCBM = GetOuterBoxData( GetItemData( $row['item_id'] )->OUTER_BOX )->CBM;
				$outerBoxQty = ($QtyMstrBox == 0 ? 0 : ceil($row['qty'] / $QtyMstrBox));
				$totalCBM += $outerBoxQty * $outerBoxCBM;

				//$item_img = GetItemData( $row['item_id'] )->ITEM_IMAGE;

				$exceldata1[] = array('item_id' => GetItemData( $row['item_id'] )->ITEM_CODE, 'item_pic' => '', 'item_desc' => GetItemData( $row['item_id'] )->ITEM_DESC, 'unit' => GetItemUnit($itemUnitID), 'order_qty' => $row['qty'], 'price' => $row['price'], 'value' => $row['qty']*$row['price'], 'cbm' => ($QtyMstrBox == 0 ? 0 : ceil($row['qty'] / $QtyMstrBox) * $outerBoxCBM));
				//$exceldata[] = $row;

				$this->excel->getActiveSheet()->getRowDimension($i)->setRowHeight(95);
				//$this->excel->getActiveSheet()->getStyle('C'.$i)->getAlignment()->setWrapText(true);

				$this->excel->getActiveSheet()->getStyle('B'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

				$objDrawing = new PHPExcel_Worksheet_Drawing();
				$objDrawing->setName('Customer Signature');
				$objDrawing->setDescription('Customer Signature');
				//Path to signature .jpg file
				$objDrawing->setPath('./uploads/item_images/'.$item_img);
				$objDrawing->setOffsetX(8);                     //setOffsetX works properly
				$objDrawing->setOffsetY(8);                     //setOffsetX works properly
				$objDrawing->setCoordinates('B'.$i);             //set image to cell E38
				$objDrawing->setHeight(75);                     //signature height
				$objDrawing->setWorksheet($this->excel->getActiveSheet());  //saveRIKSHAW_DELIVERY

			$i++; }

			$this->excel->getActiveSheet()->setCellValue('B10', $amount);

			$start_row = 15;
			$total_row = count($exceldata1);

			$x_row = $start_row + $total_row;

			$this->excel->getActiveSheet()->getStyle('A15:G'.$x_row)->getAlignment()->setWrapText(true);
			$this->excel->getActiveSheet()->getStyle('A15:G'.$x_row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('A15:G'.$x_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('F'.$x_row, 'Total');
			$this->excel->getActiveSheet()->setCellValue('G'.$x_row, '$ '.$amount);
			$this->excel->getActiveSheet()->setCellValue('H'.$x_row, $totalCBM);
			$this->excel->getActiveSheet()->getStyle("A14:H".$x_row)->applyFromArray($allborder);

			//Fill data
			$this->excel->getActiveSheet()->fromArray($exceldata1, null, 'A15');

			$this->excel->getActiveSheet()->getStyle('A15')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('B15')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('C15')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 	$this->excel->getActiveSheet()->getStyle('D15')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('E15')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('F15')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 	$this->excel->getActiveSheet()->getStyle('G15')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			// $objDrawing = new PHPExcel_Worksheet_Drawing();
// 			$objDrawing->setName('Customer Signature');
// 			$objDrawing->setDescription('Customer Signature');
// 			//Path to signature .jpg file
// 			$objDrawing->setPath('./admin/img/avatar.png');
// 			$objDrawing->setOffsetX(8);                     //setOffsetX works properly
// 			$objDrawing->setCoordinates('E38');             //set image to cell E38
// 			$objDrawing->setHeight(75);                     //signature height
// 			$objDrawing->setWorksheet($this->excel->getActiveSheet());  //save

			$filename='CPI_'.$data['customer_pi']->pi_num.'.xls'; //save our workbook as this file name
			header('Content-Type: application/octet-stream'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache



			//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
			//if you want to save it as .XLSX Excel 2007 format
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
			//force user to download the Excel file without writing it to server's HD
			$objWriter->save('php://output');

		}

	function SaveCustomer()
	{
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('customer_name','Name',  'required');
		$this->form_validation->set_rules('customer_code','Code',  'required');
		$this->form_validation->set_rules('email','Email',  'required|valid_email');
		$this->form_validation->set_rules('phone','Phone',  'required|regex_match[/^[0-9]{10}$/]');
		$this->form_validation->set_rules('contact_person','Contact Person',  'required');
		$this->form_validation->set_rules('color','Color',  'required');
		$this->form_validation->set_rules('cust_add','Shipping Address',  'required');
		$this->form_validation->set_rules('billing_add','Billing Address',  'required');
		$this->form_validation->set_rules('shipping_term','Shipping Term',  'required');
	    $this->form_validation->set_rules('customer_desc','Description',  'required');
		$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

	if($this->form_validation->run() == FALSE) // validation hasn't been passed
		{
			$this->add();
		}
		else // passed validation proceed to post success logic
		{
		// build array for the model
		$CustomerData = array(
			'customer_id' => time(),
			'oceanic_client' => @$this->input->post('oceanic_client'),
			'name' => @$this->input->post('customer_name'),
			'code' => @$this->input->post('customer_code'),
			'email' => @$this->input->post('email'),
			'phone' => @$this->input->post('phone'),
			'contact_person' => @$this->input->post('contact_person'),
			'color' => @$this->input->post('color'),
			'cust_add' => @$this->input->post('cust_add'),
			'billing_add' => @$this->input->post('billing_add'),
			'shipping_term' => @$this->input->post('shipping_term'),
			'Description' => @$this->input->post('customer_desc'),
			'status' => '1');

		// run insert model to write data to db
		$result=$this->Admin_model->SaveCustomer($CustomerData);
		if ($result == false) // the information has therefore been successfully saved in the db
			{
			$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
			redirect(base_url().'customer/add');   // or whatever logic needs to occur
			}
			else
			{
			$this->session->set_flashdata('msg','<span class="text-green">New customer added successfully.</span>');
			redirect(base_url().'customer/add');   // or whatever logic needs to occur
			}
		}
	}

	public function all_list()
	{
		$data['title']='All Customers';
		$data['customers']=$this->db->get_where('customer',array('status'=>'1'))->result_array();
		$this->RedirectToPageWithData('customer/all_customer',$data);
	}

	public function manage_customer($cid)
	{
		if( !is_UserAllowed('update_customer')){ header('Location: '.base_url().'admin/dashboard'); }

		$data['title']='Manage Customer';
		$data['page_heading']='Manage Customer';
		$data['form_heading']='Update Customer Information';
		$data['msg']=$this->session->flashdata('msg');
		$data['customers']=$this->db->get_where('customer',array('id'=>$cid))->row();
		$this->RedirectToPageWithData('customer/manage_customer',$data);
	}

	function edit_customer($cid)
	{
		$cdata = $this->db->get_where('customer',array('id'=> $cid))->row();

		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('customer_name','Name',  'required');
		$this->form_validation->set_rules('customer_code','Code',  'required');
		$this->form_validation->set_rules('email','Email',  'required');
		$this->form_validation->set_rules('phone','Phone',  'required|numeric');
		$this->form_validation->set_rules('contact_person','Contact Person',  'required');
		$this->form_validation->set_rules('cust_add','Shiping Address',  'required');
		$this->form_validation->set_rules('billing_add','Billing Address',  'required');
		$this->form_validation->set_rules('shipping_term','Shiping Term',  'required');
	    $this->form_validation->set_rules('customer_desc','Description',  'required');
		$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
		{
		$this->manage_customer($cid);
		}
		else // passed validation proceed to post success logic
		{
		// build array for the model
		$CustomerData = array(
						'customer_id' => $cdata->customer_id,
						'oceanic_client' => @$this->input->post('oceanic_client'),
						'name' => @$this->input->post('customer_name'),
						'code' => @$this->input->post('customer_code'),
						'email' => @$this->input->post('email'),
						'phone' => @$this->input->post('phone'),
						'contact_person' => @$this->input->post('contact_person'),
						'color' => @$this->input->post('color'),
						'cust_add' => @$this->input->post('cust_add'),
						'billing_add' => @$this->input->post('billing_add'),
						'shipping_term' => @$this->input->post('shipping_term'),
						'Description' => @$this->input->post('customer_desc'),
						'status' => '1',
						'date' => $cdata->date
					);

		$result=$this->Admin_model->EditCustomer($cid, $CustomerData);

		if ($result == false) // the information has therefore been successfully saved in the db
			{
			$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
			redirect(base_url().'customer/all_list/');   // or whatever logic needs to occur
			}
			else
			{
			$this->session->set_flashdata('msg','<span class="text-green">Customer information updated successfully.</span>');
			redirect(base_url().'customer/all_list/');   // or whatever logic needs to occur
			}
		}
	}

	public function add_customer_pi()
	{
		if( !is_UserAllowed('add_cpi')){ header('Location: '.base_url().'admin/dashboard'); }

		$data['title']='Add Customer P.I';
		$data['customers'] = GetAllCustomer();
		$data['items']= GetItem();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('customer/add_customer_pi',$data);
	}

	public function Upadte_customer_pi_item($id)
	{
		if( !is_UserAllowed('update_cpi_item')){ header('Location: '.base_url().'admin/dashboard'); }

		$data['title']='Update Customer P.I Item';
		$data['items']= GetItem();
		$data['CustomerPiItems'] = $this->db->get_where('customer_pi_item',array('id'=>$id))->row();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('customer/update_customer_pi_item',$data);
	}

	public function UpdateItemToCustomer($id)
	{
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('item','Item Code',  'required');
		$this->form_validation->set_rules('req_qty','Required Qty',  'required');
		$this->form_validation->set_rules('prc_epr_unt','Price Per Unit',  'required');
		$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
			{
				$this->Upadte_customer_pi_item($id);
			}
		else // passed validation proceed to post success logic
			{
				$data = array(
					'item_id' => @$this->input->post('item'),
					'qty' => @$this->input->post('req_qty'),
					'price' => @$this->input->post('prc_epr_unt'),
					'customer_item_code' => @$this->input->post('customer_item_code'),
					'customer_item_barcode' => @$this->input->post('customer_item_barcode'),
					'Packaging_instructions' => @$this->input->post('packg_inst')
				);

				$result = $this->Admin_model->UpdateCustomerPIItem($id, $data);

				$cust_pi_id = $this->db->get_where('customer_pi_item',array('id'=> $result))->row('cust_pi_id');
				$custt_id = $this->db->get_where('customer_pi',array('cust_pi_id'=> $cust_pi_id))->row('id');

				if($result)
					{
						$this->session->set_flashdata('msg','<span class="text-green">Item added successfully.</span>');
						redirect(base_url().'customer/view_customer_pi/'.$custt_id);
					}
				else
					{
						$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
 						redirect(base_url().'customer/view_customer_pi/'.$custt_id);
					}
			}
	}

	public function edit_customer_pi($id)
	{
		$data['title']='View Customer';
		$data['customers']=$this->db->get_where('customer',array('status'=>1))->result_array();
		$data['customer_pi']=$this->db->get_where('customer_pi',array('id'=>$id))->row();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('customer/update_customer_pi',$data);
	}

	function SaveCustomerPI()
	{
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('customer_name','Customer Name',  'required');
		$this->form_validation->set_rules('pi','PI#',  'required|is_unique[customer_pi.pi_num]');
		$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
			{
				$this->add_customer_pi();
			}
		else // passed validation proceed to post success logic
			{
				$uid = $this->db->get_where('login',array('id'=>$this->session->userdata('id')))->row('id');

				$PIData = array(
					'cust_pi_id' => time(),
					'cust_id' => @$this->input->post('customer_name'),
					'pi_num' => @$this->input->post('pi'),
					'created_by' => $uid,
				);

				$result = $this->Admin_model->SaveCustomerPI($PIData);

				if ( $result ) // the information has therefore been successfully saved in the db
					{
						$this->session->set_flashdata('msg','<span class="text-green">New customer P.I added successfully.</span>');
						redirect(base_url().'customer/view_customer_pi/'.$result);
					}
				else
					{
						$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
						redirect(base_url().'supplier/add_customer_pi');
					}
			}
	}
	
		
	// function UpdateCustomerPI($cpi_id)
// 	{
// 		$cpi_data = CPIdata($cpi_id);
// 
// 		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
// 		$this->form_validation->set_rules('customer_name','Customer Name',  'required');
// 		$this->form_validation->set_rules('pi','PI',  'required|callback_hasSamePI['.$cpi_id.']');
// 		$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');
// 
// 		if($this->form_validation->run() == FALSE) // validation hasn't been passed
// 			{
// 				$this->edit_customer_pi();
// 			}
// 		else // passed validation proceed to post success logic
// 			{
// 
// 				$PIData = array(
// 					'cust_pi_id' => $cpi_data->cust_pi_id,
// 					'cust_id' => @$this->input->post('customer_name'),
// 					'pi_num' => @$this->input->post('pi'),
// 					'created_at' => $cpi_data->created_at
// 				);
// 
// 				$result = $this->Admin_model->UpdateCustomerPI($cpi_id, $PIData);
// 
// 				if ( $result ) // the information has therefore been successfully saved in the db
// 					{
// 						$this->session->set_flashdata('msg','<span class="text-green">New customer P.I added successfully.</span>');
// 						redirect(base_url().'customer/view_customer_pi/'.$result);
// 					}
// 				else
// 					{
// 						$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
// 						redirect(base_url().'supplier/update_customer_pi');
// 					}
// 			}
// 	}

	public function all_list_pi()
	{
		$data['title']='All Customer P.I';
		$data['customer_pis']=$this->db->order_by('created_at', 'DESC')->get_where('customer_pi')->result_array();
		$this->RedirectToPageWithData('customer/all_customer_pi',$data);
	}

	public function view_customer_pi($id)
	{
		$data['title']='View Customer PI';
		$data['customer_pi']= $this->db->get_where('customer_pi',array('ID'=>$id))->row();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('customer/view_customer_pi',$data);
	}

	public function SaveItemToCustomer($id)
	{
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('item','Item Code',  'required');
		$this->form_validation->set_rules('req_qty','Required Qty',  'required');
		$this->form_validation->set_rules('prc_epr_unt','Price Per Unit',  'required');
		$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
			{
				$this->view_customer_pi($id);
			}
		else // passed validation proceed to post success logic
			{
				$data = array(
					'cust_pi_id' => @$this->input->post('cust_pi_id'),
					'item_id' => @$this->input->post('item'),
					'qty' => @$this->input->post('req_qty'),
					'price' => @$this->input->post('prc_epr_unt'),
					'customer_item_code' => @$this->input->post('customer_item_code'),
					'customer_item_barcode' => @$this->input->post('customer_item_barcode'),
					'Packaging_instructions' => @$this->input->post('packg_inst')
				);

				$result = $this->Admin_model->SaveCustomerPIItem($data);

				$cust_pi_id = $this->db->get_where('customer_pi_item',array('ID'=> $result))->row('cust_pi_id');
				$custt_id = $this->db->get_where('customer_pi',array('cust_pi_id'=> $cust_pi_id))->row('id');

				if($result)
					{
						$this->session->set_flashdata('msg','<span class="text-green">Item added successfully.</span>');
						redirect(base_url().'customer/view_customer_pi/'.$custt_id);
					}
				else
					{
						$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
 						redirect(base_url().'customer/view_customer_pi/'.$custt_id);
					}
			}
	}

	public function approveCPI($id)
		{
			if( !is_UserAllowed('approve_cpi')){ header('Location: '.base_url().'admin/dashboard'); }

			$uid = $this->db->get_where('login',array('id'=>$this->session->userdata('id')))->row('id');

			$result = $this->Admin_model->ApproveCPI($id, $uid);

			if ($result == false)
					{
						//$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
						redirect(base_url().'customer/all_list_pi/');   // or whatever logic needs to occur
					}
				else
					{
						//$this->session->set_flashdata('msg','<span class="text-green">Item added successfully.</span>');
						redirect(base_url().'customer/all_list_pi/');   // or whatever logic needs to occur
					}

		}

	public function getStock()
	{
		$item_id= $_POST['item_id'];
		$stocks = $this->Admin_model->GetItemByStockEntry($item_id);
		echo $stocks;
	}

	/* By Ankit
	Find data from the previous cpi of the same customer for reference
	*/
	public function getPreviousCPIdata()
	{
			$cust_id= $_POST['cust_id'];
			$item_id= $_POST['item_id'];

			// FIND ALL PI for this customer i.e. $cust_id order by lastest CPI
			$cpi_list = $this->db->order_by('id', 'desc')->get_where('customer_pi',array('cust_id' => $cust_id))->result_array();

			$data = array('ppq'=>0,'pp'=>0,'customer_item_code'=>'','customer_item_barcode'=>'','packaging'=>'');
			$item_unit_id = GetItemData($item_id)->ITEM_UNIT;
			$data['desc'] =  GetItemData($item_id)->ITEM_DESC;
			$data['ppc'] =  GetItemData($item_id)->PURCHASE_PRICE_CODE;
			$data['item_unit'] = GetItemUnit($item_unit_id);
			foreach($cpi_list as $cpi)
			{
					// FIND This item i.e. $item_id in each CPI , IF Item is found , record the data and break the loop
					$cpi_item_data = 	$this->db->get_where('customer_pi_item',array('cust_pi_id'=> $cpi['cust_pi_id'], 'item_id' => $item_id))->result_array();
					if($cpi_item_data)
					{
							$data['ppq'] = $cpi_item_data[0]['qty'];
							$data['pp'] = $cpi_item_data[0]['price'];
							$data['customer_item_code'] = $cpi_item_data[0]['customer_item_code'];
							$data['customer_item_barcode'] = $cpi_item_data[0]['customer_item_barcode'];
							$data['packaging'] = $cpi_item_data[0]['Packaging_instructions'];
							break;
					}
			}
			//var_dump($cpi_item_data);
			echo json_encode($data);
			//echo $this->db->last_query();
	}

	function remove_sub_item()
	{
		$id = $_POST['rowid'];

		$cust_pi_id = $this->db->get_where('customer_pi_item',array('ID'=> $id))->row('cust_pi_id');
		$custt_id = $this->db->get_where('customer_pi',array('cust_pi_id'=> $cust_pi_id))->row('id');

		$result = $this->Admin_model->RemoveCPIItem($id);

		if ($result == false)
			{
				$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
				redirect(base_url().'customer/view_customer_pi/'.$custt_id);   // or whatever logic needs to occur
			}
		else
			{
				$this->session->set_flashdata('msg','<span class="text-green">Item added successfully.</span>');
				redirect(base_url().'customer/view_customer_pi/'.$custt_id);   // or whatever logic needs to occur
			}
	}

}
