<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	function GetItemUnit($unitid)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$unit = $ci->db->get_where('item_unit',array('id'=> $unitid))->row('UNIT_NAME');

			return $unit;
		}

	function GetWeightUnit($id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$data = $ci->db->get_where('item_weight_unit',array('id'=> $id))->row('weight_unit');

			return $data;
		}

	function GetInnerBox($id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$data = $ci->db->get_where('item_innerbox',array('ID'=> $id))->row('INNER_BOX_SIZE');

			return $data;
		}

	function GetOuterBox($id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$data = $ci->db->get_where('item_outerbox',array('ID'=> $id))->row('OUTER_BOX_SIZE');

			return $data;
		}

	function GetAllOuterBox()
		{
			$ci =& get_instance();
		    $ci->load->database();

			$data = $ci->db->get_where('item_outerbox',array('STATUS'=> 1))->result_array();

			return $data;
		}

	function GetDimensionBox($id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$data = $ci->db->get_where('dimension_box',array('dimension_id'=>$id))->result_array();

			return $data;
		}

	function GetPLShippingData($id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$data = $ci->db->get_where('pl_shipping_information',array('pl_id'=>$id))->row();

			return $data;
		}

	function GetOuterBoxData($id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$data = $ci->db->get_where('item_outerbox',array('ID'=> $id))->row();

			return $data;
		}

	function GetItemUnitByItemid($itemid)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$UnitId = $ci->db->get_where('item',array('ID'=> $itemid))->row('ITEM_UNIT');

			$unitname = $ci->db->get_where('item_unit',array('ID'=> $UnitId))->row('UNIT_NAME');

			return $unitname;
		}

	// function GetSupplier($supplierid)
// 		{
// 			$ci =& get_instance();
// 		    $ci->load->database();
//
// 			$supplier = $ci->db->get_where('supplier',array('id'=> $supplierid))->row('supplier_name');
//
// 			return $supplier;
// 		}

	function get_item_by_grnno($grn)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$item_ids = $ci->db->get_where('grn_item',array('grn_row_id'=>$grn))->result_array();

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

	function Get_Item_Category_Name($categoryid)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$category = $ci->db->get_where('item_category',array('ID'=> $categoryid))->row('CATEGORY_NAME');

			return $category;
		}

	function CountryData($cid)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$country = $ci->db->get_where('item_country',array('id'=> $cid))->row();

			return $country;
		}

	function Get_Inner_Box_Size($innerboxid)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$data = $ci->db->get_where('item_innerbox',array('ID'=> $innerboxid))->row('INNER_BOX_SIZE');

			return $data;
		}

	function Get_Outer_Box_Size($outerboxid)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$data = $ci->db->get_where('item_outerbox',array('ID'=> $outerboxid))->row('OUTER_BOX_SIZE');

			return $data;
		}

	function GetSupplierCodeByItemid($itemid)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$supplier_id = $ci->db->get_where('item',array('ID'=> $itemid))->row('SUPPLIER_ID');

			$supplier_code = $ci->db->get_where('supplier',array('id'=> $supplier_id))->row('supplier_code');

			return $supplier_code;
		}


