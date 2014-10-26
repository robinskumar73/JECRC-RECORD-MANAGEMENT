<?php

	require ('../Slim/Slim.php');
	include_once 'database_connection.php';
	include_once 'helper_department_function.php';
	//Adding the cache for session limiter...
	session_cache_limiter(false);
	session_start();

	\Slim\Slim::registerAutoloader();

	// create new Slim instance
	$app = new \Slim\Slim();
	

	// Get Methods of Department,Batch,Section,Semester
	$app->get('/department', 'getAllDepartment');
	$app->get('/subject/:key', 'getSubject');
	$app->get('/department/:deptId','getDepartmentById');
	$app->get('/entry/department/:dept_name/semester/:sem/section/:sec_name','getEntryBysection');
	$app->get('/entry/department/:dept_name','getEntryBydept');
	$app->get('/entry/department/:dept_name/year/:year','getEntryByYear');
	$app->get('/faculty/department/:dept_name/semester/:semester_name/section/:section_name', 'getFacultyTodayEntry');
	//Getting the log details for the faculty log...
	//Here id is the faculty id..
	$app->get('/entry/faculty/:id/daysEntry','getAllFacultyLogEntry');
	//Route for fetching a peroid by its id..
	$app->get('/entry/:id','fetchPeriod');
	
	$app->get('/department/:deptId/semester/:semId','getSemesterById');
	$app->get('/department/:deptId/semester/:semId/section','getAllSection');
	$app->get('/department/:deptId/semester/:semId/section/:secId','getSectionById');
	$app->get('/department/:deptId/semester/:semId/section/:secId/batch','getAllBatch');
	$app->get('/department/:deptId/semester/:semId/section/:secId/batch/:batchId','getBatchById');
	$app->get('/branch/', 'getBranch');
	//Get Methods End Here
	
	//Post Methods of Department,Batch,Semester,Section
	$app->post('/department','addDepartment');
	$app->post('/entry/department/daysEntry','addEntryBysection');
	
	$app->post('/branch/', 'addBranch');
	
	//Delete methods of Department..
	$app->delete('/department/:deptId', 'deleteDepartment');
	//Delete period-faculty entry
	$app->delete('/entry/faculty/:id/daysEntry/:entryId','deleteEntry');
	
	//Update method for updating the period entry..
	$app->put('/entry/faculty/:id/daysEntry/:entryId', 'updateEntry');
	
	$app->run();
	
?>

<?php

	include_once 'loginscript/include/processes.php';
	$Login_Process = new Login_Process;
	$Login_Process->check_status($_SERVER['SCRIPT_NAME']);

?>




