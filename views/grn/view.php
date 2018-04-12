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

                <section class="content">
                    <div class="row">
                    
                    	<?php $grnItems = GetGRNItems( $grn->grn_id ); ?>
                    	
                        <div class="col-md-6">
                        	<div class="box box-warning">
                            	<div class="box-header">
                                    <h3 class="box-title">GRN Details</h3>
                                    <?php //var_dump($grn); ?>
                                    <div class="heading_right_box">
                                    
										<?php if( is_UserAllowed('approve_grn')){ ?>
											<?php if( $grn->status == 2) : ?>
												<a style="color:green;" href="/grn/approve_grn/<?php echo $grn->id; ?>" id="grn_approv">Click to Approve</a> 
											<?php else : ?> 
												<span style="color:green;">Approved</span> 
											<?php endif; ?>
										<?php } ?>
										
										<?php if( is_UserAllowed('approve_grn') && $grnItems ){ echo "|"; }?>
                                    	
                                    	<?php if( $grnItems ) { ?> <a style="color:orange;" href="/grn/Export_EXCEL/<?php echo $grn->grn_id; ?>">Export Excel</a> | <a style="color:orange;" href="/grn/Export_PDF/<?php echo $grn->grn_id; ?>">Export PDF</a> <?php } ?>
                                    </div>
                                </div>
                                
                            	<div class="box-body table-responsive">
                                    <table id="example2" class="table sv_table_heading table-bordered table-hover">
                                        <tbody>    
                                            <tr>
                                                <th style="width: 25%;">GRN Number</th>
                                                <td><?php echo $grn->grn_number; ?></td>
                                            </tr>  
                                            <tr>
                                                <th style="width: 25%;">Supplier Name</th>
                                                <td><?=GetSupplierData( Get_Bill_data( $grn->bill_id )->sup_id )->supplier_name;?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 25%;">Challan No.</th>
                                                <td><?php echo Get_Bill_data( $grn->bill_id )->challan_num; ?></td>
                                            </tr>  
                                             <tr>
                                                <th style="width: 25%;">Challan Date</th>
                                                <td><?php echo date("j F, Y", strtotime(Get_Bill_data( $grn->bill_id )->challan_date)); ?></td>
                                            </tr> 
  
                                            <tr>
                                                <th style="width: 25%;">No. of Boxes</th>
                                                <td><?php echo Get_Bill_data( $grn->bill_id )->num_of_box; ?></td>
                                            </tr>
                                            
                                            <?php if( $grn->status == 1) : ?>
												<tr>
													<th style="width: 25%;">Approved By</th>
													<td><?php echo GetUserData($grn->approved_by )->name; ?></td>
												</tr>
											<?php endif; ?>
                                            <tr>
                                                <th style="width: 25%;">Created By</th>
                                                <td><?php echo GetUserData( $grn->created_by )->name; ?></td>
                                            </tr>

                                            <tr>
                                                <th style="width: 25%;">Created At</th>
                                                <td><?php echo date("j F, Y | H:i:s", strtotime($grn->date)); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>   
							</div>
						</div>	
						
						<div class="col-md-6">
							<?php if( is_UserAllowed('add_grn_item')){ ?>
								<?php if( $grn->status == 2) : ?>
									<div class="box box-warning">
										<div class="box-header">
											<h3 class="box-title">Add Item to GRN</h3>
										</div>
							
										<div class="box-body">
								
											<?php echo form_error('validate'); ?>
											<form enctype="multipart/form-data" action="<?=base_url('grn/saveGrnItem/'.$grn->id); ?>" method="post">

												<?php if( $msg ) { ?>
													<div class="" style="padding-bottom: 15px;">
														<?php echo $msg; ?>
													</div>
												<?php } ?>
										
												<div class="form-group col-md-6">
													<?php $items = Get_Items_of_bill($grn->bill_id); ?>
													<label>Items <span style="color:red;">*</span></label>
													<select class="form-control item_id" name="item_id"  style="width:100%;">
														<option value="">Select Item</option>
														<?php foreach( $items as $item ) :  ?>
															<option data-billid="<?php echo $grn->bill_id; ?>" value="<?=$item['item_id'];?>"><?=GetItemData( $item['item_id'] )->ITEM_CODE;?></option>
														<?php endforeach; ?>
													</select>
													<?php echo form_error('item_id'); ?>
												</div>

												<div class="form-group col-md-6">
													<label>Supplier PO# <span style="color:red;">*</span></label>
													<input type="text" readonly class="form-control po_num" name="po_num" value=""/>
													<?php echo form_error('po_num'); ?>
												</div>
												
												<div class="form-group col-md-4">
													<label>Challan Qty <span style="color:red;">*</span></label>
													<input type="text" readonly class="form-control challan_qty" name="challan_qty" value=""/>
													<?php echo form_error('challan_qty'); ?>
												</div>

												<div class="form-group col-md-4">
													<label>Received Qty <span style="color:red;">*</span></label>
													<input type="text" class="form-control received_qty" value="" name="received_qty" />
													<?php echo form_error('received_qty'); ?>
												</div>

												<div class="form-group col-md-4">
													<label>Accepted Qty <span style="color:red;">*</span></label>
													<input type="text" class="form-control accepted_qty" onfocusout="rejectedQTY()" name="accepted_qty" value=""/>
													<?php echo form_error('accepted_qty'); ?>
												</div>
												
												<div class="form-group col-md-6">
													<label>Diffrence</label>
													<input type="text" disabled class="form-control diffrence_qty" name="diffrence_qty" value=""/>
													<?php echo form_error('diffrence_qty'); ?>
												</div>
										
												<div class="form-group col-md-6">
													<label>Rejected Qty</label>
													<input type="text" disabled class="form-control rejected_qty" name="rejected_qty" value=""/>
													<?php echo form_error('rejected_qty'); ?>
												</div>
										
												<div class="form-group col-md-12">
													<label>Remarks</label>
													<textarea class="form-control" name="remarks" placeholder="Remarks Against Rejection"></textarea>
													<?php echo form_error('remarks'); ?>
												</div>
										
												<input type="hidden" class="form-control" name="grn_id" value="<?php echo $grn->grn_id?>" />
										
												<div class="form-group col-md-12">    
													<input type="hidden" class="spo_id" name="spo_id" value="" />													<input type="submit" class="btn btn-info" value="Submit">
												</div>
												<div style="clear:both;"></div>
											</form>  
										</div>
									</div>
								<?php endif; ?>
							<?php } ?>
						</div>
						
						<div class="col-md-12">
                            <div class="box box-warning"> 
								<div class="box-header">
									<h3 class="box-title">GRN's Item</h3>
								</div>
								
								<div class="box-body table-responsive">
									<?php if( $grnItems ) : ?>
										<table id="example1" class="table sv_table_heading table-bordered table-hover">
											<thead>
												<tr>
													<th>S.No</th>
													<th>Item Code</th>
													<th>Item Description</th>
													<th>Unit</th>
													<th>Supplier PO#</th>
													<th>Challan Qty</th>
													<th>Recieved Qty</th>
													<th>Accepted Qty</th>
													<th>Rejected Qty</th>
													<th>Diffrence Qty</th>
													<th>Stocked Qty</th>
													<th>Remarks</th>
													<?php if( is_UserAllowed('update_grn_item') || is_UserAllowed('remove_grn_item') ){ ?>
														<?php if( $grn->status == 2) : ?>
															<th>Status</th>
														<?php endif; ?>	
													<?php } ?>
												</tr>
											</thead>
											<tbody>    
												<?php 	$i=1; 
														foreach( $grnItems as $grnItem ) : 
														
														$GRNtoSTOCK = GRNtoSTOCK($grnItem['grn_row_id'], $grnItem['item_id']);
												?>
												<tr>
													<td><?=$i;?></td>
													<td><?php echo GetItemData( $grnItem['item_id'] )->ITEM_CODE; ?></td>
													<td><?php echo GetItemData( $grnItem['item_id'] )->ITEM_DESC; ?></td>
													<td><?php echo GetItemUnit( GetItemData( $grnItem['item_id'] )->ITEM_UNIT); ?></td>
													<td><?php echo SPOData($grnItem['supplier_po_id'])->po_num; ?></td>
													<td><?php echo $grnItem['challan_qty']; ?></td>
													<td><?php echo $grnItem['received_qty']; ?></td>
													<td><?php echo $grnItem['accepted_qty']; ?></td>
													<td><?php echo $grnItem['received_qty'] - $grnItem['accepted_qty']; ?></td>
													<td><?php echo $grnItem['received_qty'] - $grnItem['challan_qty']; ?></td>
													<td <?php if( $grnItem['accepted_qty'] > $GRNtoSTOCK ) { echo 'class="uninvoiced_column_red"'; } ?> ><?php echo $GRNtoSTOCK; ?></td>
													<td><?php echo $grnItem['remarks']; ?></td>
													<?php if( is_UserAllowed('update_grn_item') || is_UserAllowed('remove_grn_item') ){ ?>
														<?php if( $grn->status == 2) : ?>
														<td>
														
															<?php if( is_UserAllowed('update_grn_item')){ ?>
																<a style="color:orange;" href="<?=base_url('grn/editGrnItem/'.$grnItem['id']); ?>">Update</a> 
															<?php } ?>
														
															<!-- 
<?php if( is_UserAllowed('remove_grn_item')){ ?>
																<a style="color:red;" class="remove_grn_item" rowid="<?php echo $grnItem['id']; ?>" href="#">Remove</a>
															<?php } ?>
 -->
														
														</td>
														<?php endif; ?>
													<?php } ?>
												</tr>    
												<?php $i++; endforeach; ?>
											</tbody>
										</table>
									<?php else : ?>
										<h4>No items found!!!</h4>	
									<?php endif; ?>
								</div>   
								     
							</div>
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
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

        <script type="text/javascript">
        
        	// function maxQTY()
