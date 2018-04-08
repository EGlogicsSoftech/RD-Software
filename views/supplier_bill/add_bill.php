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
                        <div class="col-md-9">
                            <div class="box box-warning">
                            
                            	<!-- 
<div class="box-header">
                                    <h3 class="box-title">General Elements</h3>
                                </div>
 -->
                                
                                <div class="box-body ab-class">
                                
                                    <?php echo form_error('validate'); ?>
                                    <form action="<?=base_url('supplier_bill/saveBill');?>" enctype="multipart/form-data" method="post">
                                    
                                        <?php if( $msg ) { ?>
                                            <div class="col-md-12" style="padding-bottom: 15px;">
                                                <?php echo $msg; ?>
                                            </div>
                                        <?php } ?> 
                                        
                                        <div class="form-group col-md-6">
                                            <label>Challan No. <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" rows="3" name="challan_no" value="<?php echo $this->input->post('challan_no')?>" placeholder="Enter Challan No.">
                                            <?php echo form_error('challan_no'); ?>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Supplier<span style="color:red;">*</span></label>
                                            <select class="form-control" name="supplier_id" id="supplier_id">
                                                <option value="">Select Supplier</option>
                                                <?php foreach( $suppliers as $supplier ) : ?>
                                                    <option <?php if( $this->input->post('supplier_id') == $supplier['id'] ) { echo "selected"; } ?> value="<?=$supplier['id'];?>"><?=$supplier['supplier_name'].' - ('.$supplier['supplier_code'].')';?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            
                                            <?php echo form_error('supplier_id'); ?>
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                        	<label>Challan Date <span style="color:red;">*</span></label>
											<div class='input-group date' id='startDate'>
												<input type='text' class="form-control" name="challan_date" value="<?php echo $this->input->post('challan_date')?>" />
												<span class="input-group-addon add-on">
													<span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                            <?php echo form_error('challan_date'); ?>
                                        </div>  

                                        <div class="form-group col-md-6">
                                            <label>No. of Boxes <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" rows="3" name="box_no" value="<?php echo $this->input->post('box_no')?>" placeholder="Enter No. of Boxes">
                                            <?php echo form_error('box_no'); ?>
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>Add Challan <span style="color:red;">*</span></label>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="file" name="challan_img" id="challan_img" >
                                                </label>                                                
                                            </div>
                                             <?php echo form_error('challan_img'); ?>
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

        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
        
        <script type="text/javascript">
            
           //  $(document).ready(function() {
//                 $("#supplier_id").change(function(){
// 
//                     var sup_id = $(this).val();
//                     
//                     $.ajax({
//                         url: '/grn/getitem',
//                         data: {'sup_id': sup_id},
//                         type: "post",
//                         success: function(data){
// 
//                             $('#supplier_pon').removeAttr('disabled');
//                             $("#supplier_pon").select2("destroy");
//                             $('#supplier_pon').html(data);
//                             $("#supplier_pon").select2();
//                         }
//                     });
//                 });
//             });

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