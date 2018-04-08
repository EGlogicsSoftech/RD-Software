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
									<?php	$items = $_POST['item']; 
											$qty = $_POST['qty']; 
									?>
									<form action="<?=base_url('production/item_issue_list');?>" method="post">			
									<table id="example1" class="table sv_table_heading table-bordered table-hover">
										<thead>
											<tr>
												<th>S.No</th>
												<th>Parent Item Code</th>
												<th>Item Image</th>
												<th>Item Code</th>
												<th>Item Stock</th>
												<th>Quantity</th>
											</tr>
										</thead>
										<tbody> 
												
											<?php for($i=0; $i<count($items); $i++)
												{
													$prent_item = $items[$i];
													$quantity = $qty[$i];
													$sub_items = GetSubItem($prent_item);
														
													$j=1; 
													
													foreach( $sub_items as $sub_item ) : 
														$item_img = GetItemData( $sub_item['ITEM_ID'] )->ITEM_IMAGE;
														$stocks = GetItemStock( $sub_item['ITEM_ID'] );
											?>
											<tr>
												<td><?=$j;?></td>
												<td><?php echo GetItemData( $sub_item['PARENT_ITEM_ID'] )->ITEM_CODE; ?></td>
												<td>
													<?php if( $item_img ): ?>
														<img style="width:100px;" src="<?=base_url();?>uploads/item_images/<?php echo $item_img; ?>" />
													<?php else : ?>
														<img style="width:100px;" src="<?=base_url();?>uploads/no-image-available.jpg" />
													<?php endif; ?>
												</td>
												<td><?php echo GetItemData( $sub_item['ITEM_ID'] )->ITEM_CODE; ?></td>
												<td>
													<table id="example1" class="table sv_table_heading table-bordered table-hover">
														<thead>
															<tr>
																<th>S.No</th>
																<th>Box Number</th>
																<th>Quantity</th>
																<th>Issue Quantity</th>
															</tr>
														</thead>
														<tbody>    
															<?php 	$k=1; 
																	foreach( $stocks as $stock ) : 
															?>
															<tr>
																<td><?=$k;?></td>
																<td><?php echo $stock['box_num']; ?></td>
																<td><?php echo $stock['SUMA']-$stock['SUMB']; ?></td>
																<td>
																	<input type="text" class="form-control" rows="3" name="issue_qty[]" value="0">
																	<input type="hidden" class="form-control" rows="3" name="issue_item_id[]" value="<?php echo $sub_item['ITEM_ID']; ?>">
																	<input type="hidden" class="form-control" rows="3" name="issue_box_num[]" value="<?php echo $stock['box_num']; ?>">
																</td>
															</tr>    
															<?php $k++; endforeach; ?>
														</tbody>
													</table>
												</td>
												<td><?php echo $sub_item['QUANTITY'] * $quantity; ?></td>
											</tr>    
											<?php $j++; endforeach; } ?>
											<tr><td colspan="7"><input type="submit" class="btn btn-info" name="sub_items" value="Submit"></td></tr>
											</tbody>
										</table>
										</form>
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
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    </body>
</html>