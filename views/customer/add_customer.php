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

        <link href="<?=base_url();?>admin/css/bootstrap-colorpicker.min.css" rel="stylesheet" type="text/css" />

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
                                    <form action="<?=base_url('customer/SaveCustomer');?>" method="post">

                                        <?php if( $msg ) : ?>
                                            <div class="col-md-12" style="padding-bottom: 15px;">
                                                <?php echo $msg; ?>
                                            </div>
                                        <?php endif; ?>

										<div class="form-group col-md-12">
                                            <div class="checkbox">
                                                <label>
                                                    <input <?php if( $this->input->post('oceanic_client') == '1' ){ echo "checked"; } ?> type="checkbox" id="oceanic_client" value="1" name="oceanic_client" /> <strong>  Is this Oceanic Client</strong>
                                                </label>
                                            </div>
                                            <?php echo form_error('oceanic_client'); ?>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Customer Code <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="customer_code" value="<?php echo $this->input->post('customer_code')?>" placeholder="Enter Customer Code"/>
                                            <?php echo form_error('customer_code'); ?>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Customer Name <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="customer_name" value="<?php echo $this->input->post('customer_name')?>" placeholder="Enter Customer Name"/>
                                            <?php echo form_error('customer_name'); ?>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Email ID <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="email" value="<?php echo $this->input->post('email')?>" placeholder="Enter Email"/>
                                            <?php echo form_error('email'); ?>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Phone <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="phone" value="<?php echo $this->input->post('phone')?>" placeholder="Enter Phone Number"/>
                                            <?php echo form_error('phone'); ?>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Contact Person <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="contact_person" value="<?php echo $this->input->post('contact_person')?>" placeholder="Enter Contact Person"/>
                                            <?php echo form_error('contact_person'); ?>
                                        </div>

										<div class="form-group col-md-6">
                                        	<label>Color</label>
                                        	<div class="input-group cp3 colorpicker-component">
												<input type="text" name="color" value="<?php echo $this->input->post('color')?>" class="cp3 form-control" />
												<span class="input-group-addon"><i></i></span>
											</div>
											<!-- <input type="text" name="color" id="cp3" value="#FFFFFF" class="form-control" /> -->
										</div>

                                        <div class="form-group col-md-6">
                                        	<label>Shipping Address <span style="color:red;">*</span></label>
                                        	<textarea class="form-control" rows="2" name="cust_add" value="" placeholder="Shipping Address"><?php echo $this->input->post('cust_add')?></textarea>
                                            <?php echo form_error('cust_add'); ?>
                                        </div>

                                        <div class="form-group col-md-6">
                                        	<label>Biling Address <span style="color:red;">*</span></label>
                                        	<textarea class="form-control" rows="2" name="billing_add" value="" placeholder="Billing Address"><?php echo $this->input->post('billing_add')?></textarea>
                                            <?php echo form_error('billing_add'); ?>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Shipping Terms <span style="color:red;">*</span></label>
                                            <select class="form-control" name="shipping_term">
                                                <option <?php if( $this->input->post('shipping_term') == '' ){ echo "selected"; } ?> value="">Select Terms</option>
                                                <option <?php if( $this->input->post('shipping_term') == 'FOB'){ echo "selected"; } ?> value="FOB">FOB</option>
                                                <option <?php if( $this->input->post('shipping_term') == 'C&F' ){ echo "selected"; } ?> value="C&F">C&F</option>
                                            </select>
                                            <?php echo form_error('shipping_term'); ?>
                                        </div>

                                        <!-- textarea -->
                                        <div class="form-group col-md-6">
                                            <label>Customer Description <span style="color:red;">*</span></label>
                                            <textarea class="form-control" rows="1" name="customer_desc" value="<?php echo $this->input->post('customer_desc')?>" placeholder="Enter Customer Description"><?php echo $this->input->post('customer_desc')?></textarea>
                                            <?php echo form_error('customer_desc'); ?>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <input type="submit" class="btn btn-info" value="Submit">
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
        <script src="<?=base_url();?>admin/js/bootstrap-colorpicker.js" type="text/javascript"></script>

        <!-- AdminLTE App -->
        <script src="<?=base_url();?>admin/js/AdminLTE/app.js" type="text/javascript"></script>
        <style>
			/*
.colorpicker-2x .colorpicker-saturation {
				width: 200px;
				height: 200px;
			}
 */

			.colorpicker-2x .colorpicker-hue,
			.colorpicker-2x .colorpicker-alpha {
				width: 30px;
				height: 200px;
			}

			.colorpicker-2x .colorpicker-color,
			.colorpicker-2x .colorpicker-color div {
				height: 30px;
			}
		</style>
		<script>
			$(function() {
				$('.cp3').colorpicker({
					customClass: 'colorpicker-2x',
					horizontal: true,
					format: 'hex',
					sliders: {
						saturation: {
							maxLeft: 200,
							maxTop: 200
						},
						hue: {
							maxTop: 200
						},
						alpha: {
							maxTop: 200
						}
					}
				});
			});
		</script>
    </body>
</html>
