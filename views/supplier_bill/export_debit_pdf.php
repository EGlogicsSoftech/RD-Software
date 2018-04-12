<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Rickshaw Delivery | <?=$title;?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?=base_url();?>admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?=base_url();?>admin/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="<?=base_url();?>admin/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?=base_url();?>admin/css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>admin/css/custom_style.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-black">
		 
		<div class="wrapper row-offcanvas row-offcanvas-left">
            <section class="content" style="border:3px solid #000;">                    
				<!-- title row -->
				<div class="row" style="padding:5px;">
					<div class="col-xs-12">
						<h2 class="page-header">
							<i class="fa fa-globe"></i>RICKSHAW DELIVERY
							<small class="pull-right">(Est.2004)</small>
						</h2>                            
					</div><!-- /.col -->
				</div> 
				<!-- info row -->
				<div class="row" style="margin-bottom:20px; border-bottom:1px solid #000; padding:5px;">
					<div class="col-md-6 invoice-col">
						<table id="example2" class="table sv_table_heading table-bordered table-hover" style="border-spacing: 0; border-collapse: collapse;">
							<tbody> 
								<tr>
									<th style="width: 50%; border:1px solid #000;">Supplier Name</th>
									<td style="width: 50%; border:1px solid #000;"><?=GetSupplierData( $bill->sup_id )->supplier_name;?></td>
								</tr>
								<tr>
									<th style="width: 50%; border:1px solid #000;">Challan Number</th>
									<td style="width: 50%; border:1px solid #000;"><?php echo $bill->challan_num; ?></td>
								</tr> 
								<tr>
									<th style="width: 50%; border:1px solid #000;">Challan Date</th>
									<td style="width: 50%; border:1px solid #000;"><?php echo date("j F, Y", strtotime($bill->challan_date)); ?></td>
								</tr>   
								<tr>
									<th style="width: 50%; border:1px solid #000;">No. of Boxes</th>
									<td style="width: 50%; border:1px solid #000;"><?php echo $bill->num_of_box; ?></td>
								</tr>
							</tbody>
						</table>
					</div>
					
				</div><!-- /.row -->

				<!-- Table row -->
				<div class="row">
					<div class="col-xs-12 table-responsive">
						<table id="example1" class="table sv_table_heading table-bordered table-hover" style="width:100%; border-spacing: 0; border-collapse: collapse;">
							<thead>
								<tr>
									<th style="border:1px solid #000;">S.No</th>
									<th style="border:1px solid #000;">Item Code</th>
									<th style="border:1px solid #000;">Item Description</th>
									<th style="border:1px solid #000;">Unit</th>
									<th style="border:1px solid #000;">Qty</th>
									<th style="border:1px solid #000;">Price</th>
									<th style="border:1px solid #000;">Amount</th>
									<th style="border:1px solid #000;">GST</th>
									<!-- 
<th>Accepted Qty</th>
									<th>Rejected Qty</th>
									<th>Diffrence Qty</th>
									<th>Stocked Qty</th>
									<th>Remarks</th>
-->
									<?php if( is_UserAllowed('update_bill_item') || is_UserAllowed('remove_bill_item') ){ ?>
										<?php if( $bill->status == 2) : ?>
											<th>Status</th>
										<?php endif; ?>	
									<?php } ?>

								</tr>
							</thead>
							<tbody>    
								<?php 	$i=1; 
										$grn_row_id = $this->db->get_where('grn',array('bill_id'=>$bill->bill_id, 'status'=>1))->row('grn_id');
										$billitems = GetBillItems( $bill->bill_id );
										foreach( $billitems as $billitem ) : 
										
										$price = $this->db->get_where('supplier_po_item',array('sup_po_id'=>$billitem['supplier_po_id'], 'item_id'=>$billitem['item_id']))->row('price'); 
										
										$sv_data = Get_debit_data($grn_row_id, $billitem['item_id'], $billitem['supplier_po_id']);
										
										if( $sv_data )
											{
												$accepted_qty = $sv_data->accepted_qty;
											}
										
										$qty = $billitem['challan_qty'] - $accepted_qty;
								?>
								<?php if( $qty > 0 ){ ?>
									<tr>
										<td style="border:1px solid #000;"><?=$i;?></td>
										<td style="border:1px solid #000;"><?php echo GetItemData( $billitem['item_id'] )->ITEM_CODE; ?></td>
										<td style="border:1px solid #000;"><?php echo GetItemData( $billitem['item_id'] )->ITEM_DESC; ?></td>
										<td style="border:1px solid #000;"><?php echo GetItemUnit( GetItemData( $billitem['item_id'] )->ITEM_UNIT); ?></td>
										<td style="border:1px solid #000;"><?php echo $qty; ?></td>
										<td style="border:1px solid #000;"><?php echo $price; ?></td>
										<td style="border:1px solid #000;"><?php echo $price * $qty; ?></td>
										<td style="border:1px solid #000;"><?php echo $billitem['gst']; ?></td>
										<!-- 
	<td><?php echo $grnItem['accepted_qty']; ?></td>
										<td><?php echo $grnItem['received_qty'] - $grnItem['accepted_qty']; ?></td>
										<td><?php echo $grnItem['received_qty'] - $grnItem['challan_qty']; ?></td>
										<td <?php if( $grnItem['accepted_qty'] > $GRNtoSTOCK ) { echo 'class="uninvoiced_column_red"'; } ?> ><?php echo $GRNtoSTOCK; ?></td>
										<td><?php echo $grnItem['remarks']; ?></td>
	-->
										<?php if( is_UserAllowed('update_bill_item') || is_UserAllowed('remove_bill_item') ){ ?>
											<?php if( $bill->status == 2) : ?>
											<td style="border:1px solid #000;">
										
												<?php if( is_UserAllowed('update_bill_item')){ ?>
													<a style="color:orange;" href="<?=base_url('supplier_bill/editBillItem/'.$billitem['id']); ?>">Update</a> 
												<?php } ?>
										
												<!-- 
	<?php if( is_UserAllowed('remove_bill_item')){ ?>
													<a style="color:red;" class="remove_bill_item" rowid="<?php echo $billitem['id']; ?>" href="#">Remove</a>
												<?php } ?>
	-->
										
											</td>
											<?php endif; ?>
										<?php } ?>

									</tr> 
								<?php } $i++; endforeach; ?>
							</tbody>
						</table>                        
					</div><!-- /.col -->
				</div><!-- /.row -->


			</section><!-- /.content -->
		
		</div>
		
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="<?=base_url();?>admin/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="<?=base_url();?>admin/js/AdminLTE/app.js" type="text/javascript"></script>

	</body>
</html>