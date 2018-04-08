<?php
// We change the headers of the page so that the browser will know what sort of file is dealing with. Also, we will tell the browser it has to treat the file as an attachment which cannot be cached.

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=CPI-".$customer_pi->pi_num.".xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<table class="table table-striped" style="border-collapse: collapse; width:100%">
	<thead>
		<tr>
			<td style="border:1px solid #000;"><strong>RICKSHAW DELIVERY</strong> (Est.2004)</td>
		</tr> 
		<tr>
			<td style="border:1px solid #000;">C - 31, Sector - 7, Noida - 201 301 U P</td>
		</tr>
		<tr>
			<td style="border:1px solid #000;">PH :0120 - 4350340 / 4260511</td>
		</tr>
		<tr>
			<td style="border:1px solid #000;">E-mail: oceanic@oceaniclink.com/marketing@rickshawdelivery.com</td>
		</tr>
		<tr>
			<td style="border:1px solid #000;"><strong>EPCH Membership No. EPCH/REG/27736/2008-09</strong></td>
		</tr>
		<tr>
			<th colspan="3" style="border:1px solid #000;">P.I.NO</th>
			<td colspan="9" style="border:1px solid #000;"><?php echo $customer_pi->pi_num; ?></td>
		</tr>  
		<tr>
			<th colspan="3" style="border:1px solid #000;">Date</th>
			<td colspan="9" style="border:1px solid #000;"><?php if( $customer_pi->pi_date ) : echo $customer_pi->pi_date; endif; ?></td>
		</tr> 
		<tr>
			<th colspan="3" style="border:1px solid #000;">Supplier Name</th>
			<td colspan="9" style="border:1px solid #000;"><?php echo GetCustomerData( $customer_pi->cust_id )->name; ?></td>
		</tr>                                    
	</thead>
	<tbody>
	</tbody>
</table>
	
<table class="table table-striped" style="border-collapse: collapse; width:100%">
	<thead>
		<tr>
			<th style="border:1px solid #000;">S.No</th>
			<!-- <th style="border:1px solid #000;">Item Image</th> -->
			<th style="border:1px solid #000;">Item Code</th>
			<th style="border:1px solid #000;">Customer Item Code</th>
			<th style="border:1px solid #000;">HS Code</th>
			<th style="border:1px solid #000;">Item Description</th>
			<th style="border:1px solid #000;">Required Qty</th>
			<th style="border:1px solid #000;">Invoiced Qty</th>
			<th style="border:1px solid #000;">Unit</th>
			<th style="border:1px solid #000;">Inner Box Size</th>
			<th style="border:1px solid #000;">Outer Box Size</th>
			<th style="border:1px solid #000;">Outer Box Quantity</th>
			<th style="border:1px solid #000;">CBM</th>
			<th style="border:1px solid #000;">Price Per Unit</th>
			<th style="border:1px solid #000;">Amount</th>
		</tr>                                    
	</thead>
	<?php $cust_pi_items = GetCustPIItem( $customer_pi->cust_pi_id ); ?>
	<tbody>
		<?php 	$i=1; 
				foreach( $cust_pi_items as $cust_pi_item ) : 
				$totalCBM;
				$amount = $cust_pi_item['qty'] * $cust_pi_item['price'];
				$item_img = GetItemData( $cust_pi_item['item_id'] )->ITEM_IMAGE;
				$itemUnitID = GetItemData( $cust_pi_item['item_id'] )->ITEM_UNIT;
				$invoiced_quantity = invoiced_quantity($cust_pi_item['cust_pi_id'], $cust_pi_item['item_id']);
				$QtyMstrBox = GetItemData( $cust_pi_item['item_id'] )->OUTER_BOX_QTY;
				$outerBoxCBM = GetOuterBoxData( GetItemData( $cust_pi_item['item_id'] )->OUTER_BOX )->CBM;
				$outerBoxQty = ceil($cust_pi_item['qty'] / $QtyMstrBox);
				$totalCBM += $outerBoxQty * $outerBoxCBM;
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
			<td style="border:1px solid #000;"><?php echo GetItemData( $cust_pi_item['item_id'] )->ITEM_CODE; ?></td>
			<td style="border:1px solid #000;"><?php echo $cust_pi_item['customer_item_code']; ?></td>
			<td style="border:1px solid #000;"><?php echo $cust_pi_item['hs_code']; ?></td>
			<td style="border:1px solid #000;"><?php echo GetItemData( $cust_pi_item['item_id'] )->ITEM_DESC; ?></td>
			<td style="border:1px solid #000;"><?php echo $cust_pi_item['qty']; ?></td>
			<td style="border:1px solid #000;" <?php if( $invoiced_quantity < $cust_pi_item['qty']) { echo 'class="uninvoiced_column_red"'; } ?> ><?=$invoiced_quantity; ?></td>
			<td style="border:1px solid #000;"><?php echo GetItemUnit($itemUnitID); ?></td>
			<td style="border:1px solid #000;">
				<?php if(GetInnerBox( GetItemData( $cust_pi_item['item_id'] )->INNER_BOX )) { echo GetInnerBox( GetItemData( $cust_pi_item['item_id'] )->INNER_BOX ); } else { echo "N/A"; } ?>
			</td>
			<td style="border:1px solid #000;">
				<?php if(GetInnerBox( GetItemData( $cust_pi_item['item_id'] )->OUTER_BOX )) { echo GetInnerBox( GetItemData( $cust_pi_item['item_id'] )->OUTER_BOX ); } else { echo "N/A"; } ?>
			</td>
			<td style="border:1px solid #000;"><?php echo $outerBoxQty; ?></td>
			<td style="border:1px solid #000;"><?php echo $outerBoxQty * $outerBoxCBM; ?></td>
			<td style="border:1px solid #000;"><?php echo $cust_pi_item['price']; ?></td>
			<td style="border:1px solid #000;"><?php echo $amount; ?></td>
			<!-- 
<td>
				<a style="color:red;" href="<?=base_url('item');?>">Remove</a>
			</td>
-->
		</tr>    
		<?php $i++; endforeach; ?>
		<tr>
			<td style="border:1px solid #000; text-align:right;font-size:20px;" colspan="11">Total CBM</td>
			<td style="border:1px solid #000; text-align:left;font-size:20px;" colspan="3"><?php echo $totalCBM; ?></td>
		</tr>
	</tbody>
</table>