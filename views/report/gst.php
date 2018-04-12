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
        <!-- DATA TABLES -->
        <link href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
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
                        <div class="col-xs-12">
                            <div class="box">
                                <!--
<div class="box-header">
                                    <h3 class="box-title"><?=$title;?></h3>
                                </div>
 --><!-- /.box-header -->


                                <div class="box-body">
                                	<div class="row">
										<form action="#" method="POST">

											<div class="col-xs-3">
												<select class="form-control sv_supplier" name="supplier">
													<option value="">Select Supplier</option>
										
													<?php foreach( $suppliers as $supplier ) : ?>
														<option <?php if( $this->input->post('supplier') == $supplier['id'] ){ echo "selected"; } ?> value="<?=$supplier['id'];?>"><?=$supplier['supplier_name'];?></option>
													<?php endforeach; ?> 
										
												</select> 
											</div>

											<!-- 
<div class="col-xs-2">
												<input type="checkbox" name="all" id="checkbox" value=""> Select All
											</div>
 -->

											<div class="col-xs-3">
												<input type="submit" class="btn btn-info" name="submit" value="Submit">
											</div>
										</form>

								 </div>
                                </div><!-- /.box-body -->

                                <div style="clear:both;"></div>

                                <div class="box-body table-responsive">
                                    <table id="item_pending" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Challan No#</th>
                                                <th class="nosort">Total</th>
                                                <th class="nosort">GST</th>
                                                <th class="nosort">Return Amount</th>
                                                <th class="nosort">Return GST</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                       		<?php
                                                //$itemss = array();
                                                if( isset($_POST) )
                                            		{
														$sid = $_POST['supplier'];
														
														$sup_bills = Get_All_Bill_by_Supplier_ID($sid);
														$total_amount = 0;
														$total_gst = 0;
														$total_return_amount = 0;
														$total_return_gst = 0;
														$i=1;

														foreach( $sup_bills as $sup_bill ):
														
														$sv_data = Get_Total_of_Return_GST($sup_bill['bill_id']);
														
														$total_amount += $sv_data['total'];
														$total_gst += Get_Total_GST_of_BILL($sup_bill['bill_id']);
														
														$total_return_amount += $sv_data['price'];
														$total_return_gst += $sv_data['gst'];
														
														
														
														
														//var_dump($sv_data);
											?>
											<tr>
												<td><?php echo $i; ?></td>
												<td><?=$sup_bill['challan_num'];?></td>
												<td><?= $sv_data['total'];?></td>
												<td><?=Get_Total_GST_of_BILL($sup_bill['bill_id']);?></td>
												<td><?= $sv_data['price']; ?></td>
												<td><?= $sv_data['gst']; ?></td>
											</tr>
                                            <?php $i++; endforeach;  } ?>

										</tbody>
                                        <tfoot>
											<tr>
												<th colspan="2" style="text-align:right">Total:</th>
												<th><?=$total_amount; ?></th>
												<th><?=$total_gst; ?></th>
												<th><?=$total_return_amount; ?></th>
												<th><?=$total_return_gst; ?></th>
											</tr>
										</tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                        </div>
                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        <?php $this->load->view('include/footer');?>
       <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        
        <!-- Bootstrap -->
        <script src="<?=base_url();?>admin/js/bootstrap.min.js" type="text/javascript"></script>
        
       	<!-- DATA TABES SCRIPT -->
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
        
        <!-- AdminLTE App -->
        <script src="<?=base_url();?>admin/js/AdminLTE/app.js" type="text/javascript"></script>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

        <script type="text/javascript">

            $('select').select2();

        </script>

       	<?php if( isset($_POST['all']) ) { ?>
       	
			<script type="text/javascript">
			
				$(document).ready(function()
					{
						var dataTable = $('#item_pending').DataTable({
							"processing": true,
								"serverSide": true,
								"order":[],
								"ajax":{
									url: "<?php echo base_url('report/fetch_items') ?>",
									type: "POST"
								},
								"aoColumnDefs": [
									{ 'bSortable': false, 'aTargets': [ 'nosort' ] }
								],
								"columnDefs": [
									{
										"targets": [ 0 ], //first column / numbering column
										"orderable": false, //set not orderable
									},
								],
							});
					});
			</script>
			
		<?php } else { ?>
			
			<script type="text/javascript">
			
				$(document).ready(function()
					{
						var dataTable = $('#item_pending').DataTable({
							"processing": false,
							"serverSide": false,
							"aoColumnDefs": [
								{ 'bSortable': false, 'aTargets': [ 'nosort' ] }
							]
						});
					});
			</script>
			
		<?php } ?>
		
		<script type="text/javascript">
            // $("#checkbox").click(function(){
// 				alert('asd');
// 				if($("#checkbox").is(':checked') ){
// 					$("#sv_items > option").prop("selected","selected");
// 					$("#sv_items").trigger("change");
// 				}else{
// 					$("#sv_items > option").removeAttr("selected");
// 					$("#sv_items").trigger("change");
// 				 }
// 			});

            $(document).ready(function() {
                $(".sv_customer").change(function(){

                    var customer_id = $(this).val();

                    $.ajax({
                        url: '/report/CustomerCPI',
                        data: {'customer_id': customer_id},
                        type: "post",
                        success: function(data){

                            $('.customer_pi').removeAttr('disabled');
                            $(".customer_pi").select2("destroy");
                            $('.customer_pi').html(data);
                            $(".customer_pi").select2();

                        }
                    });
                });
            });
        </script>
    </body>
</html>
