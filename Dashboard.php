
<?php 
session_start();

if($_SESSION['Loggedinas']){
	
}
else{
	 header("Location:index.html");
}
include 'common.php'; 

?>
<style>
.cbiweb {
	width:100%;
	height:900px;
}
#page-top {
    background-color: #F40303 !important;
}
</style>
            <!-- Section with applicants and courses containers --> 
<iframe src="https://www.cbi-electric.com.au/" class="cbiweb"></iframe>
<?php include 'loading.php'; ?>
        </div>
    </body>
</html>