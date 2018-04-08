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
                        		<form enctype="multipart/form-data" action="<?=base_url('production/Export_PDF');?>" method="post">
									<div class="box-header">
										<h3 class="box-title">Items</h3>
										<div class="heading_right_box">
											<input type="submit" class="btn btn-info" value="PDF">
										</div>
									</div>
									<div class="box-body table-responsive">
										<?php	$issue_item_id = $_POST['issue_item_id'];
												$issue_box_num = $_POST['issue_box_num']; 
												$issue_qty = $_POST['issue_qty'];
												$s= serialize($_POST);
										?>
										<input type="hidden" class="form-control" name="data" value='<?php echo $s; ?>' />
										<table id="example1" class="table sv_table_heading table-bordered table-hover">
											<thead>
												<tr>
													<th>S.No</th>
													<th>Item Code</th>
													<th>Box Number</th>
													<th>Quantity</th>
												</tr>
											</thead>
											<tbody>  
												
												<?php $j=1; for($i=0; $i<count($issue_qty); $i++)
													{
												?>
												<tr>
													<td><?=$j;?></td>
													<td><?php echo GetItemData( $issue_item_id[$i] )->ITEM_CODE; ?></td>
													<td><?php echo $issue_box_num[$i]; ?></td>
													<td><?php echo $issue_qty[$i]; ?></td>
												</tr>    
												<?php $j++; } ?>
												</tbody>
											</table>
									</div> 
								</form>       
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