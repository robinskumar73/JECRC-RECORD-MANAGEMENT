<?php

include_once 'modules/loginscript/include/processes.php';
$Login_Process = new Login_Process;
if($Login_Process->check_status($_SERVER['SCRIPT_NAME']))
{

?>

<?php
require_once 'modules/header.php';
?>

<?php
//Show this only if user is admin..
 if ($_SESSION['admin'] == 1){
	
?>

<?php
include_once 'modules/loadingbar.php';

?>

<div class="container-fluid">

	<div class="row ">
    
   		 <div class="col-sm-2 col-md-2 sidebar">
          	 <?
				//adding the left hook ....
				include "modules/admin-left-hook.php";
		 ?>
        </div><!--End of sidebar-->
        <div class="col-sm-10 col-sm-offset-2 col-md-10 col-md-offset-2 ">
        	
            <?
				//Adding navbar here..
				include "modules/admin-navbar.php";
			?>
            
            <!----Start of another row --->
            <div>
            
            	<!--DIV FOR DISPAYING STATISTICS-->
            	<div id="jecrc-main-screen" class="col-md-8 statistics  ">
                    <!--AREA FOR DISPLAYING  CENTRE CONTENT-->
                   
                   
                </div>
            
                
                <!--DIV FOR CREATING DEPT AND OTHER FIELDS-->
                <div id="right-side-hook" class="col-md-4">
                	<!--Adding right hook here--->
                    <?php
						//Adding navbar here..
						include "modules/admin-right-hook.php";
					?>
            	</div><!--<!--DIV ENDS FOR CREATING DEPT AND OTHER FIELDS-->

         	</div><!--DIV ENDS FOR ANOTHER ROW-->
		</div><!--END of col-sm-10 col-md-10 class DIV-->
	</div><!--End of Main row div-->
</div><!--End of container-fluid div-->




<?php
require_once 'modules/template.php';
require_once 'modules/footer.php';
?>

<?php
 }
	 else{
		 echo "Error: You are not authorised to view this page..";
	 	header("Location:  http://". $_SERVER['HTTP_HOST'] . "/Manage/modules/faculty.php");
 	}
}
?>
