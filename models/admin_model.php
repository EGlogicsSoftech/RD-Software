<?php
class Admin_model extends CI_Model
{
	 function __construct()
     {
     parent::__construct();
     }

public  function login($username,$password)
	{
	$this -> db -> from('login');
	$this -> db -> where('email', $username);
	$this -> db -> where('password', $password);
	$this -> db -> where('status', '1');
	$this -> db -> limit(1);
	$query = $this->db->get();
	if($query -> num_rows() == 1)
		{
		return true;
		}
		else
		{
		return false;
		}
}

public function GenerateEnctryptID($id)
	{
	$this->load->library('encrypt');
	$msg = $id;
	$key = '!@#0978123(DL)!@#0978123';
    $encrypted_string = $this->encrypt->encode($msg, $key);
	$encrypted_string = strtr($encrypted_string,array('+' => '.','=' => '-','/' => '~'));
	return $encrypted_string;
	}

public function Id_decode($encrypted_string)
	{
	$encrypted_string = strtr($encrypted_string,array('.' => '+','-' => '=','~' => '/'));
	$this->load->library('encrypt');
	$key = '!@#0978123(DL)!@#0978123';
	$id = $this->encrypt->decode($encrypted_string, $key);
	if(is_numeric($id))
		{
		return $id;
		}
		else
		{
		$this->session->sess_destroy();
		redirect(base_url(), 'refresh');
		}
	}

function SaveUser($UserData)
	{
	if($this->db->insert('login', $UserData)){
		return true;
		}
		else
		{
		return false;
		}
	}

function UpdateUser($id, $UserData)
	{
		$this->db->where('id', $id);

		if($this->db->update('login', $UserData)){
			return $id;
		}
		else
		{
			return false;
		}
	}

function SaveCustomer($CustomerData)
	{
	if($this->db->insert('customer', $CustomerData)){
		return true;
		}
		else
		{
		return false;
		}
	}

function EditCustomer($cid, $CustomerData)
	{
		$this->db->where('id', $cid);

		if($this->db->update('customer', array('status' => 0))){
			if($this->db->insert('customer', $CustomerData)){
			$id = $this->db->insert_id();
			return $id;
			}
			else
			{
			return false;
			}
		}
	}

function SaveCustomerPI($data)
	{
	if($this->db->insert('customer_pi', $data)){
		$id = $this->db->insert_id();
		return $id;
		}
		else
		{
		return false;
		}
	}

function UpdateCustomerPI($cid, $data)
	{
		$this->db->where('cust_pi_id', $cid);

		if($this->db->update('customer_pi', array('status' => 0))){
			if($this->db->insert('customer_pi', $data)){
				$id = $this->db->insert_id();
				return $id;
				}
				else
				{
				return false;
				}
		}
	}

function SaveCustomerPIItem($data)
	{
	if($this->db->insert('customer_pi_item', $data)){
		$id = $this->db->insert_id();
		return $id;
		}
		else
		{
		return false;
		}
	}

function UpdateCustomerPIItem($id, $data)
	{
		$this->db->where('id', $id);

		if($this->db->update('customer_pi_item', $data)){
			return $id;
		}
		else
		{
			return false;
		}
	}

function SaveSupplier($SupplierData)
	{
	if($this->db->insert('supplier', $SupplierData)){
		return true;
		}
		else
		{
			//echo	$this->db->error();
			//die();
			return false;
		}
	}

function EditSupplier($sid, $SupplierData)
	{
		$this->db->where('id', $sid);

		if($this->db->update('supplier', $SupplierData)){
		return $sid;
		}
		else
		{
		return false;
		}
	}

function UpdateSupplierSubItem($row_id, $qty)
	{
		$this->db->where('id', $row_id);

		if($this->db->update('supplier_po_item', array('qty' => $qty))){
			return true;
		}
		else
		{
			return false;
		}
	}

// function UpdateSupplierPO($id, $SupplierData)
// 	{
// 		$this->db->where('id', $id);
//
// 		if($this->db->update('supplier_po', $SupplierData)){
// 		return $sid;
// 		}
// 		else
// 		{
// 		return false;
// 		}
// 	}

function update_box_no($iid, $value)
	{
		// $this->db->set('box_num', $value); //value that used to update column
// 		$this->db->where('id', $iid); //which row want to upgrade
// 		$this->db->update('packing_list_item');
//
		//return $value;

		$this->db->where('id', $iid);

		if($this->db->update('packing_list_item', array('box_num'=>$value))){
		return $iid;
		}
		else
		{
		return false;
		}
	}

function SaveSupplierPO($POData)
	{
	if($this->db->insert('supplier_po', $POData)){
		$id = $this->db->insert_id();
		return $id;
		}
		else
		{
		return false;
		}
	}
function SaveSupplierPOItem($POItemData)
	{
	if($this->db->insert('supplier_po_item', $POItemData)){
		$id = $this->db->insert_id();
		return $id;
		}
		else
		{
		return false;
		}
	}

function SaveDesignation($DesignationData)
	{
	if($this->db->insert('designation', $DesignationData)){
		return true;
		}
		else
		{
		return false;
		}
	}
function SaveItem($ItemData)
	{
	if($this->db->insert('item', $ItemData)){
		$id = $this->db->insert_id();
		return $id;
		}
		else
		{
		return false;
		}
	}

function UpdateItem($id, $ItemData)
	{
		$this->db->where('ID', $id);

		if($this->db->update('item', array('STATUS' => 0) )){

			if($this->db->insert('item', $ItemData)){
				$nid = $this->db->insert_id();
				return $nid;
			}
			else
			{
				return false;
			}
		}
	}

function UpdateSubItem($id, $SubItem)
	{
		$this->db->where('ID', $id);

		if($this->db->update('sub_item', $SubItem)){
				return $id;
			}
			else
			{
				return false;
			}
	}

function RemoveSubItem($id)
	{
		$this->db->where('ID', $id);

		if($this->db->delete('sub_item')){
		return $id;
		}
		else
		{
		return false;
		}
	}

function RemoveSupplierSubItem($id)
	{
		$this->db->where('id', $id);

		if($this->db->delete('supplier_po_item')){
		return $id;
		}
		else
		{
		return false;
		}
	}

// function DeleteItem($id)
// 	{
// 		$this -> db -> where('ID', $id);
//
// 		if($this -> db -> delete('item')){
// 		return True;
// 		}
// 		else
// 		{
// 		return false;
// 		}
// 	}

function SaveSubItem($SubItem)
	{
	if($this->db->insert('sub_item', $SubItem)){
		$id = $this->db->insert_id();
		return $id;
		}
		else
		{
		return false;
		}
	}

function SaveItemCat($CatData)
	{
	if($this->db->insert('item_category', $CatData)){
		return true;
		}
		else
		{
		return false;
		}
	}

function SaveItemCountry($data)
	{
	if($this->db->insert('item_country', $data)){
		return true;
		}
		else
		{
		return false;
		}
	}

function UpdateCountry($id, $data)
	{
		$this->db->where('id', $id);

		if($this->db->update('item_country', $data)){
		return $id;
		}
		else
		{
		return false;
		}
	}

function SaveItemInnerBox($IBData)
	{
	if($this->db->insert('item_innerbox', $IBData)){
		return true;
		}
		else
		{
		return false;
		}
	}

function SaveItemOuterBox($OBData)
	{
	if($this->db->insert('item_outerbox', $OBData)){
		return true;
		}
		else
		{
		return false;
		}
	}

function SaveWeightUnit($data)
	{
	if($this->db->insert('item_weight_unit', $data)){
		return true;
		}
		else
		{
		return false;
		}
	}

function SaveUnit($UnitData)
	{
	if($this->db->insert('item_unit', $UnitData)){
		return true;
		}
		else
		{
		return false;
		}
	}

function UpdateUnit($id, $ItemData)
	{
		$this->db->where('ID', $id);

		if($this->db->update('item_unit', $ItemData)){
		//$id = $this->db->insert_id();
		return $id;
		}
		else
		{
		return false;
		}
	}

function UpdateCategory($id, $Data)
	{
		$this->db->where('ID', $id);

		if($this->db->update('item_category', $Data)){
		return $id;
		}
		else
		{
		return false;
		}
	}

function UpdateInner($id, $Data)
	{
		$this->db->where('ID', $id);

		if($this->db->update('item_innerbox', $Data)){
		return $id;
		}
		else
		{
		return false;
		}
	}

function UpdateOuter($id, $Data)
	{
		$this->db->where('ID', $id);

		if($this->db->update('item_outerbox', $Data)){
		return $id;
		}
		else
		{
		return false;
		}
	}

function saveGrn($GrnData)
	{
	if($this->db->insert('grn', $GrnData)){
		$id = $this->db->insert_id();
		return $id;
		}
		else
		{
		return false;
		}
	}

function hasSameItemCode($code, $id)
	{
		$data = $this->db->get_where('item',array('ITEM_CODE'=>$code, 'STATUS'=>1, 'ID !=' => $id))->row();

		return $data;
    }

function UPDATEgrn($id, $GrnData)
	{
		$this->db->where('id', $id);

		if($this->db->update('grn', array('status'=> 0))){
			if($this->db->insert('grn', $GrnData)){
				$id = $this->db->insert_id();
				return $id;
			}
			else
			{
				return false;
			}
		}
	}

function SaveGrnItem($GrnItemData)
	{
	if($this->db->insert('grn_item', $GrnItemData)){
		$id = $this->db->insert_id();
		return $id;
		}
		else
		{
		return false;
		}
	}

function UpdateGrnItem($id, $GrnItemData)
	{
		$this->db->where('id', $id);

		if($this->db->update('grn_item', $GrnItemData)){
		return $id;
		}
		else
		{
			return false;
		}
	}

public function getPObySupplier($sup_id){

	$sup_pos = $this->db->get_where('supplier_po',array('sup_id'=>$sup_id, 'status'=>1))->result_array();

    if ( $sup_pos )
    {
    	return $sup_pos;
    }
    else
    {
    	return false;
    }
}

function SaveEntry($EntryData)
	{
	if($this->db->insert('stock_entry', $EntryData)){
		return True;
		}
		else
		{
		return false;
		}
	}

function UpdateEntry($id, $EntryData)
	{
		$this->db->where('id', $id);

		if($this->db->update('stock_entry', array('status'=> 0))){
			if($this->db->insert('stock_entry', $EntryData)){
				$id = $this->db->insert_id();
				return $id;
			}
			else
			{
				return false;
			}
		}
	}

function SaveIssuance($IssueData)
	{
	if($this->db->insert('stock_issue', $IssueData)){
		$id = $this->db->insert_id();
		return $id;
		}
		else
		{
		return false;
		}
	}

function UpdateIssuance($id, $EntryData)
	{
		$this->db->where('id', $id);

		if($this->db->update('stock_issue', array('status'=> 0))){
			if($this->db->insert('stock_issue', $EntryData)){
				$id = $this->db->insert_id();
				return $id;
			}
			else
			{
				return false;
			}
		}
	}

function SaveIssuanceItem($Data)
	{
	if($this->db->insert('stock_issue_item', $Data)){
		$id = $this->db->insert_id();
		return $id;
		}
		else
		{
		return false;
		}
	}

// function UpdateStockAfterIssue($box_num, $Item_ID, $cur_stock)
// 	{
// 		$this->db->where(array('item_id'=>$Item_ID, 'box_num'=>$box_num));
//
// 		$this->db->update('stock_entry', array('qty'=> $cur_stock));
// 	}

public function GetBoxnoByItem($item_id)
	{
		$boxes = $this->db->group_by(array('box_num'))->get_where('stock_entry',array('item_id'=>$item_id))->result_array();

    	if($boxes)
    	{
    		return $boxes;
	    }
	    else
	    {
	    	return false;
	    }
   	}

public function GetItemByCustomerPi($id)
	{
		$data = $this->db->get_where('customer_pi_item',array('cust_pi_id'=>$id))->result_array();

    	if($data)
    	{
    		return $data;
	    }
	    else
	    {
	    	return false;
	    }
   	}

public function CustomerCPI($id)
	{
		$data = $this->db->get_where('customer_pi',array('cust_id'=>$id, status=>1))->result_array();

    	if($data)
    	{
    		return $data;
	    }
	    else
	    {
	    	return false;
	    }
   	}



// public function GetAllotedQTYByBox($item_id, $box_id)
// 	{
//
// 		$rows = $this->db->get_where('stock_entry',array('box_num'=>$box_id, 'item_id'=>$item_id))->result_array();
// 		$qty=0;
// 		foreach($rows as $row)
// 			{
// 				$qty +=  $row['qty'];
// 			}
//
//     	return $qty;
//    	}

public function GetItemByGRN($grn_id)
	{
		$items = $this->db->get_where('grn_item',array('grn_row_id'=>$grn_id))->result_array();

    	if($items)
    	{
    		return $items;
	    }
	    else
	    {
	    	return false;
	    }
   	}

function SaveWarehouseActivty($ActivityData)
	{
	if($this->db->insert('warehouse_activity', $ActivityData)){
		return True;
		}
		else
		{
		return false;
		}
	}

function UpdateWarehouseActivty($id, $EntryData)
	{
		$this->db->where('id', $id);

		if($this->db->update('warehouse_activity', array('status'=> 0))){
			if($this->db->insert('warehouse_activity', $EntryData)){
				$id = $this->db->insert_id();
				return $id;
			}
			else
			{
				return false;
			}
		}
	}

function SaveWarehouseRejection($RejectionData)
	{
	if($this->db->insert('warehouse_rejection', $RejectionData)){
		return True;
		}
		else
		{
		return false;
		}
	}

function UpdateWarehouseRejection($id, $RejectionData)
	{
		$this->db->where('id', $id);

		if($this->db->update('warehouse_rejection', array('status'=> 0))){
			if($this->db->insert('warehouse_rejection', $RejectionData)){
				$id = $this->db->insert_id();
				return $id;
			}
			else
			{
				return false;
			}
		}
	}

public function GetItemBySupplier($sup_id)
	{
		$items = $this->db->get_where('item',array('SUPPLIER_ID'=>$sup_id, 'STATUS' => 1))->result_array();

    	if($items)
    	{
    		return $items;
	    }
	    else
	    {
	    	return false;
	    }
   	}

public function GetItemByStockEntry($item_id)
	{
		$this->db->select_sum('qty');
	    $this->db->from('stock_entry');
	    $this->db->where('item_id', $item_id);
	    $query = $this->db->get();
	    return $query->row()->qty;
   	}

function SaveInvoice($invoiceData)
	{
	if($this->db->insert('invoice', $invoiceData)){
		$id = $this->db->insert_id();
		return $id;
		}
		else
		{
		return false;
		}
	}

function SavePacking($data)
	{
	if($this->db->insert('packing_list', $data)){
		$id = $this->db->insert_id();
		return $id;
		}
		else
		{
		return false;
		}
	}

function SAVEnUPDATEShipping($data, $pid)
	{
		$d = $this->db->get_where('pl_shipping_information',array('pl_id'=>$pid))->row();

		if( $d )
			{
				$this->db->where('id', $d->id);
				$this->db->update('pl_shipping_information', $data);
				return true;
			}
		else
			{
				if($this->db->insert('pl_shipping_information', $data)){
					$id = $this->db->insert_id();
					return $id;
				}
				else
				{
					return false;
				}
			}
	}

function SaveDimensions($data)
	{
	if($this->db->insert('dimension', $data)){
		$id = $this->db->insert_id();
		return $id;
		}
		else
		{
		return false;
		}
	}

function SaveDimensionBoxes($data)
	{
	if($this->db->insert('dimension_box', $data)){
		$id = $this->db->insert_id();
		return $id;
		}
		else
		{
		return false;
		}
	}

function RemoveDimensionBox($id)
	{
		$this->db->where('id', $id);

		if($this->db->delete('dimension_box')){
		return $id;
		}
		else
		{
		return false;
		}
	}


function SaveInvoiceItem($SubInvoice)
	{
	if($this->db->insert('invoice_item', $SubInvoice)){
		return True;
		}
		else
		{
		return false;
		}
	}

function SavePackingItem($data)
	{
	if($this->db->insert('packing_list_item', $data)){
		return True;
		}
		else
		{
		return false;
		}
	}

function UpdatePackingItem($id, $data)
	{
		$this->db->where('id', $id);

		if($this->db->update('packing_list_item', $data)){
		return $id;
		}
		else
		{
		return false;
		}
	}

function SaveProduction($data)
	{
	if($this->db->insert('production', $data)){
		return True;
		}
		else
		{
		return false;
		}
	}

function SaveRole($data)
	{
	if($this->db->insert('user_role', $data)){
		return true;
		}
		else
		{
		return false;
		}
	}

function UpdateRole($id, $data)
	{
		$this->db->where('id', $id);

		if($this->db->update('user_role', $data)){
		return $id;
		}
		else
		{
		return false;
		}
	}

function UpdateDesignation($id, $data)
	{
		$this->db->where('id', $id);

		if($this->db->update('designation', $data)){
		return $id;
		}
		else
		{
		return false;
		}
	}

function ApproveGRN($gid, $uid)
	{
		$this->db->where('id', $gid);

		if($this->db->update('grn', array('status'=> 1, 'approved_by'=> $uid))){
		return $gid;
		}
		else
		{
		return false;
		}
	}

function ApproveSPO($sid, $uid)
	{
		$this->db->where('id', $sid);

		if($this->db->update('supplier_po', array('status'=> 1, 'approved_by'=> $uid))){
		return $sid;
		}
		else
		{
		return false;
		}
	}

function ApproveCPI($id, $uid)
	{
		$this->db->where('id', $id);

		if($this->db->update('customer_pi', array('status'=> 1, 'approved_by'=> $uid))){
		return $id;
		}
		else
		{
		return false;
		}
	}

function RemoveStockIssueItem($rowid)
	{
		$this->db->where('id', $rowid);

		if($this->db->delete('stock_issue_item')){
		return $rowid;
		}
		else
		{
		return false;
		}
	}

