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
                        <div class="col-md-9">
                            <!-- general form elements disabled -->
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title"><?=$title;?></h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <?php echo form_error('validate'); ?>
                                    <form action="<?=base_url('user/adduser');?>" method="post">
                                        <?php if( $msg ) { ?>
                                            <div class="col-md-12" style="padding-bottom: 15px;">
                                                <?php echo $msg; ?>
                                            </div>
                                        <?php } ?>
                                        <div class="form-group col-lg-6">
                                            <label>Email <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="email" value="<?php echo $this->input->post('email')?>"  placeholder="Enter Email"/>
                                            <?php echo form_error('email'); ?>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label>Password <span style="color:red;">*</span></label>
                                            <input type="Password" class="form-control" name="password"  value="<?php echo $this->input->post('password')?>" placeholder="Enter Password"/>
                                            <?php echo form_error('password'); ?>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label>Name <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="name"  value="<?php echo $this->input->post('name')?>" placeholder="Enter Full Name"/>
                                            <?php echo form_error('name'); ?>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label>Mobile <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="mobile"  value="<?php echo $this->input->post('mobile')?>" placeholder="Enter Mobile"/>
                                            <?php echo form_error('mobile'); ?>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label>Designation <span style="color:red;">*</span></label>
                                            <select class="form-control" name="designation">
                                                <option value="">Select Designation</option>
                                                <?php foreach( $designations as $designation ) :  ?>
                                                    <option <?php if( $this->input->post('designation') == $designation['id']) {  echo "selected"; } ?> value="<?=$designation['id'];?>"><?=$designation['designation_name'];?></option>
                                                <?php endforeach; ?>  
                                            </select>
                                            <?php echo form_error('designation'); ?>
                                        </div>
                                        
                                        <div class="form-group col-lg-6">
                                            <label>Select Roles <span style="color:red;">*</span></label>
                                            <select class="form-control" name="role">
                                                <option value="">Select Role</option>
                                                <?php foreach( $roles as $role ) :  ?>
                                                    <option <?php if( $this->input->post('role') == $role['id']) {  echo "selected"; } ?> value="<?=$role['id'];?>"><?=$role['role'];?></option>
                                                <?php endforeach; ?>  
                                            </select>
                                            <?php echo form_error('role'); ?>
                                        </div>

                                        <div class="form-group col-lg-12">    
                                            <input type="submit" class="btn btn-info" value="Submit">
                                        </div>
                                        <div style="clear:both;"></div>    
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
    </body>
</html>