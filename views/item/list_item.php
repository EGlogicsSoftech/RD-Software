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
        <link href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
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
                                <div class="box-header">
                                    <h3 class="box-title"><?=$title;?></h3>                                    
                                </div><!-- /.box-header -->
                                
                                <!-- 
<div class="box-body">
                                	<div class="row">
										<form action="#" method="POST">
											
											<div class="col-xs-3">
												<select class="form-control sv_cateogry" name="cateogry">
													<option value="">Select Category</option>
										
													<?php foreach( $categories as $category ) : ?>
														<option <?php if( $this->input->post('cateogry') == $category['ID'] ){ echo "selected"; } ?> value="<?=$category['ID'];?>"><?=$category['CATEGORY_NAME'];?></option>
													<?php endforeach; ?> 
										
												</select> 
											</div>
											
											<div class="col-xs-3">
												 <input type="submit" class="btn btn-info" name="submit" value="Submit">
											</div>
											
										</form>
									</div>
                                </div>
 -->
                                
                                <div class="box-body table-responsive">
                                	
									<table id="example1" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Item Image</th>
                                                <th>Item Code</th>
                                                <th>HSN Code</th>
                                                <th>Item Description</th>
                                                <th>Item Category</th>
                                                <th>Supplier</th>
                                                <!-- <th>Net Weight</th> -->
                                                <th>Item Unit</th>
                                                <!-- 
<th>Inner Box Size</th>
                                                <th>Outer Box Size</th>
 -->
                                               	<th>Stock Quantity</th>
                                                <!-- 
<th>Purchase Price</th>
                                                <th>Assembled</th>
 -->
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody> 
                                           
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Item Image</th>
                                                <th>Item Code</th>
                                                <th>HSN Code</th>
                                                <th>Item Description</th>
                                                <th>Item Category</th>
                                                <th>Supplier</th>
                                                <!-- <th>Net Weight</th> -->
                                                <th>Item Unit</th>
                                                <!-- 
<th>Inner Box Size</th>
                                                <th>Outer Box Size</th>
 -->
                                               	<th>Stock Quantity</th>
                                                <!-- 
<th>Purchase Price</th>
                                                <th>Assembled</th>
 -->
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
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="<?=base_url();?>admin/js/AdminLTE/app.js" type="text/javascript"></script>

        <!-- page script -->
        <script type="text/javascript">
            $(document).ready(function() {
            	var dataTable = $('#example1').DataTable({
            		"processing": true,
					"serverSide": true,
					"order":[],
					"ajax":{  
						url: "<?php echo base_url('item/fetch_items') ?>",  
						type: "POST"  
				   	},
				   	"columnDefs": [
						{ 
							"targets": [ 0 ], //first column / numbering column
							"orderable": false, //set not orderable
						},
					], 
				});
            });
        </script>
    </body>
</html>