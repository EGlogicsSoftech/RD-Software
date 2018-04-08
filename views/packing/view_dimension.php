<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Rickshaw Delivery | <?=$title;?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?=base_url();?>admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- DATA TABLES -->
        <link href="<?=base_url();?>admin/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
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

                <section class="content">
                    <div class="row">
                    	
                    	<?php $boxes = GetDimensionBox( $dimension->id ); ?>
                    	
                        <div class="col-md-6">
                        	<div class="box box-warning">
                            	<div class="box-header">
                                    <h3 class="box-title">Dimension Details</h3>
                                    <div class="box-body">
              						</div>
                                    <div class="heading_right_box">
                                    	<?php if( $boxes ){ ?>
                                    		<a style="color:orange;" href="/packing/Dimension_Excel/<?php echo $dimension->id; ?>">Export Excel</a>
                                    	<?php } ?>
                                    	<!-- 
<div class="btn-group">
										  	<button disabled type="button" class="btn btn-warning btn-flat">PDF</button>
										  	<button type="button" class="btn btn-warning btn-flat dropdown-toggle" data-toggle="dropdown">
												<span class="caret"></span>
												<span class="sr-only">Toggle Dropdown</span>
										  	</button>
										  	<ul class="dropdown-menu" role="menu">
												<li><a href="/packing/CUSTOM_INVOICE_PDF/<?php echo $packing->packing_id; ?>">Custom Invoice</a></li>
                                    	  		<li><a href="/packing/INVOICE_PDF/<?php echo $packing->packing_id; ?>">Invoice</a></li>
                                    	  		<li><a href="/packing/PL_PDF/<?php echo $packing->packing_id; ?>">Packing List</a></li>
											</ul>
										</div>
										
										<div class="btn-group">
										  	<button disabled type="button" class="btn btn-warning btn-flat">Excel</button>
										  	<button type="button" class="btn btn-warning btn-flat dropdown-toggle" data-toggle="dropdown">
												<span class="caret"></span>
												<span class="sr-only">Toggle Dropdown</span>
										  	</button>
										  	<ul class="dropdown-menu" role="menu">
												<li><a href="/packing/CUSTOM_INVOICE_EXCEL/<?php echo $packing->packing_id; ?>">Custom Invoice</a></li>
												<li><a href="/packing/INVOICE_EXCEL/<?php echo $packing->packing_id; ?>">Invoice</a></li>
												<li><a href="/packing/PL_EXCEL/<?php echo $packing->packing_id; ?>">Packing List</a></li>
										  	</ul>
										</div>
 -->
                                    </div>
                                </div><!-- /.box-header -->

                                <div class="box-body table-responsive">
                                    <table id="example1" class="table sv_table_heading table-bordered table-hover">
                                        <tbody>    
                                        	<tr>
                                                <th style="width: 25%;">Packing Number</th>
                                                <td><?php echo $dimension->packing_no; ?></td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>   
							</div>
						</div>	
                        <div class="col-md-6">
                      
                        	<?php if( is_UserAllowed('add_dim_item')){ ?>
								<div class="box box-warning">
									<div class="box-header">
										<h3 class="box-title">Add Box</h3>
									</div>
							
								<div class="box-body">
								
									<?php echo form_error('validate'); ?>
									<form enctype="multipart/form-data" action="<?=base_url('packing/SaveDimensionBox').'/'.$dimension->id; ?>" method="post">

										<?php if( $msg ) { ?>
											<div class="" style="padding-bottom: 15px;">
												<?php echo $msg; ?>
											</div>
										<?php } ?>
										
										<div class="form-group col-md-4">
											<label>Outer Box Size <span style="color:red;">*</span></label>
											<?php $outers = GetAllOuterBox(); ?>
											<select class="form-control outer_box" name="box_size" style="width:100%;">
												<option value="">Select Box Size</option>
												<?php foreach( $outers as $outer ) : ?>
													<option cbm="<?php echo $outer['CBM']; ?>" value="<?php echo $outer['ID']; ?>"><?php echo $outer['OUTER_BOX_SIZE']; ?></option>
												<?php endforeach; ?>
											</select>
											<?php echo form_error('box_size'); ?>
										</div>

										<div class="form-group col-md-4">
											<label>Number of Box <span style="color:red;">*</span></label>
											<input type="text" class="form-control no_box" rows="3" name="no_of_box" value="<?php echo $this->input->post('no_of_box')?>" placeholder="enter number of box">
											<?php echo form_error('no_of_box'); ?>
										</div>
										
										<div class="form-group col-md-4">
											<label>CBM <span style="color:red;">*</span></label>
											<input type="text" disabled class="form-control cbm_value" rows="3" name="cbm" value="<?php echo $this->input->post('cbm')?>">
											<?php echo form_error('cbm'); ?>
										</div>
										
										<div class="form-group col-md-12">    
											<input type="hidden" class="form-control cbm_value" rows="3" name="cbm" value="">
											<input type="submit" class="btn btn-info" value="Submit">
										</div>
										
										<div style="clear:both;"></div>
										
									</form> 
								</div>
							</div>
							<?php } ?>
                        </div>          
						<div class="col-md-12">
							<div class="box box-warning"> 
									<div class="box-header">
										<h3 class="box-title">Boxes</h3>
									</div>
										
									<div class="box-body table-responsive">
										<?php if( $boxes ) : ?>
											<table id="packing_item_table" class="table sv_table_heading table-bordered table-hover">
												<thead>
													<tr>
														<th>S.No</th>
														<th>Outer Box Size</th>
														<th>Number of Box</th>
														<th>CBM</th>
														
														<?php if( is_UserAllowed('update_pl')){ ?>
															<th>Remove</th>
														<?php } ?>
													</tr>
												</thead>
												<tbody>    
													<?php 	$i=1; $totalCBM = ''; $totalBOX = '';
															foreach( $boxes as $box ) : 
															
															$totalCBM += $box['cbm'];
															$totalBOX += $box['no_of_box'];
													?>
													<tr>
														<td><?=$i;?></td>
														<td><?php echo GetOuterBox( $box['outer_box_id'] ); ?></td>
														<td><?php echo $box['no_of_box']; ?></td>
														<td><?php echo $box['cbm']; ?></td>
														
														<?php if( is_UserAllowed('remove_dim_item')){ ?>
															<td><a style="color:red;" class="remove_dimension_box" rowid="<?php echo $box['id']; ?>" href="#">Remove</a></td>
														<?php } ?>
													</tr>    
													<?php $i++; endforeach; ?>
													<tfoot>
														<tr>
															<th colspan="2" style="text-align:right;font-size: 25px;">Total:</th>
															<th style="font-size: 25px;"><?php echo $totalBOX; ?></th>
															<th colspan="2" style="font-size: 25px;"><?php echo $totalCBM; ?></th>
														</tr>
													</tfoot>
												</tbody>
											</table>
										<?php else : ?>
											<h4>No items found!!!</h4>	
										<?php endif; ?>
									</div>        
								</div>
						</div> 
                        
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        <?php $this->load->view('include/footer');?>
        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="<?=base_url();?>admin/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="<?=base_url();?>admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="<?=base_url();?>admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="<?=base_url();?>admin/js/AdminLTE/app.js" type="text/javascript"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

        <script type="text/javascript">
            
            $('select').select2();
            
            $(function() {
                $("#packing_item_table").dataTable({
					"aoColumnDefs" : [
						 {
						   'bSortable' : false,
						   'aTargets' : [ 'nosort' ]
						 }]
				});
            });
            
            $(document).ready(function() {
                $(".no_box").focusout(function(){

                    var cbm = $('.outer_box').find(":selected").attr('cbm');
                    var no_box = parseInt( $(this).val() );
                    
                    var data = cbm * no_box;
                    
                    $('.cbm_value').val(data);
                    
                });
                
                $(".remove_dimension_box").click(function(e) {
					e.preventDefault();
					
					if(confirm("Do you really want to remove this item?")){
					
						var rowid = $(this).attr('rowid');
					
						$.ajax({
							url: '/packing/remove_dimension',
							data: {'rowid': rowid}, 
							type: "post",
							success: function(data){
								
								location.reload();
									
							}
						});
					}
                    
				});
				
            });
