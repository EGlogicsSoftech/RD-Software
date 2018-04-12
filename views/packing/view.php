<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <title>Rickshaw Delivery | <?=$title;?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?=base_url();?>admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- DATA TABLES -->
        <link href="<?=base_url();?>admin/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
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
                    	
                    	<?php $packingitems = GetPackingItem( $packing->packing_id ); ?>
                    	
                        <div class="col-md-6">
                        	<div class="box box-warning">
                            	<div class="box-header">
                                    <h3 class="box-title">Item Details</h3>
                                    <div class="box-body">
                                    	
              						</div>
                                    <div class="heading_right_box">
                                    
										<?php if( is_UserAllowed('approve_packing_list')){ ?>
											<?php if( $packing->status == 2) : ?>
												<a href="#" style="color:#ff6666;" pid="<?php echo $packing->id; ?>" cid="<?php echo $packing->cust_id; ?>" id="packing_approve">Click to Approve</a> 
											<?php else : ?> 
												<span style="color:green;">Approved</span>
											<?php endif; ?>
										<?php } ?>	
										
                                    	<?php if( $packingitems ){ ?>
                                    	
											<div class="btn-group">
												<button disabled type="button" class="btn btn-warning btn-flat">PDF</button>
												<button type="button" class="btn btn-warning btn-flat dropdown-toggle" data-toggle="dropdown">
													<span class="caret"></span>
													<span class="sr-only">Toggle Dropdown</span>
												</button>
												<ul class="dropdown-menu" role="menu">
													<li><a href="/packing/CUSTOM_INVOICE_PDF/<?php echo $packing->packing_id; ?>">Custom Invoice</a></li>
													<li><a href="/packing/INVOICE_PDF/<?php echo $packing->packing_id; ?>">Invoice</a></li>
													<li><a href="/packing/PL_PDF/<?php echo $packing->packing_id; ?>">Packing List</a></li>
												</ul>
											</div>
										
											<div class="btn-group">
												<button disabled type="button" class="btn btn-warning btn-flat">Excel</button>
												<button type="button" class="btn btn-warning btn-flat dropdown-toggle" data-toggle="dropdown">
													<span class="caret"></span>
													<span class="sr-only">Toggle Dropdown</span>
												</button>
												<ul class="dropdown-menu" role="menu">
													<li><a href="/packing/CUSTOM_INVOICE_EXCEL/<?php echo $packing->packing_id; ?>">Custom Invoice</a></li>
													<li><a href="/packing/INVOICE_EXCEL/<?php echo $packing->packing_id; ?>">Invoice</a></li>
													<li><a href="/packing/PL_EXCEL/<?php echo $packing->packing_id; ?>">Packing List</a></li>
													<li><a href="/packing/Custom_PL_EXCEL/<?php echo $packing->packing_id; ?>">Custom Packing List</a></li>
												</ul>
											</div>
											
										<?php } ?>	
                                    </div>
                                </div><!-- /.box-header -->

                                <div class="box-body table-responsive">
                                    <table id="example1" class="table sv_table_heading table-bordered table-hover">
                                        <tbody>    
                                        	<?php if( $packing->cust_id == 0 ) : ?>
												<tr>
													<th style="width: 25%;">Client</th>
													<td>Oceanic</td>
												</tr>   
											<?php else : ?>
												<tr>
													<th style="width: 25%;">Customer</th>
													<td><?php echo GetCustomerName( $packing->cust_id );?></td>
												</tr> 	
											<?php endif; ?>
                                            <tr>
                                                <th style="width: 25%;">Packing Number</th>
                                                <td><?php echo $packing->packing_num; ?></td>
                                            </tr>
                                            
                                            <?php if( $packing->status == 1) : ?>
												<tr>
													<th style="width: 25%;">Approved By</th>
													<td><?php echo GetUserData($packing->approved_by)->name; ?></td>
												</tr>
											<?php endif; ?>
                                            <tr>
                                                <th style="width: 25%;">Created By</th>
                                                <td><?php echo GetUserData($packing->created_by)->name; ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 25%;">Date</th>
                                                <td><?php echo $packing->date; ?></td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>   
							</div>
							
							<div class="box box-warning">
                            	<div class="box-header">
                                    <h3 class="box-title">Shipping Information</h3>
                                </div>
								<div class="box-body table-responsive">
								
									<form enctype="multipart/form-data" action="<?=base_url('packing/save_shipping').'/'.$packing->id; ?>" method="post">

										<?php 	$shipping_data = GetPLShippingData($packing->packing_id);
												
												$pol = (isset($shipping_data->pol) ? $shipping_data->pol : '');
												$pod = (isset($shipping_data->pod) ? $shipping_data->pod : '');
												$fd = (isset($shipping_data->fd) ? $shipping_data->fd : '');
										 ?>
										
										<div class="form-group col-md-4">
											<label>Port of Loading</label>
											<input type="text" class="form-control" rows="3" name="pol" placeholder="Enter Port of Loading" value="<?php echo $pol;?>">
											<?php echo form_error('pol'); ?>
										</div>
									
										<div class="form-group col-md-4">
											<label>Port of Discharge</label>
											<input type="text" class="form-control" rows="3" name="pod" placeholder="Enter Port of Discharge" value="<?php echo $pod;?>">
											<?php echo form_error('pod'); ?>
										</div>
									
										<div class="form-group col-md-4">
											<label>Final Destination</label>
											<input type="text" class="form-control" rows="3" name="fd" placeholder="Enter Final Destination" value="<?php echo $fd;?>">
											<?php echo form_error('fd'); ?>
										</div>
										
										<?php if( is_UserAllowed('update_shipping_info')){ ?>
										<?php if( $packing->status != 1) : ?>
											<div class="form-group col-md-12">   
												<input type="hidden" name="id" value="<?php echo $packing->id; ?>" />
												<input type="hidden" name="p_id" value="<?php echo $packing->packing_id; ?>" />
												<input type="submit" class="btn btn-info" value="Submit">
											</div>
										<?php endif; } ?>
										
										<div style="clear:both;"></div>
										
									</form> 
								</div> 
								
							</div>
						</div>	
                        <div class="col-md-6">
                        	<?php if( is_UserAllowed('add_pl_item')){ ?>
                        		<?php if( $packing->status == 2) : ?>
									<div class="box box-warning">
										<div class="box-header">
											<h3 class="box-title">Add Items</h3>
										</div>
							
										<div class="box-body">
								
										<?php echo form_error('validate'); ?>
										<form enctype="multipart/form-data" action="<?=base_url('packing/SavePackingItem').'/'.$packing->id; ?>" method="post">

											<?php if( $msg ) { ?>
												<div class="" style="padding-bottom: 15px;">
													<?php echo $msg; ?>
												</div>
											<?php } ?>
										
											<?php if( $packing->cust_id == 0 ) : ?>
												<div class="form-group <?php if( $packing->cust_id == 0 ) : echo "col-md-4"; else: echo "col-md-6"; endif; ?>">
													<label>Customers <span style="color:red;">*</span></label>
													<select class="form-control customer" name="customer" style="width:100%;">
														<option value="">Select Customer</option>
														<?php foreach( $customers as $customer ) :  ?>
															<option <?php if( $this->input->post('customer') == $customer['customer_id'] ){ echo "selected"; } ?> value="<?=$customer['customer_id'];?>"><?=$customer['name'];?></option>
														<?php endforeach; ?>
													</select>
													<?php echo form_error('customer'); ?>
												</div>
											<?php else : ?>
												<input type="hidden" name="customer" value="<?php echo $packing->cust_id; ?>" />
											<?php endif; ?>
										
											<div class="form-group <?php if( $packing->cust_id == 0 ) : echo "col-md-4"; else: echo "col-md-6"; endif; ?>">
												<label>Customer PI <span style="color:red;">*</span></label>
											
												<?php if( $packing->cust_id == 0 ) : ?>
													<select class="form-control cust_pi" name="cust_pi" style="width:100%;">
														<option value="">Select Customer PI</option>
													</select>
												<?php else : $custpis = GetCUSTpino( $packing->cust_id ); ?>
													<select class="form-control cust_pi" name="cust_pi" style="width:100%;">
														<option value="">Select Customer PI</option>
														<?php foreach( $custpis as $custpi ) : ?>
															<option <?php if( $this->input->post('cust_pi') == $custpi['cust_pi_id'] ){ echo "selected"; } ?>  value="<?php echo $custpi['cust_pi_id']; ?>"><?php echo $custpi['pi_num']; ?></option>
														<?php endforeach; ?>
													</select>
												<?php endif; ?>
											
												<?php echo form_error('cust_pi'); ?>
											</div>
										
											<div class="form-group <?php if( $packing->cust_id == 0 ) : echo "col-md-4"; else: echo "col-md-6"; endif; ?>">
												<label>Items <span style="color:red;">*</span></label>
												<select class="form-control piitem" name="item" style="width:100%;">
													<option value="">Select Item Code</option>
												</select>
												<?php echo form_error('item'); ?>
											</div>

											<div class="form-group col-md-4">
												<label>Orderd Quantity</label>
												<input type="text" disabled class="form-control quantity" rows="3" name="qty" value="<?php echo $this->input->post('qty')?>" placeholder="Enter Quantity">
												<?php echo form_error('qty'); ?>
											</div>
										
											<div class="form-group col-md-4">
												<label>Invoiced Quantity</label>
												<input type="text" disabled class="form-control invoiced" rows="3" name="invoiced_qty" value="<?php echo $this->input->post('invoiced_qty')?>">
												<?php echo form_error('invoiced_qty'); ?>
											</div>
										
											<div class="form-group col-md-4">
												<label>Price Per Unit</label>
												<input type="text" disabled class="form-control price" rows="3" name="pprunit" value="<?php echo $this->input->post('pprunit')?>" placeholder="Enter Price Per Unit">
												<?php echo form_error('pprunit'); ?>
											</div>

											<div class="form-group col-md-4">
												<label>Packed Quantity <span style="color:red;">*</span></label>
												<input type="text" class="form-control" rows="3" name="qty_per_box" value="<?php echo $this->input->post('qty_per_box')?>" placeholder="Enter Qty Per Box">
												<?php echo form_error('qty_per_box'); ?>
											</div>
										
											<!-- 
	<div class="form-group">
												<label>Weight Per Box</label>
												<input type="text" class="form-control" rows="3" name="weight_per_box" value="<?php echo $this->input->post('weight_per_box')?>" placeholder="Enter Weight Per Box">
												<?php echo form_error('weight_per_box'); ?>
											</div>
	 -->
										
											<div class="form-group col-md-4">
												<label>Gross Weight</label>
												<input type="text" class="form-control" rows="3" name="gross_weight" value="<?php echo $this->input->post('gross_weight')?>" placeholder="Enter Gross Weight">
												<?php echo form_error('gross_weight'); ?>
											</div>
										
											<div class="form-group col-md-4">
												<label>Box Number</label>
												<input type="text" class="form-control" rows="3" name="box_num" value="<?php echo $this->input->post('box_num')?>" placeholder="Enter Box Number">
												<?php echo form_error('box_num'); ?>
											</div>
										
											<input type="hidden" name="packing_id" value="<?php echo $packing->packing_id; ?>" />
											<input type="hidden" class="form-control price" rows="3" name="pprunit" value="<?php echo $this->input->post('pprunit')?>">
											<input type="hidden" class="form-control quantity" rows="3" name="qty" value="<?php echo $this->input->post('qty')?>">
											<!-- <input type="hidden" class="max_qty" name="max_qty" value="" /> -->
											<div class="form-group col-md-12">    
												<input type="submit" class="btn btn-info" value="Submit">
											</div>
											<div style="clear:both;"></div>
										</form> 
									</div>
									</div>
								<?php endif; ?>
							<?php } ?>
                        </div>          
						<div class="col-md-12">
							<div class="box box-warning"> 
									<div class="box-header">
										<h3 class="box-title">Items</h3>
									</div>
										
									<div class="box-body table-responsive">
										<?php if( $packingitems ) : ?>
											<table id="packing_item_table" class="table sv_table_heading table-bordered table-hover">
												<thead>
													<tr>
														<th>S.No</th>
														<th>Box No.</th>
														<th>RD Item Code</th>
														<th>Customer Item Code</th>
														<th class='nosort'>Description</th>
														<th>Item Category</th>
														<th>Qty/Box</th>
														<th>Total Qty</th>
														<th>Price Per Unit</th>
														<th>FOB Value</th>
														<th>Net Weight</th>
														<th>Gross Weight</th>
														<th>Customer Name</th>
														<th>PI Number</th>
														
														<?php if( is_UserAllowed('update_pl')){ ?>
															<?php if( $packing->status == 2) : ?>
																<th>Update</th>
															<?php endif; ?>	
														<?php } ?>
													</tr>
												</thead>
												<tbody>    
													<?php 	$i=1; 
															foreach( array_reverse($packingitems) as $item ) : 
													?>
													<tr>
														<td><?=$i;?></td>
														<td>
															<?php if( $packing->status == 2) : ?>
																<span id="box_val_<?php echo $i; ?>"><?php echo $item['box_num']; ?></span>
																<input type="text" style="display:none;" id="input_box_no_<?php echo $i; ?>" class="form-control" rows="3" value="<?php echo $item['box_num']; ?>">
																<a class="sv_edit" id="edit_box_no_<?php echo $i; ?>" style="color:orange;" row_id="<?php echo $i; ?>" href="#">Edit</a> 
																<a id="save_box_no_<?php echo $i; ?>" class="save_box_no" style="display:none; color:orange;" row_id="<?php echo $i; ?>" iid="<?php echo $item['id']; ?>" href="#">Update</a>
															<?php else: ?>
																<?php echo $item['box_num']; ?>	
															<?php endif; ?>
														</td>
														<td><?php echo GetItemData( $item['item_id'] )->ITEM_CODE; ?></td>
														<td><?php echo CPIItemdata( $item['cust_pi'], $item['item_id'] )->customer_item_code; ?></td>
														<td><?php echo GetItemData( $item['item_id'] )->ITEM_DESC; ?></td>
														<td><?php echo Get_Item_Category_Name( GetItemData( $item['item_id'] )->CATEGORY_NAME ); ?></td>
														<td><?php echo $item['qty_per_box'].' '.GetItemUnit( GetItemData( $item['item_id'] )->ITEM_UNIT ); ?></td>
														<td><?php echo $item['qty']; ?></td>
														<td><?php echo '$ '.$item['price']; ?></td>
														<td><?php echo '$ '.$item['qty'] * $item['price']; ?></td>
														<td><?php echo $item['qty_per_box'] * GetItemData( $item['item_id'] )->NET_WEIGHT; ?></td>
														<td><?php echo $item['gross_weight']; ?></td>
														<td style="background-color:<?php echo GetCustomerData( $item['customer_id'] )->color; ?>"><?php echo GetCustomerData( $item['customer_id'] )->name; ?></td>
														<td style="background-color:<?php echo GetCustomerData( $item['customer_id'] )->color; ?>"><?php echo CPIdata( $item['cust_pi'])->pi_num; ?></td>
														
														<?php if( is_UserAllowed('update_pl')){ ?>
															<?php if( $packing->status == 2) : ?>
																<td><a style="color:orange;" href="/packing/edit_packing_item/<?php echo $item['id']; ?>">Update</a></td>
															<?php endif; ?>
														<?php } ?>
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
                        
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        <?php $this->load->view('include/footer');?>
        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="<?=base_url();?>admin/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="<?=base_url();?>admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="<?=base_url();?>admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="<?=base_url();?>admin/js/AdminLTE/app.js" type="text/javascript"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

        <script type="text/javascript">
            
            $('select').select2();
            
            $(function() {
                $("#packing_item_table").dataTable({
					"aoColumnDefs" : [
						 {
						   'bSortable' : false,
						   'aTargets' : [ 'nosort' ]
						 }]
				});
            });
            
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
            });
            
            $(document).ready(function() {
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
            });
            
            $(document).ready(function() {
                $(".sv_edit").click(function(e){
					
					e.preventDefault();
					
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
                        url: '/packing/GetqtyPriceofPIItem',
                        data: {'ItemID': ItemID, 'CPI':CPI},
                        type: "post",
                        dataType: 'json',
                        success: function(data){
                        
                        $('.quantity').val(data.qty);
                        $('.invoiced').val(data.invoiced);
                        $('.max_qty').val(data.max);
                        $('.price').val(data.price);
                        	
                        }
                    });
                });
            });
            
            $(document).ready(function() {
                $(".save_box_no").click(function(e){
                	e.preventDefault();

                    var row_id = $(this).attr('row_id');
                    var iid = $(this).attr('iid');
                    
                    var value = $('#input_box_no_'+row_id).val();
                   
                   $.ajax({
                        url: '/packing/update_box_no',
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
                
                $("#packing_approve").click(function(e) {
					e.preventDefault();
					
					if(confirm("Do you really want to lock this packing?")){
					
						var pid = $(this).attr('pid');
						var cid = $(this).attr('cid');
						
						$.ajax({
							url: '/packing/approve_packing',
							data: {'pid': pid }, 
							type: "post",
							success: function(data){
								
								location.reload();
									
							}
						});
					}
                    
				});
				
            });
            
        </script>

    </body>
</html>