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

                    	<?php $cust_pi_items = GetCustPIItem( $customer_pi->cust_pi_id ); ?>

                        <div class="col-md-6">

                            <div class="box box-warning">
                            	<div class="box-header">
                                    <h3 class="box-title">Customer P.I. Details</h3>
                                    <div class="heading_right_box">

                                    	<?php if( is_UserAllowed('approve_cpi')){ ?>
                                    		<?php if( $customer_pi->status == 2) : ?>
                                    			<a style="color:#ff6666;" href="/customer/approveCPI/<?php echo $customer_pi->id; ?>" id="grn_approv">Click to Approve</a>
                                    		<?php else : ?>
                                    			<span style="color:green;">Approved</span>
                                    		<?php endif; ?>
                                    	<?php } ?>

                                    	<?php if( is_UserAllowed('approve_cpi') && $cust_pi_items ){ echo "|"; }?>

                                    	<?php if( $cust_pi_items ) { ?>  <a style="color:orange;" href="/customer/Export_EXCEL/<?php echo $customer_pi->cust_pi_id; ?>">Export Excel</a> | <a style="color:orange;" href="/customer/Export_PDF/<?php echo $customer_pi->cust_pi_id; ?>">Export PDF</a><?php } ?>
                                    </div>
                                </div><!-- /.box-header -->

                                <div class="box-body table-responsive">
                                    <table id="example2" class="table sv_table_heading table-bordered table-hover">
                                        <tbody>
                                            <tr>
                                                <th style="width: 25%;">Customer Name</th>
                                                <td><?=GetCustomerName( $customer_pi->cust_id );?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 25%;">PI</th>
                                                <td><?php echo $customer_pi->pi_num; ?></td>
                                            </tr>

                                            <?php if( $customer_pi->status == 1) : ?>
												<tr>
													<th style="width: 25%;">Approved By</th>
													<td><?php echo GetUserData($customer_pi->approved_by)->name; ?></td>
												</tr>
											<?php endif; ?>
                                            <tr>
                                                <th style="width: 25%;">Created By</th>
                                                <td><?php echo GetUserData($customer_pi->created_by)->name; ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 25%;">Created At</th>
                                                <td><?php echo $newDate = date("j F, Y | H:i:s", strtotime($customer_pi->created_at)); ?></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
							</div>

                        </div>
                        <div class="col-md-6">
                        <?php if( is_UserAllowed('add_cpi_item')){ ?>
							<?php if( $customer_pi->status == 2) : ?>
								<div class="box box-warning">
									<div class="box-header">
										<h3 class="box-title">Add Item</h3>
									</div>

									<div class="box-body">

										<?php echo form_error('validate'); ?>
										<form enctype="multipart/form-data" action="<?=base_url('customer/SaveItemToCustomer/'.$customer_pi->id); ?>" method="post">

											<?php if( $msg ) { ?>
												<div class="" style="padding-bottom: 15px;">
													<?php echo $msg; ?>
												</div>
											<?php } ?>
											<?php $items = GetItem(); ?>
											<div class="form-group col-md-6">
												<label>Items <span style="color:red;">*</span></label>
												<select class="form-control sv_item_id" name="item" style="width:100%;">
													<option value="">Select Item Code</option>
													<?php foreach( $items as $item ) :  ?>
														<option value="<?=$item['ITEM_ID'];?>"><?=$item['ITEM_CODE'];?></option>
													<?php endforeach; ?>
												</select>
												<?php echo form_error('item'); ?>
											</div>

                      						<div class="form-group col-md-6">
												<label>Item Unit</label>
												<input disabled type="text" id="item_unit" class="form-control" name="unit" value="<?php echo $this->input->post('unit')?>" placeholder="Item Unit" />
												<?php echo form_error('item_unit'); ?>
											</div>

                      						<div class="form-group col-md-12">
												<label>Item Description</label>
												<textarea disabled id="desc" class="form-control" rows="3" name="item_desc" placeholder="Item Description"></textarea>
												<?php echo form_error('item_desc'); ?>
											</div>

											<div class="form-group col-md-6">
												<label>Customer Item Code</label>
												<input type="text" id="customer_item_code" class="form-control" name="customer_item_code" value="<?php echo $this->input->post('customer_item_code')?>" placeholder="Customer Item Code" />
												<?php echo form_error('customer_item_code'); ?>
											</div>

                      						<div class="form-group col-md-6">
												<label>Customer Item Barcode</label>
												<input type="text" id="customer_item_barcode" class="form-control" name="customer_item_barcode" value="<?php echo $this->input->post('customer_item_barcode')?>" placeholder="Customer Item Barcode" />
												<?php echo form_error('customer_item_barcode'); ?>
											</div>

                     		 				<div class="form-group col-md-6">
												<label>Previous Ordered Qty</label>
												<input disabled type="text" id="ppq" class="form-control" name="poq" value="<?php echo $this->input->post('poq')?>" placeholder="Previous Ordered Qty" />
												<?php echo form_error('poq'); ?>
											</div>

                      						<div class="form-group col-md-6">
												<label>Previous Price</label>
												<input disabled type="text" id="pp" class="form-control" name="previous_price" value="<?php echo $this->input->post('previous_price')?>" placeholder="Previous Price" />
												<?php echo form_error('previous_price'); ?>
											</div>
											
											<div class="form-group col-md-6">
												<label>Purchase Price Code</label>
												<input disabled type="text" id="ppc" class="form-control" name="purchase_price_code" value="<?php echo $this->input->post('purchase_price_code')?>" />
												<?php echo form_error('purchase_price_code'); ?>
											</div>

											<div class="form-group col-md-6">
												<label>Current Stock</label>
												<input disabled type="text" class="form-control Cstock" name="curr_stock" value="<?php echo $this->input->post('curr_stock')?>" placeholder="Current Stock" />
												<?php echo form_error('curr_stock'); ?>
											</div>

											<div class="form-group col-md-6">
												<label>Ordered Qty <span style="color:red;">*</span></label>
												<input type="text" class="form-control" name="req_qty" value="<?php echo $this->input->post('req_qty')?>" placeholder="Quantity" />
												<?php echo form_error('req_qty'); ?>
											</div>


											<div class="form-group col-md-6">
												<label>Price Per Unit <span style="color:red;">*</span></label>
												<input type="text" class="form-control" name="prc_epr_unt" value="<?php echo $this->input->post('prc_epr_unt')?>" placeholder="Price" />
												<?php echo form_error('prc_epr_unt'); ?>
											</div>

											<!--
<div class="form-group col-md-3">
												<label>H S Code</label>
												<input type="text" class="form-control" name="hs_code" value="<?php echo $this->input->post('hs_code')?>" placeholder="H S Code" />
												<?php echo form_error('hs_code'); ?>
											</div>
 -->

											<div class="form-group col-md-12">
												<label>Packaging Instructions</label>
												<textarea id="packaging" class="form-control" rows="3" name="packg_inst" value="<?php echo $this->input->post('packg_inst')?>" placeholder="Enter Packaging Instructions"></textarea>
												<?php echo form_error('packg_inst'); ?>
											</div>

											<input type="hidden" class="form-control" name="cust_pi_id" value="<?php echo $customer_pi->cust_pi_id?>" />

											<div class="form-group col-md-12">
												<input type="submit" class="btn btn-info" value="Submit">
											</div>
											<div style="clear:both;"></div>
										</form>
									</div>
								</div>
								<?php endif; ?>
							<?php } ?>
                        </div><!--/.col (right) -->

                    </div>   <!-- /.row -->
                    <div class="row">

                        <div class="col-md-12">

                            <div class="box box-warning">
									<div class="box-header">
										<h3 class="box-title">Customer P.I. Items</h3>
									</div>

									<div class="box-body table-responsive" style="overflow: auto;">
										<?php if( $cust_pi_items ) : ?>
											<table id="example1" class="table sv_table_heading table-bordered table-hover">
												<thead>
													<tr>
														<th>S.No</th>
														<th>Item Image</th>
														<th>Item Code</th>
														<th>Customer Item Code</th>
														<th>Customer Item Barcode</th>
														<th>HSN Code</th>
														<th>Item Description</th>
														<th>Required Qty</th>
														<th>Invoiced Qty</th>
														<th>Produced Qty</th>
														<th>Stocked Qty</th>
														<th>Unit</th>
														<th>Inner Box Size</th>
														<th>Outer Box Size</th>
														<th>Outer Box Quantity</th>
														<th>CBM</th>
														<th>Packaging Instruction</th>
														<th>Price Per Unit</th>
														<th>Amount</th>
														<?php if( is_UserAllowed('update_cpi_item') || is_UserAllowed('remove_cpi_item') ){ ?>
															<?php if( $customer_pi->status == 2) : ?>
																<th>Action</th>
															<?php endif; ?>
														<?php } ?>
													</tr>
												</thead>

												<tbody>
													<?php 	$i=1; $totalCBM = '';
															foreach( $cust_pi_items as $cust_pi_item ) :

															$amount = $cust_pi_item['qty'] * $cust_pi_item['price'];
															$item_img = GetItemData( $cust_pi_item['item_id'] )->ITEM_IMAGE;
															$itemUnitID = GetItemData( $cust_pi_item['item_id'] )->ITEM_UNIT;
															$invoiced_quantity = invoiced_quantity($cust_pi_item['cust_pi_id'], $cust_pi_item['item_id']);
															$QtyMstrBox = GetItemData( $cust_pi_item['item_id'] )->OUTER_BOX_QTY;
															$outerBoxCBM = GetOuterBoxData( GetItemData( $cust_pi_item['item_id'] )->OUTER_BOX )->CBM;
															$outerBoxQty = ($QtyMstrBox == 0 ? 0 : ceil($cust_pi_item['qty'] / $QtyMstrBox));
															$totalCBM += $outerBoxQty * $outerBoxCBM;
													?>
													<tr>
														<td><?=$i;?></td>
														<td>
															<a href="/item/view/<?php echo GetItemData( $cust_pi_item['item_id'] )->ID; ?>">
																<?php if( $item_img ): ?>
																	<img style="width:100px;" src="<?=base_url();?>uploads/item_images/<?php echo $item_img; ?>" />
																<?php else : ?>
																	<img style="width:100px;" src="<?=base_url();?>uploads/no-image-available.jpg" />
																<?php endif; ?>
															</a>
														</td>
														<td><a href="/item/view/<?php echo GetItemData( $cust_pi_item['item_id'] )->ID; ?>"><?php echo GetItemData( $cust_pi_item['item_id'] )->ITEM_CODE; ?></a></td>
														<td><?php echo $cust_pi_item['customer_item_code']; ?></td>
														<td><?php echo $cust_pi_item['customer_item_barcode']; ?></td>
														<td><?php echo GetItemData( $cust_pi_item['item_id'] )->HSN_CODE; ?></td>
														<td><?php echo GetItemData( $cust_pi_item['item_id'] )->ITEM_DESC; ?></td>
														<td><?php echo $cust_pi_item['qty']; ?></td>
														<td <?php if( $invoiced_quantity < $cust_pi_item['qty']) { echo 'class="uninvoiced_column_red"'; } ?> ><?=$invoiced_quantity; ?></td>
														<td><?php if( produced_qty($cust_pi_item['cust_pi_id'], $cust_pi_item['item_id']) ) { echo produced_qty($cust_pi_item['cust_pi_id'], $cust_pi_item['item_id']); } ?></td>
														<td><?php if( Stocked_QTY( $cust_pi_item['item_id'], $customer_pi->pi_num ) ){ echo Stocked_QTY( $cust_pi_item['item_id'], $customer_pi->pi_num ); } ?></td>
														<td><?php echo GetItemUnit($itemUnitID); ?></td>
														<td>
															<?php
																	$inner_box = GetInnerBox( GetItemData( $cust_pi_item['item_id'] )->INNER_BOX );
																	if($inner_box)
																	{
																		echo $inner_box ;
																	}
																	else
																	{
																		echo "N/A";
																	}
															?>
														</td>
														<td>
																<?php
																		$outer_box = GetOuterBox( GetItemData( $cust_pi_item['item_id'] )->OUTER_BOX );
																		if($outer_box)
																		{
																			echo $outer_box ;
																		}
																		else
																		{
																			echo "N/A";
																		}
																?>
														</td>
														<td><?php echo ($QtyMstrBox == 0 ? 0 : ceil($cust_pi_item['qty'] / $QtyMstrBox)); ?></td>
														<td><?php echo ($QtyMstrBox == 0 ? 0 : ceil($cust_pi_item['qty'] / $QtyMstrBox) * $outerBoxCBM); ?></td>
														<td>
															<?php
																	if($cust_pi_item['Packaging_instructions'])
																	{
																		echo $cust_pi_item['Packaging_instructions'];
																	}
																	else
																	{
																		echo "None";
																	}
															?>
														</td>
														<td><?php echo '$ '.$cust_pi_item['price']; ?></td>
														<td><?php echo $amount; ?></td>
														<?php if( is_UserAllowed('update_cpi_item') || is_UserAllowed('remove_cpi_item') ){ ?>
															<?php if( $customer_pi->status == 2) : ?>
															<td>
																<?php if( is_UserAllowed('update_cpi_item')){ ?>
																	<a style="color:orange;" href="<?=base_url('customer/Upadte_customer_pi_item').'/'.$cust_pi_item['id'];?>">update</a>
																<?php } ?>

																<?php if( is_UserAllowed('remove_cpi_item')){ ?>
																	<a style="color:red;" class="remove_cpi_item" rowid="<?php echo $cust_pi_item['id']; ?>" href="#">Remove</a>
																<?php } ?>
															</td>
															<?php endif; ?>
														<?php } ?>
													</tr>
													<?php $i++; endforeach; ?>
													<tfoot>
														<tr>
															<th colspan="15" style="text-align:right;font-size: 25px;">Total:</th>
															<th colspan="5" style="font-size: 25px;"><?php echo $totalCBM; ?></th>
														</tr>
													</tfoot>
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
                $(".sv_item_id").change(function(){

                   $('#ppq').val('Fetching Data ...');
                   $('#pp').val('Fetching Data ...');
                   $('#customer_item_code').val('Fetching Data ...');

                   var item_id = $(this).val();
                   var cust_id = <?php echo $customer_pi->cust_id; ?>;
                    //alert(cust_id);

                   $.ajax({
                        url: '/customer/getStock',
                        data: {'item_id': item_id},
                        type: "post",
                        success: function(data){

                        	$('.Cstock').val(data);

                        }
                    });

                    /* Find Previous CPI data for reference */
                    $.ajax({
                         url: '/customer/getPreviousCPIdata',
                         data: {'item_id': item_id,'cust_id':cust_id},
                         type: 'post',
                         dataType: 'json',
                         success: function(data){

                          //alert(data);
                         	$('#ppq').val(data.ppq);
                          $('#pp').val(data.pp);
                          $('#desc').val(data.desc);
                          $('#ppc').val(data.ppc);
                          $('#item_unit').val(data.item_unit);
                          $('#packaging').html(data.packaging);
                          //alert(data.customer_item_code);
                          if(data.customer_item_code != '')
                          {
                            $('#customer_item_code').val(data.customer_item_code);
                            $('#customer_item_code').attr('readonly','readonly');
                          }
                          else
                          {
                              $('#customer_item_code').val('');
                              $('#customer_item_code').removeAttr('readonly');
                          }
                          
                          if(data.customer_item_barcode != '')
                          {
                            $('#customer_item_barcode').val(data.customer_item_barcode);
                            $('#customer_item_barcode').attr('readonly','readonly');
                          }
                          else
                          {
                              $('#customer_item_barcode').val('');
                              $('#customer_item_barcode').removeAttr('readonly');
                          }  
                        

                         }
                     });

                });

                $(".remove_cpi_item").click(function(e) {
					event.preventDefault();

					if(confirm("Do you really want to remove this item?")){

						var rowid = $(this).attr('rowid');

						$.ajax({
							url: '/customer/remove_sub_item',
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
