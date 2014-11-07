<?php
	require ('../Slim/Slim.php');
	include_once 'database_connection.php';
	include_once 'helper_department_function.php';
	//Adding the cache for session limiter...
	session_cache_limiter(false);
	session_start();
	\Slim\Slim::registerAutoloader();
	$app = new \Slim\Slim();
	

	//------------------------------------------DEPARTMENT AREA------------------------------------------------------------
	//GET
	$app->get('/department', 'getAllDepartment');
	$app->get('/department/:deptId','getDepartmentById');
	//POST
	$app->post('/department','addDepartment');
	//DELETE
	$app->delete('/department/:deptId', 'deleteDepartment');
	
	
	
	//--------------------------------------------SUBJECT AREA---------------------------------------------------------------
	//GET
	$app->get('/subject', 'getSubject');
	$app->get('/subject/:id', 'getSubjectById');
	$app->put('/subject/:id', 'updateSubject');
	$app->post('/subject', 'addSubject');
	$app->delete('/subject/:id', 'deleteSubject');
	
	
	
	//------------------------------------------FACULTY AREA---------------------------------------------------------------
	//GET
	$app->get('/members',"getAllFaculty");
	$app->get('/members/:id',"getFacultyById");
	//POST
	$app->post('/members',"addFaculty");
	//PUT
	$app->put('/members/:id','updateFaculty');
	//DELETE
	$app->delete('/members/:id','deleteFaculty');
	

	//------------------------------------------PERIOD ENTRY AREA------------------------------------------------------------
	//NEW ROUTES
	//GET
	$app->get('/period/entry','getPeriodClassEntry');
	$app->get('/period/entry/:id','fetchPeriodEntry');
	//POST
	$app->post('/period/entry','addEntryBysection');
	//PUT
	$app->put('/period/entry/:id','updateEntry');
	//DELETE
	$app->delete('/period/entry/:id','deleteEntry');
	
	
	//------------------------------------------FACULTY LOG  AREA------------------------------------------------------------

	//NEW ROUTES
	//GET
	$app->get('/faculty/activity','getAllFacultyLogEntry'); //faculty/activity?faculty_id=3&offset=0&limit=30
	$app->get('/faculty/activity/:id','getFacultyLogEntryById');
	//PUT
	$app->put('/faculty/activity/:entryId','updateLog');

	
	
	
	//-----------------------------------------BRANCH ENTRY  AREA----------------------------------------------------------
	//GET
	$app->get('/branch/', 'getBranch');
	$app->post('/branch/', 'addBranch');
	
	//KACHRA-----------------------------------------------------------------------------------------------------------------------
	$app->get('/department/:deptId/semester/:semId','getSemesterById');
	$app->get('/department/:deptId/semester/:semId/section','getAllSection');
	$app->get('/department/:deptId/semester/:semId/section/:secId','getSectionById');
	$app->get('/department/:deptId/semester/:semId/section/:secId/batch','getAllBatch');
	$app->get('/department/:deptId/semester/:semId/section/:secId/batch/:batchId','getBatchById');

	//RUNNING THE APPLICATION
	$app->run();
	
?>

<?php

	include_once 'loginscript/include/processes.php';
	$Login_Process = new Login_Process;
	if( !$Login_Process->check_register() )
		$Login_Process->check_status($_SERVER['SCRIPT_NAME']);

?>