	function RemoveGrnItem($id)
	{
		$this->db->where('id', $id);

		if($this->db->delete('grn_item')){
		return $id;
		}
		else
		{
		return false;
		}
	}

	function RemoveCPIItem($id)
	{
		$this->db->where('id', $id);

		if($this->db->delete('customer_pi_item')){
		return $id;
		}
		else
		{
		return false;
		}
	}

	function IssueStockIssueItem($id)
	{
		$this->db->where('id', $id);

		if($this->db->update('stock_issue_item', array('issued'=> 1))){
		return $id;
		}
		else
		{
		return false;
		}
	}

	function ApprovePacking($id)
	{
		$this->db->where('id', $id);

		if($this->db->update('packing_list', array('status'=>1))){
		return $id;
		}
		else
		{
		return false;
		}
	}

	function uploadData()
    {
        $count=0;
        $filename = $_FILES["userfile"]["tmp_name"];
      	if($_FILES["userfile"]["size"] > 0)
     		{

     			$file = fopen($filename, "r");
       			 while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
        			{
						$count++;
						if($count == 1)
						{
							continue;
						}

						$data = array(
							'ITEM_ID' => time()+$count,
							'ITEM_CODE' => $getData[0],
							'CATEGORY_NAME' => $getData[1],
							'ITEM_DESC' => $getData[2],
							'ITEM_CUSTOM_DESC' => $getData[3],
							'SUPPLIER_ID' => $getData[4],
							'ITEM_UNIT' => $getData[5],
							'INNER_BOX' => $getData[6],
							'INNER_BOX_QTY' => $getData[7],
							'OUTER_BOX' => $getData[8],
							'OUTER_BOX_QTY' => $getData[9],
							'PURCHASE_PRICE' => $getData[10],
							'HSN_CODE' => $getData[11],
							'NET_WEIGHT' => $getData[12],
							'WEIGHT_UNIT' => $getData[13],
							'rd_catelog_page' => $getData[14],
							'oceanic_catelog_page' => $getData[15],
							'rep_binder_page' => $getData[16],
							'ITEM_IMAGE' => $getData[17],
							'ITEM_ASSEMBLED' => $getData[18],
							'STATUS' => $getData[19],
							'updated_date' => $getData[20],
							'DATE' => $getData[21]
						);

           	 			$data['crane_features'] = $this->db->insert('item', $data);
        			}
     		}

        @fclose($file) or die("can't close file");
        $data['success']="success";
        return $data;

    }

