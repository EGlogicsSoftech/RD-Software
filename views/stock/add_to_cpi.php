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
                                    <form action="<?=base_url('stock/updateCPI/'.$stock->id);?>" method="post">
                                        <?php if( $msg ) { ?>
                                            <div class="col-md-12" style="padding-bottom: 15px;">
                                                <?php echo $msg; ?>
                                            </div>
                                        <?php } ?>
                                        <div class="form-group col-md-6">
                                            <label>Customer Name</label>
                                            <select class="form-control customer" name="customer">
                                                <option value="">Select Customer</option>
                                                <?php foreach( $customers as $customer ) : ?>
                                                    <option value="<?=$customer['customer_id'];?>"><?=$customer['name'];?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php echo form_error('customer'); ?>
                                        </div>

										<div class="form-group col-md-6">
											<label>CPI</label>
											<select class="form-control cust_pi" name="cust_pi" item_id="<?php echo $stock->item_id; ?>" style="width:100%;">
												<option value=''>Select CPI</option>
											</select>
											<?php echo form_error('cust_pi'); ?>
										</div>

										<div class="form-group col-md-6">
											<label>Quantity</label>
											<input disabled type="text" class="form-control" name="qty" value="<?php echo $stock->qty; ?>"/>
											<?php echo form_error('qty'); ?>
										</div>
										
										<div class="form-group col-md-6">
											<label>Item</label>
											<input disabled type="text" class="form-control" name="item_id" value="<?php echo GetItemData( $stock->item_id )->ITEM_CODE; ?>" />
											<?php echo form_error('item_id'); ?>
										</div>
										
										<div class="form-group sv_submit col-md-12">    
												
											<?php if( !$stock->cpi_no ) { ?>
										
												<input style="display:none;" type="submit" class="btn btn-info" value="Submit CPI">
												<p style="display:none;">Item Not matched</p>
											<?php } else { ?>
												<label style="color:green;">Added</label>
											<?php } ?>
										
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


        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
		
		<script type="text/javascript">


            $(document).ready(function() {
                $(".customer").change(function(){

                    var cid = $(this).val();
                    
                    $.ajax({
                        url: '/stock/GetCPIByCustomer',
                        data: {'cid': cid},
                        type: "post",
                        success: function(data){
                        	
                        	$('.cust_pi').html(data);
                        	
                        }
                    });
                });
            });
            
            $(document).ready(function() {
                $(".cust_pi").change(function(){
					
					var pi_id = $(this).val();
                    var item_id = $(this).attr('item_id');
                    
                    $.ajax({
                        url: '/stock/GetItembyCPI',
                        data: {'pi_id': pi_id, 'item_id': item_id},
                        type: "post",
                        success: function(data){
                        	
                        	if( data == 1 )
                        		{
                        			$('.sv_submit input').css('display', 'block');
                        			$('.sv_submit p').css('display', 'none');
                        		}
                        	else
                        		{
                        			$('.sv_submit input').css('display', 'none');
                        			$('.sv_submit p').css('display', 'block');
                        		}
                        }
                    });
                });
            });

            $('select').select2();

        </script>
    </body>
</html>