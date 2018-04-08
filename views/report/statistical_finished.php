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
        <link href="<?=base_url();?>admin/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
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
												<select class="form-control sv_customer" name="customer">
													<option value="">Select Customer</option>

													<?php foreach( $customers as $customer ) : ?>
														<option <?php if( $this->input->post('customer') == $customer['customer_id'] ){ echo "selected"; } ?> value="<?=$customer['customer_id'];?>"><?=$customer['name'];?></option>
													<?php endforeach; ?>

												</select>
											</div>
											
											<div class="col-xs-3">
												 <input type="submit" class="btn btn-info" name="submit" value="Submit">
											</div>
										</form>
									</div>
                                </div><!-- /.box-body -->
                                
                                <div style="clear:both;"></div>
                                
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Item ID#</th>
                                                <th>Customer Item#</th>
                                                <th>Picture</th>
                                                <th>Description</th>
                                                <th>Unit</th>
                                                <th>Price</th>
                                                <th>Purchase Qty</th>
                                                <th>Shipped Qty</th>
                                                <th>Order in Hand</th>
                                                <!-- 
<th>Balance Qty</th>
                                                <th>Stock Value</th>
                                                <th>Required Qty</th>
 -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 	if( isset($_POST["customer"]) && !empty($_POST["customer"]) )
                                            			{
                                            				$cid = $_POST['customer'];
                                            				
                                            				$items = Purchased_Items_by_customer($cid);
                                            				
                                            				$i=1; 
                                            				
                                            				foreach( $items as $item ) : 
                                            				
                                            				//$good_recived = GoodsRecived($item['sup_po_id'], $item['item_id']); 
                                            				
                                            				if( GetItemData($item['item_id'])->CATEGORY_NAME == 12 )
                                            					{
                                            						continue;
                                            					}
                                            				
                                            				//$customer_item = getPreviousCPIdata($cid, $item['item_id']);
                                            				
                                            				$item_img = GetItemData($item['item_id'])->ITEM_IMAGE;
															$img_path = '/var/www/html/uploads/item_images/'.$item_img;
                                            		?>
												<tr>
												
													<td><?php echo $i; ?></td>
													<td><?=GetItemData($item['item_id'])->ITEM_CODE;?></td>
													<td>Customer Item#</td>
													<td>
														<?php if( $item_img ): ?>
																<img style="width:100px;" src="<?=base_url();?>uploads/item_images/<?php echo $item_img; ?>" />
															<?php else : ?>
																<img style="width:100px;" src="<?=base_url();?>uploads/no-image-available.jpg" />
															<?php endif; ?>
													</td>
													<td><?=GetItemData($item['item_id'])->ITEM_DESC;?></td>
													<td><?=GetItemUnit( GetItemData($item['item_id'])->ITEM_UNIT );?></td>
													<td>Price</td>
													<td><?=$item['qty'];?></td>
													<td>Shipped</td>
													<td>In hand</td>
													<!-- 
<td><?=$item['price'];?></td>
													<td><?=$item['qty'] * $item['price'];?></td>
 -->
													
												</tr>   
                                            <?php $i++; endforeach; } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>Item ID#</th>
                                                <th>Customer Item#</th>
                                                <th>Picture</th>
                                                <th>Description</th>
                                                <th>Unit</th>
                                                <th>Price</th>
                                                <th>Purchase Qty</th>
                                                <th>Shipped Qty</th>
                                                <th>Order in Hand</th>
                                               <!-- 
 <th>Balance Qty</th>
                                                <th>Stock Value</th>
                                                <th>Required Qty</th>
 -->
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
        <script src="<?=base_url();?>admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="<?=base_url();?>admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="<?=base_url();?>admin/js/AdminLTE/app.js" type="text/javascript"></script>
		
		<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

        <script type="text/javascript">

            $('select').select2();

        </script>
		
        <!-- page script -->
        <script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
            });
            
            $(document).ready(function() {
                $(".sv_supplier").change(function(){

                    var sup_id = $(this).val();
                    //alert(sup_id);
                    $.ajax({
                        url: '/report/get_supplier_po_ajax',
                        data: {'sup_id': sup_id},
                        type: "post",
                        success: function(data){
                        
                        	//alert(data);

                            $(".supplier_po").removeAttr('disabled');
                            $(".supplier_po").select2("destroy");
                            $(".supplier_po").html(data);
                            $(".supplier_po").select2();
                        }
                    });
                });
            });
        </script>
    </body>
</html>