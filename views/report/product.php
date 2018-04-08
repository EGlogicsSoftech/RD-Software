<?php 	$this->load->helper('item'); ?>
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
                                <div class="box-header">
                                    <h3 class="box-title"><?=$title;?></h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive" style="overflow: auto;">
                                	
									<table id="example1" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Item Code</th>
                                                <th>Image</th>
                                                <th>RD Catalog Page#</th>
                                                <th>OC Catalog Page#</th>
                                                <th>Description</th>
                                                <th>Supplier#</th>
                                                <th>Unit</th>
                                                <th>Size</th>
                                                <th>Net Weight</th>
                                                <th>Qty Inner Size</th>
                                                <th>Qty Outer Size</th>
                                                <th>Purchase Price</th>
                                                <th>Export Price</th>
                                                <th>Old Price</th>
                                                <th>Stock Qty</th>
                                                <th>Customer Orders Qty</th>
                                                <th>Supplier Order Qty</th>
                                                <th>Sum</th>
                                                <th>T.P Qty</th>
                                                <th>Rejection Qty</th>
                                                <th>TDS Qty</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody> 
                                            
                                            <?php   $i = 1; 
                                                    foreach( array_reverse($items) as $item ) : 
                                                    $assembled = $item['ITEM_ASSEMBLED'];
                                                    //$EnctryptID = GenerateEnctryptID($item['ID']);    
                                                   	$Stock = CheckStockbyItem($item['ITEM_ID']); 
                                                   	$r = rejection_qty($item['ITEM_ID']); 
                                                   	$a = total_purchased_qty($item['ITEM_ID']);
                                            ?>
                                                <tr>
                                                    <td><?=$i;?></td>
                                                    <td><?=$item['ITEM_CODE'];?></td>
                                                    <td>
                                                    	<?php if( $item['ITEM_IMAGE'] ): ?>
															<img style="width:100px;" src="<?=base_url();?>uploads/item_images/<?php echo $item['ITEM_IMAGE']; ?>" />
														<?php else : ?>
															<img style="width:100px;" src="<?=base_url();?>uploads/no-image-available.jpg" />
														<?php endif; ?>
                                    				</td>
                                    				<td>NULL</td>
                                    				<td>NULL</td>
                                                    <td><?=$item['ITEM_DESC'];?></td>
                                                    <td><?=GetSupplierData( $item['SUPPLIER_ID'] )->supplier_code;?></td>
                                                    <td><?=GetItemUnit( $item['ITEM_UNIT'] );?></td>
                                                    <td>NULL</td>
                                                    <td><?=$item['NET_WEIGHT'].' '.GetWeightUnit( $item['WEIGHT_UNIT'] );?></td>
                                                    <td><?php echo Get_Inner_Box_Size( $item['INNER_BOX'] ); ?></td>
                                                    <td><?php echo Get_Outer_Box_Size( $item['OUTER_BOX'] ); ?></td>
                                                    <td><?=$item['PURCHASE_PRICE'].' INR';?></td>
                                                    <td>NULL</td>
                                                    <td>NULL</td>
                                                    <td><?php echo $Stock->SUMA-$Stock->SUMB; ?></td>
                                                    <td><?php echo CustomerOrderQTY($item['ITEM_ID']); ?></td>
                                                    <td><?php echo SupplierOrderQTY($item['ITEM_ID']); ?></td>
                                                    <td>NULL</td>
                                                    <td><?php echo $a; ?></td>
                                                    <td><?php if($a) { echo $r-$a; } ?></td>
                                                    <td><?php echo Shipped_qty($item['ITEM_ID']); ?></td>
                                                    <td>
                                                    	<a style="color:green;" href="#">Export Excel</a>
													</td>
                                                </tr>
                                            <?php $i++; endforeach; ?>    
                                            
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Item Code</th>
                                                <th>Image</th>
                                                <th>RD Catalog Page#</th>
                                                <th>OC Catalog Page#</th>
                                                <th>Description</th>
                                                <th>Supplier#</th>
                                                <th>Unit</th>
                                                <th>Size</th>
                                                <th>Net Weight</th>
                                                <th>Qty Inner Size</th>
                                                <th>Qty Outer Size</th>
                                                <th>Purchase Price</th>
                                                <th>Export Price</th>
                                                <th>Old Price</th>
                                                <th>Stock Qty</th>
                                                <th>Customer Orders Qty</th>
                                                <th>Supplier Order Qty</th>
                                                <th>Sum</th>
                                                <th>T.P Qty</th>
                                                <th>Rejection Qty</th>
                                                <th>TDS Qty</th>
                                                <th>Action</th>
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

        <!-- page script -->
        <script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
            });
        </script>
    </body>
</html>