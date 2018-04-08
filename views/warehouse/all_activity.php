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
                                                <th>User Name</th>
                                                <th>Item</th>
                                                <th>Finish Quantity</th>
                                                <th>Alloted Quantity</th>
                                                <th>Shift</th>
                                                <th>Date</th>
                                                <th>Status Remarks</th>
                                                <th>Invoice</th>
                                                <?php if( is_UserAllowed('update_wa')){ ?>
                                                	<th>Action</th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <?php $i = 1; foreach( $activities as $activity ) : ?>
                                                <tr>
                                                    <td><?=$i;?></td>
                                                    <td><?php echo GetUserData( $activity['user_id'] )->name;?></td>
                                                    <td><?=GetItemData( $activity['item_id'] )->ITEM_CODE;?></td>
                                                    <td><?=$activity['qty'];?></td>
                                                    <td><?=$activity['altd_wrkr'];?></td>
                                                    <td><?=$activity['shift'];?></td>
                                                    <td><?php echo date("d-m-Y", strtotime( $activity['date'] ) );?></td>
                                                    <td><?=$activity['remarks'];?></td>
                                                    <td><?=$activity['invoice_num'];?></td>
                                                    
                                                    <?php if( is_UserAllowed('update_wa')){ ?>
                                                   		<td><a href="<?=base_url('/warehouse/edit_activity').'/'.$activity['id'];?>">Update</a></td>
                                                	<?php } ?>
                                                </tr>
                                            <?php $i++; endforeach; ?>    
                                            
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>User Name</th>
                                                <th>Item</th>
                                                <th>Finish Quantity</th>
                                                <th>Alloted Quantity</th>
                                                <th>Shift</th>
                                                <th>Date</th>
                                                <th>Status Remarks</th>
                                                <th>Invoice</th>
                                               	 <?php if( is_UserAllowed('update_wa')){ ?>
                                                	<th>Action</th>
                                                <?php } ?>
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