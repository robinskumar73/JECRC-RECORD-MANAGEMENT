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
<script src="static/jquery/jquery-1.7.2.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script type="text/javascript" src="static/bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript" src="static/dependencies/underscore-min.js"></script>
<script type="text/javascript" src="static/dependencies/backbone-min.js"></script>
<script type="text/javascript" src="static/typeahead.min.js"></script>
<!--Now loading MVC related files -->
<script type="text/javascript" src="static/js/models/jecrc-model.js"></script>
<script type="text/javascript" src="static/js/collections/jecrc-collection.min.js"></script>
<script type="text/javascript" src="static/js/views/app-pages.js"></script>
<script type="text/javascript" src="static/js/views/jecrc-view.js"></script>
<script type="text/javascript" src="static/js/routers/jecrc-routers.js"></script>
<script type="text/javascript" src="static/js/app-main/jecrc-app-main.js"></script>    
<script type="text/javascript" src="static/customscript/myscript.js"></script>
<script type="text/javascript" src="static/md5/md5-google.js"></script>

</body>
</html>
