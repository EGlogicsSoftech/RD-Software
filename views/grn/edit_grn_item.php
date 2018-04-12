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
                        <div class="col-md-4">
                            <div class="box box-warning">
                            
                            	<div class="box-header">
                                    <h3 class="box-title">General Elements</h3>
                                </div><!-- /.box-header -->
                                
                                <div class="box-body ab-class">
                                
                                    <?php echo form_error('validate'); ?>
                                    <form enctype="multipart/form-data" action="<?=base_url('grn/updateGrnItem/'.$itemrow->id); ?>" method="post">

										<?php if( $msg ) { ?>
											<div class="" style="padding-bottom: 15px;">
												<?php echo $msg; ?>
											</div>
										<?php } ?>
										
										<div class="form-group">
											<?php 	$grndata = $this->db->get_where('grn',array('grn_id'=>$itemrow->grn_row_id))->row();
													$items = Get_Items_of_bill($grndata->bill_id); ?>
											<label>Items</label>
											<select class="form-control" name="item_id"  style="width:100%;">
												<option value="">Select Item</option>
												<?php foreach( $items as $item ) :  ?>
													<option <?php if( $item['item_id'] == $itemrow->item_id ) { echo "selected"; } ?> value="<?=$item['item_id'];?>"><?=GetItemData( $item['item_id'] )->ITEM_CODE;?></option>
												<?php endforeach; ?>
											</select>
											<?php echo form_error('item_id'); ?>
										</div>

										<div class="form-group">
											<label>Challan Qty</label>
											<input type="text" class="form-control" name="challan_qty" value="<?php echo $itemrow->challan_qty; ?>"/>
											<?php echo form_error('challan_qty'); ?>
										</div>

										<div class="form-group">
											<label>Received Qty</label>
											<input type="text" class="form-control received_qty" name="received_qty" value="<?php echo $itemrow->received_qty; ?>" />
											<?php echo form_error('received_qty'); ?>
										</div>

										<div class="form-group">
											<label>Accepted Qty</label>
											<input type="text" class="form-control accepted_qty" onfocusout="rejectedQTY()" name="accepted_qty" value="<?php echo $itemrow->accepted_qty; ?>"/>
											<?php echo form_error('accepted_qty'); ?>
										</div>
										
										<div class="form-group">
											<label>Rejected Qty</label>
											<input type="text" disabled class="form-control rejected_qty" name="rejected_qty" value="<?php echo $itemrow->received_qty - $itemrow->accepted_qty; ?>"/>
											<?php echo form_error('rejected_qty'); ?>
										</div>
										
										<div class="form-group">
											<label>Remarks</label>
											<textarea class="form-control" name="remarks" placeholder="Remarks Against Rejection"><?php echo $itemrow->remarks; ?></textarea>
											<?php echo form_error('remarks'); ?>
										</div>
										
										<div class="form-group">    
											<input type="submit" class="btn btn-info" value="Submit">
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
            
            $(document).ready(function() {
                $("#supplier_id").change(function(){

                    var sup_id = $(this).val();
                    
                    $.ajax({
                        url: '/grn/getitem',
                        data: {'sup_id': sup_id},
                        type: "post",
                        success: function(data){

                            $('#supplier_pon').removeAttr('disabled');
                            $("#supplier_pon").select2("destroy");
                            $('#supplier_pon').html(data);
                            $("#supplier_pon").select2();
                        }
                    });
                });
            });
            
            function rejectedQTY()
        		{
        			var received_qty = $('.received_qty').val();
        			var accepted_qty = $('.accepted_qty').val();
        			
        			if(accepted_qty<received_qty)
        				{
        					var rejected_qty = parseFloat(received_qty) - parseFloat(accepted_qty);
        				}
        			else
        				{
        					var rejected_qty = '0';
        				}
        			
        			
        			if(rejected_qty)
        				{
        					$('.rejected_qty').val(rejected_qty);
        				}
        		}

            $('select').select2();
       
        </script>
        <script type="text/javascript" src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js"></script>

        <script type="text/javascript">
            jQuery(function () {
                jQuery('#startDate').datetimepicker({ format: 'dd/MM/yyyy' });  
            });

         </script>
    </body>
</html>