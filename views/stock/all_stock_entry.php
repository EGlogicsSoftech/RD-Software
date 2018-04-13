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
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>GRN Number</th>
                                                <th>Supplier Name</th>
                                                <th>Box Number</th>
                                                <th>Item</th>
                                                <th>Quantity</th>
                                                <th>Date</th>
                                                <th>CPI No</th>
                                        </thead>
                                        <tbody>
                                            
                                            <?php $i = 1; foreach( array_reverse( $stock_entries ) as $stock_entry ) : 
                                            		$grn_no = GetGRNno( $stock_entry['grn_row_id'] );
                                            ?>
                                                <tr>
                                                    <td><?=$i;?></td>
                                                    <td><?php if( $grn_no ){ echo $grn_no; } else { echo '0'; } ?></td>
                                                    <td><?=GetSupplierData( GetItemData( $stock_entry['item_id'])->SUPPLIER_ID )->supplier_name;?></td>
                                                    <td><?=$stock_entry['box_num'];?></td>
                                                    <td><?=GetItemData( $stock_entry['item_id'] )->ITEM_CODE;?></td>
                                                    <td><?=$stock_entry['qty'];?> <?php //echo GetItemUnitByItemid( $stock_entry['item_id'] ); ?> </td>
                                                    <td><?php echo date("d-m-Y H:i:s", strtotime( $stock_entry['updated_at']) ); ?></td>
                                                    <td>
                                                    	<?php if( !$stock_entry['cpi_no'] ) { ?>
                                                    		<a href="<?=base_url('stock/add_to_cpi/'.$stock_entry['id']);?>">Add to CPI</a>
                                                    	<?php }else{ ?>	
                                                    		<label style="color:green;"><?php echo $stock_entry['cpi_no']; ?></label>
                                                    	<?php } ?>	
                                                    </td>
                                                </tr>
                                            <?php $i++; endforeach; ?>    
                                            
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                 <th>ID</th>
                                                <th>GRN Number</th>
                                                <th>Supplier Name</th>
                                                <th>Box Number</th>
                                                <th>Item</th>
                                                <th>Quantity</th>
                                                <th>Date</th>
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