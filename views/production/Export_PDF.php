<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
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
        
        <div class="wrapper row-offcanvas row-offcanvas-left">
        	<section class="content">
				<div class="row">
					<div class="col-xs-12 table-responsive">	
						<?php	$post = unserialize($post_data);
								
								$issue_item_id = $post['issue_item_id'];
								$issue_box_num = $post['issue_box_num']; 
								$issue_qty = $post['issue_qty'];
						?>
						<table id="example1" class="table sv_table_heading table-bordered table-hover">
							<thead>
								<tr>
									<th style="border:1px solid #000;">S.No</th>
									<th style="border:1px solid #000;">Item Code</th>
									<th style="border:1px solid #000;">Box Number</th>
									<th style="border:1px solid #000;">Quantity</th>
								</tr>
							</thead>
							<tbody> 
									
								<?php $j=1; for($i=0; $i<count($issue_qty); $i++)
									{
								?>
								<tr>
									<td style="border:1px solid #000;"><?=$j;?></td>
									<td style="border:1px solid #000;"><?php echo GetItemData( $issue_item_id[$i] )->ITEM_CODE; ?></td>
									<td style="border:1px solid #000;"><?php echo $issue_box_num[$i]; ?></td>
									<td style="border:1px solid #000;"><?php echo $issue_qty[$i]; ?></td>
								</tr>    
								<?php $j++; } ?>
								</tbody>
							</table>
						</div>        
					</div>
				</section><!-- /.content -->
        	</div><!-- ./wrapper -->
        	
        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="<?=base_url();?>admin/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="<?=base_url();?>admin/js/AdminLTE/app.js" type="text/javascript"></script>

    </body>
</html>