    function uploadsubData()
    {
        $count=0;
        $filename = $_FILES["userfile"]["tmp_name"];
      	if($_FILES["userfile"]["size"] > 0)
     		{

     			$file = fopen($filename, "r");
       			 while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
        			{
						$count++;
						if($count == 1)
						{
							continue;
						}

						$this->db->where('ITEM_ID', $getData[0]);

						if($this->db->update('item', array('ITEM_ASSEMBLED'=>1))){

							$data = array(
								'PARENT_ITEM_ID' => $getData[0],
								'ITEM_ID' => $getData[1],
								'QUANTITY' => $getData[2],
								'DATE' => $getData[3]
							);

							$data['crane_features'] = $this->db->insert('sub_item', $data);

						}
						else
						{
							return false;
						}
        			}
     		}

        @fclose($file) or die("can't close file");
        $data['success']="success";
        return $data;

    }

    function UpdateCPI_Number($id, $pi_num)
	{
		$this->db->where('id', $id);

		if($this->db->update('stock_entry', array('cpi_no'=>$pi_num))){
			return $id;
		}
		else
		{
			return false;
		}
	}

	var $table = "item";
	var $select_column = array("ID","ITEM_IMAGE","ITEM_CODE","HSN_CODE","ITEM_DESC","CATEGORY_NAME","SUPPLIER_ID","ITEM_UNIT");
	var $order_column = array(null, "ITEM_CODE", "CATEGORY_NAME", null, null);

