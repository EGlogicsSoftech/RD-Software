<?php
// We change the headers of the page so that the browser will know what sort of file is dealing with. Also, we will tell the browser it has to treat the file as an attachment which cannot be cached.

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=SI-".$stock_issue->ref_id.".xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<table class="table table-striped" style="border-collapse: collapse; width:100%">
	<thead>
		<tr>
			<th style="border:1px solid #000;">S.No</th>
			<th style="border:1px solid #000;">Item Image</th>
			<th style="border:1px solid #000;">Item Code</th>
			<th style="border:1px solid #000;">Item Description</th>
			<th style="border:1px solid #000;">Box Number</th>
			<th style="border:1px solid #000;">Quantity</th>
			<th style="border:1px solid #000;">Issued</th>
		</tr>                                    
	</thead>
	<?php $issueItems = GetStockIssueItems( $stock_issue->stock_issue_id ); ?>
	<tbody>    
		<?php 	$i=1; 
				foreach( $issueItems as $issueItem ) : 
				$item_img = GetItemData( $issueItem['item_id'] )->ITEM_IMAGE;
		?>
		<tr>
			<td style="border:1px solid #000;"><?=$i;?></td>
			<td style="border:1px solid #000;">
				<a href="/item/view/<?php echo GetItemData( $issueItem['item_id'] )->ID; ?>">
					<?php if( $item_img ): ?>
						<img width="80" height="65" src="<?=base_url();?>uploads/item_images/<?php echo $item_img; ?>" />
					<?php else : ?>
						<img width="80" height="65" src="<?=base_url();?>uploads/no-image-available.jpg" />
					<?php endif; ?>
				</a>
			</td>
			<td style="border:1px solid #000;"><?php echo GetItemData( $issueItem['item_id'] )->ITEM_CODE; ?></td>
			<td style="border:1px solid #000;"><?php echo GetItemData( $issueItem['item_id'] )->ITEM_DESC; ?></td>
			<td style="border:1px solid #000;"><?php echo $issueItem['box_id']; ?></td>
			<td style="border:1px solid #000;"><?php echo $issueItem['qty']; ?></td>
			<td style="border:1px solid #000;"><?php if( $issueItem['issued'] == 1 ) { echo "YES"; }else{ echo "NO"; } ?></td>
		</tr>    
		<?php $i++; endforeach; ?>
	</tbody>
</table>