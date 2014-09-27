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
				PRIMARY KEY(id)
			);";
	$result = mysqli_query($dbc,$query);
	
	//CREATE TABLE  BRANCH
	$query = "CREATE TABLE branch
			 (
				id INT AUTO_INCREMENT NOT NULL ,
				department_id INT NOT NULL,
				semester_id INT NOT NULL,
				section_id INT NOT NULL,
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
	
	
	// CREATE TABLE SEMESTER
	$query = "CREATE TABLE semester
			(
				id INT AUTO_INCREMENT NOT NULL ,
				semester_name INT,
				PRIMARY KEY(id)
			);";
	$result = mysqli_query($dbc,$query);
	
	
	//CREATE TABLE CLASS
	$query = "CREATE TABLE class
		(
			id INT AUTO_INCREMENT NOT NULL ,
			department_id INT NOT NULL,
			section_id INT NOT NULL,
			semester_id INT NOT NULL,
			PRIMARY KEY(id)
		);";
	$result = mysqli_query($dbc,$query);
	
	
	//CREATE TABLE MAIN ENTRY
	$query = "CREATE TABLE main_entry
			(
				id INT AUTO_INCREMENT NOT NULL ,
				faculty_id INT,
				date DATETIME,
				subject VARCHAR(100),
				PRIMARY KEY(id)
			);";
	$result = mysqli_query($dbc,$query);
	
	
	//CREATE TABLE CLASS ENTRY
	$query = "CREATE TABLE class_entry
			(
				id INT AUTO_INCREMENT NOT NULL ,
				class_id INT NOT NULL,
				period_id INT,
				strength INT NOT NULL,
				PRIMARY KEY(id)
			);";
	$result = mysqli_query($dbc,$query);
	
	
	//CREATE TABLE CLASS JOIN
	$query = "CREATE TABLE class_join
			(
				main_entry_id INT,
				class_entry_id INT
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
	
	
	//CREATE TABLE PERIOD
	$query = "CREATE TABLE period
			(
				id INT AUTO_INCREMENT NOT NULL ,
				period INT,
				PRIMARY KEY(id)
			);";
	$result = mysqli_query($dbc,$query);
	
	
	//CREATE TABLE LAB ENTRY
	$query = "CREATE TABLE lab_entry
			(
				id INT AUTO_INCREMENT NOT NULL ,
				lab_id INT,
				strength INT NOT NULL,
				PRIMARY KEY(id)
			);";
	$result = mysqli_query($dbc,$query);
	
	
	//CREATE TABLE LAB
	$query = "CREATE TABLE lab
			(
				id INT AUTO_INCREMENT NOT NULL ,
				class_id INT NOT NULL,
				batch_id INT NOT NULL,
				PRIMARY KEY(id)
			);";
	$result = mysqli_query($dbc,$query);
	
	
	//CREATE TABLE LAB PERIOD JOIN
	$query = "CREATE TABLE lab_period_join
			(
				period_id INT NOT NULL,
				lab_entry_id INT NOT NULL,
			);";
	$result = mysqli_query($dbc,$query);
	
	
	//CREATE TABLE LAB JOIN
	$query = "CREATE TABLE lab_join
			(
				lab_entry_id INT NOT NULL,
				main_entry_id INT NOT NULL
			);";
	$result = mysqli_query($dbc,$query);
	
	
	mysqli_close($dbc);
?>