	function make_query()
    	{
    		$search = $_POST["search"]["value"];
        	$this->db->select($this->select_column);
           	$this->db->from('item as I');
           	$this->db->where('I.STATUS','1');

           	if(isset($_POST["search"]["value"]))
           		{
           			$this->db->where("(I.ITEM_CODE LIKE '%$search%' OR I.ITEM_DESC LIKE '%$search%')");
           			//$this->db->like("ITEM_CODE", );
                	//$this->db->or_like("ITEM_DESC", $_POST["search"]["value"]);
           		}

           	if(isset($_POST["order"]))
           		{
                	$this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
           		}
           	else
           		{
                	$this->db->order_by('ID', 'DESC');
           		}
      	}

	function make_datatables()
		{
        	$this->make_query();

           	if($_POST["length"] != -1)
           		{
                	$this->db->limit($_POST['length'], $_POST['start']);
           		}

           	$query = $this->db->get();

           	return $query->result();
      	}

    function get_filtered_data()
    	{
        	$this->make_query();
           	$query = $this->db->get();
           	return $query->num_rows();
      	}

	function get_all_data()
    	{
           	$this->db->select("*");
           	$this->db->from($this->table);
           	$this->db->where('STATUS','1');
           	return $this->db->count_all_results();
      	}

	function DeleteRole($id)
		{
			$this->db->where('id', $id);

			if($this->db->update('user_role', array('status'=> 2)))
				{
					return True;
				}
			else
				{
					return false;
				}
		}

