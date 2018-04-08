<?php $username=$this->db->get_where('login',array('id'=>$this->session->userdata('id')))->row('name'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
// Making 2 variable month and day
var monthNames = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ]; 
var dayNames= ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]

// make single object
var newDate = new Date();
// make current time
newDate.setDate(newDate.getDate());
// setting date and time
$('#Date').html(dayNames[newDate.getDay()] + " " + newDate.getDate() + ' ' + monthNames[newDate.getMonth()] + ' ' + newDate.getFullYear());

setInterval( function() {
// Create a newDate() object and extract the seconds of the current time on the visitor's
var seconds = new Date().getSeconds();
// Add a leading zero to seconds value
$("#sec").html(( seconds < 10 ? "0" : "" ) + seconds);
},1000);

setInterval( function() {
// Create a newDate() object and extract the minutes of the current time on the visitor's
var minutes = new Date().getMinutes();
// Add a leading zero to the minutes value
$("#min").html(( minutes < 10 ? "0" : "" ) + minutes);
},1000);

setInterval( function() {
// Create a newDate() object and extract the hours of the current time on the visitor's
var hours = new Date().getHours();
// Add a leading zero to the hours value
$("#hours").html(( hours < 10 ? "0" : "" ) + hours);
}, 1000); 
});
</script>
<style>
    
.clock { width: 360px; color: #fff; float: left;  margin:12px 12px 0;font-weight: bold;}
.clock ul li { display: inline; font-size: 16px; float:left; }
#Date { font-size: 16px;float: left; }
#point {
position: relative;
-moz-animation: mymove 1s ease infinite;
-webkit-animation: mymove 1s ease infinite;
padding-left: 10px;
padding-right: 10px
}
</style>
<header class="header">
	<button type="button" class="slide-toggle"  onclick="myFunction(this)">
		<div class="bar1"></div>
		<div class="bar2"></div>
		<div class="bar3"></div>
	</button>
    <a href="<?=base_url('admin/dashboard');?>" class="logo">	
        <!-- Add the class icon to your logo image or logo icon to add the margining -->
        Rickshaw Delivery
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <div class="clock">
            <div id="Date"></div>
            <ul>
				<span style="padding-left: 10px;padding-right: 10px;float: left;">|</span>
                <li id="hours"></li>
                <li id="point">:</li>
                <li id="min"></li>
                <li id="point">:</li>
                <li id="sec"></li>
            </ul>
        </div>
        <div class="navbar-right">
            <ul class="nav navbar-nav navvv">
                <!-- Messages: style can be found in dropdown.less-->
                <style>
					.navvv li a 
					{
						display: -webkit-inline-box;
					}
					.skin-black ul.nav.navbar-nav.navvv li a:hover {
						background: none;
					}
					
				</style>
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-user"></i>
                        <span><?=$username?> <!--<i class="caret"></i>--></span>
                    </a> |
                    <a href="<?=base_url('admin/logout')?>">Sign out</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
