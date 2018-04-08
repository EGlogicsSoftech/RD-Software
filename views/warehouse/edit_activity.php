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
                                    <?php echo form_error('validate'); ?>
                                    <form action="<?=base_url('warehouse/update_activity/'.$activity->id);?>" method="post">
                                        <?php if( $msg ) { ?>
                                            <div class="col-md-12" style="padding-bottom: 15px;">
                                                <?php echo $msg; ?>
                                            </div>
                                        <?php } ?>
                                        <div class="form-group col-md-4">
                                            <label>Items <span style="color:red;">*</span></label>
                                            <select class="form-control" name="item" style="width:100%;">
                                                <option value="">Select Items</option>
                                                <?php foreach( $items as $item ) : ?>
                                                    <option <?php if( $item['ITEM_ID'] == $activity->item_id ) { echo "selected"; } ?> value="<?=$item['ITEM_ID'];?>"><?=GetItemData( $item['ITEM_ID'] )->ITEM_CODE;?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php echo form_error('item'); ?>
                                        </div>

                                        <div class="form-group col-md-4">
                                        	<label>Finished Quantity <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="finsh_qty" value="<?php echo $activity->qty; ?>" placeholder="Finished Quantity" />
                                            <?php echo form_error('finsh_qty'); ?>
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                        	<label>Alloted Worker <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="altd_worker" value="<?php echo $activity->altd_wrkr; ?>" placeholder="Alloted Worker" />
                                            <?php echo form_error('altd_worker'); ?>
                                        </div>

										<div class="form-group col-md-3">
                                        	<label>Shifts <span style="color:red;">*</span></label>
                                            <select class="form-control" name="shift" style="width:100%;">
                                                <option value="">Select Shift</option>
                                                <option <?php if( $activity->shift == 'day' ){ echo "selected"; } ?> value="day">Day</option>
                                                <option <?php if( $activity->shift == 'night' ){ echo "selected"; } ?> value="night">Night</option>
                                            </select>
                                            <?php echo form_error('shift'); ?>
                                        </div>
										
                                        <div class="form-group col-md-3">
                                           	<label>Date <span style="color:red;">*</span></label>
                                            <div class='input-group date' id='startDate'>

                                                <input type='text' class="form-control" name="date" value="<?php echo $activity->date; ?>" />
                                                <span class="input-group-addon add-on">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>  
											<?php echo form_error('date'); ?>
                                        </div>
                                        
                                        <div class="form-group col-md-3">
                                         	<label>Status/Remark <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="stus_remark" value="<?php echo $activity->remarks; ?>" placeholder="Status/Remark" />
                                            <?php echo form_error('stus_remark'); ?>
                                        </div>

                                        <div class="form-group col-md-3">
                                        	<label>Invoice <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="invoice" value="<?php echo $activity->invoice_num; ?>" placeholder="Invoice" />
                                            <?php echo form_error('invoice'); ?>
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