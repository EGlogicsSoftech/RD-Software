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

        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

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
                                    <h3 class="box-title">General Elements</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <?php echo form_error('validate'); ?>
                                    <form enctype="multipart/form-data" action="<?=base_url('customer/UpdateItemToCustomer/'.$CustomerPiItems->id); ?>" method="post">

										<?php if( $msg ) { ?>
											<div class="" style="padding-bottom: 15px;">
												<?php echo $msg; ?>
											</div>
										<?php } ?>
										<?php $items = GetItem(); ?>
										<div class="form-group col-md-6">
											<label>Items</label>
											<select class="form-control" name="item" style="width:100%;">
												<option value="">Select Item Code</option>
												<?php foreach( $items as $item ) :  ?>
													<option <?php if( $CustomerPiItems->item_id == $item['ITEM_ID'] ) { echo "selected"; } ?> value="<?=$item['ITEM_ID'];?>"><?=$item['ITEM_CODE'];?></option>
												<?php endforeach; ?>
											</select>
											<?php echo form_error('item'); ?>
										</div>

										<div class="form-group col-md-3">
											<label>Ordered Qty</label>
											<input type="text" class="form-control" name="req_qty" value="<?php echo $CustomerPiItems->qty; ?>" placeholder="Quantity" />
											<?php echo form_error('req_qty'); ?>
										</div>

										<div class="form-group col-md-3">
											<label>Price Per Unit</label>
											<input type="text" class="form-control" name="prc_epr_unt" value="<?php echo $CustomerPiItems->price; ?>" placeholder="Price" />
											<?php echo form_error('prc_epr_unt'); ?>
										</div>
										
										<div class="form-group col-md-6">
											<label>Customer Item Code</label>
											<input type="text" class="form-control" name="customer_item_code" value="<?php echo $CustomerPiItems->customer_item_code; ?>" placeholder="Customer Item Code" />
											<?php echo form_error('customer_item_code'); ?>
										</div>
										
										<div class="form-group col-md-6">
											<label>Customer Item Barcode</label>
											<input type="text" class="form-control" name="customer_item_barcode" value="<?php echo $CustomerPiItems->customer_item_barcode; ?>" placeholder="Customer Item Barcode" />
											<?php echo form_error('customer_item_barcode'); ?>
										</div>
										
										<!-- 
<div class="form-group col-md-6">
											<label>H S Code</label>
											<input type="text" class="form-control" name="hs_code" value="<?php echo $CustomerPiItems->hs_code; ?>" placeholder="H S Code" />
											<?php echo form_error('hs_code'); ?>
										</div>
 -->
										
										<div class="form-group col-md-12">
											<label>Packaging Instructions</label>
											<textarea class="form-control" rows="3" name="packg_inst" value="<?php echo $CustomerPiItems->Packaging_instructions; ?>" placeholder="Enter Packaging Instructions"></textarea>
											<?php echo form_error('packg_inst'); ?>
										</div>
										
										<div class="form-group col-md-12">    
											<input type="submit" class="btn btn-info" value="Update">
										</div>
										<div style="clear:both;"></div>
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

        <script src="<?=base_url();?>admin/js/bootstrap-datepicker.js" type="text/javascript"></script>

        <script src="<?=base_url();?>admin/js/jquery.repeater.js" type="text/javascript"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
        <script type="text/javascript" src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js"></script>

        <script type="text/javascript">

            //$('#datepicker').datepicker();
            jQuery(function () {
                //jQuery('#startDate').datetimepicker({ format: 'dd/MM/yyyy hh:mm:ss' });  
                jQuery('#startDate').datetimepicker({ format: 'dd/MM/yyyy' }); 
            });

         </script>

        <script type="text/javascript">

            //$('#datepicker').datepicker();

            $('select').select2();

            $(document).ready(function () 
            {
                $('.customerpo_repeater').repeater({
                    // (Optional)
                    // "defaultValues" sets the values of added items.  The keys of
                    // defaultValues refer to the value of the input's name attribute.
                    // If a default value is not specified for an input, then it will
                    // have its value cleared.
                    defaultValues: {
                        'text-input': 'foo'
                    },
                    isFirstItemUndeletable: true,
                    // (Optional)
                    // "show" is called just after an item is added.  The item is hidden
                    // at this point.  If a show callback is not given the item will
                    // have $(this).show() called on it.
                    show: function () {
                        $(this).find('select').next('.select2-container').remove();
                        $(this).find('select').select2();
                        $(this).slideDown();
                    },
                    // (Optional)
                    // "hide" is called when a user clicks on a data-repeater-delete
                    // element.  The item is still visible.  "hide" is passed a function
                    // as its first argument which will properly remove the item.
                    // "hide" allows for a confirmation step, to send a delete request
                    // to the server, etc.  If a hide callback is not given the item
                    // will be deleted.
                    hide: function (deleteElement) {
                        if(confirm('Are you sure you want to delete this element?')) {
                            $(this).slideUp(deleteElement);
                        }
                    }
                })
                
                $('#item_assembled').on('ifChecked', function(event)
                {
                    //alert(event.type + ' callback');
                    $(".sv_repeater").show("fast");
                });
                
                $('#item_assembled').on('ifUnchecked', function(event)
                {
                    //alert(event.type + ' callback');
                    $(".sv_repeater").hide("fast");
                });
                
                
            });


        </script>
    </body>
</html>