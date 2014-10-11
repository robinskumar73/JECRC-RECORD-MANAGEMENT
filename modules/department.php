<?php

	require ('../Slim/Slim.php');
	

	\Slim\Slim::registerAutoloader();

	// create new Slim instance
	$app = new \Slim\Slim();
	
	

// Get Methods of Department,Batch,Section,Semester
	$app->get('/department', 'getAllDepartment');
	$app->get('/department/:deptId','getDepartmentById');
	$app->get('/entry/department/:dept_name/semester/:sem/section/:sec_name','getEntryBysection');
	$app->get('/entry/department/:dept_name','getEntryBydept');
	$app->get('/entry/department/:dept_name/year/:year','getEntryByYear');
	
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
		echo 'header("Server Error");';
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
		echo 'header("Server Error");';
    }
	
}


  //function to get department by id start here
  function getDepartmentById($deptId) {
		$sql = "SELECT department_name FROM department WHERE id=:deptId";
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
			echo 'header("Server Error");';
		}
    }//function to get department by id end here
	
	
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
		$dept = process_days_entry_obj($dept);
		
		echo json_encode($dept);
		
	}
	
	
	function process_days_entry_obj($days_entry_array)
	{
		foreach( $days_entry_array as $dept_one )
		{	  
			  $dept_id = $dept_one->id;
			  $date = $dept_one->date;
			  $sql = "SELECT * FROM period_entry WHERE days_entry_id = :days_entry_id ";
			  try {
				  $db = getConnection();
				  $stmt = $db->prepare($sql);
				  $stmt->bindParam("days_entry_id", $dept_id);
				  $stmt->execute();
				  $period_entry_data = $stmt->fetchAll(PDO::FETCH_OBJ);
				  $db = null;
				  foreach($period_entry_data as $period_data){
						  $dept_one->time = $period_data->time;
						  
						  $dept_one->subject_name =  getSubjectName($period_data->subject_id);
						  $dept_one->faculty_name =  getFacultyName($period_data->faculty_id);
						  $dept_one->faculty_id   =  $period_data->faculty_id;
						  $dept_one->lab		  =  $period_data->lab;
						  $dept_one->batch        =  $period_data->batch;
						  $dept_one->strength     =  $period_data->strength;
						  $dept_one->id           =  $period_data->id;
						  $dept_one->period		  =  getPeriod($period_data->id);
						  $dept_one->days_entry_id=  $period_data->days_entry_id; 	
				  }
				  	  
			  }
			  catch(PDOException $e) 
			  {
				  echo '{"error":{"text":'. $e->getMessage() .'}}';
				  echo 'header("Server Error");';
			  }
		}//End of foreach loop	
		//return 
		return $days_entry_array;
		
	}
	
	//Getting days entry by section...
	function days_entry_by_section($sem, $sec_name, $dept_name )
	{
		$dept_id = getDepartmentId($dept_name);
		$sql = "SELECT * FROM days_entry WHERE department_id=:dept_id AND semester_id = :semester_id AND section_name = :section_name";
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("semester_id", $sem);
			$stmt->bindParam("section_name", $sec_name);
			$stmt->bindParam("dept_id", $dept_id);
			$stmt->execute();
			$dept = $stmt->fetchAll(PDO::FETCH_OBJ);
			$db = null;
			
			return $dept;
			
		}
		catch(PDOException $e) 
		{
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}	
		
	}
	
	
	
	
	//Getting days entry by section...
	function days_entry_by_dept($dept_name )
	{
		$dept_id = getDepartmentId($dept_name);
		$sql = "SELECT * FROM days_entry WHERE department_id=:dept_id";
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("dept_id", $dept_id);
			$stmt->execute();
			$dept = $stmt->fetchAll(PDO::FETCH_OBJ);
			$db = null;
			
			return $dept;
			
		}
		catch(PDOException $e) 
		{
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}	
		
	}
	
	
	
	//Getting days entry by section...
	function days_entry_by_year($year, $dept_name )
	{
		$dept_id = getDepartmentId($dept_name);
		$year_int = getYear($year);
		$sem = $year_int*2;
		$sql = "SELECT * FROM days_entry WHERE department_id=:dept_id AND semester_id IN ( :semester_id, :semester_id_) ";
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("semester_id", $year_int);
			$stmt->bindParam("semester_id_", $sem);
			$stmt->bindParam("dept_id", $dept_id);
			$stmt->execute();
			$dept = $stmt->fetchAll(PDO::FETCH_OBJ);
			$db = null;
			
			return $dept;
			
		}
		catch(PDOException $e) 
		{
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}	
		
	}
	
	
	
	function getYear($yearName)
	{
		switch ($yearName){
			case "I YEAR":
				return 1;
				break;
				
			case "II YEAR":
				return 2;
				break;
			
			case "III YEAR":
				return 3;
				break;	
				
			case "IV YEAR":
				return 4;
				break;	
		}
	}
	
	function getDepartmentId($name){
		//Getting department id
		 $sql = "SELECT id FROM department WHERE name=:dept_name";
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("dept_name", $name);
			$stmt->execute();
			$dept = $stmt->fetchObject();
			$db = null;
			$dept_id = $dept->id;
			return $dept_id;
		}
		catch(PDOException $e) 
		{
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
		

	}