//             
//             $(document).ready(function() {
//                 $(".cust_pi").change(function(){
// 
//                     var pi_id = $(this).val();
//                     
//                     $.ajax({
//                         url: '/packing/GetItembyCPI',
//                         data: {'pi_id': pi_id},
//                         type: "post",
//                         success: function(data){
//                         	
//                         	$('.piitem').html(data);
//                         	
//                         }
//                     });
//                 });
//             });
//             
//             $(document).ready(function() {
//                 $(".sv_edit").click(function(){
// 
// 					var rowid = $(this).attr('row_id');
// 					
// 					$(this).css('display','none');
// 					$('#box_val_'+rowid).css('display','none');
//         			$('#input_box_no_'+rowid).removeAttr('style');
//         			$('#save_box_no_'+rowid).css('display','block');
//         			
//                 });
//             });
//             
//             $(document).ready(function() {
//                 $(".piitem").change(function(){
// 
//                     var ItemID = $(this).val();
//                     var CPI = $('.cust_pi').val();
//                     
//                     $.ajax({
//                         url: '/packing/GetqtyPriceofPIItem',
//                         data: {'ItemID': ItemID, 'CPI':CPI},
//                         type: "post",
//                         dataType: 'json',
//                         success: function(data){
//                         
//                         $('.quantity').val(data.qty);
//                         $('.invoiced').val(data.invoiced);
//                         $('.max_qty').val(data.max);
//                         $('.price').val(data.price);
//                         	
//                         }
//                     });
//                 });
//             });
//             
//             $(document).ready(function() {
//                 $(".save_box_no").click(function(){
// 
//                     var row_id = $(this).attr('row_id');
//                     var iid = $(this).attr('iid');
//                     
//                     var value = $('#input_box_no_'+row_id).val();
//                     
//                    $.ajax({
//                         url: '/invoice/update_box_no',
//                         data: {'value': value, 'iid':iid},
//                         type: "post",
//                         dataType: 'json',
//                         success: function(data){
//                         
//                         $('#box_val_'+row_id).html(data);
//                         $('#save_box_no_'+row_id).css('display','none');
//                         $('#input_box_no_'+row_id).css('display','none');
//                         $('#box_val_'+row_id).css('display','block');
//                         $('#edit_box_no_'+row_id).css('display','block');
//                         	
//                         }
//                     });
//                 });
//             });
            
        </script>

    </body>
</html>