// GET ALL DATA FUNCTIONS STARTS


	function GetPackingList($id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$data = $ci->db->get_where('packing_list',array('packing_id'=> $id))->row();

			return $data;
		}

	function GetItemData($item_id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$data = $ci->db->get_where('item',array('ITEM_ID'=> $item_id, 'status'=> 1))->row();

			return $data;
		}

	function GetSubItemData($siid)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$data = $ci->db->get_where('sub_item',array('ID'=> $siid))->row();

			return $data;
		}

	function GetWarehouseActivity($id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$data = $ci->db->get_where('warehouse_activity',array('id'=> $id, 'status'=> 1))->row();

			return $data;
		}

	function GetWarehouseRejection($id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$data = $ci->db->get_where('warehouse_rejection',array('id'=> $id, 'status'=> 1))->row();

			return $data;
		}

	function GetGRNData($id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$data = $ci->db->get_where('grn',array('id'=> $id))->row();

			return $data;
		}

	function GetStockEntry($id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$data = $ci->db->get_where('stock_entry',array('id'=> $id))->row();

			return $data;
		}

	function GetStockIssue($id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$data = $ci->db->get_where('stock_issue',array('id'=> $id))->row();

			return $data;
		}

	function GetUserData($id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$data = $ci->db->get_where('login',array('id'=>$id))->row();

			return $data;
		}

	function GetUserRoleData($id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$data = $ci->db->get_where('user_role',array('id'=>$id))->row();

			return $data;
		}

	function AllowedByRole($uid, $rid)
		{
			$ci =& get_instance();
		    $ci->load->database();

		    $user_data = GetUserData($uid);

		    if( $user_data->role == $rid )
		    	{
		    		return true;
		    	}
		    else
		    	{
					return false;
				}
		}

	function GetSubItem($itemid)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$subitems = $ci->db->get_where('sub_item',array('PARENT_ITEM_ID'=>$itemid))->result_array();

			return $subitems;
		}

	function GetCustomerData($id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$data = $ci->db->get_where('customer',array('customer_id'=> $id))->row();

			return $data;
		}

	function GetInvoiceData($id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$data = $ci->db->get_where('invoice',array('invoice_id'=> $id))->row();

			return $data;
		}

	function GetSupplierData($id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$data = $ci->db->get_where('supplier',array('id'=> $id))->row();

			return $data;
		}

	function SPOData($id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$data = $ci->db->get_where('supplier_po',array('sup_po_id'=> $id))->row();

			return $data;
		}

	function CPIdata($id)
		{
			$ci =& get_instance();
			$ci->load->database();

			$data = $ci->db->get_where('customer_pi',array('cust_pi_id'=>$id))->row();

			return $data;
		}
	function CPIItemdata($cpid, $item_id)
		{
			$ci =& get_instance();
			$ci->load->database();

			$data = $ci->db->get_where('customer_pi_item',array('cust_pi_id'=>$cpid, 'item_id'=>$item_id))->row();

			return $data;
		}

	function Is_Assembled($item_id)
		{
			$ci =& get_instance();
			$ci->load->database();

			$data = $ci->db->get_where('item',array('ITEM_ID'=>$item_id, 'ITEM_ASSEMBLED'=>1))->row();

			if($data)
				{
					return true;
				}
		}

