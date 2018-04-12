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
        <link href="<?=base_url();?>admin/css/custom_style.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>admin/css/datepicker.css" rel="stylesheet" type="text/css" />

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
                        <div class="col-md-4">
                            <div class="box box-warning">
                            
                            	<div class="box-header">
                                    <h3 class="box-title">General Elements</h3>
                                </div><!-- /.box-header -->
                                
                                <div class="box-body ab-class">
                                
                                    <?php echo form_error('validate'); ?>
                                    <form enctype="multipart/form-data" action="<?=base_url('supplier_bill/updateBillItem/'.$billitem->id); ?>" method="post">

										<?php if( $msg ) { ?>
											<div class="" style="padding-bottom: 15px;">
												<?php echo $msg; ?>
											</div>
										<?php } ?>
										
										<div class="form-group">
											<?php 	$billdata = $this->db->get_where('supplier_bill',array('bill_id'=>$billitem->bill_id))->row();
													$spos = GetAll_SPO_of_Supplier($billdata->sup_id); 
											?>
											<label>Supplier PO <span style="color:red;">*</span></label>
											<select class="form-control spo" name="spo" style="width:100%;">
												<option value="">Select SPO</option>
												<?php foreach( $spos as $spo ) : ?>
													<option <?php if( $spo['sup_po_id'] == $billitem->supplier_po_id ) { echo "selected"; } ?> value="<?=$spo['sup_po_id'];?>"><?=$spo['po_num'];?></option>
												<?php endforeach; ?>
											</select>
											<?php echo form_error('spo'); ?>
										</div>
										
										<div class="form-group">
											<label>Items</label>
											<select class="form-control item_id" name="item_id"  style="width:100%;">
												<option value="">Select Item</option>
												<?php 	$items = GetItemofSupplierPOItem($billitem->supplier_po_id); 
												
														foreach( $items as $item ) :  ?>
															<option <?php if( $item['item_id'] == $billitem->item_id ) { echo "selected"; } ?> value="<?=$item['item_id']?>"><?=GetItemData( $item['item_id'] )->ITEM_CODE;?></option>
												<?php endforeach; ?>
											</select>
											<?php echo form_error('item_id'); ?>
										</div>
										
										<div class="form-group">
											<?php $price = $this->db->get_where('supplier_po_item',array('sup_po_id'=>$billitem->supplier_po_id, 'item_id'=>$billitem->item_id))->row('price'); ?>
											<label>Price <span style="color:red;">*</span></label>
											<input style="width:100%;" readonly type="text" class="form-control price" name="price" value="<?php echo $price; ?>"/>
											<?php echo form_error('price'); ?>
										</div>

										<div class="form-group">
											<label>Challan Qty <span style="color:red;">*</span></label>
											<input style="width:100%;" type="text" onfocusout="Get_total()" class="form-control" name="challan_qty" value="<?php echo $billitem->challan_qty; ?>"/>
											<?php echo form_error('challan_qty'); ?>
										</div>
										
										<div class="form-group">
											<label>Total <span style="color:red;">*</span></label>
											<input style="width:100%;" readonly type="text" class="form-control total" value="<?php echo $price * $billitem->challan_qty; ?>" name="total" />
											<?php echo form_error('total'); ?>
										</div>

										<div class="form-group">
											<label>Total GST <span style="color:red;">*</span></label>
											<input style="width:100%;" type="text" class="form-control" name="total_gst" value="<?php echo $billitem->gst; ?>" />
											<?php echo form_error('total_gst'); ?>
										</div>

										<div class="form-group">    
											<input type="submit" class="btn btn-info" value="Submit">
										</div>
							
									</form> 
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

        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
        
        <script type="text/javascript">
        
        	$(document).ready(function() {
                $(".spo").change(function(){

                    var sup_po_id = $(this).val();
                    
                    $.ajax({
                        url: '/supplier_bill/getitem',
                        data: {'sup_po_id': sup_po_id},
                        type: "post",
                        success: function(data){

                            $('.item_id').removeAttr('disabled');
                            $(".item_id").select2("destroy");
                            $('.item_id').html(data);
                            $(".item_id").select2();
                        }
                    });
                });
                
                $(".item_id").change(function(){

                    var item_id = $(this).val();
                   	var spo_id = $('.spo').val();
                    
                    $.ajax({
                        url: '/supplier_bill/get_SPO_item_price',
                        data: {'item_id': item_id, 'spo_id': spo_id},
                        type: "post",
                        success: function(data){
							
                           $('.price').val(data);
                           
                        }
                    });
                });
            });
        
        	// function maxQTY()
//         		{
//         			var received_qty = $('.received_qty').val();
//         			alert(received_qty);
//         			
//         			$('.max_recived_qty').val(received_qty);
//         		}

        	function Get_total()
        		{
        			var challan_qty = parseFloat ( $('.challan_qty').val() );
        			var price = parseFloat ( $('.price').val() ); 
        			
        			var total = challan_qty * price;
        			
        			if(total)
        				{
        					$('.total').val(total);
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
        <script type="text/javascript" src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js"></script>

        <script type="text/javascript">
            jQuery(function () {
                jQuery('#startDate').datetimepicker({ format: 'dd/MM/yyyy' });  
            });

         </script>
    </body>
</html>