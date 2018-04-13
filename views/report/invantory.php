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

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <!-- right column -->
                        <div class="col-md-12">
                        	<div class="box box-warning">
									<!-- 
<div class="box-header">
										<h3 class="box-title">Items</h3>
									</div>
 -->
									<?php
									$CheckStock = CheckStock();
									//var_dump($CheckStock);
									//die();
									?>
									<div class="box-body table-responsive">
										<?php if( $CheckStock ) : ?>
											<table id="example1" class="table sv_table_heading table-bordered table-hover">
												<thead>
													<tr>
														<th>S.No</th>
                            							<th class="nosort">Category</th>
                            							<th class="nosort">Supplier ID</th>
														<th class="nosort">Item Code</th>
														<th class="nosort">Item Image</th>
                            							<th class="nosort">Description</th>
                            							<th class="nosort">Unit</th>
                            							<th class="nosort">Purchase Price Code</th>
														<th>Quantity in Stock</th>
                            							<th>Order in Hand</th>
                            							<th>Pending Supplier Order</th>
														<!-- <th>View</th> -->
													</tr>
												</thead>
												<tbody>
													<?php 	$j=1;
															foreach( $CheckStock as $Stock ) :
															if($Stock['SUMA']-$Stock['SUMB'] >=1 ) :
                              								$item_data = GetItemData( $Stock['item_id'] );
															$item_img = $item_data->ITEM_IMAGE;
															$img_path = FCPATH.'uploads/item_images/'.$item_img;
													?>
													<tr>
														<td><?=$j;?></td>
														<td><?php echo Get_Item_Category_Name( $item_data->CATEGORY_NAME );?></td>
														<td><?php echo GetSupplierData( $item_data->SUPPLIER_ID )->supplier_name;?></td>
														<td><?=$item_data->ITEM_CODE;?></td>
														<td>
															<?php if( file_exists( $img_path ) ): ?>
																<img style="width:100px;" src="<?=base_url();?>uploads/item_images/<?php echo $item_img; ?>" />
															<?php else : ?>
																<img style="width:100px;" src="<?=base_url();?>uploads/no-image-available.jpg" />
															<?php endif; ?>
														</td>
													  <td><?php echo $item_data->ITEM_DESC;?></td>
													  <td><?= GetItemUnit( $item_data->ITEM_UNIT );?></td>
													  <td><?= $item_data->PURCHASE_PRICE_CODE;?></td>
													  <td><?php echo $Stock['SUMA']-$Stock['SUMB']; ?></td>
                            						  <td><?php echo GetOrderInHand($Stock['item_id']); ?></td>
                            						  <td><?php echo GetPendingSPOqty($Stock['item_id']); ?></td>
													  <!-- <td><a href="/report/view_invantory/<?php echo $Stock['item_id'];?>">View</a></td> -->
													</tr>
													<?php endif; $j++; endforeach; ?>
												</tbody>
											</table>
										<?php else : ?>
											<h4>No items found!!!</h4>
										<?php endif; ?>
									</div>
								</div>
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
					"aoColumnDefs": [
						{ 'bSortable': false, 'aTargets': [ 'nosort' ] }
					],
					"iDisplayLength" : 50
				});
            });
        </script>
    </body>
</html>
