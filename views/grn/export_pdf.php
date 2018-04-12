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
						<table id="example2" class="table sv_table_heading table-bordered table-hover" style="width:100%; border-spacing: 0; border-collapse: collapse;">
							<tbody>    
								<tr>
									<th style="width: 50%; border:1px solid #000;">GRN Number</th>
									<td style="width: 50%; border:1px solid #000;"><?php echo $grn->grn_number; ?></td>
								</tr>  
								<tr>
									<th style="width: 50%; border:1px solid #000;">Supplier Name</th>
									<td style="width: 50%; border:1px solid #000;"><?=GetSupplierData( Get_Bill_data( $grn->bill_id )->sup_id )->supplier_name;?></td>
								</tr>
								<tr>
									<th style="width: 50%; border:1px solid #000;">Challan Number</th>
									<td style="width: 50%; border:1px solid #000;"><?php echo Get_Bill_data( $grn->bill_id )->challan_num; ?></td>
								</tr> 
								<tr>
									<th style="width: 50%; border:1px solid #000;">Challan Date</th>
									<td style="width: 50%; border:1px solid #000;"><?php echo date("j F, Y", strtotime(Get_Bill_data( $grn->bill_id )->challan_date)); ?></td>
								</tr>   
								<tr>
									<th style="width: 50%; border:1px solid #000;">No. of Boxes</th>
									<td style="width: 50%; border:1px solid #000;"><?php echo Get_Bill_data( $grn->bill_id )->num_of_box; ?></td>
								</tr>
								<!-- 
<tr>
									<th style="width: 50%; border:1px solid #000;">Challan</th>
									<td style="width: 50%; border:1px solid #000;">
										<?php if( $grn->challan_img ): ?>
											<a target="_blank" href="<?=base_url();?>uploads/grn_images/<?php echo $grn->challan_img; ?>">Download</a>
										<?php endif; ?>
									</td>
								</tr> 
								
								<?php if( $grn->status == 1) : ?>
									<tr>
										<th style="width: 50%; border:1px solid #000;">Approved By</th>
										<td style="width: 50%; border:1px solid #000;"><?php echo GetUserData($grn->approved_by)->name; ?></td>
									</tr>
								<?php endif; ?>
								<tr>
									<th style="width: 50%; border:1px solid #000;">Created By</th>
									<td style="width: 50%; border:1px solid #000;"><?php echo GetUserData($grn->created_by)->name; ?></td>
								</tr>
								<tr>
									<th style="width: 50%; border:1px solid #000;">Created At</th>
									<td style="width: 50%; border:1px solid #000;"><?php echo $newDate = date("j F, Y | H:i:s", strtotime($grn->date)); ?></td>
								</tr>
 -->
							</tbody>
						</table>
					</div>
					
				</div><!-- /.row -->

				<!-- Table row -->
				<div class="row">
					<div class="col-xs-12 table-responsive">
						<table class="table table-striped" style="border-collapse: collapse; width:100%">
							<thead>
								<tr>
									<th style="border:1px solid #000;">S.No</th>
									<th style="border:1px solid #000;">Item Code</th>
									<th style="border:1px solid #000;">Item Description</th>
									<th style="border:1px solid #000;">Unit</th>
									<th style="border:1px solid #000;">Supplier PO#</th>
									<th style="border:1px solid #000;">Challan Qty</th>
									<th style="border:1px solid #000;">Recieved Qty</th>
									<th style="border:1px solid #000;">Accepted Qty</th>
									<th style="border:1px solid #000;">Rejected Qty</th>
									<th style="border:1px solid #000;">Diffrence Qty</th>
									<th style="border:1px solid #000;">Stocked Qty</th>
									<th style="border:1px solid #000;">Remarks</th>
									<?php if( is_UserAllowed('update_grn_item') || is_UserAllowed('remove_grn_item') ){ ?>
										<?php if( $grn->status == 2) : ?>
											<th style="border:1px solid #000;">Status</th>
										<?php endif; ?>	
									<?php } ?>
								</tr>                                    
							</thead>
								<?php 	$i=1; 
										$grnItems = GetGRNItems( $grn->grn_id );
										foreach( $grnItems as $grnItem ) : 
										
										$GRNtoSTOCK = GRNtoSTOCK($grnItem['grn_row_id'], $grnItem['item_id']);
								?>
								<tr>
									<td style="border:1px solid #000;"><?=$i;?></td>
									<td style="border:1px solid #000;"><?php echo GetItemData( $grnItem['item_id'] )->ITEM_CODE; ?></td>
									<td style="border:1px solid #000;"><?php echo GetItemData( $grnItem['item_id'] )->ITEM_DESC; ?></td>
									<td style="border:1px solid #000;"><?php echo GetItemUnit( GetItemData( $grnItem['item_id'] )->ITEM_UNIT); ?></td>
									<td style="border:1px solid #000;"><?php echo SPOData($grnItem['supplier_po_id'])->po_num; ?></td>
									<td style="border:1px solid #000;"><?php echo $grnItem['challan_qty']; ?></td>
									<td style="border:1px solid #000;"><?php echo $grnItem['received_qty']; ?></td>
									<td style="border:1px solid #000;"><?php echo $grnItem['accepted_qty']; ?></td>
									<td style="border:1px solid #000;"><?php echo $grnItem['received_qty'] - $grnItem['accepted_qty']; ?></td>
									<td style="border:1px solid #000;"><?php echo $grnItem['received_qty'] - $grnItem['challan_qty']; ?></td>
									<td style="border:1px solid #000;" <?php if( $grnItem['accepted_qty'] > $GRNtoSTOCK ) { echo 'class="uninvoiced_column_red"'; } ?> ><?php echo $GRNtoSTOCK; ?></td>
									<td style="border:1px solid #000;"><?php echo $grnItem['remarks']; ?></td>
									<?php if( is_UserAllowed('update_grn_item') || is_UserAllowed('remove_grn_item') ){ ?>
										<?php if( $grn->status == 2) : ?>
										<td style="border:1px solid #000;">
										
											<?php if( is_UserAllowed('update_grn_item')){ ?>
												<a style="color:orange;" href="<?=base_url('grn/editGrnItem/'.$grnItem['id']); ?>">Update</a> | 
											<?php } ?>
										
											<?php if( is_UserAllowed('remove_grn_item')){ ?>
												<a style="color:red;" class="remove_grn_item" rowid="<?php echo $grnItem['id']; ?>" href="#">Remove</a>
											<?php } ?>
										
										</td>
										<?php endif; ?>
									<?php } ?>
								</tr>    
								<?php $i++; endforeach; ?>
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