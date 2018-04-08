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
 -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>GRN No</th>
                                                <th>Supplier Id</th>
                                                <th>Supplier Name</th>
                                                <th>Supplier PO#</th>
                                                <th>Challan No</th>
                                                <th>No. of Boxes</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php   $i = 1; 
                                                    foreach( array_reverse( $grns ) as $grn ) : 
                                                    //$EnctryptID = GenerateEnctryptID($item['ID']);        
                                            ?>
                                                <tr <?php if( $grn['status'] == 2) : ?> style="background: #FDEDEC;" <?php endif; ?>>
                                                    <td><?=$i;?></td>
                                                    <td><?=$grn['grn_number'];?></td>
                                                    <td><?=GetSupplierData( $grn['sup_id'] )->supplier_name;?></td>
                                                    <td><?=GetSupplierData( $grn['sup_id'] )->supplier_code;?></td>
                                                    <td><?=SPOData( $grn['sup_po_num'] )->po_num;?></td>
                                                    <td><?=$grn['challan_num'];?></td>
                                                    <td><?=$grn['box_num'];?></td>
                                                    <td><?php if( $grn['status'] == 2) : ?><span style="color:#ff6666;">Not Approved</span> <?php else : ?> <span style="color:green;">Approved</span> <?php endif; ?></td>
                                                    <td>
                                                    <?php if( is_UserAllowed('add_grn_item')){ ?>
                                                    	<a href="<?=base_url('grn/view').'/'.$grn['id'];?>">View</a><!-- <a href="<?=base_url('grn/edit').'/'.$grn['id'];?>">Update</a> --> 
                                                    <?php } ?>    
                                                    </td>
                                                </tr>
                                            <?php $i++; endforeach; ?>  
                                            
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>S.No</th>
                                                <th>GRN No</th>
                                                <th>Supplier Id</th>
                                                <th>Supplier Name</th>
                                                <th>Supplier PO#</th>
                                                <th>Challan No</th>
                                                <th>No. of Boxes</th>
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