// GET ALL DATA FUNCTIONS ENDS

	function GetItemofSupplier($sid)
		{
			$ci =& get_instance();
		    $ci->load->database();

			//$items = $ci->db->get_where('item',array('SUPPLIER_ID'=>$sid, 'STATUS' => 1))->result_array();
			$items = $ci->db->query("SELECT * FROM item WHERE FIND_IN_SET($sid,SUPPLIER_ID) AND STATUS=1")->result_array();

			// $ci->db->select("*");
//            	$ci->db->from('item');
//            	$ci->db->where('STATUS','1');
//            	//$this->db->where(find_in_set($sid, 'SUPPLIER_ID'));
//            	$items = $ci->db->get->result_array();

			return $items;
		}

	function GetItemofSupplierPOItem($spid)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$items = $ci->db->get_where('supplier_po_item',array('sup_po_id'=>$spid))->result_array();

			return $items;
		}

	// LIST OF ITEMS OF SUPPLIER BILL
	function Get_Items_of_bill($bid)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$items = $ci->db->get_where('bill_item',array('bill_id'=>$bid))->result_array();

			return $items;
		}

	function GetStockIssueItems($id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$data = $ci->db->get_where('stock_issue_item',array('stock_issue_id'=>$id))->result_array();

			return $data;
		}

	function GetGRNItems($id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$data = $ci->db->get_where('grn_item',array('grn_row_id'=>$id))->result_array();

			return $data;
		}

	function GetBillItems($id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$data = $ci->db->get_where('bill_item',array('bill_id'=>$id))->result_array();

			return $data;
		}

	function GetSupPOItem($id)
	{
		$ci =& get_instance();
		$ci->load->database();

		$data = $ci->db->get_where('supplier_po_item',array('sup_po_id'=>$id))->result_array();

		return $data;
	}

	function GetInvoiceItem($id)
	{
		$ci =& get_instance();
		$ci->load->database();

		$data = $ci->db->get_where('invoice_item',array('invoice_id'=>$id))->result_array();

		return $data;
	}

	function GetPackingItem($id)
	{
		$ci =& get_instance();
		$ci->load->database();

		$data = $ci->db->get_where('packing_list_item',array('packing_id'=>$id))->result_array();

		return $data;
	}

	function GetCustPIItem($id)
	{
		$ci =& get_instance();
		$ci->load->database();

		$data = $ci->db->get_where('customer_pi_item',array('cust_pi_id'=>$id))->result_array();

		return $data;
	}

	function GetItem()
		{
			$ci =& get_instance();
		    $ci->load->database();

			$items = $ci->db->get_where('item',array('status'=>'1'))->result_array();

			return $items;
		}

	function GetAllSupplier()
		{
			$ci =& get_instance();
		    $ci->load->database();

			$Suppliers = $ci->db->get_where('supplier',array('status'=>'1'))->result_array();

			return $Suppliers;
		}

	function GetAllBills()
		{
			$ci =& get_instance();
		    $ci->load->database();

			$Suppliers = $ci->db->get_where('supplier_bill',array('status'=>'1'))->result_array();

			return $Suppliers;
		}

	function GetAllSupplierPO()
		{
			$ci =& get_instance();
		    $ci->load->database();

			$SupplierPOs = $ci->db->get_where('supplier_po')->result_array();

			return $SupplierPOs;
		}

	function GetAllCustomerPO()
		{
			$ci =& get_instance();
		    $ci->load->database();

			$customerpo = $ci->db->get_where('customer_pi',array('status'=>'1'))->result_array();

			return $customerpo;
		}

	function GetAllCustomer()
		{
			$ci =& get_instance();
		    $ci->load->database();

			$customers = $ci->db->get_where('customer',array('status'=>'1'))->result_array();

			return $customers;
		}

	function GetCustomerName($customerid)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$customer = $ci->db->get_where('customer',array('customer_id'=> $customerid))->row('name');

			return $customer;
		}

	function GetGRNs()
		{
			$ci =& get_instance();
		    $ci->load->database();

			$grns = $ci->db->get_where('grn', array('status >'=> 0))->result_array();

			return $grns;
		}

	function GetBills()
		{
			$ci =& get_instance();
		    $ci->load->database();

			$bills = $ci->db->get_where('supplier_bill', array('status >'=> 0))->result_array();

			return $bills;
		}

	function GetGRNno($id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$grnno = $ci->db->get_where('grn',array('grn_id'=>$id))->row('grn_number');

			return $grnno;
		}

	function GetCUSTpino($id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$data = $ci->db->order_by('created_at', 'ASC')->get_where('customer_pi',array('cust_id'=>$id, 'status'=>1))->result_array();

			return $data;
		}

	function GetSubgrn($gid)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$sub_grn = $ci->db->get_where('grn_item',array('id'=>$gid))->result_array();

			return $sub_grn;
		}

	function Getgrnname($gid)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$item_name = $ci->db->get_where('item',array('ID'=>$gid))->row('ITEM_NAME');

			return $item_name;
		}

	// function GetITEMcode($id)
