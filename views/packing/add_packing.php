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
                                    <form action="<?=base_url('packing/SavePacking');?>" method="post">
                                        <?php if( $msg ) { ?>
                                            <div class="col-md-12" style="padding-bottom: 15px;">
                                                <?php echo $msg; ?>
                                            </div>
                                        <?php } ?>
                                        
                                        <?php $array1 = array();	$array2 = array();
                                        
                                        		if( $PN_from_Packing ) :
													foreach($PN_from_Packing as $row1)
														{
															$array1[] = $row1['packing_num'];
														}
												endif;	
												
												if($packing_nos) :
													foreach($packing_nos as $row2)
														{
															$array2[] = $row2['ref_id'];
														}
												endif;
												
												$results = array_diff($array2, $array1);
													 
                                       	?>
                                        
                                         <div class="form-group col-md-6">
                                            <label>Client <span style="color:red;">*</span></label>
                                            <select class="form-control client" name="client" style="width:100%;">
                                                <option value="">Select Client</option>
                                                <option <?php if( $this->input->post('client') == 1 ){ echo "selected"; } ?> value="1">Oceanic</option>
                                                <option value="0">Non-Oceanic</option>
                                            </select>
                                            <?php echo form_error('client'); ?>
                                        </div>
                                        
                                        <div class="form-group col-md-6 slct_cust">
                                            <label>Customers <span style="color:red;">*</span></label>
                                            <select class="form-control invoice_custpo" name="packing_custpo" style="width:100%;">
                                                <option value="">Select Customer</option>
                                                <?php foreach( $customers as $customer ) :  ?>
                                                    <option <?php if( $this->input->post('packing_custpo') == $customer['customer_id'] ){ echo "selected"; } ?> value="<?=$customer['customer_id'];?>"><?=$customer['name'];?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php echo form_error('packing_custpo'); ?>
                                        </div>

                                       <div class="form-group col-md-6">
                                            <label>Packing No <span style="color:red;">*</span></label>
                                             <select class="form-control" name="packing_no" style="width:100%;">
                                                <option value="">Select Packing No.</option>
                                                <?php foreach( $results as $packing_no ) :  ?>
                                                    <option <?php if( $this->input->post('packing_no') == $packing_no ){ echo "selected"; } ?> value="<?=$packing_no;?>"><?=$packing_no;?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php echo form_error('packing_no'); ?>
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>Date <span style="color:red;">*</span></label>    
                                            <div class='input-group date' id='startDate'>

                                                <input type='text' class="form-control" name="date" value="<?php echo $this->input->post('date')?>" />
                                                <span class="input-group-addon add-on">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                            <?php echo form_error('date'); ?>
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

        <script src="<?=base_url();?>admin/js/bootstrap-datepicker.js" type="text/javascript"></script>

        <script src="<?=base_url();?>admin/js/jquery.repeater.js" type="text/javascript"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
        <script type="text/javascript" src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js"></script>

        <script type="text/javascript">

            //$('#datepicker').datepicker();
            jQuery(function () {
                jQuery('#startDate').datetimepicker({ format: 'dd/MM/yyyy' });  
            });

         </script>

        <script type="text/javascript">

           // $('#datepicker').datepicker();

           

        </script>
        

        <script type="text/javascript">

            $(document).ready(function() {
                $(".client").change(function(){

                    var client = $(this).val();
					
					if( client == 1 )
						{
							$('.slct_cust').css('display', 'none');
							$('.invoice_custpo').val(0);
						}
					else
						{
							$('.slct_cust').css('display', 'block');
							
						}
				});	
            });
            
           //  $(document).ready(function() {
//                 $(".invoice_custpo").change(function(){
// 
//                     var po_id = $(this).val();
// 
//                     $.ajax({
//                         url: '/invoice/get_item_by_customerPO',
//                         data: {'po_id': po_id}, 
//                         type: "post",
//                         success: function(data){
// 
//                             $('.invoice_item').removeAttr('disabled');
//                             $(".invoice_item").select2("destroy");
//                             $('.invoice_item').html(data);
//                             $(".invoice_item").select2();
// 
//                             //alert(data);
//                         }
//                     });
//                 });
//             });


            $('select').select2();
            
        </script>
    </body>
</html>