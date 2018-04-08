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
        <!-- <link href="<?=base_url();?>admin/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" /> -->
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
										<form action="<?=base_url('production/save_production');?>" method="post">
											<table id="example1" class="table sv_table_heading table-bordered table-hover">
												<thead>
													<tr>
														<th>S.No</th>
														<th>Item Image</th>
														<th>Item Code</th>
														<th>Quantity</th>
														<th>Produced</th>
														<th>To Produced</th>
														<th>Save</th>
													</tr>
												</thead>
												<tbody>    
													<?php 	$i=1; 
															foreach( $items as $item ) : 
																//var_dump($item);
															if( Is_Assembled($item['item_id']) )
																{
																	$item_img = GetItemData( $item['item_id'] )->ITEM_IMAGE;
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
														<td><?php echo $item['qty']; ?></td>
														<td class="produced_<?php echo $i; ?>"><?php echo produced_qty( $item['cust_pi_id'], $item['item_id'] ); ?></td>
														<td>	
															<input type="text" rows="<?php echo $i; ?>" class="form-control qty_<?php echo $i; ?>" value="<?php echo $item['qty'] - produced_qty( $item['cust_pi_id'], $item['item_id'] ); ?>">
															<input type="hidden" rows="<?php echo $i; ?>" class="form-control item_id_<?php echo $i; ?>" value="<?php echo $item['item_id']; ?>">
															<input type="hidden" rows="<?php echo $i; ?>" class="form-control cpi_id_<?php echo $i; ?>" value="<?php echo $_POST['customer_pi']; ?>">
														</td>
														<td><a class="pro_save" row_id="<?php echo $i; ?>" a_prod="<?php echo produced_qty( $item['cust_pi_id'], $item['item_id'] ); ?>" produced="<?php echo $item['qty'] - produced_qty( $item['cust_pi_id'], $item['item_id'] ); ?>" href="#" />Save</td>
													</tr>    
													<?php } $i++; endforeach; ?>
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
        <!-- AdminLTE App -->
        <script src="<?=base_url();?>admin/js/AdminLTE/app.js" type="text/javascript"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
        
        <!-- DATA TABES SCRIPT -->
       <!-- 
 <script src="<?=base_url();?>admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="<?=base_url();?>admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
 -->
        
        <!-- page script -->
       <!-- 
 <script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
            });
        </script>
 -->
		<script type="text/javascript">
			
			$(document).ready(function() {
                $(".pro_save").click(function(){

                    var row_id = $(this).attr('row_id');
                    var produced = $(this).attr('produced');
                    var a_prod = $(this).attr('a_prod');
                    var qty = $('.qty_'+row_id).val();
                    var item_id = $('.item_id_'+row_id).val();
                    var cpi_id = $('.cpi_id_'+row_id).val();
					
					if(qty<=produced)
						{
							$.ajax({
								url: '/production/save_production',
								data: {'qty': qty, 'item_id': item_id, 'cpi_id': cpi_id}, 
								type: "post",
								success: function(data){
								
								var qty = $('.qty_'+row_id).val();
								var sum = (+qty) +(+a_prod);
								$('.produced_'+row_id).html(sum);
								$('.qty_'+row_id).val('');
									
								}
							});
							
							location.reload();
						}
					else
						{
							alert('Quantity not to be more than '+produced);
							location.reload();
						}
					
					
                });
            });

        </script>
    
    </body>
</html>