//Getting the subject name..
function getSubjectName($subject_id){
	$sql = "SELECT subject FROM subject WHERE id = :subject_id";
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("subject_id", $subject_id);
			$stmt->execute();
			$dept = $stmt->fetchObject();
			$db = null;
			return $dept->subject;
		}
		catch(PDOException $e) 
		{
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}	
}

//Getting the subject name..
function getSubjectId($subject_name){
	$sql = "SELECT id FROM subject WHERE subject = :subject_name";
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("subject_name", $subject_name);
			$stmt->execute();
			$dept = $stmt->fetchObject();
			$db = null;
			return $dept->id;
		}
		catch(PDOException $e) 
		{
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}	
}


//Getting the faculty name
function getFacultyName($id){
	$sql = "SELECT first_name, last_name FROM faculty WHERE id = :id";
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("id", $id);
			$stmt->execute();
			$dept = $stmt->fetchObject();
			$db = null;
			return $dept->first_name .' '. $dept->last_name;
		}
		catch(PDOException $e) 
		{
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}	
}




//Getting period..
function getPeriod($period_entry_id){
	$sql = "SELECT period FROM period_join WHERE period_entry_id = :period_entry_id";
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("period_entry_id", $period_entry_id);
			$stmt->execute();
			$dept = $stmt->fetchAll(PDO::FETCH_OBJ);
			$db = null;
			$period_arr = array();
			foreach($dept as $period_id){
				array_push($period_arr, $period_id->period);	
			}
			return $period_arr;
		}
		catch(PDOException $e) 
		{
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}	
	
	
}




	
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
			echo 'header("Server Error");';
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
			echo 'header("Server Error");';
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
			echo 'header("Server Error");';
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
			echo 'header("Server Error");';
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
			echo 'header("Server Error");';
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
		}
	}//function to add department end here


	//addEntrybySection function
	function addEntryBysection(){
		$request = \Slim\Slim::getInstance()->request();
    	$dept = json_decode($request->getBody());
		//Now inserting to branch table...
		$sql = "INSERT INTO  `days_entry` (date, department_id, section_name, semester_id) VALUES (NOW(), :department_id, :section_name, :semester_id)";
		try {
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
		}
		
		//get subject id..
		$subject_id =  getSubjectId($dept->subjectName);
		
		
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
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
		//Now adding period...
		foreach($dept->period as $period)
		{
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
			}
			
		}
		//End of foreach loop...
		 echo json_encode($dept);
		
	}
	//End of addEntrybySection function


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
		
		$db = getConnection();
		$stmt = $db->prepare($sql_1);
        $stmt->bindParam("id", $deptId);
        $stmt->execute();
        $db = null;
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}//Function to delete department ends here...



	
	function getConnection() {
    $dbhost="127.0.0.1";
    $dbuser="root";
	
    $dbpass="";
    $dbname="attendance";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}
?>
