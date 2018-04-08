<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stock extends CI_Controller {
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
	
	public function Export_PDF($id)
		{
			$this->load->library('pdf');
			$this->data['title']="Stock Issuance List";
			$this->data['stock_issue']=$this->db->get_where('stock_issue',array('id'=>$id))->row();
		
			$html=$this->load->view('stock/export_issue_pdf',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
	 
			$pdfFilePath ="SI-".$this->data['stock_issue']->ref_id.".pdf";

			$pdf = $this->pdf->load();
			
			$pdf->WriteHTML($html,2);
			
			$pdf->Output($pdfFilePath, "D");
		}
		
	// public function Export_EXCEL($id)
// 		{
// 			$data['stock_issue'] = $this->db->get_where('stock_issue',array('id'=>$id))->row();
// 			
// 			$this->RedirectToPageWithData('stock/export_issue_excel', $data, true);
// 	  	}
	  	
	public function Export_EXCEL($id)
		{
		
			$data['stock_issue'] = $this->db->get_where('stock_issue',array('ID'=>$id))->row();
			
			$FormatedDate = date("F jS, Y", strtotime($data['stock_issue']->Issued_date));
			
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
			
    		$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray($styleArray);
		
			$this->excel->setActiveSheetIndex(0);
			//name the worksheet
			$this->excel->getActiveSheet()->setTitle('Stock Issuance ');
			//set cell A1 content with some text
			$this->excel->getActiveSheet()->mergeCells('A2:G2');
			$this->excel->getActiveSheet()->setCellValue('A2', 'Stock Issuance ');
			$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$this->excel->getActiveSheet()->setCellValue('A4', 'Ref;  (Inv# or PI#)');
			$this->excel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->setCellValue('B4', $data['stock_issue']->ref_id);
			
			$this->excel->getActiveSheet()->setCellValue('A5', 'ISSUE Date: ');
			$this->excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->setCellValue('B5', $FormatedDate);
			
			$this->excel->getActiveSheet()->setCellValue('F4', 'Issue TO:');
			$this->excel->getActiveSheet()->getStyle('F4')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->setCellValue('G4', $data['stock_issue']->issued_to);
			
			$this->excel->getActiveSheet()->setCellValue('F5', 'Issued By:');
			$this->excel->getActiveSheet()->getStyle('F5')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->setCellValue('G5', $data['stock_issue']->issued_by);
			
			$this->excel->getActiveSheet()->setCellValue('A7', 'RD Stock Box#');
			$this->excel->getActiveSheet()->getStyle('A7')->getFont()->setBold(true);
			
			$this->excel->getActiveSheet()->setCellValue('B7', 'ITEM #');
			$this->excel->getActiveSheet()->getStyle('B7')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("15");
			
			$this->excel->getActiveSheet()->setCellValue('C7', 'Image');
			$this->excel->getActiveSheet()->getStyle('C7')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth("15");
			
			$this->excel->getActiveSheet()->setCellValue('D7', 'Description');
			$this->excel->getActiveSheet()->getStyle('D7')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("20");
			
			$this->excel->getActiveSheet()->setCellValue('E7', 'Size');
			$this->excel->getActiveSheet()->getStyle('E7')->getFont()->setBold(true);
			
			$this->excel->getActiveSheet()->setCellValue('F7', 'To be Issue Qty');
			$this->excel->getActiveSheet()->getStyle('F7')->getFont()->setBold(true);
			
			$this->excel->getActiveSheet()->setCellValue('G7', 'Unit');
			$this->excel->getActiveSheet()->getStyle('G7')->getFont()->setBold(true);
			
		   	for($col = ord('A'); $col <= ord('G'); $col++){ //set column dimension $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
				
				//change the font size
				$this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(11);
				//$this->excel->getActiveSheet()->getStyle(chr($col))->applyFromArray($border); 
				$this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			
			//var_dump($data);
			$StockIssueItems = GetStockIssueItems( $data['stock_issue']->stock_issue_id );
			
			$exceldata="";
			$exceldata1="";
			
			$i=1;
			$j=8;
			
			foreach ($StockIssueItems as $row){
				$item_img = GetItemData( $row['item_id'] )->ITEM_IMAGE;
				$itemUnitID = GetItemData( $row['item_id'] )->ITEM_UNIT;
				
				if($row['issued'] != 0 ){ $issued = 'Issued'; }else{ $issued = 'Pending'; }
				
				$exceldata1[] = array('stock_box' => $row['box_id'], 'item' => GetItemData( $row['item_id'] )->ITEM_CODE, 'picture' => '', 'description' => GetItemData( $row['item_id'] )->ITEM_DESC, 'size' => $row['qty'], 'issued_qty' => $issued, 'unit' => GetItemUnit($itemUnitID),);
			
				$this->excel->getActiveSheet()->getRowDimension($j)->setRowHeight(95);
				$this->excel->getActiveSheet()->getStyle('C'.$j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				
				$objDrawing = new PHPExcel_Worksheet_Drawing();
				$objDrawing->setName('Customer Signature');
				$objDrawing->setDescription('Customer Signature');
				//Path to signature .jpg file
				$objDrawing->setPath('./uploads/item_images/'.$item_img);
				$objDrawing->setOffsetX(8);                     //setOffsetX works properly
				$objDrawing->setOffsetY(8);                     //setOffsetX works properly
				$objDrawing->setCoordinates('C'.$j);             //set image to cell E38
				$objDrawing->setHeight(75);                     //signature height  
				$objDrawing->setWorksheet($this->excel->getActiveSheet());  //saveRIKSHAW_DELIVERY
			
			$i++; $j++; }
				
			$start_row = 8;
			$total_row = count($exceldata1);
			
			$x_row = $start_row + $total_row + 1;	
			
				
			//Fill data 
			$this->excel->getActiveSheet()->fromArray($exceldata1, null, 'A8');
			
			$this->excel->getActiveSheet()->getStyle('A7:H'.$x_row)->getAlignment()->setWrapText(true);
			$this->excel->getActiveSheet()->getStyle('A7:H'.$x_row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('A7:H'.$x_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 
			$this->excel->getActiveSheet()->getStyle('A8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('B8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('C8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 	$this->excel->getActiveSheet()->getStyle('D8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('E8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('F8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 	$this->excel->getActiveSheet()->getStyle('G8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$filename='Stock-Issuance-'.$id.'.xls'; //save our workbook as this file name
			header('Content-Type: application/octet-stream'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache
			
			//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
			//if you want to save it as .XLSX Excel 2007 format
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
			//force user to download the Excel file without writing it to server's HD
			$objWriter->save('php://output');
				 
		}

	public function add_entry()
	{
		if( !is_UserAllowed('add_se')){ header('Location: '.base_url().'admin/dashboard'); }
	
		$data['title']='Add Stock Entry';
		$data['items']=GetItem();
		$data['grns']= $this->db->get_where('grn',array('status'=>1))->result_array();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('stock/add_stock_entry',$data);
	}
	
	public function edit_entry($id)
	{
		$data['title']='Edit Stock Entry';
		//$data['items']=GetItem();
		$data['grns']= GetGRNs();
		$data['stocks'] = $this->db->get_where('stock_entry', array( 'id'=>$id ))->row();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('stock/edit_stock_entry',$data);
	}

	function SaveStockEntry()
	{
		$grnno = @$this->input->post('grn_number');
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('grn_number','GRN No',  'required');
	    $this->form_validation->set_rules('bx_num','Box No',  'required');
	    $this->form_validation->set_rules('item','Item',  'required');
	    $this->form_validation->set_rules('qty','Quantity',  'required');
	 	$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
			{
				$this->add_entry();
			}
		else // passed validation proceed to post success logic
			{
				$EntryData = array(
					'grn_row_id' => @$this->input->post('grn_number'),
					'box_num' => @$this->input->post('bx_num'),
					'item_id' => @$this->input->post('item'),
					'qty' => @$this->input->post('qty'),
				);	
	
				$result=$this->Admin_model->SaveEntry($EntryData);
				
				if ($result == false) // the information has therefore been successfully saved in the db
					{
						$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
						redirect(base_url().'stock/add_entry');   // or whatever logic needs to occur
					}
				else
					{
						$this->session->set_flashdata('msg','<span class="text-green">New entry added successfully.</span>');
						redirect(base_url().'stock/add_entry/?grn='.$grnno);   // or whatever logic needs to occur	
					}
			}
	}
	
	function UpdateStockEntry($id)
	{
		$data = GetStockEntry($id);
		
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('grn_number','GRN No',  'required');
	    $this->form_validation->set_rules('bx_num','Box No',  'required');
	    $this->form_validation->set_rules('item','Item',  'required');
	    $this->form_validation->set_rules('qty','Quantity',  'required');
	 	$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
			{
				$this->edit_entry($id);
			}
		else // passed validation proceed to post success logic
			{
				$EntryData = array(
					'grn_row_id' => $data->grn_row_id,
					'box_num' => @$this->input->post('bx_num'),
					'item_id' => @$this->input->post('item'),
					'qty' => @$this->input->post('qty'),
					'updated_date' => $data->updated_at
				);	
	
				$result = $this->Admin_model->UpdateEntry($id, $EntryData);
				
				if ($result == false) // the information has therefore been successfully saved in the db
					{
						$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
						redirect(base_url().'stock/edit_entry/'.$result);   // or whatever logic needs to occur
					}
				else
					{
						$this->session->set_flashdata('msg','<span class="text-green">New entry added successfully.</span>');
						redirect(base_url().'stock/edit_entry/'.$result);   // or whatever logic needs to occur	
					}
			}
	}
	
	public function view_stock_issue($id)
	{
		$data['title']='View Stock Issuance';
		$data['stock_issuance']=$this->db->get_where('stock_issue', array( 'id'=>$id ))->row();
		$data['customers']=$this->db->get_where('customer',array('status'=>1, 'oceanic_client'=>1))->result_array();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('stock/view_stock_issuance',$data);
	}
	
	public function check_stock()
	{
		$data['title']='Check Stock';
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('stock/check_stock',$data);
	}
	
	public function view_check_stock($id)
	{
		$data['title']='View Check Stock';
		$data['item_id'] = $id;
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('stock/view_check_stock',$data);
	}

	public function all_entry_list()
	{
		if( !is_UserAllowed('all_se')){ header('Location: '.base_url().'admin/dashboard'); }

		$data['title']='All Stock Entries';
		$data['stock_entries']=$this->db->get_where('stock_entry', array('status'=>1))->result_array();
		$this->RedirectToPageWithData('stock/all_stock_entry',$data);
	}

	public function add_issuance()
	{
		if( !is_UserAllowed('add_si')){ header('Location: '.base_url().'admin/dashboard'); }
		
		$data['title']='Add Stock Issue';
		$data['grns']=GetGRNs();
		$data['customers']=$this->db->get_where('customer',array('status'=>1, 'oceanic_client'=>0))->result_array();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('stock/add_stock_issuance',$data);
	}

	public function get_boxno_ajax()
	{
		$item_id= $_POST['item_id'];
		$item_ids = $this->Admin_model->GetBoxnoByItem($item_id);

		$html ="<option value=''>Select Box Number</option>";

		foreach($item_ids as $item_id)
			{
				$html .='<option value="'.$item_id['box_num'].'">'.$item_id['box_num'].'</option>';
			}
		echo $html;	
	}

	public function get_alloted_qty_ajax()
	{
		$item_id = $_POST['item_id'];
		$box_id = $_POST['box_id'];
		
		$data = CheckStockbyItemGroupbyBox($item_id, $box_id);
		
		$qty = $data->SUMA - $data->SUMB;
		
		//$qty = $this->Admin_model->GetAllotedQTYByBox($item_id, $box_id);
			
		$html ="<option value=''>Select Alloted Quantity</option>";
 
		for($i=1; $i<=$qty; $i++)
			{
				$html .='<option value="'.$i.'">'.$i.'</option>';
			}

		echo $html;	
	}
	
	public function ItemQtyGRN()
	{
		$itemID= $_POST['itemID'];
		$grnID= $_POST['grnID'];
		
		$grnData = $this->db->get_where('grn_item',array('grn_row_id'=>$grnID, 'item_id'=>$itemID))->row('accepted_qty');
		
		//$Rqty = $grnData->itemID;
		
		$qty = $grnData - GRNtoSTOCK($grnID, $itemID);
		
		//if($qty){ $qty=$qty; }else{ $qty=0; }
			
		$html ="<option value=''>Select Quantity</option>";
 		
 		if( $qty ) :
 			
			for($i=0; $i<=$qty; $i++)
				{
					$html .='<option value="'.$i.'">'.$i.'</option>';
				}
		else :
		
			$html .='<option value="">Quantity is Empty</option>';
			
		endif;
		
		echo $html;	
	}

	public function get_item_by_grnno_ajax()
	{
		$item_ids = $this->db->get_where('grn_item',array('grn_row_id'=>$_POST['grn_id']))->result_array();
		
		//$grn_ids = $this->Admin_model->GetItemByGRN($grn_id);
		
		$html ="<option value=''>Select Items</option>";
		
		if($item_ids)
			{
				foreach($item_ids as $item_id)
					{
						$html .='<option value="'.$item_id['item_id'].'">'.GetITEMdata($item_id['item_id'])->ITEM_CODE.'</option>';
					}
			}
			
		echo $html;	
	}

	function SaveStockIssuance()
	{
		$timestamp = $this->input->post('issued_date');
		$date1 = strtr($timestamp, '/', '-');
		$issued_date = date('Y-m-d', strtotime($date1));
		
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('client','Client',  'required');
		$this->form_validation->set_rules('ref_no','GRN No',  'required');
		$this->form_validation->set_rules('issue_by','Issue By',  'required');
		$this->form_validation->set_rules('issue_to','Issue To',  'required');
		$this->form_validation->set_rules('issued_date','Issue Date',  'required');
	 	$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
			{
				$this->add_issuance();
			}
		else // passed validation proceed to post success logic
			{
				$IssueData = array(
					'stock_issue_id' => time(),
					'customer_id' => @$this->input->post('customer_id'),
					'ref_id' => @$this->input->post('ref_no'),
					'issued_by' => @$this->input->post('issue_by'),
					'issued_to' => @$this->input->post('issue_to'),
					'Issued_date' => @$issued_date,
				);	
	
				$result = $this->Admin_model->SaveIssuance($IssueData);
				
				if ($result == false) // the information has therefore been successfully saved in the db
					{
						$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
						redirect(base_url().'stock/add_issuance');   // or whatever logic needs to occur
					}
				else
					{
						$this->session->set_flashdata('msg','<span class="text-green">New Issue added successfully.</span>');
						redirect(base_url().'stock/view_stock_issue/'.$result);   // or whatever logic needs to occur	
					}
			}
	}
	
	public function edit_issuance($id)
	{
		$data['title']='Edit Stock issuance';
		$data['issue'] = $this->db->get_where('stock_issue', array( 'id'=>$id ))->row();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('stock/edit_stock_issuance',$data);
	}
	
	function UpdateStockIssuance($id)
	{
		$data = GetStockIssue($id);
		
		$timestamp = $this->input->post('issued_date');
		$date1 = strtr($timestamp, '/', '-');
		$issued_date = date('Y-m-d', strtotime($date1));
		
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('ref_no','GRN No',  'required');
		$this->form_validation->set_rules('issue_by','Issue By',  'required');
		$this->form_validation->set_rules('issue_to','Issue To',  'required');
		$this->form_validation->set_rules('issued_date','Issue Date',  'required');
	 	$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
			{
				$this->edit_issuance($id);
			}
		else // passed validation proceed to post success logic
			{
				$IssueData = array(
					'stock_issue_id' => $data->stock_issue_id,
					'ref_id' => @$this->input->post('ref_no'),
					'issued_by' => @$this->input->post('issue_by'),
					'issued_to' => @$this->input->post('issue_to'),
					'Issued_date' => @$issued_date,
					'create_date' => $data->create_date,
				);	
	
				$result = $this->Admin_model->UpdateIssuance($id, $IssueData);
				
				if ($result == false) // the information has therefore been successfully saved in the db
					{
						$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
						redirect(base_url().'stock/add_issuance');   // or whatever logic needs to occur
					}
				else
					{
						$this->session->set_flashdata('msg','<span class="text-green">New Issue added successfully.</span>');
						redirect(base_url().'stock/view_stock_issue/'.$result);   // or whatever logic needs to occur	
					}
			}
	}
	
	function SaveStockIssuanceItem($id)
	{
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('item','Item',  'required');
		$this->form_validation->set_rules('box_no','Box Number',  'required');
		$this->form_validation->set_rules('alloted_qty','Alloted Quantity',  'required');
	 	$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
			{
				$this->view_stock_issue($id);
			}
		else // passed validation proceed to post success logic
			{
				$Data = array(
					'stock_issue_id' => @$this->input->post('stock_issue_id'),
					'customer_id' => @$this->input->post('customer'),
					'item_id' => @$this->input->post('item'),
					'box_id' => @$this->input->post('box_no'),
					'qty' => @$this->input->post('alloted_qty'),
				);	
				
				$box_num = @$this->input->post('box_no');
				$Item_ID = @$this->input->post('item');
				$Qty = @$this->input->post('alloted_qty');
				
				$stock = $this->db->get_where('stock_entry', array('box_num'=>$box_num, 'item_id'=>$Item_ID))->row('qty');
				
				$result = $this->Admin_model->SaveIssuanceItem($Data);
				
				if ($result == false) // the information has therefore been successfully saved in the db
					{
						$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
						redirect(base_url().'stock/view_stock_issue');   // or whatever logic needs to occur
					}
				else
					{
						// $cur_stock = $stock - $Qty;
// 						
// 						$this->Admin_model->UpdateStockAfterIssue($box_num, $Item_ID, $cur_stock);
					
						$this->session->set_flashdata('msg','<span class="text-green">New Issue added successfully.</span>');
						redirect(base_url().'stock/view_stock_issue/'.$id);   // or whatever logic needs to occur	
					}
			}
	}

	public function all_issuance_list()
	{
		if( !is_UserAllowed('all_si')){ header('Location: '.base_url().'admin/dashboard'); }
		
		$data['title']='All Issue Entries';
		$data['stock_issues']=$this->db->get_where('stock_issue', array('status'=>'1'))->result_array();
		$this->RedirectToPageWithData('stock/all_stock_issuance',$data);
	}
	
	public function RemoveStockIssueItem()
	{
		$rowid = $_POST['rowid'];
		$parent_item_id = $this->db->get_where('stock_issue_item',array('ID'=> $rowid))->row('stock_issue_id');
		$id = $this->db->get_where('stock_issue',array('stock_issue_id'=> $parent_item_id))->row('id');

		$result = $this->Admin_model->RemoveStockIssueItem($rowid);
		
		if($result)
			{
				$this->session->set_flashdata('msg','<span class="text-green">New Sub Item added successfully.</span>');
				redirect( base_url().'supplier/view_supplier_po/'.$id );   // or whatever logic needs to occur	
			}
		else
			{
				$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
				redirect( base_url().'supplier/view_supplier_po/');   // or whatever logic needs to occur		
		
			}
	}
	
	public function IssueStockIssueItem()
	{
		$rowid = $_POST['rowid'];
		$parent_item_id = $this->db->get_where('stock_issue_item',array('ID'=> $rowid))->row('stock_issue_id');
		$id = $this->db->get_where('stock_issue',array('stock_issue_id'=> $parent_item_id))->row('id');

		$result = $this->Admin_model->IssueStockIssueItem($rowid);
		
		if($result)
			{
				$this->session->set_flashdata('msg','<span class="text-green">New Sub Item added successfully.</span>');
				redirect( base_url().'supplier/view_supplier_po/'.$id );   // or whatever logic needs to occur	
			}
		else
			{
				$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
				redirect( base_url().'supplier/view_supplier_po/');   // or whatever logic needs to occur		
		
			}
	}

	public function add_to_cpi($id)
	{
		//if( !is_UserAllowed('add_si')){ header('Location: '.base_url().'admin/dashboard'); }
		
		$data['title']='Add to CPI';
		$data['customers']=$this->db->get_where('customer',array('status'=>1 ))->result_array();
		$data['stock']=GetStockEntry($id);
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('stock/add_to_cpi',$data);
	}
		
	public function GetCPIByCustomer()
	{
	
		$pinos = GetCUSTpino($_POST['cid']);
		
		$html ='<option>Select CPI</option>';
		
		foreach($pinos as $pino)
		{	
			$html .='<option value="'.$pino['cust_pi_id'].'">'.$pino['pi_num'].'</option>';
		}
		
		echo $html; 
	}
	
	public function GetItembyCPI()
	{
		$items = $this->db->get_where('customer_pi_item',array('cust_pi_id'=>$_POST['pi_id']))->result_array();
		
		$itemArray = '';
		
		foreach($items as $item)
		{	
			$itemArray[] = $item['item_id'];
		}
		
		if (in_array($_POST['item_id'], $itemArray))
		  	{
		  		echo true;	
		  	}
		
	}
	
	public function updateCPI($id)
		{
			echo $cpi_id = $this->input->post('cust_pi');
			
			$pi_num = CPIdata($cpi_id)->pi_num;
			
			$result = $this->Admin_model->UpdateCPI_Number($id, $pi_num);
				
			if ($result == false) // the information has therefore been successfully saved in the db
				{
					$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
					redirect(base_url().'stock/all_entry_list');   // or whatever logic needs to occur
				}
			else
				{
					$this->session->set_flashdata('msg','<span class="text-green">New Issue added successfully.</span>');
					redirect(base_url().'stock/all_entry_list/');   // or whatever logic needs to occur	
				}
		}


}