<?php

	
	//function to get all department start here
	function getAllDepartment() {
		$sql = "SELECT * FROM department";
		try {
			$db = getConnection();
			$stmt = $db->query($sql);
			$dept = $stmt->fetchAll(PDO::FETCH_OBJ);
			$db = null;
			echo json_encode($dept);
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
			header("Server Error");
		}
	}//function to get all department ends here
	
	
	
	function getBranch(){
			
		$sql = "SELECT * FROM branch";
		try {
			$db = getConnection();
			$stmt = $db->query($sql);
			$dept = $stmt->fetchAll(PDO::FETCH_OBJ);
			$db = null;
			echo json_encode($dept);
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
			header("Server Error");
		}
		
	}
	
	
	function getSubject($key){
		  $sql = "SELECT * FROM `subject` WHERE `subject` LIKE :key LIMIT 0, 30 ";
			$key = $key."%";
			try {
				$db = getConnection();
				$stmt = $db->prepare($sql);
				$stmt->bindParam("key", $key);
				$stmt->execute();
				$dept = $stmt->fetchAll(PDO::FETCH_OBJ);
				$db = null;
				echo json_encode($dept);
			} catch(PDOException $e) {
				echo '{"error":{"text":'. $e->getMessage() .'}}';
				header("Server Error");
			}
	}

	//$app->get('/entry/:id','fetchPeriod');
	//Function for fetching the period by its id.
 	function fetchPeriod($id)
	{
		//First fetching items from period entry....
		$sql = "SELECT * FROM `period_entry` WHERE `id` = :id ";
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("id", $id);
			$stmt->execute();
			$dept = $stmt->fetchObject();
			$db = null;
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
			header("Server Error");
		}
		//Now fetching the days_entry..
		$sql = "SELECT * FROM `days_entry` WHERE `id` = :id ";
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("id", $dept->days_entry_id);
			$stmt->execute();
			$days_entry = $stmt->fetchObject();
			$db = null;
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
			header("Server Error");
		}
		//Now fetching the period...
		$period = getPeriod($id);
		//Forming the json object..
		$dept->period 			= $period;
		$dept->department_id 	= $days_entry->department_id;
		$dept->semester_id 		= $days_entry->semester_id; 
		$dept->section_name 	= $days_entry->section_name;
		$dept->date 			= $days_entry->date;
		
		//Now returning the json response.....
		echo json_encode($dept);
	}//End of fetch period..
	
	
	
	
	
	
	
	//get faculty entry by date..
	//faculty/department/:dept_name/semester/:semester_name/section/:section_name/date/:today_date', 'getFacultyTodayEntry'
	function getFacultyTodayEntry($dept_name, $semester_name, $section_name)
	{
		//$dept_id = getDepartmentId($dept_name);
		$dept = days_entry_by_section_and_date($semester_name, $section_name, $dept_name );
		$dept_ = process_days_entry_obj($dept);
		echo json_encode($dept_);		
	}

	
	
	
	//Get days entry by section..
	function getEntryBysection($dept_name, $sem, $sec_name)
	{
		
		//$dept_id = getDepartmentId($dept_name);
		$dept = days_entry_by_section($sem, $sec_name, $dept_name );
		$dept = process_days_entry_obj($dept);
		
		echo json_encode($dept);		
	}
	
	function getEntryBydept($dept_name)
	{
		//$dept_id = getDepartmentId($dept_name);
		$dept = days_entry_by_dept($dept_name);
		$dept = process_days_entry_obj($dept);
		
		echo json_encode($dept);
		
	}
	
	function getEntryByYear($dept_name, $year)
	{
		//$dept_id = getDepartmentId($dept_name);
		$dept = days_entry_by_year($year, $dept_name);
		$dept_ = process_days_entry_obj($dept);
		
		echo json_encode($dept_);
		
	}
	
	
	//function to get department by id start here
  function getDepartmentById($deptId) {
		$sql = "SELECT name FROM department WHERE id=:deptId";
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("deptId", $deptId);
			$stmt->execute();
			$dept = $stmt->fetchObject();
			$db = null;
			echo json_encode($dept);
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
			header("Server Error");
		}
	}//function to get department by id end here	
	
	
	
	
	

	//function to get semester by id start here
		function getSemesterById($deptId,$semId) {
			$sql = " SELECT semester_name FROM semester
					WHERE id=(SELECT semester_id FROM branch WHERE
					semester_id = :semId
					AND department_id = :deptId);";
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("deptId", $deptId);
			$stmt->bindParam("semId",$semId);
			$stmt->execute();
			$dept = $stmt->fetchObject();
			$db = null;
			echo json_encode($dept);
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
			header("Server Error");
		}
	}//function to get semester by id end here
	
	
	//function to get all section start here
		function getAllSection($deptId,$semId) {
			$sql = "SELECT section_name FROM section
					WHERE id=(SELECT section_id FROM branch WHERE
					semester_id = :semId
					AND department_id = :deptId);";
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("deptId", $deptId);
			$stmt->bindParam("semId",$semId);
			$stmt->execute();
			$dept = $stmt->fetchObject();
			$db = null;
			echo json_encode($dept);
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
			header("Server Error");
		}
	}//function to get all section end here
	
	
	//function to get section by id start here
		function getSectionById($deptId,$semId,$secId) {
			$sql = "SELECT section_name
					FROM section
					WHERE id = ( SELECT section_id FROM branch
								WHERE section_id = :secId
								AND semester_id = :semId
								AND department_id = :deptId )";
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("deptId", $deptId);
			$stmt->bindParam("semId",$semId);
			$stmt->bindParam("secId",$secId);
			$stmt->execute();
			$dept = $stmt->fetchObject();
			$db = null;
			echo json_encode($dept);
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
			header("Server Error");
		}
	}//function to get section by id end here
	
	
	//function to get all batch start here
	function getAllBatch($deptId,$semId,$secId) {
			$sql = "SELECT batch_name
					FROM batch
					WHERE id = ( SELECT batch_id FROM branch
								WHERE section_id = :secId
								AND semester_id = :semId
								AND department_id = :deptId )";
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("deptId", $deptId);
			$stmt->bindParam("semId",$semId);
			$stmt->bindParam("secId",$secId);
			$stmt->execute();
			$dept = $stmt->fetchObject();
			$db = null;
			echo json_encode($dept);
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
			header("Server Error");
		}
	}//function to get all batch end here




	//function to get batch by id start here
	function getBatchById($deptId,$semId,$secId,$batchId) {
			$sql = "SELECT batch_name
					FROM batch
					WHERE id = ( SELECT batch_id FROM branch
								WHERE batch_id = :batchId
								AND section_id = :secId
								AND semester_id = :semId
								AND department_id = :deptId )";
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("deptId", $deptId);
			$stmt->bindParam("semId",$semId);
			$stmt->bindParam("secId",$secId);
			$stmt->bindParam("batchId",$batchId);
			$stmt->execute();
			$dept = $stmt->fetchObject();
			$db = null;
			echo json_encode($dept);
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
			header("Server Error");
		}
	}//function to get batch by id end here




	//function to add department start here
	function addDepartment() {
		$request = \Slim\Slim::getInstance()->request();
		$dept = json_decode($request->getBody());
		$sql = "INSERT INTO department (id,name) VALUES (:id, :name)";
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("name", $dept->name);
			$stmt->bindParam("id", $dept->id);
			$stmt->execute();
			$dept->id = $db->lastInsertId();
			$db = null;
			echo json_encode($dept);
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
			header ('Server Error');
		}
	}//function to add department end here


	//addEntrybySection function
	function addEntryBysection(){
		$request = \Slim\Slim::getInstance()->request();
    	$dept = json_decode($request->getBody());
		//Now inserting to branch table...
		if($dept->days_entry_id == '')
		{
			$sql = "INSERT INTO  `days_entry` (date, department_id, section_name, semester_id) VALUES (NOW(), :department_id, :section_name, :semester_id)";
			try {
				$dept->semester_id  = htmlspecialchars(trim($dept->semester_id));
				$dept->section_name = htmlspecialchars(trim($dept->section_name));
				 
				$db = getConnection();
				$stmt = $db->prepare($sql);
				$stmt->bindParam("department_id", $dept->department_id);
				$stmt->bindParam("semester_id", $dept->semester_id);
				$stmt->bindParam("section_name", $dept->section_name);
				$stmt->execute();
				$days_entry_id = $db->lastInsertId();
				$db = null;
			} catch(PDOException $e) {
				echo '{"error":{"text":'. $e->getMessage() .'}}';
				header ('Server Error');
			}
		}
		else{
			//Just update the $days_entry_id variable..
			$days_entry_id = $dept->days_entry_id;			
		}
		
		//First matching for validation..
		if( numberMatch(trim($dept->strength)) && numberMatch(trim($dept->lab)) && numberMatch(trim($dept->batch)) )
		{
			
			//get subject id..
			$subject_id =  getSubjectId($dept->subject_name, $dept->faculty_id);	
			
			//Now inserting data to periodEntry
			$sql = "INSERT INTO `attendance`.`period_entry` (`id`, `time`, `subject_id`, `faculty_id`, `lab`, `batch`, `strength`, `days_entry_id`) VALUES (NULL, CURTIME(), :subject_id, :faculty_id, :lab, :batch, :strength, :days_entry_id)";
			
			try {
				$db = getConnection();
				$stmt = $db->prepare($sql);
				$stmt->bindParam("subject_id", $subject_id);
				$stmt->bindParam("faculty_id", $dept->faculty_id);
				$stmt->bindParam("lab", $dept->lab);
				$stmt->bindParam("batch", $dept->batch);
				$stmt->bindParam("strength", $dept->strength);
				$stmt->bindParam("days_entry_id", $days_entry_id);
				$stmt->execute();
				$dept->id = $db->lastInsertId();
				$db = null;
			} catch(PDOException $e) 
			{
				echo '{"error":{"text":'. $e->getMessage() .'}}';
				header ('Server Error');	
			}
		}
		else
		{
			//Validation fails...
			echo '{"error":{"text":'. 'Invalid characters in the fields.' .'}}';
			header ('Server Error');
			return false;	
		}
		
		//Now adding period...
		foreach($dept->period as $period)
		{
			//validating the period..
			/*if( numberMatch(trim($period)) )
			{*/
				//Now inserting data to periodEntry
				$sql = "INSERT INTO `attendance`.`period_join` (`period_entry_id`, `period`) VALUES (:period_entry_id, :period)";
				try 
				{
					$db = getConnection();
					$stmt = $db->prepare($sql);
					$stmt->bindParam("period_entry_id", $dept->id);
					$stmt->bindParam("period", $period);
					$stmt->execute();
					$db = null;
				} 
				catch(PDOException $e)
				{
					echo '{"error":{"text":'. $e->getMessage() .'}}';
					header ('Server Error');
				}
			/*}
			else
			{
				echo '{"error":{"text":'. 'Invalid characters in period entry. Only digits allowed.' .'}}';
				header ('Server Error');
				return false;
			}*/
		}//End of foreach loop....
		
		//Now adding FACULTY ENTRY LOG---
		$sql = "INSERT INTO `attendance`.`faculty_log` (`id`, `date`, `time`, `entry_type`, `info_entry_id`, `faculty_id`, `info`, `sub_info`) VALUES (NULL, CURDATE(), CURTIME(), \"entry\", :period_id, :faculty_id, :message, :sub_info);";
		
		try {
			$db          = getConnection();
			$stmt        = $db->prepare($sql);
			if($dept->lab == 0)
				$message     = 'Class entry created for '.$dept->semester_id . getDepartmentNameById($dept->department_id) .'-'.$dept->section_name.'.';
			else
				$message     = 'Lab entry created for '.$dept->semester_id . getDepartmentNameById($dept->department_id) .'-'.$dept->section_name.$dept->batch.'.';
				
			$stmt->bindParam("faculty_id", $dept->faculty_id);
			$stmt->bindParam("period_id", $dept->id);
			$stmt->bindParam("message", $message);
			$stmt->bindParam("sub_info", $dept->subject_name);
			$stmt->execute();
			$db = null;
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
			header ('Server Error');
		}
		
		
		//echo json_encode($dept);
		//sending new updated entry to server...
		$dept_name = getDepartmentNameById($dept->department_id);
		echo json_encode($dept);	
	}//Functions ends for addEntryBysection...


    //Add batch to database..
	function addBranch(){
		$request = \Slim\Slim::getInstance()->request();
    	$dept = json_decode($request->getBody());	
		
		//Now inserting to branch table...
		$sql = "INSERT INTO  `branch` (department_id, semester_id, section_name, batch_id) VALUES (:department_id, :semester_id, :section_name, :batch_id)";
		
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("department_id", $dept->department_id);
			$stmt->bindParam("semester_id", $dept->semester_id);
			$stmt->bindParam("batch_id", $dept->batch_id);
			$stmt->bindParam("section_name", $dept->section_name);
			$stmt->execute();
			$dept->id = $db->lastInsertId();
			$db = null;
			echo json_encode($dept);
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
			header ('Server Error');
		}
			

	}//Function ends for addBranch





	//function to update department start here
	function updateDepartment($deptId) {
		$request = Slim::getInstance()->request();
		$body = $request->getBody();
		$dept = json_decode($body);
		$sql = "UPDATE branch SET name=:name, grapes=:grapes, country=:country, region=:region, year=:year, description=:description WHERE id=:id";
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("department_id", $dept->department_id);
			$stmt->bindParam("id", $id);
			$stmt->execute();
			$db = null;
			echo json_encode($dept);
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
			header ('Server Error');
		}
	}//function to update department end here

	function deleteDepartment($deptId){
		$sql = "DELETE FROM department WHERE id=:id";
		$sql_1 = "DELETE FROM branch WHERE department_id=:id";
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("id", $deptId);
			$stmt->execute();
			$db = null;
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}//Function to delete department ends here...


	//Function for getting the faculty log entry...
	//entry/faculty/:id/daysEntry/:entryId','getFacultyLogEntry'
	//collection.fetch({data: {offset: 30, limit:30}, add: true})
	function getAllFacultyLogEntry($id)
	{
		$request = \Slim\Slim::getInstance()->request();
		$request_data = json_decode($request->getBody());
		//collection.fetch({data: {offset: 30, limit:30}, add: true})
		//Setting the max limit faculty log fetch..
		try 
		{
			$limit  = $_GET['limit'];
			$offset = $_GET['offset'];
			
		}catch(ErrorException $e) 
		{
			$limit  = 30;
			$offset = 0;
		}
		$limit = (int)(trim($limit));
		$offset = (int)(trim($offset));
		
		//OFFSET 8
		$sql = "SELECT * FROM `faculty_log` WHERE faculty_id = :faculty_id ORDER BY date DESC LIMIT :limit OFFSET :offset ;";
		try 
		{
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":faculty_id", $id);
			$stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
			$stmt->bindParam(":offset", $offset,  PDO::PARAM_INT);
			$stmt->execute();
			$dept = $stmt->fetchAll(PDO::FETCH_OBJ);
			$db = null;
			echo json_encode($dept);
		} catch(PDOException $e)
		{
			echo '{"error":{"text":'. $e->getMessage() .'}}';
			header("Server Error");
		}
	}//Function for getAllFacultyLogEntry ends here....


	//'/entry/faculty/:id/daysEntry/:entryId','deleteEntry'
	//function for deleting the period entry...
	function deleteEntry($id, $entryId)
	{
		//Getting the current period info..
		$period_info = getPeriodEntry($entryId);
		//Now semester and department info..
		$days_info   = get_days_entry($period_info->days_entry_id); 
		
	 	$sql = "DELETE FROM `period_entry` WHERE `id` = :id AND faculty_id = :faculty_id";
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("id", $entryId);
			$stmt->bindParam("faculty_id", $id);
			$stmt->execute();
			$db = null;
		} catch(PDOException $e) {
			header ('Server Error');
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
		 
		 $message     = 'Entry deleted for   ' . $days_info->semester_id . getDepartmentNameById($days_info->department_id) .'-'.$days_info->section_name.'.';
		 $sub_info = getSubjectName($period_info->subject_id);
		 
		//Now logging the entry for the faculty...
		entry_faculty_log("delete", $id, $message, $sub_info, 'NULL' );
		
	}//Function ends for delete entry..
	
	
	//Function for updating Entry ...
	// entry/faculty/:id/daysEntry/:entryId', 'updateEntry'
	function updateEntry($id, $entryId)
	{
		$request = \Slim\Slim::getInstance()->request();
		$dept = json_decode($request->getBody());
		
		$sql = "UPDATE `period_entry` SET \
				  `subject_id`= :subject_id,\
				  `lab`= :lab,\
				  `batch`= :batch ,\
				  `strength`= :strength,\
				   WHERE id = :entryId AND `faculty_id` = :faculty_id" ;
		
		$subject_id = getSubjectId( $dept->subject_name, $id );		   
		
		try 
		{
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("subject_id", $subject_id);
			$stmt->bindParam("lab", $dept->lab);
			$stmt->bindParam("batch", $dept->batch);
			$stmt->bindParam("strength", $dept->strength);
			$stmt->bindParam("entryId", $entryId);
			$stmt->bindParam("faculty_id", $id);
			$stmt->execute();
			$db = null;
		} catch(PDOException $e) {
			header ('Server Error');
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
		//Updating periods...
		updatePeriod($dept->period, $entryId);
		
		//Now semester and department info..
		$days_info   = get_days_entry($dept->days_entry_id); 
		//Writing the log entry...
		$message     = 'Entry updated for   ' . $days_info->semester_id . getDepartmentNameById($days_info->department_id) .'-'.$days_info->section_name.'.'; 
		//Now logging the entry for the faculty...
		entry_faculty_log("update", $id, $message, $dept->subject_name, $dept->id );
		
		//sending the response..
		echo json_encode($dept);	
			
	}//Function ends for updateEntry...
  
	
	
	
	
	function getConnection() {
		$dbhost= HOST;
		$dbuser= USERNAME;
		
		$dbpass= PASSWORD;
		$dbname= DATABASE;
		$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $dbh;
	}
?>