// 		{
// 			$ci =& get_instance();
// 		    $ci->load->database();
//
// 			$data = $ci->db->get_where('item',array('ID'=>$id))->row('ITEM_CODE');
//
// 			return $data;
// 		}


	function GetLoggedinUserName($uid)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$user_name = $ci->db->get_where('login',array('id'=>$uid))->row('name');

			return $user_name;
		}

	function GetDesignationName($designationID)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$designation = $ci->db->get_where('designation',array('id'=> $designationID))->row('designation_name');

			return $designation;
		}

	function GetEntryItem()
		{
			$ci =& get_instance();
		    $ci->load->database();

			$data = $ci->db->group_by(array('item_id'))->get_where('stock_entry')->result_array('item_id');

			return $data;
		}

	function GetItemStock($id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$query = $ci->db->query('select A.box_num, A.SUMA , B.SUMB from ( select box_num , SUM(qty) as SUMA from stock_entry where item_id = '.$id.' group by box_num) AS A LEFT JOIN ( select box_id , SUM(qty) as SUMB from stock_issue_item where item_id = '.$id.' group by box_id) as B ON A.box_num = B.box_id');
			//$data = $ci->db->select('box_num, SUM(qty) AS qty')->group_by(array('box_num'))->get_where('stock_entry', array('item_id'=> $id))->result_array();
			$data = $query->result_array();
			return $data;
		}

	function GetPOsSupplier($id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$data = $ci->db->get_where('supplier_po',array('sup_id'=> $id))->result_array();

			return $data;
		}

	// To get array of all the PO of a supplier
	function GetApprovedSPO($id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$data = $ci->db->get_where('supplier_po',array('sup_id'=> $id, 'status'=>1))->result_array();

			$array = array_map (function($value){
                return $value['sup_po_id'];
            } , $data);

			return $array;
		}

  // GET Uninvoiced Ordered Quanity of any item in all CPI
 function GetOrderInHand($item_id)
	 {
			 $ci =& get_instance();
			 $ci->load->database();
			 // Select all CPI with this item
			 $approved_cpi_array = Get_Approved_CPI();

			 $approved_cpi = implode(", ",$approved_cpi_array);

			 // Select all CPI with this item
			 $all_cpi = $ci->db->query("select * FROM customer_pi_item WHERE item_id = $item_id AND cust_pi_id IN ($approved_cpi)");
			 $total = 0;
			 foreach ($all_cpi->result() as $cpi)
			 {
					 $CPI_ID = $cpi->cust_pi_id;
					 $orderd = $cpi->qty;
					 $invoiced = invoiced_quantity($CPI_ID, $item_id); // Find total of invoiced qty
					 $total += $orderd - $invoiced; // Add all the reamining order qty
			 }

			 return $total;

	 }

 // GET Total Order Quantity of an Item
 function Get_Total_Order($item_id)
	 {
		 $ci =& get_instance();
		 $ci->load->database();

		 $approved_cpi_array = Get_Approved_CPI();

		 $approved_cpi = implode(", ",$approved_cpi_array);

		 // Select all CPI with this item
		 $all_cpi = $ci->db->query("select * FROM customer_pi_item WHERE item_id = $item_id AND cust_pi_id IN ($approved_cpi)");
		 $total = 0;
		 foreach ($all_cpi->result() as $cpi)
		 {
				 $CPI_ID = $cpi->cust_pi_id;
				 $orderd = $cpi->qty;
				 $total += $orderd;
		 }

		 return $total;

	 }

 	function Get_Approved_CPI()
 		{
 			$ci =& get_instance();
		 	$ci->load->database();

		 	$data = $ci->db->get_where('customer_pi', array('status'=>1))->result_array();

		 	$array = array_map (function($value){
                return $value['cust_pi_id'];
            } , $data);

		 	return $array;
 		}

	// Get Total Invoiced Quanity of an item in a CPI
	function invoiced_quantity($CPI_id, $item_id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$quantity = $ci->db->select_sum('qty_per_box')->get_where('packing_list_item',array( 'cust_pi'=> $CPI_id, 'item_id'=> $item_id ))->row('qty_per_box');

			if(!$quantity)
				{
					$quantity = 0;
				}

			return $quantity;
		}

	function GRNtoSTOCK($GRN_id, $item_id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$quantity = $ci->db->select_sum('qty')->get_where('stock_entry',array( 'grn_row_id'=> $GRN_id, 'item_id'=> $item_id ))->row('qty');

			if(!$quantity)
				{
					$quantity = 0;
				}

			return $quantity;
		}

  // Get Total Pending qty of an item with supplier(s)
  function GetPendingSPOqty($item_id)
	{

		$ci =& get_instance();
		$ci->load->database();

		$approved_spo_array = Get_Approved_SPO();
		$approved_spo = implode(", ",$approved_spo_array);

		// Select all CPI with this item
		$all_spo = $ci->db->query("select * FROM supplier_po_item WHERE item_id = $item_id AND sup_po_id IN ($approved_spo)");
		$total_pending = 0;
		foreach ($all_spo->result() as $spo)
		{
				$SPO_ID = $spo->sup_po_id;
				$orderd = $spo->qty;
				$received = GoodsRecived($SPO_ID, $item_id); // Find total of orderd qty
				$total_pending += $orderd - $received; // Add all the pending order qty
		}

		return $total_pending;

	}

	// Get Total qty of Approved SPO
  function Get_Total_SPO_QTY($item_id)
	{

		$ci =& get_instance();
		$ci->load->database();

		$approved_spo_array = Get_Approved_SPO();
		$approved_spo = implode(", ",$approved_spo_array);

		// Select all CPI with this item
		$all_spo = $ci->db->query("select * FROM supplier_po_item WHERE item_id = $item_id AND sup_po_id IN ($approved_spo)");
		$total = 0;
		$total_pending = 0;
		foreach ($all_spo->result() as $spo)
		{
				$SPO_ID = $spo->sup_po_id;
				$orderd = $spo->qty;
				$total += $orderd; // Add all the pending order qty
		}

		return $total;

	}

	function Get_Approved_SPO()
 		{
 			$ci =& get_instance();
		 	$ci->load->database();

		 	$data = $ci->db->get_where('supplier_po', array('status'=>1))->result_array();

		 	$array = array_map (function($value){
                return $value['sup_po_id'];
            } , $data);

		 	return $array;
 		}

	// Get Received QTY of an item in a SPO
	function GoodsRecived($SPO_id, $item_id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$query = $ci->db->query('select B.qty from ( select grn_id from grn where status=1 ) AS A RIGHT JOIN ( select SUM(accepted_qty) as qty, grn_row_id from grn_item where supplier_po_id ='.$SPO_id.' AND item_id='.$item_id.' GROUP BY item_id) as B ON A.grn_id = B.grn_row_id');
			$data = $query->row();

			return $data->qty;
		}

	function CheckStock()
		{
			$ci =& get_instance();
		    $ci->load->database();

			$query = $ci->db->query('select A.item_id, A.SUMA , B.SUMB from ( select item_id , SUM(qty) as SUMA from stock_entry group by item_id) AS A LEFT JOIN ( select item_id , SUM(qty) as SUMB from stock_issue_item group by item_id) as B ON A.item_id = B.item_id');
			$data = $query->result_array();

			return $data;
		}

	function CheckStockbyItem($item_id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$query = $ci->db->query('select A.item_id, A.SUMA , B.SUMB from ( select item_id , SUM(qty) as SUMA from stock_entry where item_id = '.$item_id.' group by item_id) AS A LEFT JOIN ( select item_id , SUM(qty) as SUMB from stock_issue_item where item_id = '.$item_id.' group by item_id) as B ON A.item_id = B.item_id');
			$data = $query->row();

			return $data;
		}

	function CheckStockbyItemGroupbyBox($item_id, $box_id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$query = $ci->db->query('select A.item_id, A.SUMA , B.SUMB from ( select item_id , SUM(qty) as SUMA from stock_entry where item_id = '.$item_id.' AND box_num = '.$box_id.' group by item_id) AS A LEFT JOIN ( select item_id , SUM(qty) as SUMB from stock_issue_item where item_id = '.$item_id.' AND box_id = '.$box_id.' group by item_id) as B ON A.item_id = B.item_id');
			$data = $query->row();

			return $data;
		}

	function CustomerOrderQTY($item_id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$query = $ci->db->group_by(array('item_id'))->select_sum('qty')->get_where('customer_pi_item',array( 'item_id'=> $item_id ))->row('qty');

			if( empty($query))
				{
					return 0;
				}
			else
				{
					return $query;
				}
		}

	function SupplierOrderQTY($item_id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$query = $ci->db->group_by(array('item_id'))->select_sum('qty')->get_where('supplier_po_item',array( 'item_id'=> $item_id ))->row('qty');

			return $query;
		}

	// To get total order quantity of the item
	function POPlacedQTY($spo, $item_id)
		{
			$ci =& get_instance();
		    $ci->load->database();

		    $string_spi = implode(',', $spo);

			$qty = $ci->db->query("select SUM(qty) as qty from supplier_po_item WHERE sup_po_id IN ($string_spi) AND item_id = $item_id")->row('qty');
			return $qty;

		}

	function produced_qty( $cpi_id, $item_id )
		{
			$ci =& get_instance();
		    $ci->load->database();

			$query = $ci->db->select_sum('produced_qty')->get_where('production',array( 'cpi_id'=> $cpi_id, 'item_id'=> $item_id ))->row('produced_qty');
			//$data = $query->result_array();

			return $query;
		}

	function total_purchased_qty( $item_id )
		{
			$ci =& get_instance();
		    $ci->load->database();

			$query = $ci->db->group_by(array('item_id'))->select_sum('accepted_qty')->get_where('grn_item',array( 'item_id'=> $item_id ))->row('accepted_qty');
			//$data = $query->result_array();

			return $query;
		}

	function rejection_qty( $item_id )
		{
			$ci =& get_instance();
		    $ci->load->database();

			$query = $ci->db->group_by(array('item_id'))->select_sum('received_qty')->get_where('grn_item',array( 'item_id'=> $item_id ))->row('received_qty');
			//$data = $query->result_array();

			return $query;
		}

	function Shipped_qty( $item_id )
		{
			$ci =& get_instance();
		    $ci->load->database();

			$query = $ci->db->group_by(array('item_id'))->select_sum('qty')->get_where('invoice_item',array( 'item_id'=> $item_id ))->row('qty');
			//$data = $query->result_array();

			return $query;
		}


	function productionHISTORY()
		{
			$ci =& get_instance();
		    $ci->load->database();

			$data = $ci->db->get_where('production')->result_array();

			return $data;
		}

	function is_UserAllowed($action)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$uid = $ci->session->userdata('id');
			$user_data = GetUserData($uid);

			$userRoleData = GetUserRoleData($user_data->role);

			if( $userRoleData->role != 'Admin' )
				{
					$permission_array = unserialize( $userRoleData->permission );

					if (in_array($action, $permission_array))
						{
							return true;
						}
					else
						{
							return false;
						}
				}
			else
				{
					return true;
				}
		}

	function is_UserWebAdmin()
		{
			$ci =& get_instance();
		    $ci->load->database();

			$uid = $ci->session->userdata('id');
			$user_data = GetUserData($uid);

			$userRoleData = GetUserRoleData($user_data->role);

			if( $userRoleData->role == 'webadmin' || $userRoleData->role == 'Admin' )
				{
					return true;
				}
		}

	function Stocked_QTY( $item_id, $CPI )
		{
			$ci =& get_instance();
		    $ci->load->database();

			$query = $ci->db->group_by(array('item_id'))->select_sum('qty')->get_where('stock_entry',array( 'item_id'=> $item_id, 'cpi_no'=> $CPI ))->row('qty');

			return $query;
		}

	function Purchased_Itemqty_of_Origin( $item_id )
		{
			$ci =& get_instance();
		    $ci->load->database();

			//$query = $ci->db->select_sum('qty')->get_where('supplier_po_item',array( 'item_id'=> $item_id ))->row('qty');
			$query = $ci->db->query("SELECT SUM(qty) as sum FROM `supplier_po` as A,`supplier_po_item` as B WHERE A.sup_po_id = B.sup_po_id AND A.status = 1 AND B.item_id = $item_id")->result();

			return $query[0]->sum;
		}

	function Purchased_Items_by_customer( $cid )
		{
			$ci =& get_instance();
		    $ci->load->database();

			$query = $ci->db->query("SELECT item_id , SUM(qty) as qty FROM customer_pi as A , customer_pi_item as B WHERE A.cust_id=$cid AND A.cust_pi_id = B.cust_pi_id AND A.status = 1 GROUP BY B.item_id")->result_array();

			return $query;
		}

	// function getPreviousCPIdata($cid, $item_id)