<?php

	
	//function to get all department start here
	function getAllDepartment() {
		
		if( isset($_GET['key']) )
		{
			$key =  $_GET['key'];
			$sql = "SELECT * FROM `department` WHERE `name` LIKE :key LIMIT 0, 30 ";
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
		else{
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
	
	
	//------------------------------------------------SUBJECT ROUTES AREA----------------------------------------------
	
	function getSubject()
	{
				
		 if( isset($_GET['key']) )
		 {
			$key =  $_GET['key'];
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
		 else{
			$sql = "SELECT * FROM `subject`  LIMIT 0, 30 ";
			try {
				$db = getConnection();
				$stmt = $db->prepare($sql);
				$stmt->execute();
				$dept = $stmt->fetchAll(PDO::FETCH_OBJ);
				$db = null;
				echo json_encode($dept);
			} catch(PDOException $e) {
				echo '{"error":{"text":'. $e->getMessage() .'}}';
				header("Server Error");
			} 
		 }
	}
	
	
	
	//Route /subject/:id
	function getSubjectById($id){
		$sql = "SELECT * FROM `subject` WHERE `id` = :id  LIMIT 0, 30 ";
			try {
				$db = getConnection();
				$stmt = $db->prepare($sql);
				$stmt->bindParam("id", $id);
				$stmt->execute();
				$dept = $stmt->fetchObject();
				$db = null;
				echo json_encode($dept);
			} catch(PDOException $e) {
				echo '{"error":{"text":'. $e->getMessage() .'}}';
				header("Server Error");
			} 
	}//End of getting subject by id...
	
	
	//Route for updating subject...
	//'/subject/:id', 'updateSubject'
	function updateSubject($id){
		$request = \Slim\Slim::getInstance()->request();
		$dept = json_decode($request->getBody());
		$faculty_id     = $request->headers->get('faculty_id');
		$oldSubjectName = $request->headers->get('Oldsubject');
		$facultyLogId   = $request->headers->get('facultyLogId');
		
		$subjectId = checkSubjectExists( $dept->subject );
		//Now checking ..if updated subject name already present..
		if($faculty_id)
		{
			if( $subjectId)
			{
				if($subjectId == $dept->id)
				{
					//just send the respoonse....
					//sending the response..
					echo json_encode($dept);
				}
				else{
				
					//subject id already exists.... update the period entry the delete that subject id...the subject....
					updatePeriodSubject($dept->id ,  $subjectId);
					//Now delete that subject....
					deleteSubjectById($dept->id);
					
					//Writing the log entry...
					$message     = 'Subject name changed from \'' . $oldSubjectName. '\' to \'' . $dept->subject. '\'.';
					//Now logging the entry for the faculty...
					update_faculty_log( $facultyLogId ,"subject", $faculty_id, $message, $dept->subject, $subjectId  );
					$log = getFacultyLogEntry( $facultyLogId, $faculty_id );
					//update dept id
					$dept->id  = $subjectId;
					//Adding this faculty log to response...
					$dept->log = $log; 
					echo json_encode($dept);
				}
			}//End of if of subject check
			else
			{
				$sql = "UPDATE `subject` SET 
						 subject = :subject
						WHERE 
						`id` = :id ";
				try 
				{
					$db = getConnection();
					$stmt = $db->prepare($sql);
					$stmt->bindParam("id", $id);
					$stmt->bindParam("subject", $dept->subject);
					$stmt->execute();
					$db = null;
				} catch(PDOException $e) {
					header ('Server Error');
					echo '{"error":{"text":'. $e->getMessage() .'}}';
				}
				
				
				//Writing the log entry...
				$message     = 'Subject name changed from \'' . $oldSubjectName. '\' to \'' . $dept->subject. '\'.';
				//Now logging the entry for the faculty...
				update_faculty_log( $facultyLogId ,"subject", $faculty_id, $message, $dept->subject, $id  );
				$log = getFacultyLogEntry( $facultyLogId, $faculty_id );
				//update dept id
				$dept->id  = $subjectId;
				//Adding this faculty log to response...
				$dept->log = $log; 
				echo json_encode($dept);
			}
			
			
			
		
			
		}//IF STATEMENT ENDS...
		else{
			header ('Server Error');
			echo '{"error":{"text":'. 'A header with Property Name \'faculty_id\' must be provided.' .'}}';
		}
	}
	
	
	//ErrorCode : #0000 - "Subject cannot be deleted. It is linked with other class entries delete that enteries first.You can only rename the subject until until all related subject enteries are deleted."
	function deleteSubjectById($id){
		$sql = "DELETE FROM `subject` WHERE  `id` = :id ";
			try 
			{
				$db = getConnection();
				$stmt = $db->prepare($sql);
				$stmt->bindParam("id", $id);
				$stmt->execute();
				
				$db = null;
				return true;
			} catch(PDOException $e) {
				header ('Server Error');
				echo '{"error":{"text":'. 'A header with Property Name \'faculty_id\' must be provided.' .'}}';
				return false;
			}
	}
	
	
	
	
	//subject/:id','deleteSubject'
	function deleteSubject($id){
		$request      = \Slim\Slim::getInstance()->request();
		$faculty_id   = $request->headers->get('faculty_id');
		$facultyLogId = $request->headers->get('facultyLogId');
		if($faculty_id)
		{
			$subjectName = getSubjectName($id);
			$value = deleteSubjectById($id);
			if($value)
			{				
			  //Writing the log entry...
			  $message     = 'Subject ' . $subjectName . ' deleted.' ;
			  //Now logging the entry for the faculty...
			  update_faculty_log( $facultyLogId ,"delete", $faculty_id, $message, $subjectName, "NULL" );
			  //Now fetching the log entry...
			  $log = getFacultyLogEntry(  $facultyLogId , $faculty_id );
			  //returning the response ....
			  echo json_encode( $log );
			}
		}//IF STATEMENT ENDS...
		else{
			header ('Server Error');
			echo '{"error":{"text":'. 'A header with Property Name \'faculty_id\' must be provided.' .'}}';
		}
	}//End of deleteSubject function...
	
	
	
	//----------------------------------------------END OF SUBJECT ROUTES AREA--------------------------------------------
	//$app->get('/entry/:id','fetchPeriodEntry');
	//Function for fetching the period by its id.
 	function fetchPeriodEntry($id)
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
		$dept->subject_name		= getSubjectName($dept->subject_id);
		$dept->faculty_name		= getFacultyName($dept->faculty_id);
		
		//Now returning the json response.....
		echo json_encode($dept);
	}//End of fetch period..
	
	
	
	
	
	
	/*
	//get faculty entry by date..
	//faculty/department/:dept_name/semester/:semester_name/section/:section_name/date/:today_date', 'getFacultyTodayEntry'
	function getFacultyTodayEntry($dept_name, $semester_name, $section_name)
	{
		//$dept_id = getDepartmentId($dept_name);
		$dept = days_entry_by_section_and_date($semester_name, $section_name, $dept_name );
		$dept_ = process_days_entry_obj($dept);
		echo json_encode($dept_);		
	}
	*/
	
	
	
	//Get days entry by section..
	//OLD URL '/entry/department/:dept_name/semester/:sem/section/:sec_name','getEntryBysection'
	//NEW URL '/period/entry','getPeriodEntry''
	//Removing the arguments $dept_name, $sem, $sec_name
	//Changing the getEntryBysection($dept_name, $sem, $sec_name) to getPeriodClassEntry
	function getPeriodClassEntry()
	{
		//Adding the offset and limit ..
		if( isset($_GET['limit']) &&  isset($_GET['offset']) )
		{
			$limit  = $_GET['limit'];
			$offset = $_GET['offset'];
		}
		else{
			$limit  = 5;
			$offset = 0;	
		}
		
		if( isset($_GET['dept_name']) && isset($_GET['sem']) && isset($_GET['sec_name']) && isset($_GET['todayEntry']) ) {
			//Fetch period entry for today's date only..	
			//$dept_id = getDepartmentId($dept_name);
			$dept_name      = $_GET['dept_name'];
			$semester_name	= $_GET['sem'];
			$section_name   = $_GET['sec_name'];
			
			$dept = days_entry_by_section_and_date($semester_name, $section_name, $dept_name );
			$dept_ = process_days_entry_obj($dept);
			echo json_encode($dept_);		
				
		}
		elseif( isset($_GET['dept_name']) && isset($_GET['sem']) && isset($_GET['sec_name']) ){	
			//FETCH PERIOD ENTRY FOR SECTION WISE...	
			//$dept_id = getDepartmentId($dept_name);
			$dept_name = $_GET['dept_name'];
			$sem	   = $_GET['sem'];
			$sec_name  = $_GET['sec_name'];
			
			$dept = days_entry_by_section($sem, $sec_name, $dept_name, $limit, $offset );
			$dept = process_days_entry_obj($dept);
			
			echo json_encode($dept);
		}
		elseif(  isset($_GET['dept_name']) && isset($_GET['year']) ){
			//FETCH PERIOD ENTRY YEAR WISE...
			//$dept_id = getDepartmentId($dept_name);
			
			$dept_name = $_GET['dept_name'];
			$year	   = $_GET['year'];
			
			$dept = days_entry_by_year($year, $dept_name, $limit, $offset);
			$dept_ = process_days_entry_obj($dept);
		
			echo json_encode($dept_);
			
		}
		elseif( isset($_GET['dept_name']) ){
			//FETCH PERIOD ENTRY BY DEPARTMENT WISE...
			//$dept_id = getDepartmentId($dept_name);
			$dept_name = $_GET['dept_name'];
			$dept = days_entry_by_dept($dept_name, $limit, $offset);
			$dept = process_days_entry_obj($dept);
			echo json_encode($dept);
		}
		else{
			echo '{"error":{"text":"Invalid Route."}}';
			header("Server Error");	
		}
	}
	
	/*
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
	*/
	
	
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
		$request       = \Slim\Slim::getInstance()->request();
		$faculty_id    = $request->headers->get('faculty_id');
		$dept          = json_decode($request->getBody());
		$sql = "INSERT INTO department (id,name) VALUES (:id, :name)";
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("name", $dept->name);
			$stmt->bindParam("id", $dept->id);
			$stmt->execute();
			$dept->id = $db->lastInsertId();
			$db = null;
			
			$message="Department " . $dept->name . " created";
			//Add log report...
			entry_admin_log( 'create' , $faculty_id, $message, $dept->name, "NULL" );
			
			echo json_encode($dept);
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
			header ('Server Error');
		}
	}//function to add department end here
	
	//DUMMY
	function addSubject(){
		$request = \Slim\Slim::getInstance()->request();
		$dept = json_decode($request->getBody());
		$headers = $request->headers->get('param_1');
		print_r ($headers);
		
	}
	


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
		$request       = \Slim\Slim::getInstance()->request();
		$faculty_id    = $request->headers->get('faculty_id');
		$dept_name     = getDepartmentNameById($deptId); 
		
		
		$sql = "DELETE FROM department WHERE id=:id";
		$sql_1 = "DELETE FROM branch WHERE department_id=:id";
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("id", $deptId);
			$stmt->execute();
			$db = null;
			echo '{}';
			//Writing the logs....			 
			$message=" Department " . $dept_name   . " deleted.";
			//Add log report...
			entry_admin_log( 'delete' , $faculty_id, $message, $dept_name, "NULL" );
			
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}//Function to delete department ends here...


	//Function for getting the faculty log entry...
	//OLD URL - 	'entry/faculty/:id/daysEntry/:entryId','getFacultyLogEntry'
	//NEW URL - 	'/faculty/activity','getAllFacultyLogEntry'
	//collection.fetch({data: {offset: 30, limit:30, faculty_id:id_of_faculty}, add: true})
	function getAllFacultyLogEntry()
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
		if( isset($_GET['faculty_id']) )
		{
			$id = $_GET['faculty_id'];
			//OFFSET 8
			$sql = "SELECT * FROM `faculty_log` WHERE faculty_id = :faculty_id ORDER BY date DESC, time DESC  LIMIT :limit OFFSET :offset ;";
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
		}//End of if clause..
	}//Function for getAllFacultyLogEntry ends here....
	
	
	
	
	//Function for getting the faculty log entry...
	//NEW URL - 	'/faculty/activity/:id','getFacultyLogEntryById'
	function getFacultyLogEntryById( $id )
	{
		$request = \Slim\Slim::getInstance()->request();
		$request_data = json_decode($request->getBody());
			$sql = "SELECT * FROM `faculty_log` WHERE id = :id ";
			try 
			{
				$db = getConnection();
				$stmt = $db->prepare($sql);
				$stmt->bindParam(":id", $id);
				$stmt->execute();
				$dept = $stmt->fetchObject();
				$db = null;
				echo json_encode($dept);
			} catch(PDOException $e)
			{
				echo '{"error":{"text":'. $e->getMessage() .'}}';
				header("Server Error");
			}
		
	}//Function for getFacultyLogEntryById ends here....
	
	
	


	//OLD ROUTE		'/entry/faculty/:id/daysEntry/:entryId','deleteEntry'
	//NEW ROUTE		'/period/entry/:id','deleteEntry'
	//function for deleting the period entry...
	function deleteEntry($id)
	{
		$request       = \Slim\Slim::getInstance()->request();
		$faculty_id    = $request->headers->get('faculty_id');
		$facultyLogId  = $request->headers->get('facultyLogId');
		
		if($faculty_id)
		{
			//Getting the current period info..
			$period_info = getPeriodEntry($id);
			//Now semester and department info..
			$days_info   = get_days_entry($period_info->days_entry_id); 
			
			$sql = "DELETE FROM `period_entry` WHERE `id` = :id AND faculty_id = :faculty_id";
			try {
				$db = getConnection();
				$stmt = $db->prepare($sql);
				$stmt->bindParam("id", $id);
				$stmt->bindParam("faculty_id", $faculty_id);
				$stmt->execute();
				$db = null;
			} catch(PDOException $e) {
				header ('Server Error');
				echo '{"error":{"text":'. $e->getMessage() .'}}';
			}
			 
			 $message     = 'Entry deleted for   ' . $days_info->semester_id . getDepartmentNameById($days_info->department_id) .'-'.$days_info->section_name.'.';
			 $sub_info = getSubjectName($period_info->subject_id);
			 
			//Now logging the entry for the faculty...
			update_faculty_log( $facultyLogId ,"delete", $faculty_id, $message, $sub_info, 'NULL' );
			$log = getFacultyLogEntry( $facultyLogId, $faculty_id );
			//sending the response...
			echo json_encode($log);
		}
		else{
			header ('Server Error');
			echo '{"error":{"text":'. 'Property Name \'faculty_id\' must be provided with the Header. ' .'}}';
		}
	}//Function ends for delete entry..
	
	
	
	
	//Function for updating Entry ...
	// '/period/entry/:id','updateEntry'
	// faculty_id is send through header..
	function updateEntry($id)
	{
		$request = \Slim\Slim::getInstance()->request();
		$dept = json_decode($request->getBody());
		$faculty_id   = $request->headers->get('faculty_id');
		$facultyLogId = $request->headers->get('facultyLogId');
		if($faculty_id && $facultyLogId)
		{
			$sql = "UPDATE `period_entry` SET 
					  `subject_id`= :subject_id,
					  `lab`= :lab,
					  `batch`= :batch ,
					  `strength`= :strength
					   WHERE `id` = :entryId AND `faculty_id` = :faculty_id" ;
			
			$subject_id = getSubjectId( $dept->subject_name, $faculty_id );		   
			
			try 
			{
				$db = getConnection();
				$stmt = $db->prepare($sql);
				$stmt->bindParam("subject_id", $subject_id);
				$stmt->bindParam("lab", $dept->lab);
				$stmt->bindParam("batch", $dept->batch);
				$stmt->bindParam("strength", $dept->strength);
				$stmt->bindParam("entryId", $id);
				$stmt->bindParam("faculty_id", $faculty_id);
				$stmt->execute();
				$db = null;
			} catch(PDOException $e) {
				header ('Server Error');
				echo '{"error":{"text":'. $e->getMessage() .'}}';
			}
			//Updating periods...
			updatePeriod($dept->period, $id);
			
			//Now semester and department info..
			$days_info   = get_days_entry($dept->days_entry_id); 
			//Writing the log entry...
			$message     = 'Entry updated for   ' . $days_info->semester_id . getDepartmentNameById($days_info->department_id) .'-'.$days_info->section_name.'.'; 
			//Now logging the entry for the faculty...
			update_faculty_log($facultyLogId, "update", $faculty_id, $message, $dept->subject_name, $dept->id );
			$log = getFacultyLogEntry( $facultyLogId, $faculty_id );
			$dept->log = $log;
			//sending the response..
			echo json_encode($dept);
			
		}//IF STATEMENT ENDS...
	}//Function ends for updateEntry...
	
	
	
	
	//Route function for updating the faculty_log for storing the last_update_type
	//OLD URL '/entry/faculty/:id/daysEntry/:entryId', 'updateLog'
	//NEW ROUTE faculty/activity/:entryId','updateLog'
	function updateLog( $entryId )
	{
		$request       = \Slim\Slim::getInstance()->request();
		$dept          = json_decode($request->getBody());
		$faculty_id    = $request->headers->get('faculty_id');
		if( matchSubjectName( $dept->last_update_type ) && $faculty_id )
		{
			//Perform update operation...
			$sql = "UPDATE `faculty_log` SET `last_update_type`= :type WHERE id=:id AND faculty_id = :faculty_id";	
			try 
			{
			  $db = getConnection();
			  $stmt = $db->prepare($sql);
			  $stmt->bindParam("type", $dept->last_update_type);
			  $stmt->bindParam("id", $entryId);
			  $stmt->bindParam("faculty_id", $faculty_id);
			  $stmt->execute();
			  $db = null;
			  echo json_encode($dept);
			} catch(PDOException $e) {
				header ('Server Error');
				echo '{"error":{"text":'. $e->getMessage() .'}}';
			}	
		}
		else{
			header ('Server Error');
			echo '{"error":{"text":'. 'Invalid characters' .'}}';
			return false;
		}	
	}//Function ends for updateLog...