	function DeleteDesignation($id)
		{
			$this->db->where('id', $id);

			if($this->db->update('designation', array('status'=> 2)))
				{
					return True;
				}
			else
				{
					return false;
				}
		}

	function DisableUser($id)
		{
			$this->db->where('id', $id);

			if($this->db->update('login', array('status'=> 2)))
				{
					return True;
				}
			else
				{
					return false;
				}
		}

	function EnableUser($id)
		{
			$this->db->where('id', $id);

			if($this->db->update('login', array('status'=> 1)))
				{
					return True;
				}
			else
				{
					return false;
				}
		}

	function importITEM()
		{
			$count=0;
			$fp = fopen($_FILES['imp_item']['tmp_name'],'r') or die("can't open file");
			while($csv_line = fgetcsv($fp,1024))
			{
				$count++;
				if($count == 1)
				{
					continue;
				}//keep this if condition if you want to remove the first row
				for($i = 0, $j = count($csv_line); $i < $j; $i++)
				{
					$insert_csv = array();

					//$insert_csv['id'] = $csv_line[0];//remove if you want to have primary key,
					$insert_csv['ID'] = $csv_line[0];
					$insert_csv['ITEM_ID'] = $csv_line[1];
					$insert_csv['ITEM_CODE'] = $csv_line[2];
					$insert_csv['CATEGORY_NAME'] = $csv_line[3];
					$insert_csv['ITEM_DESC'] = $csv_line[4];
					$insert_csv['ITEM_CUSTOM_DESC'] = $csv_line[5];
					$insert_csv['SUPPLIER_ID'] = $csv_line[6];
					$insert_csv['ITEM_UNIT'] = $csv_line[7];
					$insert_csv['INNER_BOX'] = $csv_line[8];
					$insert_csv['INNER_BOX_QTY'] = $csv_line[9];
					$insert_csv['OUTER_BOX'] = $csv_line[10];
					$insert_csv['OUTER_BOX_QTY'] = $csv_line[11];
					$insert_csv['PURCHASE_PRICE'] = $csv_line[12];
					$insert_csv['HSN_CODE'] = $csv_line[13];
					$insert_csv['NET_WEIGHT'] = $csv_line[14];
					$insert_csv['WEIGHT_UNIT'] = $csv_line[15];
					$insert_csv['rd_catelog_page'] = $csv_line[16];
					$insert_csv['oceanic_catelog_page'] = $csv_line[17];
					$insert_csv['rep_binder_page'] = $csv_line[18];
					$insert_csv['ITEM_IMAGE'] = $csv_line[19];
					$insert_csv['ITEM_ASSEMBLED'] = $csv_line[20];
					$insert_csv['STATUS'] = $csv_line[21];
					$insert_csv['updated_date'] = $csv_line[22];
					$insert_csv['DATE'] = $csv_line[23];


				}
				$i++;

				if(empty($insert_csv['ITEM_ID']))
					{
						$item_id = time();
					}
				else
					{
						$item_id = $insert_csv['ITEM_ID'];
					}

				$data = array(
					//'id' => $insert_csv['id'] ,
					'ITEM_ID' => $item_id,
					'ITEM_CODE' => $insert_csv['ITEM_CODE'],
					'CATEGORY_NAME' => $insert_csv['CATEGORY_NAME'],
					'ITEM_DESC' => $insert_csv['ITEM_DESC'],
					'ITEM_CUSTOM_DESC' => $insert_csv['ITEM_CUSTOM_DESC'],
					'SUPPLIER_ID' => $insert_csv['SUPPLIER_ID'],
					'ITEM_UNIT' => $insert_csv['ITEM_UNIT'],
					'INNER_BOX' => $insert_csv['INNER_BOX'],
					'INNER_BOX_QTY' => $insert_csv['INNER_BOX_QTY'],
					'OUTER_BOX' => $insert_csv['OUTER_BOX'],
					'OUTER_BOX_QTY' => $insert_csv['OUTER_BOX_QTY'],
					'PURCHASE_PRICE' => $insert_csv['PURCHASE_PRICE'],
					'HSN_CODE' => $insert_csv['HSN_CODE'],
					'NET_WEIGHT' => $insert_csv['NET_WEIGHT'],
					'WEIGHT_UNIT' => $insert_csv['WEIGHT_UNIT'],
					'rd_catelog_page' => $insert_csv['rd_catelog_page'],
					'oceanic_catelog_page' => $insert_csv['oceanic_catelog_page'],
					'rep_binder_page' => $insert_csv['rep_binder_page'],
					'ITEM_IMAGE' => $insert_csv['ITEM_IMAGE'],
					'ITEM_ASSEMBLED' => $insert_csv['ITEM_ASSEMBLED'],
					'STATUS' => $insert_csv['STATUS'],
					'updated_date' => $insert_csv['updated_date'],
					'DATE' => $insert_csv['DATE']

				);

				if(empty($insert_csv['ITEM_ID']))
					{
						$this->db->insert('item', $data);
					}
				else
					{
						$this->db->where('ID', $insert_csv['ID']);

						$this->db->update('item', $data);
					}

				//$data['crane_features'] = $this->db->insert('upload_csv', $data);
			}
			fclose($fp) or die("can't close file");
			$data['success']="success";
			return $data;
		}

