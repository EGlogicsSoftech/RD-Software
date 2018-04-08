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

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <!-- right column -->
                        <div class="col-md-9">
                            <!-- general form elements disabled -->
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">Customer Details</h3>
                                    <div class="heading_right_box">
                                    	<?php if( is_UserAllowed('update_customer')){ ?>
                                    		<a style="color:orange;" href="/customer/manage_customer/<?php echo $customer->id; ?>">Update</a> <!-- | <a style="color:red;" href="">Remove</a> -->
                                    	<?php } ?>
                                    </div>
                                </div><!-- /.box-header --> 

                                <div class="box-body table-responsive">
                                    <table id="example1" class="table sv_table_heading table-bordered table-hover">
                                        <tbody>
 
                                            <tr>
                                                <th style="width: 25%;">Customer Code</th>
                                                <td><?php echo $customer->code; ?></td>
                                            </tr> 
                                             <tr>
                                                <th style="width: 25%;">Oceanic Customer</th>
                                                <td><?php if($customer->oceanic_client == 1 ) : echo "Yes"; else: echo "No"; endif; ?></td>
                                            </tr>  
                                            <tr>
                                                <th style="width: 25%;">Customer Name</th>
                                                <td><?php echo $customer->name; ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 25%;">Email</th>
                                                <td><?php echo $customer->email; ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 25%;">Office Phone</th>
                                                <td><?php echo $customer->phone; ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 25%;">Contact Person</th>
                                                <td><?php echo $customer->contact_person; ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 25%;">Color</th>
                                                <td><?php echo $customer->color; ?><span style="width:20px;height:10px;display: inline-table; margin-left: 10px; background-color:<?php echo $customer->color; ?>;">&nbsp;</span></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 25%;">Shipping Address</th>
                                                <td><?php echo $customer->cust_add; ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 25%;">Billing Address</th>
                                                <td><?php echo $customer->billing_add; ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 25%;">Shipping Term</th>
                                                <td><?php echo $customer->shipping_term; ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 25%;">Customer Description</th>
                                                <td><?php echo $customer->description; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>   
  
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