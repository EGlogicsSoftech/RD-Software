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
                        <!-- right column -->
                        <div class="col-md-4">
                            <!-- general form elements disabled -->
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title"><?=$title;?></h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <form action="<?=base_url('user/Save_user_role');?>" method="post">
                                        <?php if( $msg ) { ?>
                                            <div class="col-md-12" style="padding-bottom: 15px;">
                                                <?php echo $msg; ?>
                                            </div>
                                        <?php } ?>
                                        <div class="form-group col-lg-12">
                                            <label>User Role <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="user_role" value="<?php echo $this->input->post('user_role')?>"  placeholder="Enter User Role"/>
                                            <?php echo form_error('user_role'); ?>
                                        </div>

                                        <div class="form-group col-lg-12">
                                        	<ul class="list-group">
                                        		<li class="list-group-item">
                                            		<input type="checkbox" name="permission[]" value="item"> <label>Item</label><br>
                                            		<ul class="list-group">
                                            			<li class="list-group-item">
                                            				<input type="checkbox" name="permission[]" value="add_item"> Add Item<br>
															<input type="checkbox" name="permission[]" value="all_item"> All Item <br>
                                                            <input type="checkbox" name="permission[]" value="view_item"> View Item <br>
															<input type="checkbox" name="permission[]" value="update_item"> Update Item <br>
															<input type="checkbox" name="permission[]" value="update_item_code"> Update Item Code<br>
															<input type="checkbox" name="permission[]" value="add_unit"> Add Unit<br>
															<input type="checkbox" name="permission[]" value="update_unit"> Update Unit <br>
															<input type="checkbox" name="permission[]" value="add_category"> Add Category <br>
															<input type="checkbox" name="permission[]" value="update_category"> Update Category<br>
															<input type="checkbox" name="permission[]" value="add_inner_box"> Add Inner Box <br>
															<input type="checkbox" name="permission[]" value="update_inner_box"> Update Inner Box <br>
															<input type="checkbox" name="permission[]" value="add_outer_box"> Add Outer Box<br>
															<input type="checkbox" name="permission[]" value="update_outer_box"> Update Outer Box<br>
														</li>
													</ul>
												</li>
												<li class="list-group-item">
													<input type="checkbox" name="permission[]" value="supplier"> <label>Supplier</label><br> 
													<ul class="list-group">
                                            			<li class="list-group-item">
															<input type="checkbox" name="permission[]" value="add_supplier"> Add Supplier<br>
                                                            <input type="checkbox" name="permission[]" value="all_supplier"> All Supplier <br>
                                                            <input type="checkbox" name="permission[]" value="view_supplier"> View Supplier <br>
															<input type="checkbox" name="permission[]" value="update_supplier"> Update Supplier <br>
															<input type="checkbox" name="permission[]" value="add_spo"> Add SPO<br>
                                                            <input type="checkbox" name="permission[]" value="all_spo"> All SPO<br>
                                                            <input type="checkbox" name="permission[]" value="approve_spo"> Approve SPO<br>
															<input type="checkbox" name="permission[]" value="add_spo_item"> Add SPO Item<br>
                                                            
															<input type="checkbox" name="permission[]" value="remove_spo_item"> Remove SPO Item <br>
															<input type="checkbox" name="permission[]" value="update_spo_item"> Update SPO Item <br>
														</li>
													</ul>
												</li>
												<li class="list-group-item">
													<input type="checkbox" name="permission[]" value="customer"> <label>Customer</label><br> 
													<ul class="list-group">
                                            			<li class="list-group-item">
															<input type="checkbox" name="permission[]" value="add_customer"> Add Customer<br>
                                                            <input type="checkbox" name="permission[]" value="all_customer"> All Customer<br>
                                                            <input type="checkbox" name="permission[]" value="view_customer"> View Customer<br>
															<input type="checkbox" name="permission[]" value="update_customer"> Update Customer <br>
															<input type="checkbox" name="permission[]" value="add_cpi"> Add CPI<br>
															<input type="checkbox" name="permission[]" value="all_CPI"> All CPI<br>
															<input type="checkbox" name="permission[]" value="approve_cpi"> Approve CPI<br>
                                                            <input type="checkbox" name="permission[]" value="add_cpi_item"> Add CPI Item<br>
                                                            <input type="checkbox" name="permission[]" value="view_cpi"> View CPI Item<br>
															<input type="checkbox" name="permission[]" value="update_cpi_item"> Update CPI Item <br>
															<input type="checkbox" name="permission[]" value="remove_cpi_item"> Remove CPI Item <br>
														</li>
													</ul>
												</li>
												<li class="list-group-item">
													<input type="checkbox" name="permission[]" value="grn"> <label>GRN</label><br> 
													<ul class="list-group">
                                            			<li class="list-group-item">
															<input type="checkbox" name="permission[]" value="add_grn"> Add GRN<br>
                                                            <input type="checkbox" name="permission[]" value="all_grn"> All GRN<br>
                                                            <input type="checkbox" name="permission[]" value="approve_grn"> Approve GRN<br>

															<input type="checkbox" name="permission[]" value="add_grn_item"> Add GRN Item<br>
															<input type="checkbox" name="permission[]" value="remove_grn_item"> Remove GRN Item <br>
															<input type="checkbox" name="permission[]" value="update_grn_item"> Update GRN Item<br>
														</li>
													</ul>
												</li>
												<li class="list-group-item">
													<input type="checkbox" name="permission[]" value="stock"> <label>Stock</label><br> 
													<ul class="list-group">
                                            			<li class="list-group-item">
															<input type="checkbox" name="permission[]" value="add_se"> Add Stock Entry<br>
                                                            <input type="checkbox" name="permission[]" value="all_se"> All Stock<br>
															<input type="checkbox" name="permission[]" value="add_si"> Add Stock Issuance<br>
                                                            <input type="checkbox" name="permission[]" value="all_si"> All Stock Issuance<br>
															<input type="checkbox" name="permission[]" value="add_si_item"> Add Stock Issuance Item<br>
															<input type="checkbox" name="permission[]" value="remove_si_item"> Remove Stock Issuance <br>
															<input type="checkbox" name="permission[]" value="view_checkstock"> View Check Stock <br>
														</li>
													</ul>
												</li>
												<li class="list-group-item">
													<input type="checkbox" name="permission[]" value="warehouse"> <label>Warehouse</label><br> 
													<ul class="list-group">
                                            			<li class="list-group-item">
															<input type="checkbox" name="permission[]" value="add_wa"> Add Warehouse Activity<br>
                                                            <input type="checkbox" name="permission[]" value="all_wa"> All Warehouse Activity<br>
															<input type="checkbox" name="permission[]" value="update_wa"> Update Warehouse Activity <br>
															<input type="checkbox" name="permission[]" value="add_wr"> Add Warehouse Rejection<br>
                                                            <input type="checkbox" name="permission[]" value="view_wr"> View Warehouse Rejection<br>
															<input type="checkbox" name="permission[]" value="update_wr"> Update Warehouse Rejection <br>
														</li>
													</ul>
												</li>
												<li class="list-group-item">
													<input type="checkbox" name="permission[]" value="invoice"> <label>Packing List & Invoice</label><br> 
													<ul class="list-group">
                                            			<li class="list-group-item">
															<input type="checkbox" name="permission[]" value="add_pl"> Add Packing List<br>
                                                            <input type="checkbox" name="permission[]" value="all_pl"> All Packing Lists<br>
                                                            <input type="checkbox" name="permission[]" value="approve_packing_list"> Approve Packing List<br>
                                                            <input type="checkbox" name="permission[]" value="update_shipping_info"> Update Shipping Info<br>
															<input type="checkbox" name="permission[]" value="add_pl_item"> Add PL Item<br>
															<input type="checkbox" name="permission[]" value="update_pl"> Update Packing List <br>
                                                            <input type="checkbox" name="permission[]" value="add_dim"> Add Dimension<br>
                                                            <input type="checkbox" name="permission[]" value="all_dim"> All Dimension<br>
                                                            <input type="checkbox" name="permission[]" value="add_dim_item"> Add Dimension items<br>
                                                            <input type="checkbox" name="permission[]" value="remove_dim_item"> Remove Dimension items<br>
														</li>
													</ul>
												</li>
												<li class="list-group-item">
													<input type="checkbox" name="permission[]" value="production"> <label>Production</label><br> 
												</li>
												<li class="list-group-item">
													<input type="checkbox" name="permission[]" value="reports"> <label>Reports</label><br> 
													<ul class="list-group">
                                            			<li class="list-group-item">
															<input type="checkbox" name="permission[]" value="rep_inventory"> Inventory<br>
                                                            <input type="checkbox" name="permission[]" value="rep_customer"> Customer<br>
                                                            <input type="checkbox" name="permission[]" value="rep_supplier"> Supplier<br>
                                                            <input type="checkbox" name="permission[]" value="rep_statistical_raw"> Statistical Data ( Raw )<br>
															<input type="checkbox" name="permission[]" value="rep_statistical_finished"> Statistical Data ( Finished )<br>
														</li>
													</ul>
												</li>
											</ul>
                                            
											<?php echo form_error('permission'); ?>
                                        </div>


                                        <div class="form-group col-lg-12">    
                                            <input type="submit" class="btn btn-info" value="Submit">
                                        </div>
                                        <div style="clear:both;"></div>    
                                    </form>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                        
                        <div class="col-md-8">
                            <!-- general form elements disabled -->
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title"><?=$table_title;?></h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Name</th>
                                                <th>Update</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=1; foreach($RolesArray as $roles) { ?>
                                                <tr>
                                                    <td><?=$i;?></td>
                                                    <td><?=$roles['role'];?></td>
                                                    <td><a href="<?=base_url('user/manage_user_role/'.$roles['id']); ?>">Update</a></td>
                                                    <td><a href="<?=base_url('user/DeleteRole/'.$roles['id']); ?>">Delete</a></td>
                                                </tr>
                                            <?php $i++; }?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Name</th>
                                                <th>Update</th>
                                                <th>Delete</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
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
    </body>
</html>