//-----------------------------------FACULTY ROUTE AREA--------------------------------------------------------
	//$app->get('/members',"getAllFaculty");
	//collection.fetch({data: {offset: 30, limit:30, dept_id:154}, add: true})
	function getAllFaculty(){
		
		//Setting the max limit faculty log fetch..
		try 
		{
			$limit  = $_GET['limit'];
			$offset = $_GET['offset'];
			
		}catch(ErrorException $e) 
		{
			$limit  = 10;
			$offset = 0;
		}
		$limit = (int)(trim($limit));
		$offset = (int)(trim($offset));
		//proceed only if user is admin...
		if( $_SESSION['admin'] )
		{
			if( isset($_GET['dept_id']) )
			{
				//set department id..
				$department_id = $_GET['dept_id'];
				//ORDER BY `first_name` DESC, `last_name` DESC 
				$sql = "SELECT `id`,
				  			   `first_name`,
							   `last_name`,
							   `username`,
							   `department_id`,
							   `email_address`,
							   `last_loggedin` 
						FROM
						  `faculty` 
						WHERE 
								department_id = :department_id 
						
						 LIMIT :limit OFFSET :offset;";
				try 
				{
					$db = getConnection();
					$stmt = $db->prepare($sql);
					$stmt->bindParam(":department_id", $department_id);
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
			}//End of if clause DEPARTMENT ID CHECKING..
			else{
				$sql = "SELECT `id`,
				  			   `first_name`,
							   `last_name`,
							   `username`,
							   `department_id`,
							   `email_address`,
							   `last_loggedin` 
						FROM 
						  `faculty` 
						 ORDER BY `first_name` DESC, `last_name` DESC
						  LIMIT :limit OFFSET :offset ;";
				try 
				{
					$db = getConnection();
					$stmt = $db->prepare($sql);
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
			}//End of else statemenet..
		}//IF stat ends for checkin of admin...
	}//Function ends for getAll Faculty
	
	
	
	//$app->get('/members/:id',"getFacultyById");
	//collection.fetch({data: {offset: 30, limit:30}})
	function getFacultyById( $id ){
		
		//proceed only if user is admin...
		if( $_SESSION['admin'] )
		{
			$dept = getMemberById( $id );
			echo json_encode($dept);
		}//IF stat ends for checkin of admin...
	}//getFacultyById function ends here....
	
	
	//$app->post('/memebers',"addFaculty");
	function addFaculty(){
		$request          = \Slim\Slim::getInstance()->request();
		$admin_id       = $request->headers->get('faculty_id');
    	$dept             = json_decode($request->getBody());
		
		//proceed only if user is admin...
		if( $_SESSION['admin'] )
		{	
		  $sql = "INSERT INTO  `faculty` 
		        (
				  first_name,
				  last_name,
				  email_address, 
				  username, 
				  password, 
				  department_id, 
				  status
				)VALUES (
				  :first_name,
				  :last_name, 
				  :email_address, 
				  :username,
				  :password,
				  :department_id, 
				  :status
				)";
		   try 
		   {
			  //Checking for validity
			  if( 
			      numberMatch( $dept->department_id ) && 
			      matchEmail( $dept->email_address )  && 
				  matchName( $dept->first_name )      &&
				  matchName( $dept->last_name )       &&
				  matchUserName( $dept->username ) 
				)
			  {
				   //Getting the random password...
				  $pass                     = randomPassword();
				  $password_md5             = md5( $pass ); 
				  $dept->first_name         = htmlspecialchars(trim($dept->first_name));
				  $dept->last_name          = htmlspecialchars(trim($dept->last_name));
				  $dept->username           = htmlspecialchars(trim($dept->username));
				  $dept->department_id      = htmlspecialchars(trim($dept->department_id));
				  $status					= 'live';	
				  
				  
				  //First check for possible update....
				  $whereString = " email_address = '$dept->email_address' ";
				  $rows = countReturnedRows( $whereString );
				  
				  if($rows > 0)
				  {
						header ('Server Error');
						echo "<strong>Email address is not availaible</strong>.Please choose another";
						return true;
				  }
				  
				  $whereString = " username =  '$dept->username' ";
				  $rows = countReturnedRows( $whereString );
				  if($rows > 0)
				  {
						header ('Server Error');
						echo  "<strong>Username is not availaible</strong>.Please choose another" ;
						return true;
				  }
			  				
				  
				  //Getting the connection...
				  $db = getConnection();
				  $stmt = $db->prepare($sql);
				  $stmt->bindParam("first_name",     $dept->first_name);
				  $stmt->bindParam("last_name",      $dept->last_name);
				  $stmt->bindParam("email_address",  $dept->email_address);
				  $stmt->bindParam("username",       $dept->username);
				  $stmt->bindParam("password",       $password_md5);
				  $stmt->bindParam("department_id",  $dept->department_id);
				  $stmt->bindParam("status",         $status);
				  $stmt->execute();
				  $faculty_id = $db->lastInsertId();
				  //Now fetch feculty data...
				  $dept = getMemberById( $faculty_id );
				  //Add string  pass to dept..
				  $dept->pass_string =  $pass;
				  echo json_encode($dept);
				  //writing logs..			  
			  	  $message=" Faculty " .$dept->first_name . ' ' . $dept->last_name . " created";
			      //Add log report...
			      entry_admin_log( 'create' , $admin_id, $message, $dept->username, "NULL" );
				  
				  $db = null;
			  }//End of if
			  else{
				  echo  "Invalid characters" ;
				  header("Server Error");
				  return false; 	  
			  }
			  
			
			  	
			} catch(PDOException $e) {
				echo '{"error":{"text":'. $e->getMessage() .'}}';
				header ('Server Error');
			}
		}//End of if for checking of admin
		else{
			echo "Only Admin can have permission to add faculty members" ;
			header("Server Error");
		}
	}//Function ends for addFaculty....
	
	
	
	
	//$app->put('members/:id','updateFaculty');
	function updateFaculty( $id ){
		$request          = \Slim\Slim::getInstance()->request();
		$dept             = json_decode($request->getBody());
		$faculty_id       = $request->headers->get('faculty_id');
		$facultyOldName   = getFacultyName($id);
		
		if( $_SESSION['admin'] )
		{
		   if( numberMatch( $dept->department_id ) && matchEmail( $dept->email_address )  && matchName( $dept->first_name )      &&  matchName( $dept->last_name )       &&   matchUserName( $dept->username )    )
		   {
				
			  //Perform update operation...
			  $sql = " UPDATE `faculty` 
			           SET 
						   `first_name`     =  :first_name,
						   `last_name`      =  :last_name,
						   `username`       =  :username,
						   `password`       =  :password,
						   `department_id`  =  :department_id,
						   `email_address`  =  :email_address
				      WHERE 
					  	   `id`               =  :id ";
			  
			  $password_md5             =  md5($dept->password ); 
			  $dept->first_name         =  htmlspecialchars(trim($dept->first_name));
			  $dept->last_name          =  htmlspecialchars(trim($dept->last_name));
			  $dept->username           =  htmlspecialchars(trim($dept->username));
			  $dept->department_id      =  htmlspecialchars(trim($dept->department_id));
			 
			 
			  //First check for possible update....
			  $whereString = " email_address  =  '$dept->email_address' ";
			  $rows = countReturnedRows( $whereString );
			  if($rows > 1)
			  {
					header ('Server Error');
					echo '{"error":{"text":'. '<strong>Email address is not availaible</strong>.Please choose another' .'}}';
					return true;
			  }
			  
			  $whereString = " username =  '$dept->username' ";
			  $rows = countReturnedRows( $whereString );
			  if($rows > 1)
			  {
					header ('Server Error');
					echo '{"error":{"text":'. '<strong>Username is not availaible</strong>.Please choose another' .'}}';
					return true;
			  }
			  				 
			 
			  try 
			  {
				$db = getConnection();
				$stmt = $db->prepare($sql);
				$stmt->bindParam("id",            $id);
				$stmt->bindParam("first_name",    $dept->first_name );
				$stmt->bindParam("last_name",     $dept->last_name);
				$stmt->bindParam("username",      $dept->username);
				$stmt->bindParam("password",      $password_md5);
				$stmt->bindParam("department_id", $dept->department_id);
				$stmt->bindParam("email_address", $dept->email_address);
				$stmt->execute();
				$db = null;
				$dept->password = $password_md5;
				echo json_encode($dept);
				
			  } catch(PDOException $e) {
				  header ('Server Error');
				  echo '{"error":{"text":'. $e->getMessage() .'}}';
			  }	
			  
			}//End of if validation..
			
			//Writing the logs...
			$message        = "Faculty " . $facultyOldName . " got updated.";
			$facultyNewName = $dept->first_name .' '. $dept->last_name;
			//Add log report...
			entry_admin_log( 'update' , $faculty_id, $message, $facultyNewName, "NULL" );
			
		}//end of if admin...
		else{
			header ('Server Error');
			echo '{"error":{"text":'. 'Only Admin can have permission to add faculty members' .'}}';
		}	
	}//End of function of updateFaculty
	
	
	
	//$app->delete('/members/:id','deleteFaculty');
	function deleteFaculty( $id ){
	  $request       = \Slim\Slim::getInstance()->request();
	  $faculty_id    = $request->headers->get('faculty_id');
	  $facultyName   = getFacultyName($id);
	  
	  if( $_SESSION['admin'] )
	  {
		//Performing the delete operations...
		$sql = "DELETE FROM `faculty` WHERE id=:id";
		
		 try 
		  {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("id",  $id);
			$stmt->execute();
			$db = null;
			echo '{}';
			
			//Writing logs....
			$message="Faculty '" . $facultyName . "' deleted";
			//Add log report...
			entry_admin_log( 'delete' , $faculty_id, $message, $facultyName, "NULL" );
			
		  } catch(PDOException $e) {
			  header ('Server Error');
			  echo '{"error":{"text":'. $e->getMessage() .'}}';
		  }	
	  }
	}//End of function of deleteFaculty...


//-----------------------------------AREA ENDS FOR FACULTY AREA-------------------------------------------------


	
	

//-----------------------------------CONNECTION AREA------------------------------------------------------------	
	
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
