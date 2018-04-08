<?php
// We change the headers of the page so that the browser will know what sort of file is dealing with. Also, we will tell the browser it has to treat the file as an attachment which cannot be cached.

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=SPO-".$supplier_po->po_num.".xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<table class="table table-striped" style="border-collapse: collapse; width:100%">
	<thead>
		<tr>
			<th colspan="7" style="border:1px solid #000; text-align:center;">Supplier Purchase Order</th>
		</tr> 
		<tr>
			<th colspan="3" style="border:1px solid #000;">P.O.NO</th>
			<td colspan="4" style="border:1px solid #000;"><?php echo $supplier_po->po_num; ?></td>
		</tr>  
		<tr>
			<th colspan="3" style="border:1px solid #000;">Delivery Date</th>
			<td colspan="4" style="border:1px solid #000;"><?php echo $supplier_po->delivery_date; ?></td>
		</tr> 
		<tr>
			<th colspan="3" style="border:1px solid #000;">Supplier Name</th>
			<td colspan="4" style="border:1px solid #000;"><?php echo GetSupplierData( $supplier_po->sup_id )->supplier_name; ?></td>
		</tr>                                    
	</thead>
	<?php $sup_po_items = GetSupPOItem( $supplier_po->sup_po_id ); ?>
	<tbody>
	</tbody>
</table>
	
<table class="table table-striped" style="border-collapse: collapse; width:100%">
	<thead>
		<tr>
			<th style="border:1px solid #000;">Sr#</th>
			<!-- <th style="border:1px solid #000;">Pictures</th> -->
			<th style="border:1px solid #000;">Item #</th>
			<th style="border:1px solid #000;">Description</th>
			<th style="border:1px solid #000;">Qty</th>
			<th style="border:1px solid #000;">Unit</th>
			<th style="border:1px solid #000;">Rate</th>
			<th style="border:1px solid #000;">Amount</th>
		</tr>                                    
	</thead>
	<?php $sup_po_items = GetSupPOItem( $supplier_po->sup_po_id ); $total = 0; ?>
	<tbody>
		<?php 	$i=1; 
				foreach( $sup_po_items as $sup_po_item ) : 
	
				$amount = $sup_po_item['qty'] * $sup_po_item['price'];
				$item_img = GetItemData( $sup_po_item['item_id'] )->ITEM_IMAGE;
				$itemUnitID = GetItemData( $sup_po_item['item_id'] )->ITEM_UNIT;
				$good_recived = GoodsRecived($supplier_po->sup_po_id, $sup_po_item['item_id']);
				
				$total+= $amount;
		?>
		<tr>
			<td style="border:1px solid #000;"><?=$i;?></td>
			<!-- 
<td style="border:1px solid #000;">
				<?php if( $item_img ): ?>
					<img style="width:100px;" src="<?=base_url();?>uploads/item_images/<?php echo $item_img; ?>" />
				<?php else : ?>
					<img style="width:100px;" src="<?=base_url();?>uploads/no-image-available.jpg" />
				<?php endif; ?>
			</td>
 -->
			<td style="border:1px solid #000;"><?php echo GetItemData( $sup_po_item['item_id'] )->ITEM_CODE; ?></td>
			<td style="border:1px solid #000;"><?php echo GetItemData( $sup_po_item['item_id'] )->ITEM_DESC; ?></td>
			<td style="border:1px solid #000;"><?php echo $sup_po_item['qty']; ?></td>
			<td style="border:1px solid #000;"><?php echo GetItemUnit($itemUnitID); ?></td>
			<td style="border:1px solid #000;"><?php echo $sup_po_item['price']; ?></td>
			<td style="border:1px solid #000;"><?php echo $amount; ?></td>
		
		</tr>    
		<?php $i++; endforeach; ?>
		<tr>
			<td style="border:1px solid #000;" colspan="6">GROSS Total</td>
			<td style="border:1px solid #000;"><?php echo $total; ?></td>
		</tr>
	</tbody>
</table>