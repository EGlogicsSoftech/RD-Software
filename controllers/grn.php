<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grn extends CI_Controller {

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
		if( !is_UserAllowed('add_grn')){ header('Location: '.base_url().'admin/dashboard'); }
		
		$data['title']='Add GRN';
		$data['bills']= GetAllBills();
		$data['items']= GetItem();
		$data['msg']=$this->session->flashdata('msg');
		//$data['sup_pos']= GetAllSupplierPO();
		
    	$this->RedirectToPageWithData('grn/add_grn',$data);
	}
	
	public function getitem()
	{
		$sup_id= $_POST['sup_id'];
		$sup_pos = $this->Admin_model->getPObySupplier($sup_id);

		$html ="<option value=''>Select Supplier PO</option>";

		foreach($sup_pos as $sup_po)
			{
				$html .='<option value="'.$sup_po['sup_po_id'].'">'.$sup_po['po_num'].'</option>';
			}

		echo $html;
	}

	public function grnlist()
	{
		if( !is_UserAllowed('all_grn')){ header('Location: '.base_url().'admin/dashboard'); }
		
		$data['title']='Manage GRN';
		$data['grns']= GetGRNs();
		$this->RedirectToPageWithData('grn/all_grn',$data);
	}
	
	public function Export_PDF($id)
		{
			$this->load->library('pdf');
			
			$this->data['title'] = "GRN";
			
			$this->data['grn'] = $this->db->get_where('grn',array('grn_id'=>$id))->row();
			
			$html = $this->load->view('grn/export_pdf',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
	 
			$pdfFilePath ="GRN-".$this->data['grn']->grn_number.".pdf";

			$pdf = $this->pdf->load();
			
			$pdf->WriteHTML($html,2);
			
			$pdf->Output($pdfFilePath, "D");
		}
	
	public function Export_EXCEL($id)
		{
		
			$data['grn'] = $this->db->get_where('grn',array('grn_id'=>$id))->row();
			
			$grn_data = GetGRNItems($data['grn']->grn_id);
			
			$FormatedDate = date("j F, Y", strtotime(Get_Bill_data( $data['grn']->bill_id )->challan_date));
			
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
    		
    		$this->excel->getActiveSheet()->getStyle("A3:B8")->applyFromArray($allborder);
		
			$this->excel->setActiveSheetIndex(0);
			//name the worksheet
			$this->excel->getActiveSheet()->setTitle('GRN');
			//set cell A1 content with some text
			$this->excel->getActiveSheet()->setCellValue('A1', 'RICKSHAW DELIVERY (Est.2004)');
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			
			$this->excel->getActiveSheet()->setCellValue('A3', 'GRN Number');
			$this->excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
			
			$this->excel->getActiveSheet()->setCellValue('A4', 'Supplier Name');
			$this->excel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
			
			
			
			$this->excel->getActiveSheet()->setCellValue('A6', 'Challan Number');
			$this->excel->getActiveSheet()->getStyle('A6')->getFont()->setBold(true);
			
			$this->excel->getActiveSheet()->setCellValue('A7', 'Challan Date');
			$this->excel->getActiveSheet()->getStyle('A7')->getFont()->setBold(true);
			
			$this->excel->getActiveSheet()->setCellValue('A8', 'No. of Boxes');
			$this->excel->getActiveSheet()->getStyle('A8')->getFont()->setBold(true);
			// 
// 			$this->excel->getActiveSheet()->setCellValue('A8', 'Approved By');
// 			$this->excel->getActiveSheet()->getStyle('A8')->getFont()->setBold(true);
// 			
// 			$this->excel->getActiveSheet()->setCellValue('A9', 'Created By');
// 			$this->excel->getActiveSheet()->getStyle('A9')->getFont()->setBold(true);
// 			
// 			$this->excel->getActiveSheet()->setCellValue('A10', 'Created At');
// 			$this->excel->getActiveSheet()->getStyle('A10')->getFont()->setBold(true);
			
			$this->excel->getActiveSheet()->setCellValue('B3', $data['grn']->grn_number);
			$this->excel->getActiveSheet()->setCellValue('B4', GetSupplierData( Get_Bill_data( $data['grn']->bill_id )->sup_id )->supplier_name);
			
			$this->excel->getActiveSheet()->setCellValue('B6', Get_Bill_data( $data['grn']->bill_id )->challan_num);
			$this->excel->getActiveSheet()->setCellValue('B7', $FormatedDate);
			$this->excel->getActiveSheet()->setCellValue('B8', Get_Bill_data( $data['grn']->bill_id )->num_of_box);
			// $this->excel->getActiveSheet()->setCellValue('B8', GetUserData($data['grn']->approved_by)->name);
// 			$this->excel->getActiveSheet()->setCellValue('B9', GetUserData($data['grn']->created_by)->name);
// 			$this->excel->getActiveSheet()->setCellValue('B10', date("j F, Y | H:i:s", strtotime($data['grn']->date)));
			
			$this->excel->getActiveSheet()->getStyle('A15:L15')->applyFromArray($border);
			$this->excel->getActiveSheet()->setCellValue('A15', 'Sr #');
			$this->excel->getActiveSheet()->getStyle('A15')->getFont()->setBold(true);
			
			$this->excel->getActiveSheet()->setCellValue('B15', 'Item Code');
			$this->excel->getActiveSheet()->getStyle('B15')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth("15");
			
			$this->excel->getActiveSheet()->setCellValue('C15', 'Item Description');
			$this->excel->getActiveSheet()->getStyle('C15')->getFont()->setBold(true);
			
			$this->excel->getActiveSheet()->setCellValue('D15', 'Unit');
			$this->excel->getActiveSheet()->getStyle('D15')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth("20");
			
			$this->excel->getActiveSheet()->setCellValue('E15', 'Supplier PO#');
			$this->excel->getActiveSheet()->getStyle('E15')->getFont()->setBold(true);
			
			$this->excel->getActiveSheet()->setCellValue('F15', 'Challan Qty');
			$this->excel->getActiveSheet()->getStyle('F15')->getFont()->setBold(true);
			
			$this->excel->getActiveSheet()->setCellValue('G15', 'Received Qty');
			$this->excel->getActiveSheet()->getStyle('G15')->getFont()->setBold(true);
			
			$this->excel->getActiveSheet()->setCellValue('H15', 'Accepted Qty');
			$this->excel->getActiveSheet()->getStyle('H15')->getFont()->setBold(true);
			
			$this->excel->getActiveSheet()->setCellValue('I15', 'Rejected Qty');
			$this->excel->getActiveSheet()->getStyle('I15')->getFont()->setBold(true);
			
			$this->excel->getActiveSheet()->setCellValue('J15', 'Difference Qty');
			$this->excel->getActiveSheet()->getStyle('J15')->getFont()->setBold(true);
			
			$this->excel->getActiveSheet()->setCellValue('K15', 'Stocked Qty');
			$this->excel->getActiveSheet()->getStyle('K15')->getFont()->setBold(true);
			
			$this->excel->getActiveSheet()->setCellValue('L15', 'Remarks Qty');
			$this->excel->getActiveSheet()->getStyle('L15')->getFont()->setBold(true);
			
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
			
			$grn_items = GetGRNItems( $data['grn']->grn_id );
			
			//$row_num = count($sup_po_items);
			//$rs = $this->db->get('countries');
			$exceldata="";
			$exceldata1="";
			$total="";
			
			$i=1;
			$j=16;
			foreach ($grn_items as $row){
				
				$itemUnitID = GetItemUnit( GetItemData( $row['item_id'] )->ITEM_UNIT);
				
				$GRNtoSTOCK = GRNtoSTOCK($row['grn_row_id'], $row['item_id']);
				
				$diff_qty = $row['received_qty'] - $row['challan_qty'];
				
				$spo_num = SPOData($row['supplier_po_id'])->po_num;
				
				$exceldata1[] = array('sno' => $i, 'item_code' => GetItemData( $row['item_id'] )->ITEM_CODE,'description' => GetItemData( $row['item_id'] )->ITEM_DESC, 'unit' => $itemUnitID, 'supplier_po'=> $spo_num, 'challan_qty' => $row['challan_qty'], 'received_qty' => $row['received_qty'], 'accepted_qty' => $row['accepted_qty'], 'rejected_qty' => $row['received_qty'] - $row['accepted_qty'], 'difference_qty' => $diff_qty, 'stocked_qty' => $GRNtoSTOCK, 'remarks' => $row['remarks']);
				
			$i++; $j++; }
			
			$start_row = 16;
			$total_row = count($exceldata1);
			
			$x_row = $start_row + $total_row + 1;
			
			//Fill data 
			$this->excel->getActiveSheet()->fromArray($exceldata1, null, 'A16');
			
			$this->excel->getActiveSheet()->getStyle('A15:L'.$x_row)->getAlignment()->setWrapText(true);
			$this->excel->getActiveSheet()->getStyle('A15:L'.$x_row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('A15:L'.$x_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle("A15:L".$x_row)->applyFromArray($allborder);
		 	
		 	$this->excel->getActiveSheet()->getStyle('A16:L'.$x_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$filename='GRN_'.$data['grn']->grn_number.'.xls'; //save our workbook as this file name
			header('Content-Type: application/octet-stream'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache
			
			

			//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
			//if you want to save it as .XLSX Excel 2007 format
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
			//force user to download the Excel file without writing it to server's HD
			$objWriter->save('php://output');
				 
		}
	
	function file_selected_test()
	{

		    $this->form_validation->set_message('file_selected_test', 'Please select file.');
		    if (empty($_FILES['challan_img']['name'])) {
		            return false;
		        }else{
		            return true;
		        }
		}
		
	function saveGrn()
	{
		$sub_grns = @$this->input->post('sub_grn_group');
		$created_by = $this->db->get_where('login',array('id'=>$this->session->userdata('id')))->row('id'); 

		$timestamp = $this->input->post('challan_date');
		$date1 = strtr($timestamp, '/', '-');
		$challan_date = date('Y-m-d', strtotime($date1));
		$grn_status = 0;
		
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('gn_no','GRN No',  'required|is_unique[grn.grn_number]');
		$this->form_validation->set_rules('bill_id','Bill Id',  'required');
	 	$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
			{
				$this->add();
			}
		else
			{
				$data = array(
					'grn_id' => time(),
					'grn_number' => @$this->input->post('gn_no'),
					'bill_id' => @$this->input->post('bill_id'),
					'created_by' => $created_by
				);
				
				$result = $this->Admin_model->saveGrn($data);
	
				if ($result == false) // the information has therefore been successfully saved in the db
					{
						$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
						redirect(base_url().'grn/add');   // or whatever logic needs to occur
					}
				else
					{
						$this->session->set_flashdata('msg','<span class="text-green">New GRN added successfully.</span>');
						redirect(base_url().'grn/view/'.$result);   // or whatever logic needs to occur	
					}
			}
	}
	
	function updateGrn($id)
	{
		$created_by = $this->db->get_where('login',array('id'=>$this->session->userdata('id')))->row('name'); 
		$grn_data = GetGRNData($id);
		
		$timestamp = $this->input->post('challan_date');
		$date1 = strtr($timestamp, '/', '-');
		$challan_date = date('Y-m-d', strtotime($date1));
		$grn_status = 0;
		
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('gn_no','GRN No',  'required');
	    $this->form_validation->set_rules('supplier_id','Supplier Id',  'required');
	    $this->form_validation->set_rules('supplier_pon','Supplier PO No',  'required');
	    $this->form_validation->set_rules('challan_no','Challan No',  'required');
	    $this->form_validation->set_rules('challan_date','Challan date',  'required');
	    $this->form_validation->set_rules('box_no','Box No',  'required');
	 	$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
			{
				$this->edit($id);
			}
		else
			{
				$GrnData = array(
					'grn_id' => $grn_data->grn_id,
					'grn_number' => @$this->input->post('gn_no'),
					'sup_id' => @$this->input->post('supplier_id'),
					'sup_po_num' => @$this->input->post('supplier_pon'),
					'challan_num' => @$this->input->post('challan_no'),
					'challan_date' => @$challan_date,
					'box_num' => @$this->input->post('box_no'),
					'created_by' => $created_by,
					'date' => $grn_data->date
				);
	
				$result = $this->Admin_model->UPDATEgrn($id, $GrnData);

				if ($result == false) // the information has therefore been successfully saved in the db
					{
						$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
						redirect(base_url().'grn/edit');   // or whatever logic needs to occur
					}
				else
					{
						$this->session->set_flashdata('msg','<span class="text-green">New GRN added successfully.</span>');
						redirect(base_url().'grn/view/'.$result);   // or whatever logic needs to occur	
					}
			}
	}

	public function view($id)
	{
		$data['title']='View GRN';
		$data['grn']=$this->db->get_where('grn',array('ID'=>$id))->row();
		//$data['items']= GetItem();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('grn/view',$data);
	}
	
	function saveGrnItem($id)
	{
	
		$recived_qty = @$this->input->post('received_qty');
		
		if($recived_qty != 0)
			{
				$recived_qty = $recived_qty+1;
			}
		$this->form_validation->set_message('less_than', 'accepted quantity can not be more than recived quantity');
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
	 	$this->form_validation->set_rules('item_id','item Id',  'required');
		$this->form_validation->set_rules('challan_qty','Challan Qty',  'required');
		$this->form_validation->set_rules('received_qty','Received Qty',  'required');
		$this->form_validation->set_rules('accepted_qty','Accepted Qty',  'required|less_than['.$recived_qty.']');
	 	$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');
		
		if($this->form_validation->run() == FALSE) // validation hasn't been passed
			{
				$this->view($id);
			}
		else 
			{
				$GrnItemData = array(
					'grn_row_id' => @$this->input->post('grn_id'),
					'supplier_po_id' => @$this->input->post('spo_id'),
					'item_id' => @$this->input->post('item_id'),
					'challan_qty' => @$this->input->post('challan_qty'),
					'received_qty' => @$this->input->post('received_qty'),
					'accepted_qty' => @$this->input->post('accepted_qty'),
					'remarks' => @$this->input->post('remarks'),
				);
	
				$result = $this->Admin_model->SaveGrnItem($GrnItemData);
				
				$grn_row_id = $this->db->get_where('grn_item',array('id'=> $result))->row('grn_row_id');
				$grn_id = $this->db->get_where('grn',array('grn_id'=> $grn_row_id))->row('id');

				if ($result == false) 
					{
						$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
						redirect(base_url().'grn/view/'.$grn_id);   // or whatever logic needs to occur
					}
				else
					{
						$this->session->set_flashdata('msg','<span class="text-green">Item added successfully.</span>');
						redirect(base_url().'grn/view/'.$grn_id);   // or whatever logic needs to occur	
					}
			}
	}

	public function edit($id)
	{
		$data['title']='Edit Item';
		$data['suppliers']= GetAllSupplier();
		$data['items']= GetItem();
		$data['msg']=$this->session->flashdata('msg');
		$data['edit_grn']=$this->db->get_where('grn',array('id'=>$id))->row();
		$this->RedirectToPageWithData('grn/edit',$data);
	}
	
	public function approve_grn($gid)
		{
			if( !is_UserAllowed('approve_grn')){ header('Location: '.base_url().'admin/dashboard'); }
			
			$uid = $this->db->get_where('login',array('id'=>$this->session->userdata('id')))->row('id');
			
			$result = $this->Admin_model->ApproveGRN($gid, $uid);
			
			if ($result == false) 
					{
						$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
						redirect(base_url().'grn/view/'.$result);   // or whatever logic needs to occur
					}
				else
					{
						$this->session->set_flashdata('msg','<span class="text-green">Item added successfully.</span>');
						redirect(base_url().'grn/view/'.$result);   // or whatever logic needs to occur	
					}
			
		}
	public function editGrnItem($id)
	{
		if( !is_UserAllowed('update_grn_item')){ header('Location: '.base_url().'admin/dashboard'); }
		
		$data['title']='Edit Grn Item';
		$data['suppliers']= GetAllSupplier();
		$data['itemrow']=$this->db->get_where('grn_item',array('id'=>$id))->row();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('grn/edit_grn_item',$data);
	}
	
	function UpdateGrnItem($id)
	{
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
	 	$this->form_validation->set_rules('item_id','item Id',  'required');
		$this->form_validation->set_rules('challan_qty','Challan Qty',  'required');
		$this->form_validation->set_rules('received_qty','Received Qty',  'required');
		$this->form_validation->set_rules('accepted_qty','Accepted Qty',  'required');
	 	$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
			{
				$this->editGrnItem($id);
			}
		else 
			{
				$GrnItemData = array(
					'item_id' => @$this->input->post('item_id'),
					'challan_qty' => @$this->input->post('challan_qty'),
					'received_qty' => @$this->input->post('received_qty'),
					'accepted_qty' => @$this->input->post('accepted_qty'),
					'remarks' => @$this->input->post('remarks'),
				);
	
				$result = $this->Admin_model->UpdateGrnItem($id, $GrnItemData);
				
				$grn_row_id = $this->db->get_where('grn_item',array('id'=>$result))->row('grn_row_id');
				$grnID = $this->db->get_where('grn',array('grn_id'=>$grn_row_id))->row('id');
				
				if ($result == false) 
					{
						$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
						redirect(base_url().'grn/view/'.$grnID);   // or whatever logic needs to occur
					}
				else
					{
						$this->session->set_flashdata('msg','<span class="text-green">Item added successfully.</span>');
						redirect(base_url().'grn/view/'.$grnID);   // or whatever logic needs to occur	
					}
			}
	}
	
	function remove_sub_item()
	{
		$id = $_POST['rowid'];
		
		$grn_row_id = $this->db->get_where('grn_item',array('id'=>$id))->row('grn_row_id');
		$grnID = $this->db->get_where('grn',array('grn_id'=>$grn_row_id))->row('id');
	
		$result = $this->Admin_model->RemoveGrnItem($id);
		
		if ($result == false) 
			{
				$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
				redirect(base_url().'grn/view/'.$grnID);   // or whatever logic needs to occur
			}
		else
			{
				$this->session->set_flashdata('msg','<span class="text-green">Item added successfully.</span>');
				redirect(base_url().'grn/view/'.$grnID);   // or whatever logic needs to occur	
			}
	}
	
	function Get_Bill_Item_QTY()
	{
		$item_id = $_POST['item_id'];
		$bill_id = $_POST['bill_id'];
		
		$challan_qty = $this->db->get_where('bill_item',array('item_id'=>$item_id, 'bill_id'=>$bill_id ))->row();
		
		$po_num = SPOData($challan_qty->supplier_po_id)->po_num;
		
		$data['qty'] = $challan_qty->challan_qty;
		$data['spo_id'] = $challan_qty->supplier_po_id;
		$data['po_num'] = $po_num;
		
		//$data = array('qty'=>$challan_qty->challan_qty, 'spo_id'=> $challan_qty->supplier_po_id );
		
		$json_data = json_encode($data);
		
		echo $json_data;
	}
	
}
