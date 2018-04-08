<!DOCTYPE html>
<?php if( AllowedByRole($this->session->userdata('id'), 4) ) : ?>
	<?php redirect(base_url().'item/listitems'); ?>
<?php endif; ?>
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
                        <div class="col-md-4">
                            <!-- general form elements disabled -->
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">General Information</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body" style="overflow:hidden;">
                                    <?php echo form_error('validate'); ?>
                                    <form class="repeater"  enctype="multipart/form-data"  action="<?=base_url('item/update_sub_item/'.$subitems->ID );?>" method="post">
										<?php //var_dump($item); ?>
										
                                        <div class="form-group">
											<label>Item Codes <span style="color:red;">*</span></label>
											<select class="form-control" name="sub_item" style="width:100%;">
												<option value="">Select Item</option>
												<?php foreach( $items as $itm ) :  ?>
													<option <?php if( $subitems->ITEM_ID == $itm['ITEM_ID'] ) : echo "selected"; endif; ?> value="<?=$itm['ITEM_ID'];?>"><?=$itm['ITEM_CODE'];?></option>
												<?php endforeach; ?>
											</select>
											<?php echo form_error('sub_item'); ?>
										</div> 
										<div class="form-group">
											<label>Item Quantity <span style="color:red;">*</span></label>
											<input type="text" class="form-control" name="sub_item_qty" placeholder="Item Quantity" value="<?php echo $subitems->QUANTITY; ?>" />
											<?php echo form_error('sub_item_qty'); ?>
										</div>
                                        
                                       	<div class="form-group col-md-12"> 
                                       		<input type="hidden" class="form-control" name="sv_item_id" value="<?php echo $subitems->PARENT_ITEM_ID; ?>"  />
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