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
                        <div class="col-md-9">
                        
                            <div class="box box-warning">
                            	<div class="box-header">
                                    <h3 class="box-title">Item Details</h3>
                                    <div class="heading_right_box">
                                    	<?php if( is_UserAllowed('update_item')){ ?> <a style="color:orange;" href="<?=base_url('item/edit').'/'.$item->ID;?>">Update</a><?php } ?>
                                    </div>
                                </div><!-- /.box-header -->

                                <div class="box-body table-responsive">
                                    <table id="example12" class="table sv_table_heading item_view_table table-bordered table-hover">
                                        <tbody>    
                                            <tr>
                                                <th style="width: 35%;">Item Code</th>
                                                <td><?php echo $item->ITEM_CODE; ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 35%;">Item Category</th>
                                                <td><?php echo Get_Item_Category_Name( $item->CATEGORY_NAME ); ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 35%;">Country of Origin</th>
                                                <td><?php echo CountryData( $item->COUNTRY_ID )->country_name; ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 35%;">Item Description</th>
                                                <td><?php echo $item->ITEM_DESC; ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 35%;">Item Custom Description</th>
                                                <td><?php echo $item->ITEM_CUSTOM_DESC; ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 35%;">Supplier</th>
                                                <td>
                                                	<?php $i=1; $sup_id_array = explode(',',$item->SUPPLIER_ID); 
                                                		foreach($sup_id_array as $sid)
                                                			{
                                                				echo GetSupplierData( $sid )->supplier_code;
                                                				if( $i != count($sup_id_array))
                                                					{
                                                						echo ", ";
                                                					}
                                                				$i++;
                                                			}
                                                	?>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <th style="width: 35%;">Inner Box Size</th>
                                                <td>
                                                	<?php 
                                                		if(Get_Inner_Box_Size( $item->INNER_BOX ) != NULL)
                                                			{
                                                				echo Get_Inner_Box_Size( $item->INNER_BOX );
                                                			}
                                                			else
                                                			{
                                                				echo "N/A";
                                                			}
                                                		//echo Get_Inner_Box_Size( $item->INNER_BOX ); 
                                                	?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width: 35%;">Quantity Per Inner Box</th>
                                                
                                                
                                                <td><?php echo $item->INNER_BOX_QTY; ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 35%;">Outer Box Size</th>
                                                <td>
                                                	 <?php //echo Get_Outer_Box_Size( $item->OUTER_BOX ); ?>
                                                	<?php 
                                                		if(Get_Outer_Box_Size( $item->OUTER_BOX ) != NULL)
                                                			{
                                                				echo Get_Outer_Box_Size( $item->OUTER_BOX );
                                                			}
                                                			else
                                                			{
                                                				echo "N/A";
                                                			}
                                                		//echo Get_Inner_Box_Size( $item->INNER_BOX ); 
                                                	?>
                                                </td>
                                           
                                            </tr>
                                            <tr>
                                                <th style="width: 35%;">Quantity Per Master Box</th>
                                                <td><?php echo $item->OUTER_BOX_QTY; ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 35%;">Purchase Price</th>
                                                <td><?php echo $item->PURCHASE_PRICE.' INR'; ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 35%;">Purchase Price Code</th>
                                                <td><?php echo $item->PURCHASE_PRICE_CODE; ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 35%;">HSN Code</th>
                                                <td><?php echo $item->HSN_CODE; ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 35%;">Net Weight</th>
                                                <td>
                                                	<?php 
                                                			if($item->NET_WEIGHT != NULL)
                                                			{
                                                				echo $item->NET_WEIGHT;
                                                			}
                                                			else
                                                			{
                                                				echo "N/A";
                                                			}
                                                	?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width: 35%;">Item Unit</th>
                                                <td><?php echo GetItemUnit( $item->ITEM_UNIT ); ?></td>
                                            </tr>
                                            <tr>                                    
                                                <th style="width: 35%;">RD Catelog Page#</th>
                                                <td><?php echo $item->rd_catelog_page; ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 35%;">Oceanic Catelog Page#</th>
                                                <td><?php echo $item->oceanic_catelog_page; ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 35%;">Rep Binder Page#</th>
                                                <td><?php echo $item->rep_binder_page; ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 35%;">Item Assembled</th>
                                                <td><?php if( $item->ITEM_ASSEMBLED == '1') { echo "YES"; } else { echo "NO"; } ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                    <div class="image_box">
                                    	<?php if( $item->ITEM_IMAGE ): ?>
                                    		<a class="lightbox" href="#<?php echo $item->ID; ?>">
                                    			<img src="<?=base_url();?>uploads/item_images/<?php echo $item->ITEM_IMAGE; ?>" />
                                    			<label>click here to enlarge</label>
                                    		</a>
                                    	<?php else : ?>
                                    		<img src="<?=base_url();?>uploads/no-image-available.jpg" />
                                    	<?php endif; ?>
                                    </div>
                                    
                                    <?php if( $item->ITEM_IMAGE ): ?>
										<div class="lightbox-target" id="<?php echo $item->ID; ?>">
											<img src="<?=base_url();?>uploads/item_images/<?php echo $item->ITEM_IMAGE; ?>" />
											<a class="lightbox-close" href="#"></a>
										</div>
                                    <?php endif; ?>
                                    
                                	<div style="clear:both;"></div>
                                </div>   
							</div>
							
                                   
							<?php 	if( $item->ITEM_ASSEMBLED ) : 
									$i = 1; 
									$sub_items = GetSubItem($item->ITEM_ID);
							?>
								<div class="box box-warning"> 
									<div class="box-header">
										<h3 class="box-title">Sub Items</h3>
									</div>
									
									<div class="box-body table-responsive">
										<?php if( $sub_items ) : ?>
											<table id="example1" class="table sv_table_heading table-bordered table-hover">
												<thead>
													<tr>
														<th>S.No</th>
														<th>Item Image</th>
														<th>Item Code</th>
														<th>Item Qty</th>
														<th>Remove</th>
													</tr>
												</thead>
												<tbody>    
													<?php 	foreach( $sub_items as $sub_item ) :
															$item_data = GetItemData( $sub_item['ITEM_ID'] );
															$item_img = GetItemData( $sub_item['ITEM_ID'] )->ITEM_IMAGE;
													?>
													<tr>
														<td><?=$i;?></td>
														<td>
															<a href="/item/view/<?php echo GetItemData( $sub_item['ITEM_ID'] )->ID; ?>">
																<?php if( $item_img ): ?>
																	<img style="width:100px;" src="<?=base_url();?>uploads/item_images/<?php echo $item_img; ?>" />
																<?php else : ?>
																	<img style="width:100px;" src="<?=base_url();?>uploads/no-image-available.jpg" />
																<?php endif; ?>
															</a>
														</td>
														<td><?php echo $item_data->ITEM_CODE; ?></td>
														<td><?php echo $sub_item['QUANTITY']; ?></td>
														<td><a style="color:red;" href="<?=base_url('item/remove_sub_item').'/'.$sub_item['ID'];?>">Remove</a> | <a style="color:orange;" href="<?=base_url('item/edit_subitem').'/'.$sub_item['ID'];?>">Update</a>
                                                    	</td>
													</tr>    
													<?php $i++; endforeach; ?>
												</tbody>
											</table>
										<?php else : ?>
											<h4>No sub-item found!!!</h4>	
										<?php endif; ?>
									</div>        
								</div>
							<?php endif; ?>
                        </div>
                            
                        <div class="col-md-3">
                        	<?php if( $item->ITEM_ASSEMBLED ) :  ?>
								<div class="box box-warning">
									<div class="box-header">
										<h3 class="box-title">Add Sub Items</h3>
									</div>
								
									<div class="box-body">
									
										<?php echo form_error('validate'); ?>
										<form enctype="multipart/form-data" action="<?=base_url('item/saveSubItem').'/'.$item->ID;?>" method="post">

											<?php if( $msg ) { ?>
												<div class="" style="padding-bottom: 15px;">
													<?php echo $msg; ?>
												</div>
											<?php } ?>

											<div class="form-group">
												<label>Raw Item Codes <span style="color:red;">*</span></label>
												<select class="form-control" name="sub_item" style="width:100%;">
													<option value="">Select Raw Item</option>
													<?php foreach( $items as $itm ) :  ?>
														<option value="<?=$itm['ITEM_ID'];?>"><?=$itm['ITEM_CODE'];?></option>
													<?php endforeach; ?>
												</select>
												<?php echo form_error('sub_item'); ?>
											</div> 
											<div class="form-group">
												<label>Item Quantity <span style="color:red;">*</span></label>
												<input type="text" class="form-control" name="sub_item_qty" placeholder="Item Quantity" />
												<?php echo form_error('sub_item_qty'); ?>
												<input type="hidden" class="form-control" name="sv_item_id" value="<?php echo $item->ITEM_ID; ?>"  />
											</div>

											<div class="form-group">    
												<input type="submit" class="btn btn-info" value="Submit">
											</div>
								
										</form> 
									</div>
								</div>
							<?php endif; ?> 
                        
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
            
        </script>
    </body>
</html>