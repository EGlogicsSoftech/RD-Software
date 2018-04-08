<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>AdminLTE | <?=$title;?></title>
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
        <link href="<?=base_url();?>admin/css/datepicker.css" rel="stylesheet" type="text/css" />

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

                <!-- Main content -->
                <section class="content">
					<div class="row">
                        <div class="col-md-4">
                            <div class="box box-warning">
                            
                            	<div class="box-header">
                                    <h3 class="box-title">General Elements</h3>
                                </div><!-- /.box-header -->
                                
                                <div class="box-body ab-class">
                                
                                    <?php echo form_error('validate'); ?>
                                    <?php 	$PListData = GetPackingList($packing_item->packing_id);
                                    		$customerData = GetCustomerData($PListData->cust_id); 
                                    ?>
                                    <form enctype="multipart/form-data" action="<?=base_url('packing/UpdatePackingItem').'/'.$packing_item->id; ?>" method="post">

										<?php if( $PListData->cust_id == 0 ) : ?>
											<div class="form-group">
												<label>Customers</label>
												<select class="form-control customer" name="customer" style="width:100%;">
													<option value="">Select Customer</option>
													<?php foreach( $customers as $customer ) :  ?>
														<option <?php if( $packing_item->customer_id == $customer['customer_id'] ){ echo "selected"; } ?> value="<?=$customer['customer_id'];?>"><?=$customer['name'];?></option>
													<?php endforeach; ?>
												</select>
												<?php echo form_error('customer'); ?>
											</div>
										<?php else : ?>
											<input type="hidden" name="customer" value="<?php echo $PListData->cust_id; ?>" />
										<?php endif; ?>
										
										<div class="form-group">
											<label>Customer PI</label>
											
											<?php if( $PListData->cust_id == 0 ) : ?>
												<select class="form-control cust_pi" name="cust_pi" style="width:100%;">
													<option value="">Select Customer PI</option>
												</select>
											<?php else : $custpis = GetCUSTpino( $customerData->customer_id ); ?>
												<select class="form-control cust_pi" name="cust_pi" style="width:100%;">
													<option value="">Select Customer PI</option>
													<?php foreach( $custpis as $custpi ) : ?>
														<option <?php if( $packing_item->cust_pi == $custpi['cust_pi_id'] ){ echo "selected"; } ?>  value="<?php echo $custpi['cust_pi_id']; ?>"><?php echo $custpi['pi_num']; ?></option>
													<?php endforeach; ?>
												</select>
											<?php endif; ?>
											
											<?php echo form_error('cust_pi'); ?>
										</div>
										
										<div class="form-group">
											<label>Items</label>
											<select class="form-control piitem" name="item" style="width:100%;">
												<option value="">Select Item Code</option>
												<option selected value="<?php echo $packing_item->item_id; ?>"><?php echo GetItemData( $packing_item->item_id )->ITEM_CODE; ?></option>
											</select>
											<?php echo form_error('item'); ?>
										</div>

										<div class="form-group">
											<label>Orderd Quantity</label>
											<input type="text" disabled class="form-control quantity" rows="3" name="qty" value="<?php echo $packing_item->qty; ?>" placeholder="Enter Quantity">
											<?php echo form_error('qty'); ?>
										</div>
										
										<div class="form-group">
											<label>Price Per Unit</label>
											<input type="text" disabled class="form-control price" rows="3" name="pprunit" value="<?php echo $packing_item->price; ?>" placeholder="Enter Price Per Unit">
											<?php echo form_error('pprunit'); ?>
										</div>

										<div class="form-group">
											<label>Packed Quantity</label>
											<input type="text" class="form-control" rows="3" name="qty_per_box" value="<?php echo $packing_item->qty_per_box; ?>" placeholder="Enter Qty Per Box">
											<?php echo form_error('qty_per_box'); ?>
										</div>
										
										<!-- 
										<div class="form-group">
											<label>Weight Per Box</label>
											<input type="text" class="form-control" rows="3" name="weight_per_box" value="<?php echo $this->input->post('weight_per_box')?>" placeholder="Enter Weight Per Box">
											<?php echo form_error('weight_per_box'); ?>
										</div>
 										-->
										
										<div class="form-group">
											<label>Gross Weight</label>
											<input type="text" class="form-control" rows="3" name="gross_weight" value="<?php echo $packing_item->gross_weight; ?>" placeholder="Enter Gross Weight">
											<?php echo form_error('gross_weight'); ?>
										</div>
										
										<div class="form-group">
											<label>Box Number</label>
											<input type="text" class="form-control" rows="3" name="box_num" value="<?php echo $packing_item->box_num; ?>" placeholder="Enter Box Number">
											<?php echo form_error('box_num'); ?>
										</div>
										
										<input type="hidden" name="packing_id" value="<?php echo $packing_item->packing_id; ?>" />
										<input type="hidden" class="form-control price" rows="3" name="pprunit" value="<?php echo $packing_item->price; ?>">
										<input type="hidden" class="form-control quantity" rows="3" name="qty" value="<?php echo $packing_item->qty; ?>">
										<input type="hidden" class="max_qty" name="max_qty" value="<?php echo $packing_item->qty; ?>" />
										<div class="form-group">    
											<input type="submit" class="btn btn-info" value="Update">
										</div>
							
									</form> 
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
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
            
            	$(".customer").change(function(){

                    var cid = $(this).val();
                    
                    $.ajax({
                        url: '/packing/GetCPIByCustomer',
                        data: {'cid': cid},
                        type: "post",
                        success: function(data){
                        	
                        	$('.cust_pi').html(data);
                        	
                        }
                    });
                });
            	
                $(".cust_pi").change(function(){

                    var pi_id = $(this).val();
                    
                    $.ajax({
                        url: '/packing/GetItembyCPI',
                        data: {'pi_id': pi_id},
                        type: "post",
                        success: function(data){
                        	
                        	$('.piitem').html(data);
                        	
                        }
                    });
                });
                
                $(".piitem").change(function(){

                    var ItemID = $(this).val();
                    var CPI = $('.cust_pi').val();
                    
                    $.ajax({
                        url: '/packing/GetqtyPriceofPIItem',
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
            
        </script>
       
    </body>
</html>