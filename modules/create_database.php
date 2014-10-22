<?php
	require_once('database_connection.php');
	$dbc = mysqli_connect(HOST,USERNAME,PASSWORD) or die('Connection Not Found');
	// CREATE DATABASE
	$query = "CREATE DATABASE `attendance`";
	//$result = mysqli_query($dbc,$query);
	
	
	// USE DATABASE
	$query = "USE attendance";
	$result = mysqli_query($dbc,$query);
	
	
	// CREATE TABLE FACULTY
	$query = "CREATE TABLE faculty
			 (
				id INT AUTO_INCREMENT NOT NULL ,
				first_name VARCHAR(50) NOT NULL,
				last_name VARCHAR(50) NOT NULL,
				username VARCHAR(50) NOT NULL,
				password VARCHAR(40) NOT NULL,
				department_id INT ,
				session_id VARCHAR(30),
				admin INT NOT NULL DEFAULT \'0\',
				email_address VARCHAR(100) ,
				status VARCHAR(20),
				forgot VARCHAR(100),
				last_loggedin DATETIME,
				user_level INT,
				PRIMARY KEY(id)
			);";
	$result = mysqli_query($dbc,$query);
	
	
	
	//CREATE TABLE  BRANCH
	$query = "CREATE TABLE branch
			 (
				id INT AUTO_INCREMENT NOT NULL ,
				department_id INT NOT NULL,
				semester_id INT NOT NULL,
				section_name INT NOT NULL,
			 	batch_id INT NOT NULL,
				PRIMARY KEY(id)
			);";
	$result = mysqli_query($dbc,$query);
	
	
	
	// CREATE TABLE DEPARTMENT
	$query = "CREATE TABLE department
			(
				id INT AUTO_INCREMENT NOT NULL ,
				name VARCHAR(50),
				PRIMARY KEY(id)
			);";
	$result = mysqli_query($dbc,$query);
	
	
	
	// CREATE TABLE SECTION
	$query = "CREATE TABLE section
			(
				id INT AUTO_INCREMENT NOT NULL ,
				section_name VARCHAR(50),
				PRIMARY KEY(id)
			);";
	$result = mysqli_query($dbc,$query);
	//Write insert table for writing default section..
	
	// CREATE TABLE SEMESTER
	$query = "CREATE TABLE semester
			(
				id INT AUTO_INCREMENT NOT NULL ,
				semester_name INT,
				PRIMARY KEY(id)
			);";
	$result = mysqli_query($dbc,$query);
	//Write insert table for writing default semester...
	
	
	//CREATE TABLE CLASS ENTRY
	$query = "CREATE TABLE  `subject`
			(
				id INT AUTO_INCREMENT NOT NULL ,
				subject VARCHAR(100),
				PRIMARY KEY(id)
			);";
	$result = mysqli_query($dbc,$query);
	
	
	//CREATE TABLE BATCH
	$query = "CREATE TABLE batch
			(
				id INT AUTO_INCREMENT NOT NULL ,
				batch_name INT,
				PRIMARY KEY(id)
			);";
	$result = mysqli_query($dbc,$query);
	
	
	//CREATE TABLE PERIOD_ENTRY
	$query = "CREATE TABLE period_entry
			(
				id INT AUTO_INCREMENT NOT NULL ,
				time TIME,
				subject_id INT,
				faculty_id  INT,
				lab INT,
				batch INT,
				strength INT,
				days_entry_id INT NOT NULL,
				INDEX days_id (days_entry_id),
				FOREIGN KEY (days_entry_id)
					REFERENCES days_entry(id)
					ON DELETE CASCADE,
				
				FOREIGN KEY (faculty_id)
					REFERENCES faculty(id),
					
				FOREIGN KEY (subject_id)
					REFERENCES subject(id),	
				
				PRIMARY KEY(id)
			);";
	$result = mysqli_query($dbc,$query);
	
	//CREATE TABLE DAYS_ENTRY
	$query = "CREATE TABLE days_entry
			(
				id INT AUTO_INCREMENT NOT NULL ,
				date DATE,
				department_id INT NOT NULL,
				semester_id INT NOT NULL,
				section_name CHAR(2) NOT NULL,
				INDEX depart_id (department_id),
				FOREIGN KEY (department_id)
					REFERENCES department(id)
					ON DELETE CASCADE,
				PRIMARY KEY(id)
			);";
	$result = mysqli_query($dbc,$query);
	
	//CREATE TABLE FOR FACULTY_LOG ENTRY..DEFAULT \'0\'
	$query = "CREATE  TABLE faculty_log
			 (
			 	`id` INT AUTO_INCREMENT NOT NULL,
				`date` DATE,
				`time` TIME,
				`entry_type` enum ('update','create','delete', 'password', 'entry', 'subject') NOT NULL,
				`info_entry_id`  INT,
				`faculty_id`  INT NOT NULL,
				`info` VARCHAR(200),
				`sub_info` VARCHAR(100),
				
				FOREIGN KEY (faculty_id)
					REFERENCES faculty(id)
					ON DELETE CASCADE,
                
				PRIMARY KEY(id)
				
			  );";
	

	//CREATE TABLE DAYS_ENTRY
	$query = "CREATE TABLE period_join
			(
				period_entry_id INT NOT NULL,
				FOREIGN KEY (period_entry_id)
					REFERENCES period_entry(id)
					ON DELETE CASCADE,
				period INT
			);";
	$result = mysqli_query($dbc,$query);
	mysqli_close($dbc);
?>