	function importSUPPLIER()
		{
			$count=0;
			$fp = fopen($_FILES['imp_supplier']['tmp_name'],'r') or die("can't open file");
			while($csv_line = fgetcsv($fp,1024))
			{
				$count++;
				if($count == 1)
				{
					continue;
				}//keep this if condition if you want to remove the first row
				for($i = 0, $j = count($csv_line); $i < $j; $i++)
				{
					$insert_csv = array();
					//$insert_csv['id'] = $csv_line[0];//remove if you want to have primary key,
					$insert_csv['id'] = $csv_line[0];
					$insert_csv['supplier_name'] = $csv_line[1];
					$insert_csv['tin_no'] = $csv_line[2];
					$insert_csv['gstin_no'] = $csv_line[3];
					$insert_csv['pan_no'] = $csv_line[4];
					$insert_csv['email'] = $csv_line[5];
					$insert_csv['mobile'] = $csv_line[6];
					$insert_csv['phone'] = $csv_line[7];
					$insert_csv['contact_person'] = $csv_line[8];
					$insert_csv['supplier_code'] = $csv_line[9];
					$insert_csv['full_add'] = $csv_line[10];
					$insert_csv['state'] = $csv_line[11];
					$insert_csv['supplier_desc'] = $csv_line[12];
					$insert_csv['status'] = $csv_line[13];
					$insert_csv['date'] = $csv_line[14];

				}
				$i++;

				$data = array(
					//'id' => $insert_csv['id'] ,
					'supplier_name' => $insert_csv['supplier_name'],
					'tin_no' => $insert_csv['tin_no'],
					'gstin_no' => $insert_csv['gstin_no'],
					'pan_no' => $insert_csv['pan_no'],
					'email' => $insert_csv['email'],
					'mobile' => $insert_csv['mobile'],
					'phone' => $insert_csv['phone'],
					'contact_person' => $insert_csv['contact_person'],
					'supplier_code' => $insert_csv['supplier_code'],
					'full_add' => $insert_csv['full_add'],
					'state' => $insert_csv['state'],
					'supplier_desc' => $insert_csv['supplier_desc'],
					'status' => $insert_csv['status'],
					'date' => $insert_csv['date'],
				);

				if( empty($insert_csv['id']) )
					{
						$this->db->insert('supplier', $data);
					}
				else
					{
						$this->db->where('id', $insert_csv['id']);

						$this->db->update('supplier', $data);
					}

				//$data['crane_features'] = $this->db->insert('upload_csv', $data);
			}
			fclose($fp) or die("can't close file");
			$data['success']="success";
			return $data;
		}

