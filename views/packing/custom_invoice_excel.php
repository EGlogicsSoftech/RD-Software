<?php
// We change the headers of the page so that the browser will know what sort of file is dealing with. Also, we will tell the browser it has to treat the file as an attachment which cannot be cached.
//var_dump($packing_list);
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=custom-invoice/".$packing_list->packing_id.".xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table class="table table-striped" style="border-collapse: collapse; width:100%">
	<thead>
		<tr>
			<th style="border:1px solid #000;">S.No</th>
			<th style="border:1px solid #000;">Box No.</th>
			<th style="border:1px solid #000;">RD Item Code</th>
			<th style="border:1px solid #000;">Customer Item Code</th>
			<th style="border:1px solid #000;">HSN Code</th>
			<th style="border:1px solid #000;">Description</th>
			<th style="border:1px solid #000;">Item Category</th>
			<th style="border:1px solid #000;">Net Weight</th>
			<th style="border:1px solid #000;">Total Qty</th>
			<th style="border:1px solid #000;">Unit</th>
			<th style="border:1px solid #000;">Price Per Unit</th>
			<th style="border:1px solid #000;">FOB Value</th>
			<th style="border:1px solid #000;">Customer Name</th>
			<th style="border:1px solid #000;">PI Number</th>
		</tr>                                    
	</thead>
	<?php $packingitems = GetPackingItem( $packing_list->packing_id ); ?>
	<tbody>    
		<?php 	$i=1; 
				foreach( array_reverse($packingitems) as $item ) : 
		?>
		<tr>
			<td style="border:1px solid #000; text-align:center;"><?=$i;?></td>
			<td style="border:1px solid #000; text-align:center;"><?php echo $item['box_num']; ?></td>
			<td style="border:1px solid #000; text-align:center;"><?php echo GetItemData( $item['item_id'] )->ITEM_CODE; ?></td>
			<td style="border:1px solid #000; text-align:center;"><?php echo CPIItemdata( $item['cust_pi'], $item['item_id'] )->customer_item_code; ?></td>
			<td style="border:1px solid #000; text-align:center;"><?php echo GetItemData( $item['item_id'] )->HSN_CODE; ?></td>
			<td style="border:1px solid #000;"><?php echo GetItemData( $item['item_id'] )->ITEM_CUSTOM_DESC; ?></td>
			<td style="border:1px solid #000; text-align:center;"><?php echo Get_Item_Category_Name( GetItemData( $item['item_id'] )->CATEGORY_NAME ); ?></td>
			<td style="border:1px solid #000; text-align:center;"><?php echo $item['qty_per_box'] * GetItemData( $item['item_id'] )->NET_WEIGHT; ?></td>
			<td style="border:1px solid #000; text-align:center;"><?php echo $item['qty_per_box']; ?></td>
			<td style="border:1px solid #000; text-align:center;"><?php echo GetItemUnit( GetItemData( $item['item_id'] )->ITEM_UNIT ); ?></td>
			<td style="border:1px solid #000; text-align:center;"><?php echo '$ '.$item['price']; ?></td>
			<td style="border:1px solid #000; text-align:center;"><?php echo '$ '.$item['qty_per_box'] * $item['price']; ?></td>
			<td style="border:1px solid #000; text-align:center; background-color:<?php echo GetCustomerData( $item['customer_id'] )->color; ?>;"><?php echo GetCustomerData( $item['customer_id'] )->name; ?></td>
			<td style="border:1px solid #000; text-align:center; background-color:<?php echo GetCustomerData( $item['customer_id'] )->color; ?>;"><?php echo CPIdata( $item['cust_pi'])->pi_num; ?></td>
		
		</tr>    
		<?php $i++; endforeach; ?>
	</tbody>
</table>  	