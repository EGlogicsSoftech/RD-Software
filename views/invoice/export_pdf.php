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
				<div style="margin-bottom:20px; border-bottom:1px solid #000; padding:5px;">
				
					<div style="width:60%; float:left;">
						<p style="font-size:12px;">
							<b>EXPORTER</b><br>
							RICKSHAW DELIVERY (Est.2004)<br>
							C - 31, Sector - 7, Noida - 201301 U.P<br>
							PH: 0120 - 4350340 / 4260511<br>
							Email: info@rickshawdelivery.com<br/>
							<b>TIN NO: 9465702772</b><br/><br/><br/>
							<p style="font-size:12px;">
							<b>CONSIGNEE</b><br>
							<?php echo GetCustomerData( $invoice->cust_id )->name; ?><br/>
							<?php echo GetCustomerData( $invoice->cust_id )->cust_add; ?><br/>
						</p>
						</p>
					</div>
					
					<div style="width:40%; float:right;">
						<b>Invoice No:</b> <?php echo $invoice->invoice_num; ?><br/>
						<b>Date:</b> <?php echo $invoice->date; ?><br/>
						<b>Exporter ref. No:</b> #######<br/>
						<b>Buyer Order & ref:</b> #######<br/>
						<b>Other References:</b> #######<br/>
						<b>IEC CODE NO:</b> 0504070860<br/>
						<b>TIN NO:</b> 09465702772<br/>
						<b>Service Tax No:</b> AAHFR1192BSD003<br/>
						<b>Buyer ( if other than consignee ):</b> <br/>
						<b>Country of Origin of goods:</b> 
						<b>Buyer ( if other than consignee ):</b> <br/>
						<b>Country of Origin of Goods:</b> INDIA <br/>
						<b>Country of Final Destination:</b>  <br/>
						<b>Batch No:</b>  <br/>
						<b>Spices Used:</b>  <br/>
						<b>VRIKSH Certificate Code:</b>  <br/>
						<b>Mango & Sheesham Wood Spices are VRI</b>  <br/>
					</div>
					
				</div>

				<!-- Table row -->
				<div class="row">
					<div class="col-xs-12 table-responsive">
						<table class="table table-striped" style="border-collapse: collapse; width:100%">
							<thead>
								<tr>
									<th style="border:1px solid #000;">S.No</th>
									<th style="border:1px solid #000;">Customer PI</th>
									<th style="border:1px solid #000;">Item Code</th>
									<th style="border:1px solid #000;">Quantity</th>
									<th style="border:1px solid #000;">Price Per Unit</th>
									<th style="border:1px solid #000;">Dummy Box Number</th>
									<th style="border:1px solid #000;">Box Number</th>
								</tr>                                    
							</thead>
							<?php $invoiceitems = GetInvoiceItem( $invoice->invoice_id ); ?>
							<tbody>
								<?php 	$i=1; 
										foreach( $invoiceitems as $item ) : 
								?>
								<tr>
									<td style="border:1px solid #000;"><?=$i;?></td>
									<td style="border:1px solid #000;"><?php echo CPIdata( $item['cust_pi'] )->pi_num; ?></td>
									<td style="border:1px solid #000;"><?php echo GetItemData( $item['item_id'] )->ITEM_CODE; ?></td>
									<td style="border:1px solid #000;"><?php echo $item['qty']; ?></td>
									<td style="border:1px solid #000;"><?php echo $item['price']; ?></td>
									<td style="border:1px solid #000;"><?php echo $item['d_box_num']; ?></td>
									<td style="border:1px solid #000;"><?php echo $item['box_num']; ?></td>
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