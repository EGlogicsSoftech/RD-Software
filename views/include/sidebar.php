<?php $username=$this->db->get_where('login',array('id'=>$this->session->userdata('id')))->row('name'); ?>
<aside class="left-side sidebar-offcanvas box1">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar box-inner">
        <!-- Sidebar user panel -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="<?php if($this->uri->segment(1)=="admin"){echo "active";}?>">
                <a href="<?=base_url('admin/dashboard');?>">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            
            <?php if( is_UserAllowed('item')){ ?>
            
				<li class="treeview <?php if($this->uri->segment(1)=="item"){echo "active";}?>">
					<a href="#">
						<i class="fa fa-bar-chart-o"></i>
						<span>Item</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
				
						<?php if( is_UserAllowed('add_item')){ ?>
							<li class="<?php if($this->uri->segment(2)=="add"){echo "active";}?>">
								<a href="<?=base_url('item/add');?>"><i class="fa fa-angle-double-right"></i> Add Item</a>
							</li>
						<?php } ?>

						<?php if( is_UserAllowed('all_item')){ ?>
							<li class="<?php if($this->uri->segment(2)=="listitems"){echo "active";}?>">
								<a href="<?=base_url('item/listitems');?>"><i class="fa fa-angle-double-right"></i> All Item</a>
							</li>
						<?php } ?>	
					
						<?php if( is_UserAllowed('add_unit')){ ?>
							<li class="<?php if($this->uri->segment(2)=="listunits"){echo "active";}?>">
								<a href="<?=base_url('item/listunits');?>"><i class="fa fa-angle-double-right"></i> Item Units</a>
							</li>
						<?php } ?>
					
						<?php if( is_UserAllowed('add_category')){ ?>
							<li class="<?php if($this->uri->segment(2)=="listitemcategory"){echo "active";}?>">
								<a href="<?=base_url('item/listitemcategory');?>"><i class="fa fa-angle-double-right"></i> Item Category</a>
							</li>
						<?php } ?>
						
						<?php //if( is_UserAllowed('add_category')){ ?>
							<li class="<?php if($this->uri->segment(2)=="listitemcountry"){echo "active";}?>">
								<a href="<?=base_url('item/listitemcountry');?>"><i class="fa fa-angle-double-right"></i> Item Country</a>
							</li>
						<?php //} ?>
					
						<?php if( is_UserAllowed('add_inner_box')){ ?>
							<li class="<?php if($this->uri->segment(2)=="listinnerbox"){echo "active";}?>">
								<a href="<?=base_url('item/listinnerbox');?>"><i class="fa fa-angle-double-right"></i> Inner Box</a>
							</li>
						<?php } ?>
					
						<?php if( is_UserAllowed('add_outer_box')){ ?>
							<li class="<?php if($this->uri->segment(2)=="listouterbox"){echo "active";}?>">
								<a href="<?=base_url('item/listouterbox');?>"><i class="fa fa-angle-double-right"></i> Outer Box</a>
							</li>
						<?php } ?>
					
						<!-- 
	<li class="<?php if($this->uri->segment(2)=="listweight"){echo "active";}?>">
							<a href="<?=base_url('item/listweight');?>"><i class="fa fa-angle-double-right"></i> Weight Unit</a>
						</li>
	 -->
					</ul>
				</li>
				
			<?php } if( is_UserAllowed('supplier')){ ?>
			
				<li class="treeview <?php if($this->uri->segment(1)=="supplier"){echo "active";}?>">
					<a href="#">
						<i class="fa fa-bar-chart-o"></i>
						<span>Supplier</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
				
						<?php if( is_UserAllowed('add_supplier')){ ?>
							<li class="<?php if($this->uri->segment(2)=="add"){echo "active";}?>">
								<a href="<?=base_url('supplier/add');?>"><i class="fa fa-angle-double-right"></i> Add Supplier</a>
							</li>
						<?php } ?>
						
						<?php if( is_UserAllowed('all_supplier')){ ?>
							<li class="<?php if($this->uri->segment(2)=="all_list"){echo "active";}?>">
								<a href="<?=base_url('supplier/all_list');?>"><i class="fa fa-angle-double-right"></i> All Suppliers</a>
							</li>
						<?php } ?>
					
						<?php if( is_UserAllowed('add_spo')){ ?>
							<li class="<?php if($this->uri->segment(2)=="add_supplier_po"){echo "active";}?>">
								<a href="<?=base_url('supplier/add_supplier_po');?>"><i class="fa fa-angle-double-right"></i> Add Supplier P.O</a>
							</li>
						<?php } ?>
						
						<?php if( is_UserAllowed('all_spo')){ ?>
						   <li class="<?php if($this->uri->segment(2)=="all_list_po"){echo "active";}?>">
								<a href="<?=base_url('supplier/all_list_po');?>"><i class="fa fa-angle-double-right"></i> All Supplier P.O</a>
							</li>
						<?php } ?>		
					
					</ul>
				</li>
				
			<?php } if( is_UserAllowed('customer')){ ?>
			
				<li class="treeview <?php if($this->uri->segment(1)=="customer"){echo "active";}?>">
					<a href="#">
						<i class="fa fa-bar-chart-o"></i>
						<span>Customer</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
				
						<?php if( is_UserAllowed('add_customer')){ ?>
							<li class="<?php if($this->uri->segment(2)=="add"){echo "active";}?>">
								<a href="<?=base_url('customer/add');?>"><i class="fa fa-angle-double-right"></i> Add Customer</a>
							</li>
						<?php } ?>
						
						<?php if( is_UserAllowed('all_customer')){ ?>
							<li class="<?php if($this->uri->segment(2)=="all_customer"){echo "active";}?>">
								<a href="<?=base_url('customer/all_list');?>"><i class="fa fa-angle-double-right"></i> All Customers</a>
							</li>
						<?php } ?>	
					
						<?php if( is_UserAllowed('add_cpi')){ ?>
							<li class="<?php if($this->uri->segment(2)=="add"){echo "active";}?>">
								<a href="<?=base_url('customer/add_customer_pi');?>"><i class="fa fa-angle-double-right"></i> Add Customer P.I</a>
							</li>
						<?php } ?>
						
						<?php if( is_UserAllowed('all_CPI')){ ?>
							<li class="<?php if($this->uri->segment(2)=="all_list_pi"){echo "active";}?>">
								<a href="<?=base_url('customer/all_list_pi');?>"><i class="fa fa-angle-double-right"></i> All Customer P.I</a>
							</li>
						<?php } ?>
					
					</ul>
				</li>
				
			<?php } if( is_UserAllowed('grn')){ ?>
			
				<li class="treeview <?php if($this->uri->segment(1)=="grn"){echo "active";}?>">
					<a href="#">
						<i class="fa fa-laptop"></i>
						<span>GRNs</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
				
						<?php if( is_UserAllowed('add_grn')){ ?>
							<li class="<?php if($this->uri->segment(2)=="add"){echo "active";}?>">
								<a href="<?=base_url('grn/add');?>"><i class="fa fa-angle-double-right"></i> Add GRN</a>
							</li>
						<?php } ?>
						
						<?php if( is_UserAllowed('all_grn')){ ?>
							<li><a href="<?=base_url('grn/grnlist');?>"><i class="fa fa-angle-double-right"></i> All GRNs</a></li>
						<?php } ?>	
					
					</ul>
				</li>
				
			<?php } ?> 
				
				<li class="treeview <?php if($this->uri->segment(1)=="grn"){echo "active";}?>">
					<a href="#">
						<i class="fa fa-laptop"></i>
						<span>Supplier Bills</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
				
						<?php //if( is_UserAllowed('add_grn')){ ?>
							<li class="<?php if($this->uri->segment(2)=="add"){echo "active";}?>">
								<a href="<?=base_url('supplier_bill/add');?>"><i class="fa fa-angle-double-right"></i> Add Bill</a>
							</li>
						<?php //} ?>
						
						<?php //if( is_UserAllowed('all_grn')){ ?>
							<li><a href="<?=base_url('supplier_bill/all_bills');?>"><i class="fa fa-angle-double-right"></i> All Bills</a></li>
						<?php //} ?>	
					
					</ul>
				</li>
				
			<?php if( is_UserAllowed('stock')){ ?>
			
				<li class="treeview <?php if($this->uri->segment(1)=="stock"){echo "active";}?>">
					<a href="#">
						<i class="fa fa-edit"></i> <span>Stock</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
				
						<?php if( is_UserAllowed('add_se')){ ?>
							<li class="<?php if($this->uri->segment(2)=="add_entry"){echo "active";}?>"><a href="<?=base_url('stock/add_entry');?>"><i class="fa fa-angle-double-right"></i> Add Stock Entry</a></li>
						<?php } ?>
						
						<?php if( is_UserAllowed('all_se')){ ?>
						<li class="<?php if($this->uri->segment(2)=="all_entry_list"){echo "active";}?>"><a href="<?=base_url('stock/all_entry_list');?>"><i class="fa fa-angle-double-right"></i> All Stock Entries</a></li>
						<?php } ?>
					
						<?php if( is_UserAllowed('add_si')){ ?>
							<li class="<?php if($this->uri->segment(2)=="add_issuance"){echo "active";}?>"><a href="<?=base_url('stock/add_issuance');?>"><i class="fa fa-angle-double-right"></i> Add Stock Issuance</a></li>
						<?php } ?>
						
						<?php if( is_UserAllowed('all_si')){ ?>
							<li class="<?php if($this->uri->segment(2)=="all_issuance_list"){echo "active";}?>"><a href="<?=base_url('stock/all_issuance_list');?>"><i class="fa fa-angle-double-right"></i> All Stock Issuances</a></li>
						<?php } ?>
					
						<?php if( is_UserAllowed('view_checkstock')){ ?>
							<li class="<?php if($this->uri->segment(2)=="check_stock"){echo "active";}?>"><a href="<?=base_url('stock/check_stock');?>"><i class="fa fa-angle-double-right"></i> Check Stock</a></li>
						<?php } ?>
					
					</ul>
				</li>

			<?php } if( is_UserAllowed('warehouse')){ ?>	

				<li class="treeview <?php if($this->uri->segment(1)=="warehouse"){echo "active";}?>">
					<a href="#">
						<i class="fa fa-folder"></i> <span>Warehouse</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
				
						<?php if( is_UserAllowed('add_wa')){ ?>
							<li class="<?php if($this->uri->segment(2)=="add_activity"){echo "active";}?>"><a href="<?=base_url('warehouse/add_activity');?>"><i class="fa fa-angle-double-right"></i> Add Warehouse Activity</a></li>
						<?php } ?>
						
						<?php if( is_UserAllowed('all_wa')){ ?>
						<li class="<?php if($this->uri->segment(2)=="all_activity_list"){echo "active";}?>"><a href="<?=base_url('warehouse/all_activity_list');?>"><i class="fa fa-angle-double-right"></i> All Warehouse Activities</a></li>
						<?php } ?>
					
						<?php if( is_UserAllowed('add_wr')){ ?>
							<li class="<?php if($this->uri->segment(2)=="add_rejection"){echo "active";}?>"><a href="<?=base_url('warehouse/add_rejection');?>"><i class="fa fa-angle-double-right"></i> Add Warehouse Rejection</a></li>
						<?php } ?>
						
						<?php if( is_UserAllowed('view_wr')){ ?>
						<li class="<?php if($this->uri->segment(2)=="all_rejection_list"){echo "active";}?>"><a href="<?=base_url('warehouse/all_rejection_list');?>"><i class="fa fa-angle-double-right"></i> All Warehouse Rejection</a></li>
						<?php } ?>
					</ul>
				</li>

			<?php } ?>
			
            <!-- 
			<li class="treeview <?php if($this->uri->segment(1)=="invoice"){echo "active";}?>">
                <a href="#">
                    <i class="fa fa-folder"></i> <span>Invoice</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php if($this->uri->segment(2)=="add_invoice"){echo "active";}?>"><a href="<?=base_url('invoice/add_invoice');?>"><i class="fa fa-angle-double-right"></i> Add Invoice</a></li>
                    <li class="<?php if($this->uri->segment(2)=="invoice_list"){echo "active";}?>"><a href="<?=base_url('invoice/invoice_list');?>"><i class="fa fa-angle-double-right"></i> All Invoice</a></li>
                </ul>
            </li>
 -->
            <?php if( is_UserAllowed('invoice')){ ?>
				<li class="treeview <?php if($this->uri->segment(1)=="packing"){echo "active";}?>">
					<a href="#">
						<i class="fa fa-folder"></i> <span>Packing List & Invoice</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
				
						<?php if( is_UserAllowed('add_pl')){ ?>
							<li class="<?php if($this->uri->segment(2)=="add_packing"){echo "active";}?>"><a href="<?=base_url('packing/add_packing');?>"><i class="fa fa-angle-double-right"></i> Add Packing List</a></li>
						<?php } ?>
					
						<?php if( is_UserAllowed('all_pl')){ ?>
						<li class="<?php if($this->uri->segment(2)=="packing_list"){echo "active";}?>"><a href="<?=base_url('packing/packing_list');?>"><i class="fa fa-angle-double-right"></i> All Packing List</a></li>
						<?php } ?>
					
						<?php if( is_UserAllowed('add_dim')){ ?>
							<li class="<?php if($this->uri->segment(2)=="add_dimension"){echo "active";}?>"><a href="<?=base_url('packing/add_dimension');?>"><i class="fa fa-angle-double-right"></i> Add Dimension</a></li>
						<?php } ?>

						<?php if( is_UserAllowed('all_dim')){ ?>
							<li class="<?php if($this->uri->segment(2)=="dimension_list"){echo "active";}?>"><a href="<?=base_url('packing/dimension_list');?>"><i class="fa fa-angle-double-right"></i> All Dimension</a></li>
						<?php } ?>	
					
					</ul>
				</li>
			<?php } ?>
            
            <?php if( is_UserAllowed('production')){ ?>
				<li class="treeview <?php if($this->uri->segment(1)=="production"){echo "active";}?>">
					<a href="#">
						<i class="fa fa-folder"></i> <span>Production</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li class="<?php if($this->uri->segment(2)=="issue_list"){echo "active";}?>"><a href="<?=base_url('production/issue_list');?>"><i class="fa fa-angle-double-right"></i> Issue List</a></li>
						<li class="<?php if($this->uri->segment(2)=="update_issue_list"){echo "active";}?>"><a href="<?=base_url('production/update_issue_list');?>"><i class="fa fa-angle-double-right"></i> Update</a></li>
						<li class="<?php if($this->uri->segment(2)=="production_history"){echo "active";}?>"><a href="<?=base_url('production/production_history');?>"><i class="fa fa-angle-double-right"></i> Production History</a></li>
					</ul>
				</li>
			<?php } ?>
			
            <?php if( is_UserAllowed('reports')){ ?>
				<li class="treeview <?php if($this->uri->segment(1)=="report"){echo "active";}?>">
					<a href="#">
						<i class="fa fa-folder"></i> <span>Reports</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<?php if( is_UserAllowed('rep_inventory')){ ?>
							<li class="<?php if($this->uri->segment(2)=="invantory"){echo "active";}?>"><a href="<?=base_url('report/invantory');?>"><i class="fa fa-angle-double-right"></i> Invantory</a></li>
						<?php } ?>

						<?php if( is_UserAllowed('rep_customer')){ ?>
							<li class="<?php if($this->uri->segment(2)=="customer"){echo "active";}?>"><a href="<?=base_url('report/customer');?>"><i class="fa fa-angle-double-right"></i> Customer</a></li>
						<?php } ?>

						<?php if( is_UserAllowed('rep_supplier')){ ?>
							<li class="<?php if($this->uri->segment(2)=="supplier"){echo "active";}?>"><a href="<?=base_url('report/supplier');?>"><i class="fa fa-angle-double-right"></i> Supplier</a></li>
						<?php } ?>

						<?php if( is_UserAllowed('rep_statistical_raw')){ ?>
							<li class="<?php if($this->uri->segment(2)=="statistical_raw"){echo "active";}?>"><a href="<?=base_url('report/statistical_raw');?>"><i class="fa fa-angle-double-right"></i> Statistical ( Raw )</a></li>
						<?php } ?>

						<?php if( is_UserAllowed('rep_statistical_finished')){ ?>
							<li class="<?php if($this->uri->segment(2)=="statistical_finished"){echo "active";}?>"><a href="<?=base_url('report/statistical_finished');?>"><i class="fa fa-angle-double-right"></i> Statistical ( Finished )</a></li>
						<?php } ?>


						<!-- 
<li class="<?php if($this->uri->segment(2)=="product"){echo "active";}?>"><a href="<?=base_url('report/product');?>"><i class="fa fa-angle-double-right"></i> Product</a></li>
						<li class="<?php if($this->uri->segment(2)=="grn"){echo "active";}?>"><a href="<?=base_url('report/grn');?>"><i class="fa fa-angle-double-right"></i> GRN</a></li>
						<li class="<?php if($this->uri->segment(2)=="invoice"){echo "active";}?>"><a href="<?=base_url('report/invoice');?>"><i class="fa fa-angle-double-right"></i> Invoice</a></li>
						<li class="<?php if($this->uri->segment(2)=="master"){echo "active";}?>"><a href="<?=base_url('report/master');?>"><i class="fa fa-angle-double-right"></i> Master</a></li>
						<li class="<?php if($this->uri->segment(2)=="purchase_order"){echo "active";}?>"><a href="<?=base_url('report/purchase_order');?>"><i class="fa fa-angle-double-right"></i> Purchase Order</a></li>
 -->
					</ul> 
				</li>
			<?php } ?>

            
            <?php if( is_UserWebAdmin() ) : ?>
            
				<li class="treeview <?php if($this->uri->segment(1)=="user"){echo "active";}?>">
					<a href="#">
						<i class="fa fa-folder"></i> <span>Users</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li class="<?php if($this->uri->segment(2)=="add_user_role"){echo "active";}?>">
							<a href="<?=base_url('user/add_user_role');?>"><i class="fa fa-angle-double-right"></i> Add User Role</a>
						</li>
						<li class="<?php if($this->uri->segment(2)=="user"){echo "active";}?>">
							<a href="<?=base_url('user');?>"><i class="fa fa-angle-double-right"></i> Add Users</a>
						</li>
						<li class="<?php if($this->uri->segment(2)=="all_users"){echo "active";}?>">
							<a href="<?=base_url('user/all_users');?>"><i class="fa fa-angle-double-right"></i> All Users</a>
						</li>
						<li class="<?php if($this->uri->segment(2)=="designation"){echo "active";}?>">
							<a href="<?=base_url('user/designation');?>"><i class="fa fa-angle-double-right"></i> Designation</a>
						</li>
					</ul>
				</li>
				
				<li class="treeview <?php if($this->uri->segment(1)=="impexport"){echo "active";}?>">
					<a href="#">
						<i class="fa fa-folder"></i> <span>Import / Export</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li class="<?php if($this->uri->segment(2)=="add_user_role"){echo "active";}?>">
							<a href="<?=base_url('impexport/import');?>"><i class="fa fa-angle-double-right"></i> Import</a>
						</li>
						<li class="<?php if($this->uri->segment(2)=="user"){echo "active";}?>">
							<a href="<?=base_url('impexport/export');?>"><i class="fa fa-angle-double-right"></i> Export</a>
						</li>
					</ul>
				</li>
				
			<?php endif; ?>
            
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>