	function importCUSTOMER()
		{
			$count=0;
			$fp = fopen($_FILES['imp_customer']['tmp_name'],'r') or die("can't open file");
			while($csv_line = fgetcsv($fp,1024))
			{
				$count++;
				if($count == 1)
				{
					continue;
				}//keep this if condition if you want to remove the first row
				for($i = 0, $j = count($csv_line); $i < $j; $i++)
				{
					$insert_csv = array();

					//$insert_csv['id'] = $csv_line[0];//remove if you want to have primary key,
					$insert_csv['id'] = $csv_line[0];
					$insert_csv['customer_id'] = $csv_line[1];
					$insert_csv['oceanic_client'] = $csv_line[2];
					$insert_csv['name'] = $csv_line[3];
					$insert_csv['email'] = $csv_line[4];
					$insert_csv['phone'] = $csv_line[5];
					$insert_csv['contact_person'] = $csv_line[6];
					$insert_csv['color'] = $csv_line[7];
					$insert_csv['code'] = $csv_line[8];
					$insert_csv['cust_add'] = $csv_line[9];
					$insert_csv['billing_add'] = $csv_line[10];
					$insert_csv['shipping_term'] = $csv_line[11];
					$insert_csv['description'] = $csv_line[12];
					$insert_csv['status'] = $csv_line[13];
					$insert_csv['updated_date'] = $csv_line[14];
					$insert_csv['date'] = $csv_line[15];
				}
				$i++;

				if(empty($insert_csv['customer_id']))
					{
						$customer_id = time();
					}
				else
					{
						$customer_id = $insert_csv['customer_id'];
					}

				$data = array(
					//'id' => $insert_csv['id'] ,
					'customer_id' => $customer_id,
					'oceanic_client' => $insert_csv['oceanic_client'],
					'name' => $insert_csv['name'],
					'email' => $insert_csv['email'],
					'phone' => $insert_csv['phone'],
					'contact_person' => $insert_csv['contact_person'],
					'color' => $insert_csv['color'],
					'code' => $insert_csv['code'],
					'cust_add' => $insert_csv['cust_add'],
					'billing_add' => $insert_csv['billing_add'],
					'shipping_term' => $insert_csv['shipping_term'],
					'description' => $insert_csv['description'],
					'status' => $insert_csv['status'],
					'updated_date' => $insert_csv['updated_date'],
					'date' => $insert_csv['date']

				);

				if(empty($insert_csv['customer_id']))
					{
						$this->db->insert('customer', $data);
					}
				else
					{
						$this->db->where('id', $insert_csv['id']);

						$this->db->update('customer', $data);
					}
			}

			fclose($fp) or die("can't close file");
			$data['success']="success";
			return $data;
		}


	function SaveLog($data)
		{
		if($this->db->insert('impexport_log', $data)){
			return true;
			}
			else
			{
			return false;
			}
		}

}

?>
