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
												<label> Suppliers</label>
												<select class="form-control sv_supplier" name="supplier" required>
													<option value="">Select Supplier</option>
										
													<?php foreach( $suppliers as $supplier ) : ?>
														<option <?php if( $this->input->post('supplier') == $supplier['id'] ){ echo "selected"; } ?> value="<?=$supplier['id'];?>"><?=$supplier['supplier_name'];?></option>
													<?php endforeach; ?> 
										
												</select> 
											</div>
												
											<div class="col-xs-3">
												<label> Supplier PO</label>
												<select class="form-control supplier_po" name="supplier_po" required>
													<option value="">Select Supplier PO</option>
													<?php if( $_POST['supplier'] ){  
													
														$rows = $this->db->get_where('supplier_po',array('sup_id'=> $_POST['supplier'], 'status'=> 1))->result_array();?>
													
														<?php foreach( $rows as $row ) : var_dump($row); ?>
															<option <?php if( $this->input->post('supplier_po') == $row['sup_po_id'] ){ echo "selected"; } ?> value="<?php echo $row['sup_po_id']; ?>"><?php echo $row['po_num']; ?></option>
														<?php endforeach; ?>
														
													<?php } ?>	
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
                                    <table id="example1" class="table sv_table_heading table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th class="nosort">Item ID#</th>
                                                <th class="nosort">Category</th>
                                                <th class="nosort">RD Item#</th>
                                                <th class="nosort">Picture</th>
                                                <th class="nosort">Description</th>
                                                <th class="nosort">Unit</th>
                                                <th>Order Quantity</th>
                                                <th>Recived Quantity</th>
                                                <th>Balance</th>
                                                <th>Price INR</th>
                                                <th>Total Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 	if( isset($_POST["supplier_po"]) && !empty($_POST["supplier_po"]) )
                                            			{
                                            				$spo_id = $_POST['supplier_po'];
                                            				$items = GetItemofSupplierPOItem($spo_id);
                                            				
                                            				$spo = GetApprovedSPO($spo_id);
                                            				
                                            				$i=1; foreach( $items as $item ) : 
                                            				
                                            				$good_recived = GoodsRecived($item['sup_po_id'], $item['item_id']); 
                                            				
                                            				$item_img = GetItemData($item['item_id'])->ITEM_IMAGE;
                                            				
                                            				if( $item_img )
                                            					{
                                            						$img_path = FCPATH.'uploads/item_images/'.$item_img;
                                            					}
                                            				else
                                            					{
                                            						$img_path = '';
                                            					}
                                            		?>
												<tr> 
												
													<td><?php echo $i; ?></td>
													<td><?=GetItemData($item['item_id'])->ITEM_CODE;?></td>
													<td><?=Get_Item_Category_Name(GetItemData($item['item_id'])->CATEGORY_NAME);?></td>
													<td><?=GetItemData($item['item_id'])->ITEM_CODE;?></td>
													<td>
														<?php if( file_exists( $img_path ) ): ?>
																<img style="width:100px;" src="<?=base_url();?>uploads/item_images/<?php echo $item_img; ?>" />
															<?php else : ?>
																<img style="width:100px;" src="<?=base_url();?>uploads/no-image-available.jpg" />
															<?php endif; ?>
													</td>
													<td><?=GetItemData($item['item_id'])->ITEM_DESC;?></td>
													<td><?=GetItemUnit( GetItemData($item['item_id'])->ITEM_UNIT );?></td>
													<td><?=$item['qty'];?></td>
													<td><?php echo $good_recived; ?></td>
													<td><?=$item['qty'] - $good_recived;?></td>
													<td><?=$item['price'];?></td>
													<td><?=$item['qty'] * $item['price'];?></td>
													
												</tr>   
                                            <?php $i++; endforeach; } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>Item ID#</th>
                                                <th>Category</th>
                                                <th>RD Item#</th>
                                                <th>Picture</th>
                                                <th>Description</th>
                                                <th>Unit</th>
                                                <th>Order Quantity</th>
                                                <th>Recived Quantity</th>
                                                <th>Balance</th>
                                                <th>Price INR</th>
                                                <th>Total Value</th>
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
                $("#example1").dataTable({
                	"aoColumnDefs": [
						{ 'bSortable': false, 'aTargets': [ 'nosort' ] }
					],
                });
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