// 		{
// 			//$cid= $_POST['cust_id'];
// 			//$item_id= $_POST['item_id'];
//
// 			// FIND ALL PI for this customer i.e. $cust_id order by lastest CPI
// 			$cpi_list = $this->db->order_by('id', 'desc')->get_where('customer_pi',array('cust_id' => $cid))->result_array();
//
// 			//$data = array('customer_item_code'=>'');
// 			// $item_unit_id = GetItemData($item_id)->ITEM_UNIT;
// // 			$data['desc'] =  GetItemData($item_id)->ITEM_DESC;
// // 			$data['ppc'] =  GetItemData($item_id)->PURCHASE_PRICE_CODE;
// // 			$data['item_unit'] = GetItemUnit($item_unit_id);
// 			foreach($cpi_list as $cpi)
// 			{
// 				// FIND This item i.e. $item_id in each CPI , IF Item is found , record the data and break the loop
// 				$cpi_item_data = $this->db->get_where('customer_pi_item',array('cust_pi_id'=> $cpi['cust_pi_id'], 'item_id' => $item_id))->result_array();
//
// 				if($cpi_item_data)
// 					{
// 						$customer_item_code = $cpi_item_data[0]['customer_item_code'];
// 						//$data['ppq'] = $cpi_item_data[0]['qty'];
// 						//$data['pp'] = $cpi_item_data[0]['price'];
// 						//$data['customer_item_code'] = $cpi_item_data[0]['customer_item_code'];
// 						//$data['customer_item_barcode'] = $cpi_item_data[0]['customer_item_barcode'];
// 						//$data['packaging'] = $cpi_item_data[0]['Packaging_instructions'];
// 						//break;
// 					}
// 			}
// 			//var_dump($cpi_item_data);
// 			echo $customer_item_code;
// 			//echo $this->db->last_query();
// 		}

	function GetAll_SPO_of_Supplier($id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$data = $ci->db->get_where('supplier_po',array('sup_id'=> $id, 'status'=>1))->result_array();

			return $data;
		}

	function Get_Bill_data($bid)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$data = $ci->db->get_where('supplier_bill',array('bill_id'=>$bid))->row();

			return $data;
		}

	function Get_debit_data($grn_id, $item_id, $spo)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$query = $ci->db->query('select * from grn_item where item_id = '.$item_id.' AND supplier_po_id = '.$spo.' AND grn_row_id = '.$grn_id);
			$data = $query->row();

			return $data;
		}

	function Get_Supplier_Data_by_Array_ID($id)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$query = $ci->db->query('SELECT * FROM supplier WHERE `id` IN ('.$id.')');

			$data = $query->result_array();

			return $data;

		}
		
	function Get_All_Bill_by_Supplier_ID($sid)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$data = $ci->db->get_where('supplier_bill',array('sup_id'=>$sid, 'status'=>1))->result_array();

			return $data;

		}
	
	// GET TOTAL GST OF BILL	
	function Get_Total_GST_of_BILL($bid)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$query = $ci->db->query('SELECT SUM(gst) as gst FROM bill_item WHERE bill_id = '.$bid.' group by bill_id');
			$data = $query->row();
			
			return $data->gst;

		}
		
	// GET TOTAL AMOUNT OF BILL 
	function Get_Total_Amount_of_BILL($bid)
		{
			$ci =& get_instance();
		    $ci->load->database();

			$items = $ci->db->get_where('bill_item',array('bill_id'=>$bid))->result_array();
			$total = 0;
			
			foreach($items as $item)
				{
					$item_price = GetItemData($item['item_id'])->PURCHASE_PRICE;
					$total_amount = $item_price * $item['challan_qty'];
					$total += $total_amount;
				}
			
			return $total;

		}
		
	// GET TOTAL AMOUNT OF BILL 
	function Get_Total_of_Return_GST($bid)
		{
			$ci =& get_instance();
		    $ci->load->database();
		    
			$grn_row_id = $ci->db->get_where('grn',array('bill_id'=>$bid, 'status'=>1))->row('grn_id');
			
			$items = $ci->db->get_where('bill_item',array('bill_id'=>$bid))->result_array();
			
			$total = 0;
			$return_price = 0;
			$return_gst = 0;
			
			foreach($items as $item)
				{
					$price = $ci->db->get_where('supplier_po_item',array('sup_po_id'=>$item['supplier_po_id'], 'item_id'=>$item['item_id']))->row('price'); 
														
					$sv_data = Get_debit_data($grn_row_id, $item['item_id'], $item['supplier_po_id']);
														
					if( $sv_data )
						{
							$accepted_qty = $sv_data->accepted_qty;
						}
					
					$qty = $item['challan_qty'] - $accepted_qty;
					
					$total_amount = $price * $item['challan_qty'];
					
					$return_price += $price * $qty;
					
					$return_gst += ($item['gst']/$item['challan_qty'])*$qty;
				
					$total += $total_amount;
				}
				
			$data['price'] = $return_price;
			$data['gst'] = $return_gst;
			$data['total'] = $total;
			
			return $data;

		}
		
	function Get_shipped_qty_of_Customer($cid, $iid)
		{
			$ci =& get_instance();
		    $ci->load->database();
		    
			$packings = $ci->db->get_where('packing_list',array('cust_id'=>$cid, 'status'=>1))->result_array();
			
			$packing_ids = array_map (function($value){
                return $value['packing_id'];
            } , $packings);
			
			// $total_qty = 0;
// 				
// 			$query = $ci->db->query('SELECT SUM(qty) as qty FROM `packing_list_item` WHERE packing_id IN '.$packing_ids.' AND item_id = '.$iid.' group by item_id');
// 			$data = $query->row();
// 			
			return $packing_ids;
			
		}	


?>
