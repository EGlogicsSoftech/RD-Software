<?php
// We change the headers of the page so that the browser will know what sort of file is dealing with. Also, we will tell the browser it has to treat the file as an attachment which cannot be cached.
var_dump($invoice);
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=INVOICE-".$invoice->invoice_id.".xls");
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
			<th style="border:1px solid #000;">Description</th>
			<th style="border:1px solid #000;">Net Weight in KG</th>
			<th style="border:1px solid #000;">Qty</th>
			<th style="border:1px solid #000;">Units</th>
			<th style="border:1px solid #000;">Rate</th>
			<th style="border:1px solid #000;">FOB Value</th>
			<th style="border:1px solid #000;">PI Number</th>
			<th style="border:1px solid #000;">Dummy Box Number</th>
		</tr>                                    
	</thead>
	<tbody>  
		<?php $invoiceitems = GetInvoiceItem( $invoice->invoice_id ); ?>  
		<?php $i=1; foreach( $invoiceitems as $item ) : ?>
		<tr>
			<td style="border:1px solid #000;"><?=$i;?></td>
			<td style="border:1px solid #000;"><?php echo $item['box_num']; ?></td>
			<td style="border:1px solid #000;"><?php echo GetItemData( $item['item_id'] )->ITEM_CODE; ?></td>
			<td style="border:1px solid #000;"><?php echo CPIItemdata( $item['cust_pi'], $item['item_id'] )->customer_item_code; ?></td>
			<td style="border:1px solid #000;"><?php echo GetItemData( $item['item_id'] )->ITEM_DESC; ?></td>
			<td style="border:1px solid #000;"><?php echo GetItemData( $item['item_id'] )->NET_WEIGHT; ?></td>
			<td style="border:1px solid #000;"><?php echo $item['qty']; ?></td>
			<td style="border:1px solid #000;"><?php echo GetItemUnit( GetItemData( $item['item_id'] )->ITEM_UNIT ); ?></td>
			<td style="border:1px solid #000;"><?php echo CPIItemdata( $item['cust_pi'], $item['item_id'] )->price; ?></td>
			<td style="border:1px solid #000;"><?php echo $item['qty'] * CPIItemdata( $item['cust_pi'], $item['item_id'] )->price; ?></td>
			<td style="border:1px solid #000;"><?php echo CPIdata( $item['cust_pi'] )->pi_num; ?></td>
			<td style="border:1px solid #000;"><?php echo $item['d_box_num']; ?></td>
		</tr>    
		<?php $i++; endforeach; ?>
	</tbody>
</table>