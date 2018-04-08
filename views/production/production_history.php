<!DOCTYPE html>
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
        <!-- DATA TABLES -->
        <link href="<?=base_url();?>admin/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
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
                        <div class="col-md-9">
                        	
                        	<div class="box box-warning"> 
                        		
								<div class="box-header">
									<h3 class="box-title">Items</h3>
								</div>
								<div class="box-body table-responsive">
									<table id="example1" class="table sv_table_heading table-bordered table-hover">
										<?php $histories = productionHISTORY(); ?>
										<thead>
											<tr>
												<th>S.No</th>
												<th>Customer PI</th>
												<th>Item Image</th>
												<th>Item Code</th>
												<th>Produced Quantity</th>
												<th>Date</th>
											</tr>
										</thead>
										<tbody>  
											
											<?php $i=1; foreach( $histories as $history )
												{
													$item_img = GetItemData( $history['item_id'] )->ITEM_IMAGE;
											?>
											<tr>
												<td><?=$i;?></td>
												<td><?php echo CPIdata( $history['cpi_id'] )->pi_num; ?></td>
												<td>
													<?php if( $item_img ): ?>
														<img style="width:100px;" src="<?=base_url();?>uploads/item_images/<?php echo $item_img; ?>" />
													<?php else : ?>
														<img style="width:100px;" src="<?=base_url();?>uploads/no-image-available.jpg" />
													<?php endif; ?>
												</td>
												<td><?php echo GetItemData( $history['item_id'] )->ITEM_CODE; ?></td>
												<td><?php echo $history['produced_qty']; ?></td>
												<td><?php echo date("d-m-Y H:i:s", strtotime($history['created_date'])); ?></td>
											</tr>    
											<?php $i++; } ?>
										</tbody>
									</table>
								</div>       
							</div>
                        
                        </div> 
                        <div class="col-md-3">
							
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
		
		<!-- DATA TABES SCRIPT -->
        <script src="<?=base_url();?>admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="<?=base_url();?>admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        
        <!-- page script -->
        <script type="text/javascript">
            $(function() {
                $("#example1").dataTable({
					"aLengthMenu": [
						[50, 100, 200, -1],
						[50, 100, 200, "All"]
					], 
					"iDisplayLength" : 50 
				});
            });
        </script>
		
    </body>
</html>