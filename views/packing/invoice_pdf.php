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
					<div class="col-sm-4 invoice-col" style="width:33.33%; float:left;">
						<p style="font-size:12px;">
							C - 31, Sector - 7, Noida - 201301 U.P<br>
							PH: 0120 - 4350340 / 4260511<br>
							Email: info@rickshawdelivery.com<br/>
							<b>TIN NO: 9465702772</b>
						</p>
					</div><!-- /.col -->
					<div class="col-sm-4 invoice-col" style="width:33.33%; float:left;">
						
					</div><!-- /.col -->
					<!-- 
<div class="col-sm-4 invoice-col" style="width:33.33%; float:right; text-align:right:">
						<b>Purchase Order</b><br/>
						<br/>
						<b>Date:</b> <?php echo $supplier_po->created_at; ?><br/>
						<b>P.O.NO:</b> <?php echo $supplier_po->po_num; ?>
					</div><!~~ /.col ~~>
 -->
					
				</div><!-- /.row -->
				<!-- 
<div class="row" style="margin-top:20px; padding:5px; padding-bottom:20px; border-bottom:1px solid #000;">
					<div class="col-sm-4 invoice-col" style="width:50%; float:left; font-size:12px;">
						<b><?php echo GetSupplierData( $supplier_po->sup_id )->supplier_name; ?></b><br/>
						<?php echo GetSupplierData( $supplier_po->sup_id )->full_add; ?><br/><br/>
						<p style="font-size:12px;">
							We are pleased to place the order as detailed below. Supply as per the terms & <br/>
							condition mentioned below the order :-
						</p>
					</div><!~~ /.col ~~>
					
					<div class="col-sm-4 invoice-col" style="width:50%; float:right; text-align:right:">
						Delivery Date : <b> <?php echo $supplier_po->delivery_date; ?></b>
					</div><!~~ /.col ~~>
				</div>
 -->

				<!-- Table row -->
				<div class="row">
					<div class="col-xs-12 table-responsive">
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
									<td style="border:1px solid #000; text-align:center;"><?php echo GetItemData( $item['item_id'] )->ITEM_DESC; ?></td>
									<td style="border:1px solid #000; text-align:center;"><?php echo Get_Item_Category_Name( GetItemData( $item['item_id'] )->CATEGORY_NAME ); ?></td>
									<td style="border:1px solid #000; text-align:center;"><?php echo $item['qty_per_box'] * GetItemData( $item['item_id'] )->NET_WEIGHT; ?></td>
									<td style="border:1px solid #000; text-align:center;"><?php echo $item['qty']; ?></td>
									<td style="border:1px solid #000; text-align:center;"><?php echo GetItemUnit( GetItemData( $item['item_id'] )->ITEM_UNIT ); ?></td>
									<td style="border:1px solid #000; text-align:center;"><?php echo '$ '.$item['price']; ?></td>
									<td style="border:1px solid #000; text-align:center;"><?php echo '$ '.$item['qty'] * $item['price']; ?></td>
									<td style="border:1px solid #000; text-align:center; background-color:<?php echo GetCustomerData( $item['customer_id'] )->color; ?>;"><?php echo GetCustomerData( $item['customer_id'] )->name; ?></td>
									<td style="border:1px solid #000; text-align:center; background-color:<?php echo GetCustomerData( $item['customer_id'] )->color; ?>;"><?php echo CPIdata( $item['cust_pi'])->pi_num; ?></td>
								
								</tr>    
								<?php $i++; endforeach; ?>
							</tbody>
						</table>                            
					</div><!-- /.col -->
				</div><!-- /.row -->

				<div class="row">
					<!-- accepted payments column -->
					<div class="col-xs-6">
						<p class="lead">Terms & Conditions</p>
						<p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
							Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
						</p>
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