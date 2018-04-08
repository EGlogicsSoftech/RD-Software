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
					<div class="col-md-9" style="width:75%; float:left;">
						<h2 class="page-header">
							<i class="fa fa-globe"></i>RICKSHAW DELIVERY
							<small class="pull-right">(Est.2004)</small>
						</h2>
					</div><!-- /.col -->
					<div class="col-md-3" style="width:25%; float:left;">
						<img style="width:100px;" src="<?=base_url();?>uploads/rickshaw_delivery.png" />
					</div><!-- /.col -->
				</div>
				<!-- info row -->
				<div class="row" style="margin-bottom:20px; border-bottom:1px solid #000; padding:5px;">

					<div class="col-sm-4 invoice-col" style="width:33.33%; float:left;">
						<p style="font-size:12px;">
							C - 31, Sector - 7, Noida - 201301 U.P<br>
							PH: 0120 - 4350340 / 4260511<br>
							Email: marketing@rickshawdelivery.com<br/>oceanic@oceaniclink.com<br/>
							<b>TIN NO: 9465702772</b>
						</p>
					</div>

				</div><!-- /.row -->
				<div class="row" style="margin-top:20px; padding:5px; padding-bottom:20px; border-bottom:1px solid #000;">
					<div class="col-sm-4 invoice-col" style="width:50%; float:left; font-size:12px;">
						<b>Buyer Name: </b><?php echo GetCustomerData( $customer_pi->cust_id )->name; ?><br/>
						<b>Buyer Address: </b><?php echo GetCustomerData( $customer_pi->cust_id )->cust_add; ?><br/>
						<b>Payment Terms: </b>20% Advance and Rest before delivery of Goods<br/>
						<b>Price Terms: </b>USD-FOB
					</div><!-- /.col -->

					<div class="col-sm-4 invoice-col" style="width:50%; float:right; text-align:right:">
						<b>Proforma Invoice</b><br/>
						<br/>
						<b>Date:</b> <?php echo $customer_pi->created_at; ?><br/>
						<b>P.I.NO:</b> <?php echo $customer_pi->pi_num; ?><br/>
						<b>Phonix PO:</b> #######
					</div><!-- /.col -->
				</div>

				<!-- Table row -->
				<div class="row">
					<div class="col-xs-12 table-responsive">
						<table class="table table-striped" style="border-collapse: collapse; width:100%">
							<thead>
								<tr>
									<th style="border:1px solid #000;">S.No</th>
									<th style="border:1px solid #000;">Item Image</th>
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
								<?php
                    $i=1;
                    $totalCBM = 0;
										foreach( $cust_pi_items as $cust_pi_item ) :

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
									<td style="border:1px solid #000;">
										<?php if( $item_img ): ?>
											<img style="width:100px;" src="<?=base_url();?>uploads/item_images/<?php echo $item_img; ?>" />
										<?php else : ?>
											<img style="width:100px;" src="<?=base_url();?>uploads/no-image-available.jpg" />
										<?php endif; ?>
									</td>
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
									<td style="border:1px solid #000; text-align:right;font-size:20px;" colspan="12">Total CBM</td>
									<td style="border:1px solid #000;font-size:20px;" colspan="3"><?php echo $totalCBM; ?></td>
								</tr>
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
