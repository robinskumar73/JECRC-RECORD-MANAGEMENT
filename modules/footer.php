<script>
<?php
//Getting faculty name
$first_name    = $_SESSION['first_name'];
$last_name     = $_SESSION['last_name'];
$id            = $_SESSION['id'];
$username      = $_SESSION['username'];
$department_id = $_SESSION['department_id'];
$admin         = $_SESSION['admin'];
$admin_type    = $_SESSION['admin_type'];
?>
var first_name = "<?php echo $first_name ; ?>" ;
var last_name = "<?php echo $last_name ; ?>" ;
var id = "<?php echo $id ; ?>" ;
var username = "<?php echo $username ; ?>" ;
var department_id = "<?php echo $department_id ; ?>" ;
var admin  = "<?php echo $admin ?>";
var admin_type  = "<?php echo $admin_type ?>";

var faculty = {
	"id": id,
	"first_name": 	first_name,
	"last_name": last_name,
	"username" : username,
	"department_id" : department_id,
	"admin"          : admin,
	"admin_type"       : admin_type	
}



</script>

<!--script area-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="Manage/static/jquery/jquery-1.7.2.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script type="text/javascript" src="Manage/static/bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript" src="Manage/static/dependencies/underscore-min.js"></script>
<script type="text/javascript" src="Manage/static/dependencies/backbone-min.js"></script>
<script type="text/javascript" src="Manage/static/typeahead.min.js"></script>
<!--Now loading MVC related files -->
<script type="text/javascript" src="Manage/static/js/models/jecrc-model.min.js"></script>
<script type="text/javascript" src="Manage/static/js/collections/jecrc-collection.min.js"></script>
<script type="text/javascript"  src="Manage/static/js/views/app-pages.min.js"></script>
<script type="text/javascript" src="Manage/static/js/views/jecrc-view.min.js"></script>
<script type="text/javascript" src="Manage/static/js/routers/jecrc-routers.min.js"></script>
<script type="text/javascript" src="Manage/static/js/app-main/jecrc-app-main.min.js"></script>    
<script type="text/javascript" src="Manage/static/customscript/myscript.min.js"></script>
<script type="text/javascript" src="Manage/static/md5/md5-google.js"></script>

</body>
</html>