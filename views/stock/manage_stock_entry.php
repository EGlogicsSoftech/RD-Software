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

        <link href="<?=base_url();?>admin/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css" />

        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

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
                                    <h3 class="box-title">General Elements</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <?php echo form_error('validate'); ?>
                                    <form action="<?=base_url('stock/SaveStockEntry');?>" method="post">
                                        
                                        <div class="form-group col-md-6">
                                            <label>GRN Number</label>
                                            <select class="form-control" name="grn_number">
                                                <option value="">Select GRN Number</option>
                                                <?php foreach( $grns as $grn ) : ?>
                                                    <option value="<?=$grn['id'];?>"><?=$grn['grn_number'];?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php echo form_error('grn_number'); ?>
                                        </div>

                                        <div class="form-group col-md-6">&nbsp;</div>

                                        <div class="stck_register_repeater"> 
                                            <div class="box-header">
                                                <h3 class="box-title">Sub Items</h3>
                                            </div><!-- /.box-header -->
                                
                                            <div data-repeater-list="stock_entry">
                                                <div data-repeater-item>

                                                    <div class="form-group col-md-4">
                                                        <input type="text" class="form-control" name="bx_num" value="<?php echo $this->input->post('bx_num')?>" placeholder="Box Number" />
                                                        <?php echo form_error('bx_num'); ?>
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <select class="form-control" name="item" style="width:100%;">
                                                            <option value="">Select Items</option>
                                                            <?php foreach( $items as $item ) :  ?>
                                                                <option value="<?=$item['ID'];?>"><?=$item['ITEM_NAME'].' ( '.$item['ITEM_CODE'].' ) ';?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <?php echo form_error('item'); ?>
                                                    </div>

                                                    <div class="form-group col-md-3">
                                                        <input type="text" class="form-control" name="qty" value="<?php echo $this->input->post('qty')?>" placeholder="Quantity" />
                                                        <?php echo form_error('qty'); ?>
                                                    </div>

                                                    <div class="col-md-1">
                                                        <input type="hidden" name="country" value="<?php echo $this->input->post('qty')?>">
                                                        <input class="cross-btn" data-repeater-delete type="button" value=""/>
                                                        <i data-repeater-delete class="fa fa-times crooss" aria-hidden="true"></i>
                                                    </div>

                                                    <div style="clear:both;"></div>
                                                </div>
                                            </div>

                                            <div class="form-group"> 
                                                <input class="btn-green" data-repeater-create type="button" value=""/>
                                                <i class="fa fa-plus green-btn-icn" data-repeater-create aria-hidden="true"></i>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">    
                                            <input type="submit" class="btn btn-info" value="Update">
                                        </div>
                                        <div style="clear:both;"></div> 

                                        <style>
                                            .stck_register_repeater
                                            {  
                                                clear:both;
                                            }
                                            .cross-btn
                                            {
                                                background: #f32929;
                                                border: 1px solid #f32929;
                                                padding: 12px 16px 0;
                                            }
                                            .crooss
                                            {
                                                position: absolute;
                                                left: 25px;
                                                top: 9px;
                                                color: #fff;
                                                font-size: 18px;
                                                cursor:pointer;
                                            }
                                            .btn-green
                                            {
                                                float: right;
                                                margin-right: 83px;
                                                background: #149655;
                                                border: 1px solid #149655;
                                                padding: 12px 16px 0;
                                            }
                                            .green-btn-icn
                                            {
                                                position: absolute;
                                                right: 102px;
                                                bottom: 47px;
                                                color: #fff;
                                                font-size: 18px;
                                                cursor:pointer;
                                            }
                                        </style>   
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

        <script src="<?=base_url();?>admin/js/bootstrap-datetimepicker.js" type="text/javascript"></script>

        <script src="<?=base_url();?>admin/js/jquery.repeater.js" type="text/javascript"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

        <script type="text/javascript">

            //$('#datetimepicker1').datetimepicker();

            $('select').select2();

            $(document).ready(function () 
            {
                $('.stck_register_repeater').repeater({
                    // (Optional)
                    // "defaultValues" sets the values of added items.  The keys of
                    // defaultValues refer to the value of the input's name attribute.
                    // If a default value is not specified for an input, then it will
                    // have its value cleared.
                    defaultValues: {
                        'text-input': 'foo'
                    },
                    // (Optional)
                    // "show" is called just after an item is added.  The item is hidden
                    // at this point.  If a show callback is not given the item will
                    // have $(this).show() called on it.
                    show: function () {
                        $(this).slideDown();
                        $(this).find('select').select2();
                    },
                    // (Optional)
                    // "hide" is called when a user clicks on a data-repeater-delete
                    // element.  The item is still visible.  "hide" is passed a function
                    // as its first argument which will properly remove the item.
                    // "hide" allows for a confirmation step, to send a delete request
                    // to the server, etc.  If a hide callback is not given the item
                    // will be deleted.
                    hide: function (deleteElement) {
                        if(confirm('Are you sure you want to delete this element?')) {
                            $(this).slideUp(deleteElement);
                        }
                    }
                })
                
                $('#item_assembled').on('ifChecked', function(event)
                {
                    //alert(event.type + ' callback');
                    $(".sv_repeater").show("fast");
                });
                
                $('#item_assembled').on('ifUnchecked', function(event)
                {
                    //alert(event.type + ' callback');
                    $(".sv_repeater").hide("fast");
                });
                
                
            });


        </script>
    </body>
</html>