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
 --><!-- /.box-header -->


                                <div class="box-body">
                                	<div class="row">
										<form action="#" method="POST">

											<div class="col-xs-3">
												<select id="sv_items" class="item-ajax form-control sv_item" name="item[]" multiple>
													<?php if( $_POST['item'] && !isset($_POST['all'] ) ) {
														foreach( $_POST['item'] as $item ) : ?>
																<option selected value ="<?php echo $item; ?>"><?php echo GetItemData( $item )->ITEM_CODE; ?></option>
														<?php endforeach; } ?>
												</select>
											</div>

											<div class="col-xs-2">
												<input type="checkbox" <?php if( isset( $_POST['all'] ) ) { echo "checked"; } ?> name="all" id="checkbox" value=""> Select All
											</div>

											<div class="col-xs-3">
												<input type="submit" class="btn btn-info" name="submit" value="Submit">
											</div>
										</form>

								 </div>
                                </div><!-- /.box-body -->

                                <div style="clear:both;"></div>

                                <div class="box-body table-responsive">
                                    <table id="item_pending" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Item#</th>
                                                <th class="nosort">Item Description</th>
                                                <th class="nosort">Manufacturing Timeframe</th>
                                            	<th class="nosort">Supplier Code</th>
                                            	<th class="nosort">Quantity In Stock</th>
                                                <th class="nosort">Supplier PO Qty</th>
                                                <th class="nosort">Total Customer Order</th>
                                                <th class="nosort">Order Balance</th>
                                                <th class="nosort">YTDS Previous Year</th>
                                                <th class="nosort">YTD Sold Qty</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                       		<?php
                                                $itemss = array();
                                                if( isset($_POST) )
                                            		{
														// IF ITEMS SELEECTED , SHOW ONLY THOSE ITEMS
                                                      	if( isset($_POST["item"]) && !empty($_POST["item"]) )
                                                      		{
                                                        		$itemss = $_POST['item'];
                                                      		}// 
//                                                       	else
//                                                       		{
//                                                       			$items = GetItem();
//                                                       			
//                                                       			foreach($items as $item)
//                                                           			{
//                                                             			$itemss[] = $item['ITEM_ID'];
//                                                           			}    
//                                                       		}

                                                      	// IF CHECKBOX SELECTED , SHOW ALL ITEMS
                                                      	// if( isset($_POST['all']) )
//                                                       		{
//                                                         		$items = GetItem();
//                                                         		foreach($items as $item)
//                                                           			{
//                                                             			//var_dump($item);
//                                                             			$itemss[] = $item['ITEM_ID'];
//                                                           			}                      
//                                                       		} // IF CHECKBOX SELECTED

														$i=1; 

														foreach( $itemss as $item ) :

														$sup_id = GetItemData($item)->SUPPLIER_ID;
														$sup_data = Get_Supplier_Data_by_Array_ID($sup_id);
														$sup_code = array();

														foreach($sup_data as $sup_dat)
															{
																$sup_code[] = $sup_dat['supplier_code'];
															}

														$stock = CheckStockbyItem($item);
														$stock_entry = (isset($stock->SUMA) ? $stock->SUMA : 0);
														$stock_issue = (isset($stock->SUMB) ? $stock->SUMB : 0);
				
														$spo_qty = Get_Total_SPO_QTY($item);
														$order_balance = GetOrderInHand($item);
														$total_order = Get_Total_Order($item);

                                            			//$shipped_qty = invoiced_quantity($item['cust_pi_id'], $item['item_id']);
                                            ?>
												<tr>

													<td><?php echo $i; ?></td>
													<td><?=GetItemData($item)->ITEM_CODE;?></td>
													<td><?=GetItemData($item)->ITEM_DESC;?></td>
													<td><?=GetItemData($item)->MANUFACTURING_TIMEFRAME;?></td>
													<td><?php echo implode(", ",$sup_code); ?></td>
													<td><?php echo $stock_entry - $stock_issue; ?></td>
													<td><?php echo $spo_qty; ?></td>
													<td><?php echo $total_order; ?></td>
													<td><?php echo $order_balance; ?></td>
													<td><?php  ?></td>
													<td></td>
												</tr>
                                            <?php $i++; endforeach; } ?>


                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>Item#</th>
                                                <th>Item Description</th>
                                                <th>Manufacturing Timeframe</th>
                                            	<th>Supplier Code</th>
                                            	<th>Quantity In Stock</th>
                                                <th>Supplier PO Qty</th>
                                                <th>Total Customer Order</th>
                                                <th>Order Balance</th>
                                                <th>YTDS Previous Year</th>
                                                <th>YTD Sold Qty</th>
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

        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

        <script type="text/javascript">

            //var data = [{ id: 0, text: 'enhancement' }, { id: 1, text: 'bug' }, { id: 2, text: 'duplicate' }, { id: 3, text: 'invalid' }, { id: 4, text: 'wontfix' }];
            $(".item-ajax").select2({

              ajax: {
                      // The number of milliseconds to wait for the user to stop typing before
                      // issuing the ajax request.
                      delay: 250,
                      dataType: 'json',
                      url: '<?php echo base_url('item/itemJson'); ?>',
                      // You can pass custom data into the request based on the parameters used to
                      // make the request. For `GET` requests, the default method, these are the
                      // query parameters that are appended to the url. For `POST` requests, this
                      // is the form data that will be passed into the request. For other requests,
                      // the data returned from here should be customized based on what jQuery and
                      // your server are expecting.
                      //
                      // @param params The object containing the parameters used to generate the
                      //   request.
                      // @returns Data to be directly passed into the request.
                      data: function (params) {
                        var queryParameters = {
                          q: params.term
                        }

                        return queryParameters;
                      },

                      // @param data The data as it is returned directly by jQuery.
                      // @returns An object containing the results data as well as any required
                      //   metadata that is used by plugins. The object should contain an array of
                      //   data objects as the `results` key.
                      processResults: function (data) {
                        return {
                          results: data.result
                        };
                      },

                    },
                    placeholder: 'Search for item(s)',
                    minimumInputLength: 1,
          });

        </script>

       <?php if( empty($_POST) || isset($_POST['all']) ) : ?>
       
			<script type="text/javascript">
		
				$(document).ready(function()
					{
						var dataTable = $('#item_pending').DataTable({
							"processing": true,
								"serverSide": true,
								"order":[],
								"ajax":{
									url: "<?php echo base_url('report/fetch_items') ?>",
									type: "POST"
								},
								"aoColumnDefs": [
									{ 'bSortable': false, 'aTargets': [ 'nosort' ] }
								],
								"columnDefs": [
									{
										"targets": [ 0 ], //first column / numbering column
										"orderable": false, //set not orderable
									},
								],
							});
					});
			</script>
			
		<?php endif; ?>
		
		<script type="text/javascript">
            // $("#checkbox").click(function(){
// 				alert('asd');
// 				if($("#checkbox").is(':checked') ){
// 					$("#sv_items > option").prop("selected","selected");
// 					$("#sv_items").trigger("change");
// 				}else{
// 					$("#sv_items > option").removeAttr("selected");
// 					$("#sv_items").trigger("change");
// 				 }
// 			});

            $(document).ready(function() {
                $(".sv_customer").change(function(){

                    var customer_id = $(this).val();

                    $.ajax({
                        url: '/report/CustomerCPI',
                        data: {'customer_id': customer_id},
                        type: "post",
                        success: function(data){

                            $('.customer_pi').removeAttr('disabled');
                            $(".customer_pi").select2("destroy");
                            $('.customer_pi').html(data);
                            $(".customer_pi").select2();

                        }
                    });
                });
            });
        </script>
    </body>
</html>
