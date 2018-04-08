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
                                    <h3 class="box-title">Add Supplier Information</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <form action="<?=base_url('supplier/save_supplier');?>" method="post">

                                        <?php if( $msg ) : ?>
                                            <div class="col-md-12" style="padding-bottom: 15px;">
                                                <?php echo $msg; ?>
                                            </div>
                                        <?php endif; ?>

                                        <div class="form-group col-md-6">
                                            <label>Supplier Code <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="supplier_code" value="<?php echo $this->input->post('supplier_code')?>"   placeholder="Enter Supplier Code"/>
                                            <?php echo form_error('supplier_code'); ?>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Supplier Name <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="supplier_name" value="<?php echo $this->input->post('supplier_name')?>" placeholder="Enter Supplier Name"/>
                                            <?php echo form_error('supplier_name'); ?>
                                        </div>

                                        <!--
<div class="form-group col-md-6">
                                            <label>Tin No.</label>
                                            <input type="text" class="form-control" name="tin_no" value="<?php echo $this->input->post('tin_no')?>" placeholder="Enter Tin No"/>
                                            <?php echo form_error('tin_no'); ?>
                                        </div>
 -->

                                        <div class="form-group col-md-6">
                                            <label>GSTIN No. <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="gstin_no" value="<?php echo $this->input->post('gstin_no')?>" placeholder="Enter GSTIN No."/>
                                            <?php echo form_error('gstin_no'); ?>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>PAN No. <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="pan_no" value="<?php echo $this->input->post('pan_no')?>" placeholder="Enter PAN No."/>
                                            <?php echo form_error('pan_no'); ?>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Email ID</label>
                                            <input type="text" class="form-control" name="email" value="<?php echo $this->input->post('email')?>" placeholder="Enter Email"/>
                                            <?php echo form_error('email'); ?>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Mobile# <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="mobile" value="<?php echo $this->input->post('mobile')?>" placeholder="Enter Mobile Number"/>
                                            <?php echo form_error('mobile'); ?>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Office Phone</label>
                                            <input type="text" class="form-control" name="phone" value="<?php echo $this->input->post('phone')?>" placeholder="Enter Office Phone Number"/>
                                            <?php echo form_error('phone'); ?>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Contact Person <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="contact_person" value="<?php echo $this->input->post('contact_person')?>" placeholder="Enter Contact Person"/>
                                            <?php echo form_error('contact_person'); ?>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>State <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="state" value="<?php echo $this->input->post('state')?>" placeholder="Enter State"/>
                                            <?php echo form_error('state'); ?>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Full Address <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="full_add" value="<?php echo $this->input->post('full_add')?>" placeholder="Enter Address"/>
                                            <?php echo form_error('full_add'); ?>
                                        </div>

                                        <!-- <div class="form-group col-md-6">&nbsp;</div> -->

                                        <!-- textarea -->
                                        <div class="form-group col-md-12">
                                            <label>Supplier Notes</label>
                                            <textarea class="form-control" rows="3" name="supplier_desc" value="<?php echo $this->input->post('supplier_desc')?>" placeholder="Enter Supplier Notes"></textarea>
                                            <?php echo form_error('supplier_desc'); ?>
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
        <!-- AdminLTE App -->
        <script src="<?=base_url();?>admin/js/AdminLTE/app.js" type="text/javascript"></script>
    </body>
</html>
