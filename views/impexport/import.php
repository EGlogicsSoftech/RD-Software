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

        <link href="<?=base_url();?>admin/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css" />

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
                                	
                                	<?php if( $msg ) { ?>
										<div class="col-md-12" style="padding-bottom: 15px;">
											<?php echo $msg; ?>
										</div>
									<?php } ?>
									
                                    <?php echo form_error('validate'); ?>
                                    
                                    <table id="example12" class="table sv_table_heading item_view_table table-bordered table-hover">
                                        <tbody>  
                                          
                                            <tr>
                                                <th style="width: 35%;">Item Import</th>
                                                <td>
                                                	<form action="<?=base_url('impexport/import_item');?>" method="post" enctype="multipart/form-data" name="import_item" id="import_item"> 
														<input style="float: left; width: 83%; margin-right: 2%;" type="file" class="form-control" name="imp_item" id="imp_item"  align="center"/>
														<button type="submit" name="item_submit" class="btn btn-info">Import</button>
													</form>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width: 35%;">Supplier Import</th>
                                                <td>
                                                	<form action="<?=base_url('impexport/import_supplier');?>" method="post" enctype="multipart/form-data" name="import_supplier" id="import_supplier"> 
														<input style="float: left; width: 83%; margin-right: 2%;" type="file" class="form-control" name="imp_supplier" id="imp_supplier"  align="center"/>
														<button type="submit" name="supplier_submit" class="btn btn-info">Import</button>
													</form>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width: 35%;">Customer Import</th>
                                                <td> 
                                                	<form action="<?=base_url('impexport/import_customer');?>" method="post" enctype="multipart/form-data" name="import_customer" id="import_customer"> 
														<input style="float: left; width: 83%; margin-right: 2%;" type="file" class="form-control" name="imp_customer" id="imp_customer"  align="center"/>
														<button type="submit" name="customer_submit" class="btn btn-info">Import</button>
													</form>
                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                    <div style="clear:both;"></div>
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
		<script type="text/javascript" src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js"></script>
       
        <script type="text/javascript">

			$('select').select2();

            jQuery(function () {
                jQuery('#startDate').datetimepicker({ format: 'dd/MM/yyyy' });
            });

         </script>
    </body>
</html>