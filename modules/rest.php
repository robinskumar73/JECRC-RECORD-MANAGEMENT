<?php

	require_once ('../Slim/Slim.php');
	//\Slim\Slim::registerAutoloader();

	//$app = new \Slim\Slim();
	$app = new Slim();
	// Get Methods of Department,Batch,Section,Semester
	$app->get('/department', 'getAllDepartment');
	$app->get('/department/:deptId','getDepartmentById');
	$app->get('/department/:deptId/semester','getAllSemester');
	$app->get('/department/:deptId/semester/:semId','getSemesterById');
	$app->get('/department/:deptId/semester/:semId/section','getAllSection');
	$app->get('/department/:deptId/semester/:semId/section/:secId','getSectionById');
	$app->get('/department/:deptId/semester/:semId/section/:secId/batch','getAllBatch');
	$app->get('/department/:deptId/semester/:semId/section/:secId/batch/:batchId','getBatchById');
	//Get Methods End Here
	
	//Post Methods of Department,Batch,Semester,Section
	$app->post('/department','addDepartment');
	$app->post('/department/:deptId/semester','addSemester');
	$app->post('/department/:deptId/semester/:semId/section','addSection');
	$app->post('/department/:deptId/semester/:semId/section/:secId/batch','addBatch');
	//Post Method End Here
	
	//Put Methods of Department,Batch,Semester,Section
	$app->put('/department/:deptId','updateDepartment');
	$app->put('/department/:deptId/semester/:semId','updateSemester');
	$app->put('/department/:deptId/semester/:semId/section/:secId','updateSection');
	$app->put('/department/:deptId/semseter/:semId/section/:secId/batch/:batchId','updateBatch');
	//Put Methods End Here
	
	//Delete Methods of Department,Batch,Semester,Section
	$app->delete('/department/:deptId/:deptName','deleteDepartment');
	$app->delete('/department/:deptId/semester/:semId/:semName','deleteSemester');
	$app->delete('/department/:deptId/semester/:semId/section/:secId/:secName','deleteSection');
	$app->delete('/department/:deptid/semester/:semId/section/:secId/batch/:batchId/:batchName','deleteBatch');
	//Delete Methods End Here
	
	$app->run();
	
	//function to get all department start here
	function getAllDepartment() {
    $sql = "SELECT department_name FROM department";
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


	//function to get all semester start here
	function getAllSemester($deptId) {
		$sql = "SELECT s.semester_name FROM semester as s
				INNER JOIN branch as b ON
				s.id = b.semester_id
				AND b.department_id = :deptId;";
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
}//function to get all semester end here


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
    $sql = "INSERT INTO branch (department_id) VALUES (:name) WHERE department.id = branch.department_id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("name", $dept->name);
        $stmt->execute();
        $dept->id = $db->lastInsertId();
        $db = null;
        echo json_encode($dept);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}//function to add department end here


//function to add Semester start here
function addSemester($deptId) {
    $request = Slim::getInstance()->request();
    $dept = json_decode($request->getBody());
    $sql = "INSERT INTO semester (semester_name) VALUES (:name)";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("name", $dept->name);
        $stmt->execute();
        $dept->id = $db->lastInsertId();
        $db = null;
        echo json_encode($dept);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}//function to add Semester end here


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
	
	function getConnection() {
    $dbhost="127.0.0.1";
    $dbuser="root";
	
    $dbpass="";
    $dbname="cellar";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}
?>