//         		{
//         			var received_qty = $('.received_qty').val();
//         			alert(received_qty);
//         			
//         			$('.max_recived_qty').val(received_qty);
//         		}

        	function rejectedQTY()
        		{
        			var challan_qty = parseFloat ( $('.challan_qty').val() );
        			var received_qty = parseFloat ( $('.received_qty').val() ); 
        			var accepted_qty = parseFloat ( $('.accepted_qty').val() );
        			
        			var diff = received_qty - challan_qty;
        			
        			if(diff)
        				{
        					$('.diffrence_qty').val(diff);
        				}

        			if(accepted_qty < received_qty)
        				{	
        					var rejected_qty = received_qty - accepted_qty;

        				}
        			else
        				{
        					var rejected_qty = '0';
        				}
        			
        			if(rejected_qty)
        				{
        					$('.rejected_qty').val(rejected_qty);
        				}
        		}
            
           	$(document).ready(function() {
           		$(".remove_grn_item").click(function(e) {
					event.preventDefault();
					
					if(confirm("Do you really want to remove this item?")){
					
						var rowid = $(this).attr('rowid');
					
						$.ajax({
							url: '/grn/remove_sub_item',
							data: {'rowid': rowid}, 
							type: "post",
							success: function(data){
								
								location.reload();
									
							}
						});
					}
                    
				});	
			});
			
			$( ".item_id" ).change(function() {
				
				var item_id = $(this).val();
				var bill_id = $(".item_id option:selected").data('billid');
				
				$.ajax({
					url: '/grn/Get_Bill_Item_QTY',
					data: {'item_id' : item_id, 'bill_id' : bill_id},
					type: "post",
					dataType: "json",
					success: function(data){
						alert(data.qty);
						$('.challan_qty').val(data.qty);
						$('.spo_id').val(data.spo_id);
						$('.po_num').val(data.po_num);
					}
				});
			});
           			
           
//                 $("#grn_approv").click(function(){
// 
// 					var gid = $(this).attr('gid');
// 						
// 					$.ajax({
//                         url: '/grn/approve_grn',
//                         data: {'gid': gid},
//                         type: "post",
//                         success: function(data){
// 							alert(data);
//                             $('.item').removeAttr('disabled');
//                             $(".item").select2("destroy");
//                             $('.item').html(data);
//                             $(".item").select2();
//                             //alert(data);
//                         }
//                     });
//                 });
            
            $('select').select2();
            
        </script>

    </body>
</html>