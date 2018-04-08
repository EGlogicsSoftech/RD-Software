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
                                    <h3 class="box-title"><?=$form_title;?></h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <?php echo form_error('validate'); ?>
                                    
                                    <form action="<?=base_url('item/update_outer/'.$outerbox->ID);?>" method="post">
                                    
                                        <div class="form-group col-lg-12">
                                            <label>Outer Box Size <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="ob_size" value="<?php echo $outerbox->OUTER_BOX_SIZE; ?>"  placeholder="Outer Box Size"/>
                                            <?php echo form_error('ob_size'); ?>
                                        </div>
                                        
                                         <div class="form-group col-lg-12">
                                            <label>CBM <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="ob_cbm" value="<?php echo $outerbox->CBM; ?>"  placeholder="cbm"/>
                                            <?php echo form_error('ob_cbm'); ?>
                                        </div>
 
                                        <div class="form-group col-lg-12">    
                                            <input type="submit" class="btn btn-info" value="Update">
                                        </div>
                                        <div style="clear:both;"></div>  
                                          
                                    </form>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!--/.col (right) -->

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
                                                <th>ID</th>
                                                <th>Outer Box Size</th>
                                                <th>CBM</th>
                                                <?php if( is_UserAllowed('update_outer_box')){ ?>
                                                	<th>Update</th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=1; foreach($OuterArray as $Outer) { ?>
                                                <tr>
                                                    <td><?=$i;?></td>
                                                    <td><?=$Outer['ID'];?></td>
                                                    <td><?=$Outer['OUTER_BOX_SIZE'];?></td>
                                                    <td><?=$Outer['CBM'];?></td>
                                                    <?php if( is_UserAllowed('update_outer_box')){ ?>
                                                    	<td><a href="<?=base_url('item/updateouter').'/'.$Outer['ID'];?>">Update</a></td>
                                                	<?php } ?>
                                                </tr>
                                            <?php $i++; }?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                            	<th>S.No</th>
                                                <th>ID</th>
                                                <th>Outer Box Size</th>
                                                <th>CBM</th>
                                                <?php if( is_UserAllowed('update_outer_box')){ ?>
                                                	<th>Update</th>
                                                <?php } ?>
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