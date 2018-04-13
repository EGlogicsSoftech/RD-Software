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
         <!-- DATA TABLES -->
        <link href="<?=base_url();?>admin/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        

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
                    
                    	<?php $issueItems = GetStockIssueItems( $stock_issuance->stock_issue_id ); ?>
                    
                        <div class="col-md-6">
                        	<div class="box box-warning">
                            	<div class="box-header">
                                    <h3 class="box-title">Stock Issuance Details</h3>
                                    <div class="heading_right_box">
                                    	<?php if( $issueItems ) { ?><a style="color:orange;" href="/stock/Export_EXCEL/<?php echo $stock_issuance->id; ?>">Export Excel</a> | <a style="color:orange;" href="/stock/Export_PDF/<?php echo $stock_issuance->id; ?>">Export PDF</a> | <?php } ?><a style="color:red;" href="">Remove</a><!-- <a style="color:orange;" href="/stock/manage_customer_po/<?php echo $stock_issuance->id; ?>">Update</a> |  -->
                                    </div>
                                </div>
                            	<div class="box-body table-responsive">
                                    <table id="example1" class="table sv_table_heading table-bordered table-hover">
                                        <tbody> 
                                        	<?php if( $stock_issuance->customer_id == 0 ) : ?>
												<tr>
													<th style="width: 25%;">Client</th>
													<td>Oceanic</td>
												</tr>   
											<?php else : ?>
												<tr>
													<th style="width: 25%;">Customer</th>
													<td><?php echo GetCustomerData( $stock_issuance->customer_id )->name; ?></td>
												</tr> 	
											<?php endif; ?>  
                                            <tr>
                                                <th style="width: 25%;">Ref no/ Invoice No</th>
                                                <td><?php echo $stock_issuance->ref_id; ?></td>
                                            </tr>   
                                            <tr>
                                                <th style="width: 25%;">Issued By</th>
                                                <td><?php echo $stock_issuance->issued_by; ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 25%;">Issued To</th>
                                                <td><?php echo $stock_issuance->issued_to; ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 25%;">Issued Date</th>
                                                <td><?php echo $stock_issuance->Issued_date; ?></td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>   
							</div>
						</div>	
						
						<div class="col-md-6">
							<?php if( is_UserAllowed('add_si_item')){ ?>
								<div class="box box-warning">
									<div class="box-header">
										<h3 class="box-title">Add Item</h3>
									</div>
							
									<div class="box-body">
								
										<?php echo form_error('validate'); ?>
										<form enctype="multipart/form-data" action="<?=base_url('stock/SaveStockIssuanceItem/'.$stock_issuance->id); ?>" method="post">

											<?php if( $msg ) { ?>
												<div class="" style="padding-bottom: 15px;">
													<?php echo $msg; ?>
												</div>
											<?php } ?>
										
											<?php if( $stock_issuance->customer_id == 0 ) : ?>
												<div class="form-group col-md-6">
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
												<input type="hidden" name="customer" value="<?php echo $stock_issuance->customer_id; ?>" />
											<?php endif; ?>
										
											<div class="form-group col-md-6">
												<?php $items = GetEntryItem(); //var_dump($items); ?>
												<label>Items <span style="color:red;">*</span></label>
												<select class="form-control issue_item" name="item" style="width:100%;">
													<option value="">Select Items</option>
													<?php foreach( $items as $item ) :  ?>
														<option value="<?=$item['item_id'];?>"><?php echo GetItemData( $item['item_id'] )->ITEM_CODE; ?></option>
													<?php endforeach; ?>
												</select>
												<?php echo form_error('item'); ?>
											</div>

											<div class="form-group col-md-6">
												<label>Box Number <span style="color:red;">*</span></label>
												<select disabled class="form-control box_no" name="box_no" style="width:100%;">
													<option value="">Select Box Number</option>
												</select>
												<?php echo form_error('box_no'); ?>
											</div>

											<div class="form-group col-md-6">
												<label>Alloted Quantity <span style="color:red;">*</span></label>
												<select disabled class="form-control alloted_qty" name="alloted_qty" style="width:100%;">
													<option value="">Select Alloted Quantity</option>
												</select>
												<?php echo form_error('alloted_qty'); ?>
											</div>
										
											<div class="form-group col-md-12">
												<input type="hidden" class="form-control" name="stock_issue_id" value="<?php echo $stock_issuance->stock_issue_id;?>" />    
												<input type="submit" class="btn btn-info" value="Submit">
											</div>
											<div style="clear:both;"></div>	
										</form> 
									</div>
								</div>
							<?php } ?>
                        </div>
						
						<div class="col-md-12">
                            <div class="box box-warning"> 
								<div class="box-header">
									<h3 class="box-title">Stock Issuance Items</h3>
								</div>
								<div class="box-body table-responsive">
									<?php if( $issueItems ) : ?>
										<table id="stock_issue_table" class="table sv_table_heading table-bordered table-hover">
											<thead>
												<tr>
													<th>S.No</th>
													<th>Item Image</th>
													<th>Item Code</th>
													<th>Customer name</th>
													<th>Item Description</th>
													<th>Box Number</th>
													<th>Quantity</th>
													<th>Issued</th>
													<?php if( is_UserAllowed('remove_si_item')){ ?>
														<th>Remove</th>
													<?php } ?>	
												</tr>
											</thead>
											<tbody>    
												<?php 	$i=1; 
														foreach( $issueItems as $issueItem ) : 
															$item_img = GetItemData( $issueItem['item_id'] )->ITEM_IMAGE;
															
															if( $item_img )
																{
																	$img_path = FCPATH.'uploads/item_images/'.$item_img;
																}
															else
																{
																	$img_path = '';
																}
												?>
												<tr>
													<td><?=$i;?></td>
													<td>
														<a href="/item/view/<?php echo GetItemData( $issueItem['item_id'] )->ID; ?>">
															<?php if( file_exists( $img_path ) ): ?>
																<img style="width:100px;" src="<?=base_url();?>uploads/item_images/<?php echo $item_img; ?>" />
															<?php else : ?>
																<img style="width:100px;" src="<?=base_url();?>uploads/no-image-available.jpg" />
															<?php endif; ?>
														</a>
													</td>
													<td><?php echo GetItemData( $issueItem['item_id'] )->ITEM_CODE; ?></td>
													<td><?php echo GetCustomerData( $issueItem['customer_id'] )->name; ?></td>
													<td><?php echo GetItemData( $issueItem['item_id'] )->ITEM_DESC; ?></td>
													<td><?php echo $issueItem['box_id']; ?></td>
													<td><?php echo $issueItem['qty']; ?></td>
													<td class="issue<?php echo $issueItem['id']; ?>">
														<?php if( $issueItem['issued'] != 1 ) : ?>
															<a style="color:orange;" class="si_issue_item" rowid="<?php echo $issueItem['id']; ?>" href="#">Issue</a></td>
														<?php else : ?>
															<span style="color:green;">Item Issued</span>
														<?php endif; ?>
														
													<?php if( is_UserAllowed('remove_si_item')){ ?>	
														<td class="remove<?php echo $issueItem['id']; ?>">
															<?php if( $issueItem['issued'] != 1 ) : ?>
																<a style="color:red;" class="remove_issue_item" rowid="<?php echo $issueItem['id']; ?>" href="#">Remove</a>
															<?php else : ?>
																<span style="color:green;">Item has been issued can not remove now.</span>
															<?php endif; ?>
														</td>
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
                $("#stock_issue_table").dataTable({
					"aLengthMenu": [
						[10, 100, 200, -1],
						[10, 100, 200, "All"]
					], 
					"iDisplayLength" : 10 
				});
            });

            
            $(document).ready(function() {
                $(".issue_item").change(function(){

                    var item_id = $(this).val();

                    $.ajax({
                        url: '/stock/get_boxno_ajax',
                        data: {'item_id': item_id}, 
                        type: "post",
                        success: function(data){

                            $('.box_no').removeAttr('disabled');
                            $(".box_no").select2("destroy");
                            $('.box_no').html(data);
                            $(".box_no").select2();
                        }
                    });
                });
            
            	$("#stock_issue_table").on( "click", ".remove_issue_item", function(e) {
					e.preventDefault();
					
					if(confirm("Do you really want to remove this item?")){
					
						var rowid = $(this).attr('rowid');
					
						$.ajax({
							url: '/stock/RemoveStockIssueItem',
							data: {'rowid': rowid}, 
							type: "post",
							success: function(data){
								
								location.reload();
									
							}
						});
					}
                    
				});
				
				$("#stock_issue_table").on( "click", ".si_issue_item", function(e) {

					e.preventDefault();
					
					if(confirm("Do you really want to issue this item?")){
					
						var rowid = $(this).attr('rowid');
					
						$.ajax({
							url: '/stock/IssueStockIssueItem',
							data: {'rowid': rowid}, 
							type: "post",
							success: function(data){
								
								//location.reload();
								if(data)
									{
										$('.issue'+rowid).html('<span style="color:green;">Item Issued</span>');
										$('.remove'+rowid).html('<span style="color:green;">Item has been issued can not remove now.</span>');
									}
							}
						});
					}
                    
				});
				
			});

            $(document).ready(function() {
                $(".box_no").change(function(){

                    var box_id = $(this).val();
                    var item_id = $('.issue_item').val();
					
					$.ajax({
                        url: '/stock/get_alloted_qty_ajax',
                        data: {'item_id': item_id, 'box_id': box_id },
                        type: "post",
                        success: function(data){
                        
                        	$('.alloted_qty').removeAttr('disabled');
                            $(".alloted_qty").select2("destroy");
                            $('.alloted_qty').html(data);
                            $(".alloted_qty").select2();
                        }
                    });
                });
            });
            
        </script>

    </body>
</html>