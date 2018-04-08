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
        <!-- DATA TABLES -->
        <link href="<?=base_url();?>admin/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
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
                        
                        <?php $sup_po_items = GetSupPOItem( $supplier_po->sup_po_id ); ?>
                        
                        <div class="col-md-6">
                        	<div class="box box-warning">
                            	<div class="box-header">
                                    <h3 class="box-title">Supplier Details</h3>
                                    <div class="heading_right_box">
                                    
                                    	<?php if( is_UserAllowed('approve_spo')){ ?>
											<?php if( $supplier_po->status == 2) : ?>
												<a style="color:#ff6666;" href="/supplier/approveSPO/<?php echo $supplier_po->id; ?>" id="grn_approv">Click to Approve</a> 
											<?php else : ?> 
												<span style="color:green;">Approved</span>
											<?php endif; ?>
										<?php } ?>
										
										<?php if( is_UserAllowed('approve_spo') && $sup_po_items ){ echo "|"; }?>
                                    	
                                    	<?php if( $sup_po_items ) { ?> <a style="color:orange;" href="/supplier/Export_EXCEL/<?php echo $supplier_po->id; ?>">Export Excel</a> | <a style="color:orange;" href="/supplier/Export_PDF/<?php echo $supplier_po->id; ?>">Export PDF</a> <?php } ?>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example2" class="table sv_table_heading table-bordered table-hover">
                                        <tbody>    
                                            <tr>
                                                <th style="width: 25%;">Supplier Name</th>
                                                <td><?=GetSupplierData( $supplier_po->sup_id )->supplier_name;?></td>
                                            </tr>   
                                            <tr>
                                                <th style="width: 25%;">PO#</th>
                                                <td><?php echo $supplier_po->po_num; ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 25%;">PO Date</th>
                                                <td><?php echo date("j F, Y", strtotime($supplier_po->delivery_date)); ?></td>
                                            </tr>
                                            <?php if( $supplier_po->status == 1) : ?>
												<tr>
													<th style="width: 25%;">Approved By</th>
													<td><?php echo GetUserData($supplier_po->approved_by)->name; ?></td>
												</tr>
											<?php endif; ?>
                                            <tr>
                                                <th style="width: 25%;">Created By</th>
                                                <td><?php echo GetUserData($supplier_po->created_by)->name; ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 25%;">Created At</th>
                                                <td><?php echo date("j F, Y | H:i:s", strtotime($supplier_po->created_at)); ?></td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>   
							</div>
						</div>	
						
                    	<div class="col-md-6">
                    		<?php if( is_UserAllowed('add_spo_item')){ ?>
								<?php if( $supplier_po->status == 2) : ?>
									<div class="box box-warning">
										<div class="box-header">
											<h3 class="box-title">Add Item</h3>
										</div>
							
										<div class="box-body">
								
											<?php echo form_error('validate'); ?>
											<form enctype="multipart/form-data" action="<?=base_url('supplier/SaveItemToSuplier').'/'.$supplier_po->id; ?>" method="post">

												<?php if( $msg ) { ?>
													<div class="" style="padding-bottom: 15px;">
														<?php echo $msg; ?>
													</div>
												<?php } ?>
												<?php $items = GetItemofSupplier($supplier_po->sup_id); ?>
												<div class="form-group col-md-6">
													<label>Items <span style="color:red;">*</span></label>
													<select class="form-control supplier_code" name="item" style="width:100%;">
														<option value="">Select Item Code</option>
														<?php foreach( $items as $item ) :  ?>
															<option value="<?=$item['ITEM_ID'];?>"><?=$item['ITEM_CODE'];?></option>
														<?php endforeach; ?>
													</select>
													<?php echo form_error('item'); ?>
												</div>

												<div class="form-group col-md-6">
													<label>Current Stock</label>
													<input disabled type="text" class="form-control Cstock" name="curr_stock" value="<?php echo $this->input->post('curr_stock')?>" placeholder="Current Stock" />
													<?php echo form_error('curr_stock'); ?>
												</div>

												<div class="form-group col-md-6">
													<label>Ordered Qty <span style="color:red;">*</span></label>
													<input type="text" class="form-control" name="ordered_qty" value="<?php echo $this->input->post('ordered_qty')?>" placeholder="Ordered Qty" />
													<?php echo form_error('ordered_qty'); ?>
												</div>

												<div class="form-group col-md-6">
													<label>Price Per Unit</label>
													<input disabled type="text" class="form-control price" name="prc_epr_untt" value="<?php echo $this->input->post('prc_epr_unt')?>" placeholder="Price Per Unit" />
													<?php echo form_error('prc_epr_unt'); ?>
												</div>
										
												<input type="hidden" class="form-control" name="sup_po_id" value="<?php echo $supplier_po->sup_po_id?>" />
										
												<div class="form-group col-md-12">  
													<input type="hidden" class="form-control price" name="prc_epr_unt" value="<?php echo $this->input->post('prc_epr_unt')?>" placeholder="Price Per Unit" /> 
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
										<h3 class="box-title">Supplier P.O. Items</h3>
									</div>
										
									<div class="box-body table-responsive">
										<?php if( $sup_po_items ) : ?>
											<table id="example1" class="table sv_table_heading table-bordered table-hover">
												<thead>
													<tr>
														<th>S.No</th>
														<th>Item Image</th>
														<th>Item Code</th>
														<th>Item Description</th>
														<th>Ordered Qty</th>
														<th>Good Recived</th>
														<th>Unit</th>
														<th>Price Per Unit</th>
														<th>Amount</th>
														<?php if( $supplier_po->status == 2) : ?>
														<?php if( is_UserAllowed('remove_spo_item')){ ?><th>Remove</th><?php } ?>
														<?php endif; ?>
													</tr>
												</thead>
												<tbody>    
													<?php 	$i=1; 
															$gross = 0;
															foreach( $sup_po_items as $sup_po_item ) : 
											
															$amount = $sup_po_item['qty'] * $sup_po_item['price'];
															$gross += $amount;
															$item_img = GetItemData( $sup_po_item['item_id'] )->ITEM_IMAGE;
															$itemUnitID = GetItemData( $sup_po_item['item_id'] )->ITEM_UNIT;
															$good_recived = GoodsRecived($supplier_po->sup_po_id, $sup_po_item['item_id']);
													?>
													<tr>
														<td><?=$i;?></td>
														<td>
															<a href="/item/view/<?php echo GetItemData( $sup_po_item['item_id'] )->ID; ?>">
																<?php if( $item_img ): ?>
																	<img style="width:100px;" src="<?=base_url();?>uploads/item_images/<?php echo $item_img; ?>" />
																<?php else : ?>
																	<img style="width:100px;" src="<?=base_url();?>uploads/no-image-available.jpg" />
																<?php endif; ?>
															</a>
														</td>
														<td><a href="/item/view/<?php echo GetItemData( $sup_po_item['item_id'] )->ID; ?>"><?php echo GetItemData( $sup_po_item['item_id'] )->ITEM_CODE; ?></a></td>
														<td><?php echo GetItemData( $sup_po_item['item_id'] )->ITEM_DESC; ?></td>
														<td>
															<?php if( is_UserAllowed('update_spo_item')){ ?>
																<?php if( $supplier_po->status == 2) : ?>
																	<input type="text" class="form-control order_qty<?php echo $sup_po_item['id']; ?>" name="order_qty<?php echo $sup_po_item['id']; ?>" value="<?php echo $sup_po_item['qty']; ?>"  />
																	<a class="qty_update" rowid="<?php echo $sup_po_item['id']; ?>" price="<?php echo $sup_po_item['price']; ?>" href="#">Update</a>
																<?php else : ?>
																	<?php echo $sup_po_item['qty']; ?>
																<?php endif; ?>
															<?php }else{ ?>
																<?php echo $sup_po_item['qty']; ?>
															<?php } ?>
															
														</td>
														<td <?php if( $good_recived < $sup_po_item['qty']) { echo 'class="uninvoiced_column_red"'; } ?> ><?php echo $good_recived; ?></td>
														<td><?php echo GetItemUnit($itemUnitID); ?></td>
														<td class="update_price"><?php echo $sup_po_item['price']; ?></td>
														<td><?php echo $amount; ?></td>
														
														<?php if( is_UserAllowed('remove_spo_item')){ ?>
															<?php if( $supplier_po->status == 2) : ?>
																<td>
																	<a style="color:red;" class="remove_spo_item" rowid="<?php echo $sup_po_item['id']; ?>" href="#">Remove</a>
																</td>
                                                    		<?php endif; ?>
														<?php } ?>	

													</tr>    
													<?php $i++; endforeach; ?>
												</tbody>
											</table>
											<table id="example2" class="table sv_table_heading table-bordered table-hover">
												<tbody>
													<tr><td colspan="8" style="font-size:20px;text-align:right;">GROSS TOTAL</td><td style="font-size:20px;" ><?php echo $gross; ?></td></tr>
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
        <!-- page script -->
        <script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
            });
        </script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

        <script type="text/javascript">
            
            $('select').select2();
            
            $(document).ready(function() {
                $(".supplier_code").change(function(){

                    var item_id = $(this).val();
                    
                    $.ajax({
                        url: '/supplier/GetPricebyItemID',
                        data: {'item_id': item_id},
                        type: "post",
                        success: function(data){
                        	
                        	$('.price').val(data);
                        	
                        }
                    });
                });
            });
            
            $(document).ready(function() {
                $(".supplier_code").change(function(){

                    var item_id = $(this).val();
                   
                   $.ajax({
                        url: '/supplier/getStock',
                        data: {'item_id': item_id},
                        type: "post",
                        success: function(data){
                        
                        	$('.Cstock').val(data);
                        	
                        }
                    });
                });
            });
            
            $(document).ready(function() {
                $(".qty_update").click(function(){

                    //var price = $(this).attr('price');
                    var row_id = $(this).attr('rowid');
                    var qty = $('.order_qty'+row_id).val();
                    
                   $.ajax({
                        url: '/supplier/updateQTY',
                        data: {'row_id': row_id, 'qty': qty},
                        type: "post",
                        success: function(data){
                        
                        	location.reload();
                        	
                        }
                    });
                });
                
                $(".remove_spo_item").click(function(e) {
					event.preventDefault();
					
					if(confirm("Do you really want to remove this item?")){
					
						var rowid = $(this).attr('rowid');
					
						$.ajax({
							url: '/supplier/remove_sub_item',
							data: {'rowid': rowid}, 
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