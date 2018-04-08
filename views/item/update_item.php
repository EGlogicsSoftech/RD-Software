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

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <!-- right column -->
                        <div class="col-md-9">
                            <!-- general form elements disabled -->
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">General Information</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body" style="overflow:hidden;">
                                    <?php echo form_error('validate'); ?>
                                    <form class="repeater"  enctype="multipart/form-data"  action="<?=base_url('item/updateItem/'.$item->ID );?>" method="post">
										<?php //var_dump($item); ?>
                                        <div class="form-group col-md-6">
                                            <label>Item Code <span style="color:red;">*</span></label>
                                            <input <?php if( !is_UserAllowed('update_item_code')){ echo "disabled"; } ?> type="text" class="form-control" name="item_code" value="<?php echo $item->ITEM_CODE; ?>" />
                                            <?php echo form_error('item_code'); ?>
                                        </div>

                                        <!-- textarea -->
                                        <div class="form-group col-md-6">
                                            <label>Item Category <span style="color:red;">*</span></label>
                                            <select class="form-control" name="item_category">
                                                <option value="">Select Item Category</option>
                                                <?php foreach( $categories as $category ) : ?>
                                                    <option <?php if( $item->CATEGORY_NAME == $category['ID'] ) { echo "selected";  } ?> value="<?=$category['ID'];?>"><?=$category['CATEGORY_NAME'];?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php echo form_error('item_category'); ?>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>Item Description <span style="color:red;">*</span></label>
                                            <textarea class="form-control" rows="3" name="item_desc"><?php echo $item->ITEM_DESC; ?></textarea>
                                            <?php echo form_error('item_desc'); ?>
                                        </div>
                                        
                                        <div class="form-group col-md-12">
                                            <label>Item Custom Description</label>
                                            <textarea class="form-control" rows="3" name="item_custom_desc"><?php echo $item->ITEM_CUSTOM_DESC; ?></textarea>
                                            <?php echo form_error('item_custom_desc'); ?>
                                        </div>
										
                                        <div class="form-group col-md-6">
                                            <?php $sup_id_array = explode(',',$item->SUPPLIER_ID); ?>
                                            <label>Suppliers <span style="color:red;">*</span></label>
                                            <select class="form-control" name="supplier[]" multiple="multiple">
                                                <option value="">Select Supplier</option>
                                                <?php foreach( $suppliers as $supplier ) : ?>
                                                    <option <?php if( in_array($supplier['id'],$sup_id_array) ) { echo "selected";  }?> value="<?=$supplier['id'];?>"><?=$supplier['supplier_name'];?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php echo form_error('supplier_desc'); ?>
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>Country of Origin <span style="color:red;">*</span></label>
                                            <select class="form-control" name="item_country">
                                                <option value="">Select Country</option>
                                                <?php foreach( $countries as $country ) : ?>
                                                    <option <?php if( $item->COUNTRY_ID == $country['id'] ){ echo "selected"; } ?> value="<?=$country['id'];?>"><?=$country['country_name'];?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php echo form_error('item_unit'); ?>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Item Units <span style="color:red;">*</span></label>
                                            <select class="form-control" name="item_unit">
                                                <option value="">Select Item Unit</option>
                                                <?php foreach( $units as $unit ) : ?>
                                                    <option <?php if( $item->ITEM_UNIT == $unit['ID'] ) { echo "selected";  }?> value="<?=$unit['ID'];?>"><?=$unit['UNIT_NAME'];?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php echo form_error('item_unit'); ?>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Inner Box</label>
                                            <select class="form-control" name="inner_box">
                                                <option value="0">Select Inner Box</option>
                                                <?php foreach( $innerboxes as $innerbox ) : ?>
                                                    <option <?php if( $item->INNER_BOX == $innerbox['ID'] ) { echo "selected";  }?> value="<?=$innerbox['ID'];?>"><?=$innerbox['INNER_BOX_SIZE'];?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php echo form_error('inner_box'); ?>
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>Quantity in Inner Box</label>
                                            <input type="text" class="form-control" name="inner_qty" placeholder="QTY" value="<?php echo $item->INNER_BOX_QTY; ?>" />
                                            <?php echo form_error('inner_qty'); ?>
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>Outer Box</label>
                                            <select class="form-control" name="outer_box">
                                                <option value="0">Select Outer Box</option>
                                                <?php foreach( $outerboxes as $outerbox ) : ?>
                                                    <option <?php if( $item->OUTER_BOX == $outerbox['ID'] ) { echo "selected";  }?> value="<?=$outerbox['ID'];?>"><?=$outerbox['OUTER_BOX_SIZE'];?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php echo form_error('outer_box'); ?>
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>Quantity in master box</label>
                                            <input type="text" class="form-control" name="outer_qty" placeholder="QTY" value="<?php echo $item->OUTER_BOX_QTY; ?>" />
                                            <?php echo form_error('outer_qty'); ?>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Purchase Price <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="purchase_price" placeholder="Purchase Price" value="<?php echo $item->PURCHASE_PRICE; ?>" />
                                            <?php echo form_error('purchase_price'); ?>
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>Purchase Price Code <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="purchase_price_code" placeholder="Purchase Price Code" value="<?php echo $item->PURCHASE_PRICE_CODE; ?>" />
                                            <?php echo form_error('purchase_price_code'); ?>
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>HSN Code <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="hsn_code" placeholder="HSN Code" value="<?php echo $item->HSN_CODE; ?>" />
                                            <?php echo form_error('hsn_code'); ?>
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>Net Weight</label>
                                            <input type="text" class="form-control" name="net_weight" placeholder="Net Weight" value="<?php echo $item->NET_WEIGHT; ?>" /> 
                                            <?php echo form_error('net_weight'); ?>
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>RD Catelog Page#</label>
                                            <input type="text" class="form-control" name="rd_catelog_page" placeholder="RD Catelog Page" value="<?php echo $item->rd_catelog_page; ?>" />
                                            <?php echo form_error('rd_catelog_page'); ?>
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>Oceanic Catelog Page#</label>
                                            <input type="text" class="form-control" name="oceanic_catelog_page" placeholder="Oceanic Catelog Page" value="<?php echo $item->oceanic_catelog_page; ?>" />
                                            <?php echo form_error('oceanic_catelog_page'); ?>
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>Rep Binder Page#</label>
                                            <input type="text" class="form-control" name="rep_binder_page" placeholder="Rep Binder Page" value="<?php echo $item->rep_binder_page; ?>" />
                                            <?php echo form_error('rep_binder_page'); ?>
                                        </div>
										
										<div class="form-group col-md-6">
                                            <label>Change Item Image</label>
                                            <div class="checkbox">
                                                <label>
                                                	<input type="file" name="item_image" id="item_image" >
                                                </label>                                                
                                            </div>
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <div class="edit_item_image_box">
												<?php if( $item->ITEM_IMAGE ): ?>
													<img src="<?=base_url();?>uploads/item_images/<?php echo $item->ITEM_IMAGE; ?>" />
												<?php else : ?>
													<img src="<?=base_url();?>uploads/no-image-available.jpg" />
												<?php endif; ?>
											</div>
                                        </div>
                                        
                                       
											<div class="form-group col-md-6">  
												<label>Item Assembled</label> 
												<div class="checkbox">
													<label>
														<input type="checkbox" <?php if( $item->ITEM_ASSEMBLED == 1 ) : echo "checked"; endif; ?> id="item_assembled" name="item_assembled" /> Yes
													</label>                                                
												</div>
												<?php echo form_error('item_assembled'); ?>
											</div>
                                        
                                       	<div class="form-group col-md-12"> 
                                       		<input type="hidden" name="item_id" value="<?php echo $item->ITEM_ID; ?>" >
                                       		<input type="hidden" name="item_image" value="<?php echo $item->ITEM_IMAGE; ?>" >
                                       		
                                       		<?php if( !is_UserAllowed('update_item_code')){  ?>
                                       		
                                       			<input type="hidden" name="item_code" value="<?php echo $item->ITEM_CODE; ?>" />
                                       			
                                       		<?php } ?>
                                       		<!-- <input type="hidden" name="item_assembled" value="<?php echo $item->ITEM_ASSEMBLED; ?>" > -->
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
            
        </script>

    </body>
</html>