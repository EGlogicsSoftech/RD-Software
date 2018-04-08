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
        <!-- header logo: style can be found in header.less -->
        <?php $this->load->view('include/header');?>

        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <?php $this->load->view('include/sidebar');?>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1><?=$title;?></h1>
                    <ol class="breadcrumb">
                        <li><a href="<?=base_url('admin/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active"><?=$title;?></li>
                    </ol>
                </section>

                <section class="content">
                    <div class="row">
                        <div class="col-md-9">
                        
                        	<?php $invoiceitems = GetInvoiceItem( $invoice->invoice_id ); ?>
                            
                            <div class="box box-warning">
                            	<div class="box-header">
                                    <h3 class="box-title">Item Details</h3>
                                    <div class="heading_right_box">
                                    	<?php if( $invoiceitems ) { ?> <a style="color:orange;" href="/invoice/ExportEXL/<?php echo $invoice->invoice_id; ?>">Export Excel</a> | <a style="color:orange;" href="/invoice/Export_PDF/<?php echo $invoice->invoice_id; ?>">Export PDF</a><?php } ?> <!-- | <a style="color:orange;" href="#">Update</a> | <a style="color:red;" href="#">Remove</a> -->
                                    </div>
                                </div><!-- /.box-header -->

                                <div class="box-body table-responsive">
                                    <table id="example1" class="table sv_table_heading table-bordered table-hover">
                                        <tbody>    
                                            <tr>
                                                <th style="width: 25%;">Customer</th>
                                                <td><?php echo GetCustomerName( $invoice->cust_id );?></td>
                                            </tr>   
                                            <tr>
                                                <th style="width: 25%;">Date</th>
                                                <td><?php echo $invoice->date; ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 25%;">Invoice Number</th>
                                                <td><?php echo $invoice->invoice_num; ?></td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>   
							</div>
							
                                   
							<?php  ?>
							
								<div class="box box-warning"> 
									<div class="box-header">
										<h3 class="box-title">Items</h3>
									</div>
										
									<div class="box-body table-responsive">
										<?php if( $invoiceitems ) : ?>
											<table id="example1" class="table sv_table_heading table-bordered table-hover">
												<thead>
													<tr>
														<th>S.No</th>
														<th>RD Item Code</th>
														<th>Customer Item Code</th>
														<th>Description</th>
														<th>Net Weight in KG</th>
														<th>Qty</th>
														<th>Units</th>
														<th>Rate</th>
														<th>FOB Value</th>
														<th>PI Number</th>
														<th>Dummy Box Number</th>
														<th>Box No.</th>
													</tr>
												</thead>
												<tbody>    
													<?php 	$i=1; 
															foreach( $invoiceitems as $item ) : 
													?>
													<tr>
														<td><?=$i;?></td>
														<td><?php echo GetItemData( $item['item_id'] )->ITEM_CODE; ?></td>
														<td><?php echo CPIItemdata( $item['cust_pi'], $item['item_id'] )->customer_item_code; ?></td>
														<td><?php echo GetItemData( $item['item_id'] )->ITEM_DESC; ?></td>
														<td><?php echo GetItemData( $item['item_id'] )->NET_WEIGHT; ?></td>
														<td><?php echo $item['qty']; ?></td>
														<td><?php echo GetItemUnit( GetItemData( $item['item_id'] )->ITEM_UNIT ); ?></td>
														<td><?php echo CPIItemdata( $item['cust_pi'], $item['item_id'] )->price; ?></td>
														<td><?php echo $item['qty'] * CPIItemdata( $item['cust_pi'], $item['item_id'] )->price; ?></td>
														<td><?php echo CPIdata( $item['cust_pi'] )->pi_num; ?></td>
														<td><?php echo $item['d_box_num']; ?></td>
														<td><span id="box_val_<?php echo $i; ?>"><?php echo $item['box_num']; ?></span>
															<input type="text" style="display:none;" id="input_box_no_<?php echo $i; ?>" class="form-control" rows="3" value="<?php echo $item['box_num']; ?>">
															<a class="sv_edit" id="edit_box_no_<?php echo $i; ?>" style="color:orange;" row_id="<?php echo $i; ?>" href="#">Edit</a> 
															<a id="save_box_no_<?php echo $i; ?>" class="save_box_no" style="display:none; color:orange;" row_id="<?php echo $i; ?>" iid="<?php echo $item['id']; ?>" href="#">Update</a>
														</td>
													</tr>    
													<?php $i++; endforeach; ?>
												</tbody>
											</table>
										<?php else : ?>
											<h4>No items found!!!</h4>	
										<?php endif; ?>
									</div>        
								</div>

                        </div> 
                        <div class="col-md-3">
							<div class="box box-warning">
								<div class="box-header">
									<h3 class="box-title">Add Items</h3>
								</div>
							
								<div class="box-body">
								
									<?php echo form_error('validate'); ?>
									<form enctype="multipart/form-data" action="<?=base_url('invoice/SaveInvoiceItem').'/'.$invoice->id; ?>" method="post">

										<?php if( $msg ) { ?>
											<div class="" style="padding-bottom: 15px;">
												<?php echo $msg; ?>
											</div>
										<?php } ?>
										
										<div class="form-group">
											<?php 
											$custpis = GetCUSTpino( $invoice->cust_id ); ?>
											<label>Customer PI</label>
											<select class="form-control cust_pi" name="cust_pi" style="width:100%;">
												<option value="">Select Customer PI</option>
												<?php foreach( $custpis as $custpi ) : ?>
													<option <?php if( $custpi['cust_pi_id'] == $this->input->post('cust_pi')) { echo "selected"; }  ?> value="<?=$custpi['cust_pi_id'];?>"><?=$custpi['pi_num'];?></option>
												<?php endforeach; ?>
											</select>
											<?php echo form_error('item'); ?>
										</div>
										
										<div class="form-group">
											<label>Items</label>
											<select class="form-control piitem" name="item" style="width:100%;">
												<option value="">Select Item Code</option>
											</select>
											<?php echo form_error('item'); ?>
										</div>

										<div class="form-group">
											<label>Quantity</label>
											<input type="text" class="form-control quantity" rows="3" name="qty" value="<?php echo $this->input->post('qty')?>" placeholder="Enter Quantity">
											<?php echo form_error('qty'); ?>
										</div>

										<div class="form-group">
											<label>Price Per Unit</label>
											<input type="text" disabled class="form-control price" rows="3" name="pprunit" value="<?php echo $this->input->post('pprunit')?>" placeholder="Enter Price Per Unit">
											<?php echo form_error('pprunit'); ?>
										</div>
										
										<div class="form-group">
											<label>Dummy Box Number</label>
											<input type="text" class="form-control" rows="3" name="d_box_num" value="<?php echo $this->input->post('d_box_num')?>" placeholder="Enter Dummy Box Number">
											<?php echo form_error('d_box_num'); ?>
										</div>
										
										<div class="form-group">
											<label>Box Number</label>
											<input type="text" class="form-control" rows="3" name="box_num" value="<?php echo $this->input->post('box_num')?>" placeholder="Enter Box Number">
											<?php echo form_error('box_num'); ?>
										</div>
										
										<input type="hidden" name="invoice_id" value="<?php echo $invoice->invoice_id; ?>" />
										<input type="hidden" class="max_qty" name="max_qty" value="" />
										<div class="form-group">    
											<input type="submit" class="btn btn-info" value="Submit">
										</div>
							
									</form> 
								</div>
							</div>
                        </div><!--/.col (right) -->
                        
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        <?php $this->load->view('include/footer');?>
        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="<?=base_url();?>admin/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="<?=base_url();?>admin/js/AdminLTE/app.js" type="text/javascript"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

        <script type="text/javascript">
            
            $('select').select2();
            
            $(document).ready(function() {
                $(".cust_pi").change(function(){

                    var pi_id = $(this).val();
                    
                    $.ajax({
                        url: '/invoice/GetItembyCPI',
                        data: {'pi_id': pi_id},
                        type: "post",
                        success: function(data){
                        	
                        	$('.piitem').html(data);
                        	
                        }
                    });
                });
            });
            
            $(document).ready(function() {
                $(".sv_edit").click(function(){

					var rowid = $(this).attr('row_id');
					
					$(this).css('display','none');
					$('#box_val_'+rowid).css('display','none');
        			$('#input_box_no_'+rowid).removeAttr('style');
        			$('#save_box_no_'+rowid).css('display','block');
        			
                });
            });
            
            $(document).ready(function() {
                $(".piitem").change(function(){

                    var ItemID = $(this).val();
                    var CPI = $('.cust_pi').val();
                    
                    $.ajax({
                        url: '/invoice/GetqtyPriceofPIItem',
                        data: {'ItemID': ItemID, 'CPI':CPI},
                        type: "post",
                        dataType: 'json',
                        success: function(data){
                        
                        $('.quantity').val(data.qty);
                        $('.max_qty').val(data.qty);
                        $('.price').val(data.price);
                        	
                        }
                    });
                });
            });
            
            $(document).ready(function() {
                $(".save_box_no").click(function(){

                    var row_id = $(this).attr('row_id');
                    var iid = $(this).attr('iid');
                    
                    var value = $('#input_box_no_'+row_id).val();
                    
                   $.ajax({
                        url: '/invoice/update_box_no',
                        data: {'value': value, 'iid':iid},
                        type: "post",
                        dataType: 'json',
                        success: function(data){
                        
                        $('#box_val_'+row_id).html(data);
                        $('#save_box_no_'+row_id).css('display','none');
                        $('#input_box_no_'+row_id).css('display','none');
                        $('#box_val_'+row_id).css('display','block');
                        $('#edit_box_no_'+row_id).css('display','block');
                        	
                        }
                    });
                });
            });
            
        </script>

    </body>
</html>