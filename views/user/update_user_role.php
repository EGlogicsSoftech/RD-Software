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
                                    <form action="<?=base_url('user/Update_user_role/'.$roledata->id);?>" method="post">
                                        <?php if( $msg ) { ?>
                                            <div class="col-md-12" style="padding-bottom: 15px;">
                                                <?php echo $msg; ?>
                                            </div>
                                        <?php } ?>
                                        <div class="form-group col-lg-12">
                                            <label>User Role <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="user_role" value="<?php echo $roledata->role; ?>" />
                                            <?php echo form_error('user_role'); ?>
                                        </div>

                                        <div class="form-group col-lg-12">
                                        	<?php 
                                        		$per_array = $roledata->permission; 
                                        		$per_data = unserialize($per_array);
                                        	?>
                                        	<ul class="list-group">
                                        		<li class="list-group-item">
                                            		<input <?php if (in_array("item", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="item"> <label>Item</label><br>
                                            		<ul class="list-group">
                                            			<li class="list-group-item">
                                            				<input <?php if (in_array("add_item", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="add_item"> Add Item<br>
															<input <?php if (in_array("all_item", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="all_item"> All Item <br>
                                                            <input <?php if (in_array("view_item", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="view_item"> View Item <br>
															<input <?php if (in_array('update_item', $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="update_item"> Update Item <br>
															<input <?php if (in_array('update_item_code', $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="update_item_code"> Update Item Code<br>
															<input <?php if (in_array('add_unit', $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="add_unit"> Add Unit<br>
															<input <?php if (in_array('update_unit', $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="update_unit"> Update Unit <br>
															<input <?php if (in_array('add_category', $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="add_category"> Add Category <br>
															<input <?php if (in_array('update_category', $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="update_category"> Update Category<br>
															<input <?php if (in_array('add_inner_box', $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="add_inner_box"> Add Inner Box <br>
															<input <?php if (in_array('update_inner_box', $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="update_inner_box"> Update Inner Box <br>
															<input <?php if (in_array('add_outer_box', $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="add_outer_box"> Add Outer Box<br>
															<input <?php if (in_array('update_outer_box', $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="update_outer_box"> Update Outer Box<br>
														</li>
													</ul>
												</li>
												<li class="list-group-item">
													<input <?php if (in_array("supplier", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="supplier"> <label>Supplier</label><br> 
													<ul class="list-group">
                                            			<li class="list-group-item">
															<input <?php if (in_array("add_supplier", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="add_supplier"> Add Supplier<br>
															
                                                            <input <?php if (in_array("all_supplier", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="all_supplier"> All Supplier <br>
                                                            <input <?php if (in_array("view_supplier", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="view_supplier"> View Supplier <br>
                                                            <input <?php if (in_array("update_supplier", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="update_supplier"> Update Supplier <br>
															<input <?php if (in_array("add_spo", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="add_spo"> Add SPO<br>
                                                            <input <?php if (in_array("all_spo", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="all_spo"> All SPO<br>
                                                            <input <?php if (in_array("approve_spo", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="approve_spo"> Approve SPO<br>
                                                            
															<input <?php if (in_array("add_spo_item", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="add_spo_item"> Add SPO Item<br>
															<input <?php if (in_array("remove_spo_item", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="remove_spo_item"> Remove SPO Item <br>
															<input <?php if (in_array("update_spo_item", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="update_spo_item"> Update SPO Item <br>
														</li>
													</ul>
												</li>
												<li class="list-group-item">
													<input <?php if (in_array("customer", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="customer"> <label>Customer</label><br> 
													<ul class="list-group">
                                            			<li class="list-group-item">
															<input <?php if (in_array("add_customer", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="add_customer"> Add Customer<br>
                                                            <input <?php if (in_array("all_customer", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="all_customer"> All Customer<br>
															<input  <?php if (in_array("view_customer", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="view_customer"> View Customer<br>
                                                            <input <?php if (in_array("update_customer", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="update_customer"> Update Customer <br>
															<input <?php if (in_array("add_cpi", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="add_cpi"> Add CPI<br>
                                                            <input <?php if (in_array("view_cpi", $per_data)){ echo "checked"; } ?>  type="checkbox" name="permission[]" value="view_cpi"> View CPI Item<br>
                                                            <input <?php if (in_array("add_cpi", $per_data)){ echo "checked"; } ?>  type="checkbox" name="permission[]" value="all_CPI"> All CPI<br>
                                                            <input <?php if (in_array("approve_cpi", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="approve_cpi"> Approve CPI<br>
															<input <?php if (in_array("add_cpi_item", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="add_cpi_item"> Add CPI Item<br>
															<input <?php if (in_array("update_cpi_item", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="update_cpi_item"> Update CPI Item <br>
															<input <?php if (in_array("remove_cpi_item", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="remove_cpi_item"> Remove CPI Item <br>
														</li>
													</ul>
												</li>
												<li class="list-group-item">
													<input <?php if (in_array("grn", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="grn"> <label>GRN</label><br> 
													<ul class="list-group">
                                            			<li class="list-group-item">
															<input <?php if (in_array("add_grn", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="add_grn"> Add GRN<br>
                                                            <input <?php if (in_array("all_grn", $per_data)){ echo "checked"; } ?>  type="checkbox" name="permission[]" value="all_grn"> All GRN<br>
                                                            <input <?php if (in_array("approve_grn", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="approve_grn"> Approve GRN<br>

															<input <?php if (in_array("add_grn_item", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="add_grn_item"> Add GRN Item<br>
															<input <?php if (in_array("remove_grn_item", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="remove_grn_item"> Remove GRN Item <br>
															<input <?php if (in_array("update_grn_item", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="update_grn_item"> Update GRN Item<br>
														</li>
													</ul>
												</li>
												<li class="list-group-item">
													<input <?php if (in_array("supplier_bill", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="supplier_bill"> <label>Supplier Bill</label><br> 
													<ul class="list-group">
                                            			<li class="list-group-item">
															<input <?php if (in_array("add_bill", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="add_bill"> Add Bill<br>
                                                            <input <?php if (in_array("all_bill", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="all_bill"> All Bill<br>
                                                            <input <?php if (in_array("approve_bill", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="approve_bill"> Approve Bill<br>

															<input <?php if (in_array("debit_note", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="debit_note"> Debit Note<br>
															
															<input <?php if (in_array("add_bill_item", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="add_bill_item"> Add Bill Item<br>
															<input <?php if (in_array("remove_bill_item", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="remove_bill_item"> Remove Bill Item <br>
															<input <?php if (in_array("update_bill_item", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="update_bill_item"> Update Bill Item<br>
														</li>
													</ul>
												</li>
												<li class="list-group-item">
													<input <?php if (in_array("stock", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="stock"> <label>Stock</label><br> 
													<ul class="list-group">
                                            			<li class="list-group-item">
															<input <?php if (in_array("add_se", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="add_se"> Add Stock Entry<br>
                                                            <input <?php if (in_array("all_se", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="all_se"> All Stock<br>
															<input <?php if (in_array("add_si", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="add_si"> Add Stock Issuance<br>
                                                            <input <?php if (in_array("all_si", $per_data)){ echo "checked"; } ?>  type="checkbox" name="permission[]" value="all_si"> All Stock Issuance<br>
															<input <?php if (in_array("add_si_item", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="add_si_item"> Add Stock Issuance Item<br>
															<input <?php if (in_array("remove_si_item", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="remove_si_item"> Remove Stock Issuance <br>
															<input <?php if (in_array("view_checkstock", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="view_checkstock"> View Check Stock <br>
														</li>
													</ul>
												</li>
												<li class="list-group-item">
													<input <?php if (in_array("warehouse", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="warehouse"> <label>Warehouse</label><br> 
													<ul class="list-group">
                                            			<li class="list-group-item">
															<input <?php if (in_array("add_wa", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="add_wa"> Add Warehouse Activity<br>
                                                            <input <?php if (in_array("all_wa", $per_data)){ echo "checked"; } ?>  type="checkbox" name="permission[]" value="all_wa"> All Warehouse Activity<br>
															<input <?php if (in_array("update_wa", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="update_wa"> Update Warehouse Activity <br>
															<input <?php if (in_array("add_wr", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="add_wr"> Add Warehouse Rejection<br>
                                                            <input <?php if (in_array("view_wr", $per_data)){ echo "checked"; } ?>  type="checkbox" name="permission[]" value="view_wr"> View Warehouse Rejection<br>
															<input <?php if (in_array("update_wr", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="update_wr"> Update Warehouse Rejection <br>
														</li>
													</ul>
												</li>
												<li class="list-group-item">
													<input <?php if (in_array("invoice", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="invoice"> <label>Packing List & Invoice</label><br> 
													<ul class="list-group">
                                            			<li class="list-group-item">
															<input <?php if (in_array("add_pl", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="add_pl"> Add Packing List<br>
                                                            <input <?php if (in_array("all_pl", $per_data)){ echo "checked"; } ?>  type="checkbox" name="permission[]" value="all_pl"> All Packing List<br>
                                                            <input <?php if (in_array("approve_packing_list", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="approve_packing_list"> Approve Packing List<br>
                                                            <input <?php if (in_array("update_shipping_info", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="update_shipping_info"> Update Shipping Info<br>
															<input <?php if (in_array("add_pl_item", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="add_pl_item"> Add PL Item<br>
															<input <?php if (in_array("update_pl", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="update_pl"> Update Packing List <br>
                                                            <input <?php if (in_array("add_dim", $per_data)){ echo "checked"; } ?>  type="checkbox" name="permission[]" value="add_dim"> Add Dimension<br>
                                                            <input <?php if (in_array("all_dim", $per_data)){ echo "checked"; } ?>  type="checkbox" name="permission[]" value="all_dim"> All Dimension<br>
                                                             <input <?php if (in_array("add_dim_item", $per_data)){ echo "checked"; } ?>  type="checkbox" name="permission[]" value="add_dim_item"> Add Dimension items<br>
                                                            <input <?php if (in_array("remove_dim_item", $per_data)){ echo "checked"; } ?>  type="checkbox" name="permission[]" value="remove_dim_item"> Remove Dimension items<br>
														</li>
													</ul>
												</li>
												<li class="list-group-item">
													<input <?php if (in_array("production", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="production"> <label> Production</label><br> 
												</li>
												<li class="list-group-item">
													<input <?php if (in_array("reports", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="reports"> <label> Reports</label><br> 
													<ul class="list-group">
                                            			<li class="list-group-item">
                                            				<input <?php if (in_array("rep_inventory", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="rep_inventory"> Inventory<br>
                                                            <input <?php if (in_array("rep_customer", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="rep_customer"> Customer<br>
                                                            <input <?php if (in_array("rep_supplier", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="rep_supplier"> Supplier<br>
                                                            <input <?php if (in_array("rep_statistical_raw", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="rep_statistical_raw"> Statistical Data ( Raw )<br>
															<input <?php if (in_array("rep_statistical_finished", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="rep_statistical_finished"> Statistical Data ( Finished )<br>
															<input <?php if (in_array("rep_item_pending", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="rep_item_pending"> Item Pending<br>
															<input <?php if (in_array("rep_gst", $per_data)){ echo "checked"; } ?> type="checkbox" name="permission[]" value="rep_gst"> GST<br>
														</li>
													</ul>
												</li>
											</ul>
											
										</div>


                                        <div class="form-group col-lg-12">    
                                            <input type="submit" class="btn btn-info" value="Update">
                                        </div>
                                        <div style="clear:both;"></div>    
                                    </form>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                        
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