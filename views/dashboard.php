<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>AdminLTE | Dashboard</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?=base_url();?>admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?=base_url();?>admin/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="<?=base_url();?>admin/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="<?=base_url();?>admin/css/morris/morris.css" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="<?=base_url();?>admin/css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- fullCalendar -->
        <link href="<?=base_url();?>admin/css/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="<?=base_url();?>admin/css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="<?=base_url();?>admin/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
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
        
        <?php $this->load->view('include/header');?>

        <div class="wrapper row-offcanvas row-offcanvas-left">
        
            <?php $this->load->view('include/sidebar');?>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Dashboard
                        <!--<small>Control panel</small>-->
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?=base_url('admin/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                    
                    <?php if( is_UserAllowed('all_item')){ ?>
                    
                        <div class="col-lg-3 col-xs-4">
                            <!-- small box -->
                            <div class="small-box bg-Burgundy">
                                <div class="inner">
                                    <h3>
                                        <?php echo sizeof(GetItem()); ?>
                                    </h3>
                                    <h4>
                                        Items
                                    </h4>
                                </div>
                                <div class="icon">
                                    <img src="../admin/css/images/IMG_5484dashboard100.jpg"/>
                                </div>
                                <a href="<?=base_url('item/listitems');?>" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        
                    <?php } ?>   
                     
					<?php if( is_UserAllowed('all_grn')){ ?>
					
                        <div class="col-lg-3 col-xs-4">
                            <!-- small box -->
                            <div class="small-box bg-Burgundy">
                                <div class="inner">
                                    <h3>
                                        <?php echo sizeof(GetGRNs());?>
                                    </h3>
                                    <h4>
                                        GRNs
                                    </h4>
                                </div>
                                <div class="icon">
                                    <img src="../admin/css/images/Arrows Circle100.png"/>
                                </div>
                                <a href="<?=base_url('grn/grnlist');?>" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                    <?php } ?>
                    
                    <?php if( is_UserAllowed('all_supplier')){ ?>
                    
                        <div class="col-lg-3 col-xs-4">
                            <!-- small box -->
                            <div class="small-box bg-Burgundy">
                                <div class="inner">
                                    <h3>
                                        <?php echo sizeof(GetAllSupplier());?>
                                    </h3>
                                    <h4>
                                        Suppliers
                                    </h4>
                                </div>
                                <div class="icon">
                                     <img src="../admin/css/images/Flag-Of-India100.jpg"/>
                                </div>
                                <a href="<?=base_url('supplier/all_list');?>" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        
                    <?php } ?>
                        
                    <?php if( is_UserAllowed('all_customer')){ ?>
                    
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-Burgundy">
                                <div class="inner">
                                    <h3>
                                        <?php echo sizeof(GetAllCustomer());?>
                                    </h3>
                                    <h4>
                                        Customers
                                    </h4>
                                </div>
                                <div class="icon">
                                    <img src="../admin/css/images/Earth burgundy100.png"/>
                                </div>
                                <a href="<?=base_url('customer/all_list');?>" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        
                     <?php } ?>
                     
                    </div><!-- /.row -->

                    <!-- top row -->
                    <div class="row">
                        <div class="col-xs-12 connectedSortable">
                            
                        </div><!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- Main row -->
                    <div class="row">
                        
                        <?php if( is_UserAllowed('all_item')){ ?>
                        
                        <section class="col-lg-4 connectedSortable">

                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Recent Items</h3>
                                </div>
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width:10%;">S.No</th>
                                                <th>Item Code</th>
                                            </tr>
                                            <?php $i=1; foreach( array_reverse( $items ) as $item ) : if( $i<=10) : ?>
                                                <tr>
                                                    <td style="width:10%;"><?=$i; ?></td>
                                                    <td><a href="<?=base_url('item/view').'/'.$item['ID'];?>"><?=$item['ITEM_CODE'];?></a></td>
                                                </tr>
                                            <?php endif; $i++; endforeach; ?>
                                            <tr>
                                                <th style="width:10%;">S.No</th>
                                                <th>Item Code</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>

                        </section>
                        
                        <?php } ?>
                        
                        <?php if( is_UserAllowed('all_supplier')){ ?>
                        
						<section class="col-lg-4 connectedSortable"> 
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Recent Suppliers</h3>
                                </div>
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width:10%;">S.No</th>
                                                <th>Supplier Name</th>
                                            </tr>
                                            <?php $i=1; foreach( array_reverse( $suppos ) as $suppo ) : if( $i<=10) : ?>
                                                <tr>
                                                    <td style="width:10%;"><?=$i; ?></td>
                                                    <td><?=GetSupplierData( $suppo['id'] )->supplier_name;?></td>
                                                </tr>
                                            <?php endif; $i++; endforeach; ?>
                                            <tr>
                                                <th style="width:10%;">S.No</th>
                                                <th>Supplier Name</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>    

                        </section><!-- /.Left col -->
                        
                        <?php } ?>
                        
                        <?php if( is_UserAllowed('all_customer')){ ?>
                        
                        <section class="col-lg-4 connectedSortable"> 

                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Recent Customers</h3>
                                </div>
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width:10%;">S.No</th>
                                                <th>Customer Name</th>
                                            </tr>
                                            <?php $i=1; foreach( array_reverse( $custpos ) as $custpo ) : if( $i<=10) : ?>
                                                <tr>
                                                    <td style="width:10%;"><?=$i; ?></td>
                                                    <td><?=$custpo['name'];?></td>
                                                </tr>
                                            <?php endif; $i++; endforeach; ?>
                                            <tr>
                                                <th style="width:10%;">S.No</th>
                                                <th>Customer Name</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </section>
                        
                        <?php } ?>
                        
                        <?php if( is_UserAllowed('all_grn')){ ?>
                        
                        <section class="col-lg-4 connectedSortable">

                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Recent GRN's</h3>
                                </div>
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width:10%;">S.No</th>
                                                <th>GRN Number</th>
                                            </tr>
                                            <?php $i=1; foreach( array_reverse( $grns ) as $grn ) : if( $i<=10) : ?>
                                                <tr>
                                                    <td style="width:10%;"><?=$i; ?></td>
                                                    <td><?=$grn['grn_number'];?></td>
                                                </tr>
                                            <?php endif; $i++; endforeach; ?>
                                            <tr>
                                                <th style="width:10%;">S.No</th>
                                                <th>GRN Number</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>

                        </section>
                        
                        <?php } ?>
                        
                        <?php if( is_UserAllowed('all_spo')){ ?>
                        
                    	<section class="col-lg-4 connectedSortable">

                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Recent SPO</h3>
                                </div>
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width:10%;">S.No</th>
                                                <th>PO Number</th>
                                            </tr>
                                            <?php $i=1; foreach( array_reverse( $spos ) as $spo ) : if( $i<=10) : ?>
                                                <tr>
                                                    <td style="width:10%;"><?=$i; ?></td>
                                                    <td><?=$spo['po_num'];?></td>
                                                </tr>
                                            <?php endif; $i++; endforeach; ?>
                                            <tr>
                                                <th style="width:10%;">S.No</th>
                                                <th>PO Number</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>

                        </section>
                       
                       <?php } ?> 
                       
                       <?php if( is_UserAllowed('all_CPI')){ ?>
                       
                        <section class="col-lg-4 connectedSortable">

                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Recent CPI</h3>
                                </div>
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width:10%;">S.No</th>
                                                <th>PI Number</th>
                                            </tr>
                                            <?php $i=1; foreach( array_reverse( $cpis ) as $cpi ) : if( $i<=10) : ?>
                                                <tr>
                                                    <td style="width:10%;"><?=$i; ?></td>
                                                    <td><?=$cpi['pi_num'];?></td>
                                                </tr>
                                            <?php endif; $i++; endforeach; ?>
                                            <tr>
                                                <th style="width:10%;">S.No</th>
                                                <th>PI Number</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>

                        </section>
                        
                        <?php } ?>
                        
                        <?php if( is_UserAllowed('all_pl')){ ?>
                        
                        <section class="col-lg-4 connectedSortable">

                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Recent Invoice</h3>
                                </div>
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width:10%;">S.No</th>
                                                <th>Invoice Number</th>
                                            </tr>
                                            <tr>
                                                <th style="width:10%;">S.No</th>
                                                <th>Invoice Number</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>

                        </section>
                        
                       <?php } ?> 
                    </div><!-- /.row (main row) -->

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        <?php $this->load->view('include/footer');?>
        <!-- add new calendar event modal -->


        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- jQuery UI 1.10.3 -->
        <script src="<?=base_url();?>admin/js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="<?=base_url();?>admin/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- Morris.js charts -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="<?=base_url();?>admin/js/plugins/morris/morris.min.js" type="text/javascript"></script>
        <!-- Sparkline -->
        <script src="<?=base_url();?>admin/js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
        <!-- jvectormap -->
        <script src="<?=base_url();?>admin/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
        <script src="<?=base_url();?>admin/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
        <!-- fullCalendar -->
        <script src="<?=base_url();?>admin/js/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <!-- jQuery Knob Chart -->
        <script src="<?=base_url();?>admin/js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
        <!-- daterangepicker -->
        <script src="<?=base_url();?>admin/js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="<?=base_url();?>admin/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="<?=base_url();?>admin/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

        <!-- AdminLTE App -->
        <script src="<?=base_url();?>admin/js/AdminLTE/app.js" type="text/javascript"></script>
        
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="<?=base_url();?>admin/js/AdminLTE/dashboard.js" type="text/javascript"></script>        

    </body>
</html>