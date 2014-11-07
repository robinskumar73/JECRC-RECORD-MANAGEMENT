<?php
 
 
	
	function getDepartmentNameById($deptId) {
		$sql = "SELECT name FROM department WHERE id=:deptId";
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("deptId", $deptId);
			$stmt->execute();
			$dept = $stmt->fetchObject();
			$db = null;
			return $dept->name;
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
			header("Server Error");
		}
    }//function to get department by id end here
	
	
	
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

	
	

	//Getting days entry by section...
	function days_entry_by_dept($dept_name, $limit, $offset )
	{
		$dept_id = getDepartmentId($dept_name);
		$sql = "SELECT * FROM days_entry WHERE department_id=:dept_id  ORDER BY semester_id, section_name, date DESC  LIMIT $limit OFFSET $offset";
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("dept_id", $dept_id);			
			//$stmt->bindParam("limit", $limit);
			//$stmt->bindParam("offset", $offset);
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
	function days_entry_by_year($year, $dept_name, $limit, $offset )
	{
		$dept_id = getDepartmentId($dept_name);
		$year_int = getYear($year);
		$sem = $year_int*2;
		$sql = "SELECT * FROM days_entry WHERE department_id=:dept_id AND semester_id IN ( :semester_id, :semester_id_)  ORDER BY date DESC  LIMIT $limit OFFSET $offset
 ";
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("semester_id", $year_int);
			$stmt->bindParam("semester_id_", $sem);
			$stmt->bindParam("dept_id", $dept_id);
			//$stmt->bindParam("limit", $limit);
			//$stmt->bindParam("offset", $offset);
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
	function days_entry_by_section($sem, $sec_name, $dept_name, $limit, $offset )
	{
		$dept_id = getDepartmentId($dept_name);
		$sql = "SELECT * FROM days_entry WHERE department_id=:dept_id AND semester_id = :semester_id AND section_name = :section_name ORDER BY  date DESC  LIMIT $limit OFFSET $offset";
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("semester_id", $sem);
			$stmt->bindParam("section_name", $sec_name);
			$stmt->bindParam("dept_id", $dept_id);
			//$stmt->bindParam("limit", $limit);
			//$stmt->bindParam("offset", $offset);
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
	
	
	//Getting days entry by date and section...
	function days_entry_by_section_and_date($semester_name, $section_name, $dept_name )
	{
		$dept_id = getDepartmentId($dept_name);
		$sql = "SELECT * FROM days_entry WHERE department_id=:dept_id AND semester_id = :semester_id AND section_name = :section_name AND date=CURDATE() ;";
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("semester_id", $semester_name);
			$stmt->bindParam("section_name", $section_name);
			$stmt->bindParam("dept_id", $dept_id);
			
			//$stmt->bindParam("today_date",  $today_date );
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
	
	
	
	function process_days_entry_obj($days_entry_array)
	{
		//creating an array..
		$days_array = array();
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
						  
						  //Creating a clone dept_one
						  $resp = clone($dept_one);
						  //Pushing to days_array array
						  array_push($days_array, $resp);	
				  }
				  	  
			  }
			  catch(PDOException $e) 
			  {
				  echo '{"error":{"text":'. $e->getMessage() .'}}';
				  header("Server Error");
			  }
		}//End of foreach loop	
		//return 
		return $days_array;
		
	}
	
	
	
	//Getting period..
	function deletePeriod($period_entry_id){
		
			$sql = "DELETE FROM `period_join`  WHERE period_entry_id = :period_entry_id";
				try {
					$db = getConnection();
					$stmt = $db->prepare($sql);
					$stmt->bindParam("period_entry_id", $period_entry_id);
					$stmt->execute();
					$db = null;
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
	
	//Getting period..
	function getPeriodEntry($period_entry_id){
		$sql = "SELECT * FROM period_entry WHERE id = :period_entry_id";
			try {
				$db = getConnection();
				$stmt = $db->prepare($sql);
				$stmt->bindParam("period_entry_id", $period_entry_id);
				$stmt->execute();
				$dept = $stmt->fetchObject();
				$db = null;
				return $dept;
			}
			catch(PDOException $e) 
			{
				echo '{"error":{"text":'. $e->getMessage() .'}}';
			}	
		
		
	}
	
	
	
	
	
	
	//Function for getting the info..
	function get_days_entry($id)
	{
		$sql = "SELECT * FROM  days_entry  WHERE id = :id";
		try {
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("id", $id);
			$stmt->execute();
			$dept = $stmt->fetchObject();
			$db = null;
			return $dept;
		}
		catch(PDOException $e) 
		{
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}	
		
			
	}
	
	
	//function for updating the subject_id
	function updatePeriodSubject($old_subject_id, $new_subject_id){
		
		$request = \Slim\Slim::getInstance()->request();
		$dept = json_decode($request->getBody());
		$faculty_id = $request->headers->get('faculty_id');
		
		
		if($faculty_id)
		{
			$sql = "UPDATE `period_entry` SET   `subject_id` = :new_subject_id WHERE subject_id = :old_subject_id "  ;
			   
			
			try 
			{
				
				$db = getConnection();
				$stmt = $db->prepare($sql);
				$stmt->bindParam("new_subject_id", $new_subject_id);
				$stmt->bindParam("old_subject_id", $old_subject_id);
				$stmt->execute();
				$db = null;
				
			} catch(PDOException $e) {
				header ('Server Error');
				echo '{"error":{"text":'. $e->getMessage() .'}}';
			}
		}
		
	}
	
	
	//Function for checking if subject name exists...
	function checkSubjectExists($subject_name){
		
		//Validation operations...
		if(!$subject_name && !matchSubjectName($subject_name))
		{	
			header ('Server Error');
			echo '{"error":{"text":'. 'Invalid characters in the subject field' .'}}';
			return false;
		}
		else
		{
			$sql = "SELECT id FROM subject WHERE subject = :subject_name";
			try {
				$db = getConnection();
				$stmt = $db->prepare($sql);
				$stmt->bindParam("subject_name", $subject_name);
				$stmt->execute();
				$dept = $stmt->fetchObject();
				$db = null;
				if($dept){
					return $dept->id;
				}
				else{
					return false;
				}
			}
			catch(PDOException $e) 
			{
				echo '{"error":{"text":'. $e->getMessage() .'}}';
				header('Server Error');
			}	
		}
	
	}//function for check subject_name ends..
	
	
	
	
	//Getting the subject name..
	function getSubjectId($subject_name, $faculty_id){
		
		//Validation operations...
		if(!$subject_name && !matchSubjectName($subject_name))
		{	
			header ('Server Error');
			echo '{"error":{"text":'. 'Invalid characters in the subject field' .'}}';
			return false;
		}
		else
		{
			$sql = "SELECT id FROM subject WHERE subject = :subject_name";
			try {
				$db = getConnection();
				$stmt = $db->prepare($sql);
				$stmt->bindParam("subject_name", $subject_name);
				$stmt->execute();
				$dept = $stmt->fetchObject();
				$db = null;
				//return $dept->id;
			}
			catch(PDOException $e) 
			{
				echo '{"error":{"text":'. $e->getMessage() .'}}';
				header('Server Error');
			}	
			
			if(!$dept){
				//Insert object first..
				$sql = "INSERT INTO `attendance`.`subject` (`id`, `subject`) VALUES (NULL, :subject_name);";
				try {
					$db = getConnection();
					$stmt = $db->prepare($sql);
					$stmt->bindParam("subject_name", $subject_name);
					$stmt->execute();
					$dept = $db->lastInsertId();
					$db = null;
					
				} catch(PDOException $e) {
					echo '{"error":{"text":'. $e->getMessage() .'}}';
				}
				
				//Now adding faculty log entry ..
				$sql = "INSERT INTO `attendance`.`faculty_log` (`id`, `date`, `time`, `entry_type`, `info_entry_id`, `faculty_id`, `info`, `sub_info` ) VALUES (NULL, CURDATE(), CURTIME(), \"subject\", :subject_id, :faculty_id, :message, :subMessage);";
				
				try {
					$db 		= getConnection();
					$stmt 		= $db->prepare($sql);
					$message 	= "Subject has been created.";
					$stmt->bindParam("faculty_id", $faculty_id);
					$stmt->bindParam("subject_id", $dept);
					$stmt->bindParam("message", $message);
					$stmt->bindParam("subMessage", $subject_name);
					$stmt->execute();
					$db = null;
				} catch(PDOException $e) {
					echo '{"error":{"text":'. $e->getMessage() .'}}';
				}
				
				//Returning the department...
				return $dept;
					
			}
			
			else{
				return $dept->id;
			}	
		}//End of else of validation...
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
	
	
	function entry_admin_log($entry_type, $faculty_id, $message, $sub_info, $info_entry_id )
	{
		$log_type = "admin";
		//Now adding FACULTY ENTRY LOG---
		$sql = "INSERT INTO `attendance`.`faculty_log` 
					(`id`, `date`, `time`, `entry_type`, `info_entry_id`, `faculty_id`, `info`, `sub_info`, `log_type`)VALUES 
					(NULL, CURDATE(), CURTIME(), :entry_type , :info_entry_id, :faculty_id, :message, :sub_info, :log_type);";
		try 
		{
			$db   = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("faculty_id",    $faculty_id);
			$stmt->bindParam("message",       $message);
			$stmt->bindParam("sub_info",      $sub_info);
			$stmt->bindParam("info_entry_id", $info_entry_id);
			$stmt->bindParam("entry_type",    $entry_type);
			$stmt->bindParam("log_type",      $log_type);
			$stmt->execute();
			$db = null;
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}	
	}//End of function of entry_admin_log
	
	
	
	function entry_faculty_log($entry_type, $faculty_id, $message, $sub_info, $info_entry_id )
	{
		//Now adding FACULTY ENTRY LOG---
		$sql = "INSERT INTO `attendance`.`faculty_log` 
					(`id`, `date`, `time`, `entry_type`, `info_entry_id`, `faculty_id`, `info`, `sub_info`)VALUES 
					(NULL, CURDATE(), CURTIME(), :entry_type , :info_entry_id, :faculty_id, :message, :sub_info);";
		//$subject_name = getSubjectName($days_info->subject_id);
		
		
		try 
		{
			$db   = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("faculty_id", $faculty_id);
			$stmt->bindParam("message", $message);
			$stmt->bindParam("sub_info", $sub_info);
			$stmt->bindParam("info_entry_id", $info_entry_id);
			$stmt->bindParam("entry_type", $entry_type);
			$stmt->execute();
			$db = null;
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}	
	}//End of function of entry_faculty_log
	
	
	
	function update_faculty_log( $id ,$entry_type, $faculty_id, $message, $sub_info, $info_entry_id )
	{
		//Now adding FACULTY ENTRY LOG---
		$sql = "UPDATE 
				`attendance`.`faculty_log` 
				 SET 				 				
				 	`date`         = CURDATE(),
				 	`time`         = CURTIME(),	
				 	`entry_type`   = :entry_type,
				 	`info_entry_id`= :info_entry_id,
				 	`info`         = :message,
				 	`sub_info`     = :sub_info
				WHERE 
					`id`		   = :id 
				AND
					`faculty_id`   = :faculty_id  
				";
		try 
		{
			$db   = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("id", $id);
			$stmt->bindParam("faculty_id", $faculty_id);
			$stmt->bindParam("message", $message);
			$stmt->bindParam("sub_info", $sub_info);
			$stmt->bindParam("info_entry_id", $info_entry_id);
			$stmt->bindParam("entry_type", $entry_type);
			$stmt->execute();
			$db = null;
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}	
	}//End of function of entry_faculty_log
	
	
	
	function getFacultyLogEntry( $id, $faculty_id ){	
		
		$sql = "SELECT * FROM `faculty_log` WHERE faculty_id = :faculty_id AND id = :id ;";
		try 
		{
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":id", $id);
			$stmt->bindParam(":faculty_id", $faculty_id);
			$stmt->execute();
			$dept_ = $stmt->fetchObject();
			$db = null;
			return $dept_;
		} catch(PDOException $e)
		{
			echo '{"error":{"text":'. $e->getMessage() .'}}';
			header("Server Error");
		}	
	}
	
	
	function countReturnedRows($whereString){
		
		$sql = "SELECT count(*) FROM `faculty` WHERE $whereString " ; 
		try 
		{
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->execute(); 
			$number_of_rows = $stmt->fetchColumn();
			return $number_of_rows; 
		} catch(PDOException $e)
		{
			echo '{"error":{"text":'. $e->getMessage() .'}}';
			header("Server Error");
		}	
		
	}
	
	
	
	function getMemberById( $id )
	{
		$sql = "SELECT * FROM `faculty` WHERE id=:id  ;";
		try 
		{
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":id", $id);
			$stmt->execute();
			$dept = $stmt->fetchObject();
			$db = null;
			return $dept;
		} catch(PDOException $e)
		{
			echo '{"error":{"text":'. $e->getMessage() .'}}';
			header("Server Error");
		}
	}
	
	/*-------------------------------------NOW APPLYING SOME VALIDATION FUNCTIONS------------------------------------*/
	/*
		$subject='Give me 10 eggs';
		$pattern='~\b(\d+)\s*(\w+)$~';
		$success = preg_match($pattern, $subject, $match);
	*/
	//MATCHES digit, name and whitespace, period, dashes only
	//Matches for subject validation name
	function matchSubjectName($subject)
	{
		$pattern = '/[^\d\s\w\.\-]/';
		$success = preg_match($pattern, $subject);
		if($success)	
		{
			//retun validation fails..
			return false;	
		}
		else
			return true;
	}
	
	
	function matchUserName($subject)
	{
		$pattern = '/[^\d\w\.\-\_]/';
		$success = preg_match($pattern, $subject);
		if($success)	
		{
			//retun validation fails..
			return false;	
		}
		else
			return true;
	}
	
	
	function matchName($subject)
	{
		$pattern = '/[^\w]/';
		$success = preg_match($pattern, $subject);
		if($success)	
		{
			//retun validation fails..
			return false;	
		}
		else
			return true;
	}
	
	
	function matchEmail($subject)
	{
		$pattern = '/[^\d\w\.\-\@\_]/';
		$success = preg_match($pattern, $subject);
		if($success)	
		{
			//retun validation fails..
			return false;	
		}
		else
			return true;
	}
	
	//Validation for numbers only..
	//Matches number only...
	function numberMatch($number)
	{
		$strength_pattern = '/[^\d]/';
		$success = preg_match($strength_pattern, $number);	
		if($success)
		{
			//return validation fails...
			return false;
		}
		else{
			//returns true if data is valid..
			return true;
		}
	}
	
	//For getting the random digit password...
	function randomPassword() {
	  $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
	  $pass = array(); //remember to declare $pass as an array
	  $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	  for ($i = 0; $i < 8; $i++) {
		  $n = rand(0, $alphaLength);
		  $pass[] = $alphabet[$n];
	  }
    return implode($pass); //turn the array into a string
	}


?>