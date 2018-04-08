<footer style="background: #800020;">
<div class="copyright">
	<span style="float:left;">©2016 Rickshaw Delivery All Rights Reserved  </span>
	<span><b>Developed & Maintained By</b> - <a href="http://www.eglogics.com/" target="_blank">EGlogics Softech Pvt. Ltd.</a></span>
</div>
</footer>
<style>
	.copyright
	{
	height: 50px;
    margin-bottom: 0;
    margin-left: 220px;
    z-index: 0;
    background: #e5c37f;
	padding: 17px;
	}
	
	.copyright span{float:right;color: #800020;}
	.copyright span a{color:#800020;}
</style> 

<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".slide-toggle").click(function(){
            $(".box1").animate({
                width: "toggle"
            });
        });
    });
</script>
<script>
function myFunction(x) {
    x.classList.toggle("change");
}
</script>