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
										
									<?php if( $items ) : ?>
										<form action="<?=base_url('production/cpi_sub_item');?>" method="post">
											<table id="example1" class="table sv_table_heading table-bordered table-hover">
												<thead>
													<tr>
														<th>S.No</th>
														<th>Item Image</th>
														<th>Item Code</th>
														<th>Quantity</th>
													</tr>
												</thead>
												<tbody>    
													<?php 	$i=1; 
															foreach( $items as $item ) : 
																//var_dump($item);
															if( Is_Assembled($item['item_id']) )
																{
																	$item_img = GetItemData( $item['item_id'] )->ITEM_IMAGE;
																	$produced = produced_qty($item['cust_pi_id'], $item['item_id']);
													?>
													<tr>
														<td><?=$i;?></td>
														<td>
															<?php if( $item_img ): ?>
																<img style="width:100px;" src="<?=base_url();?>uploads/item_images/<?php echo $item_img; ?>" />
															<?php else : ?>
																<img style="width:100px;" src="<?=base_url();?>uploads/no-image-available.jpg" />
															<?php endif; ?>
														</td>
														<td><?php echo GetItemData( $item['item_id'] )->ITEM_CODE; ?></td>
														<td>
															<input type="text" class="form-control" rows="3" name="qty[]" value="<?php echo $item['qty'] - $produced; ?>">
															<input type="hidden" class="form-control" rows="3" name="item[]" value="<?php echo $item['item_id']; ?>">
														</td>
													</tr>    
													<?php } $i++; endforeach; ?>
													<tfoot>
														<tr>
															<th colspan="4" style="text-align:right;"><input type="submit" class="btn btn-info" name="sub_items" value="Submit"></th>
														</tr>
													</tfoot>
													<!-- <tr><td colspan="4"></td></tr> -->
												</tbody> 
											</table>
										</form>
									<?php else : ?>
										<h4>No items found!!!</h4>	
									<?php endif; ?>
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
        
        <!-- DATA TABES SCRIPT -->
        <script src="<?=base_url();?>admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="<?=base_url();?>admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        
        <!-- AdminLTE App -->
        <script src="<?=base_url();?>admin/js/AdminLTE/app.js" type="text/javascript"></script>
        
        
        
        <!-- page script -->
        <script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
            });
        </script>

    </body>
</html>