<?php

require_once('../config/ConnectDb.php');

class DB_Model {

	public function __construct()
	{
		$instance = ConnectDb::getInstance();
		$this->dbconn = $instance->getConnection();
	}

	//************* Student table model query starts *************/
	public function Save_Students_Data($data){

		$result = array();

		try{
			$this->dbconn->beginTransaction();

			// insert sql prepare statement
			$insert_statement = $this->dbconn->prepare('INSERT INTO student_registration 
				(firstname, lastname, dob, contactno, created_datetime, modified_datetime) 
				VALUES (:firstname, :lastname, :dob, :contactno, :created_datetime, :modified_datetime)');

			$currentDate = date('Y-m-d H:i:s');

			//execute insert sql prepate statement
			$insert_statement->execute([
			    'firstname' => $data['firstname'],
			    'lastname' => $data['lastname'],
			    'dob' => $data['dob'],
			    'contactno' => $data['contactno'],
			    'created_datetime' => $currentDate,
			    'modified_datetime' => $currentDate
			]);

			$this->dbconn->commit();

			$result = array(
			'data' => '',
			'message' => '',
			'status' => 'SUCCESS'
			);
		}
		catch (Exception $e) {
			$this->dbconn->rollBack();
			$result = array(
			'data' => '',
			'message' => $e,
			'status' => 'ERROR'
			);
		}
		return $result;
	}

	public function GetAllStudents($data,$start_from,$record_per_page){

		$result = array();

		try{
			$this->dbconn->beginTransaction();

			$sSQL = "SELECT * FROM student_registration 
				WHERE delete_flag = 0 ORDER BY student_id DESC LIMIT $start_from,$record_per_page";
			$fSQL = $this->dbconn->prepare($sSQL);

			$fSQL->execute();
			$output = $fSQL->fetchAll(PDO::FETCH_ASSOC);

			$tSQL = $this->dbconn->prepare('SELECT count(*) as totalrow FROM student_registration 
				WHERE delete_flag=0');
			$tSQL->execute();
			$output_totalrows = $tSQL->fetch(PDO::FETCH_ASSOC);

			$this->dbconn->commit();

			$result = array(
			'allstudents' => $output,
			'paginaterows' => $output_totalrows,
			'message' => '',
			'status' => 'SUCCESS'
			);

		}
		catch (Exception $e) {
			$this->dbconn->rollBack();
			$result = array(
			'allstudents' => '',
			'paginaterows' => '',
			'message' => $e,
			'status' => 'ERROR'
			);
		}

		return $result;
	}

	public function GetSingleStudent($data){

		$result = array();

		try{

			$this->dbconn->beginTransaction();

			$fSQL = $this->dbconn->prepare("SELECT * FROM student_registration 
			WHERE student_id='".$data['student_id']."' AND delete_flag=0");
			$fSQL->execute();
			$output = $fSQL->fetchAll(PDO::FETCH_ASSOC);

			$this->dbconn->commit();

			$result = array(
			'data' => $output,
			'message' => '',
			'status' => 'SUCCESS'
			);
		}
		catch (Exception $e) {
			$this->dbconn->rollBack();
			$result = array(
			'allstudents' => '',
			'paginaterows' => '',
			'message' => $e,
			'status' => 'ERROR'
			);
		}

		return $result;	
	
	}

	public function UpdateStudent($data){

		$result = array();

		try{

			$this->dbconn->beginTransaction();

			// insert sql prepare statement
			$update_statement = $this->dbconn->prepare("UPDATE student_registration 
				SET firstname = :firstname, lastname = :lastname, dob = :dob, contactno = :contactno, modified_datetime = :modified_datetime WHERE student_id = :student_id");
			
			$currentDate = date('Y-m-d H:i:s');

			//execute insert sql prepate statement
			$update_statement->execute([
			    'firstname' => $data['firstname'],
			    'lastname' => $data['lastname'],
			    'dob' => $data['dob'],
			    'contactno' => $data['contactno'],
			    'modified_datetime' => $currentDate,
			    'student_id' => $data['student_id']
			]);

			$this->dbconn->commit();

			$result = array(
			'data' => '',
			'message' => '',
			'status' => 'SUCCESS'
			);

		}
		catch (Exception $e) {
			$this->dbconn->rollBack();
			$result = array(
			'allstudents' => '',
			'paginaterows' => '',
			'message' => $e,
			'status' => 'ERROR'
			);
		}

		return $result;	

	}

	public function DeleteStudent($data){

		$result = array();

		try{

			$this->dbconn->beginTransaction();

			// insert sql prepare statement
			$update_statement = $this->dbconn->prepare("UPDATE student_registration 
				SET delete_flag = :delete_flag, modified_datetime = :modified_datetime WHERE student_id = :student_id");
			
			$currentDate = date('Y-m-d H:i:s');

			//execute insert sql prepate statement
			$update_statement->execute([
			    'modified_datetime' => $currentDate,
			    'delete_flag' => 1,
			    'student_id' => $data['student_id']
			]);

			$this->dbconn->commit();

			$result = array(
			'data' => '',
			'message' => '',
			'status' => 'SUCCESS'
			);
		}
		catch (Exception $e) {
			$this->dbconn->rollBack();
			$result = array(
			'allstudents' => '',
			'paginaterows' => '',
			'message' => $e,
			'status' => 'ERROR'
			);
		}

		return $result;	
	}

	//************* Student table model query Ends *************/

	//************* Course table model query starts *************/
	public function Save_Course_Data($data){

		$result = array();

		try{
			$this->dbconn->beginTransaction();

			// insert sql prepare statement
			$insert_statement = $this->dbconn->prepare('INSERT INTO course_details 
				(course_name, course_details, created_datetime, modified_datetime) 
				VALUES (:course_name, :course_details, :created_datetime, :modified_datetime)');
			
			$currentDate = date('Y-m-d H:i:s');

    		//execute insert sql prepate statement
			$insert_statement->execute([
			    'course_name' => $data['coursename'],
			    'course_details' => $data['course_details'],
			    'created_datetime' => $currentDate,
			    'modified_datetime' => $currentDate
			]);

			$this->dbconn->commit();

			$result = array(
			'data' => '',
			'message' => '',
			'status' => 'SUCCESS'
			);
		}
		catch (Exception $e) {
			$this->dbconn->rollBack();
			$result = array(
			'data' => '',
			'message' => $e,
			'status' => 'ERROR'
			);
		}
		return $result;
	}

	public function GetAllCourses($data,$start_from,$record_per_page){

		$result = array();

		try{
			$this->dbconn->beginTransaction();

			$sSQL = "SELECT * FROM course_details
			WHERE delete_flag = 0 ORDER BY course_id DESC LIMIT $start_from,$record_per_page";

			$fSQL = $this->dbconn->prepare($sSQL);

			$fSQL->execute();
			$output = $fSQL->fetchAll(PDO::FETCH_ASSOC);

			$tSQL = $this->dbconn->prepare('SELECT count(*) as totalrow FROM course_details 
				WHERE delete_flag=0');
			$tSQL->execute();
			$output_totalrows = $tSQL->fetch(PDO::FETCH_ASSOC);

			$this->dbconn->commit();

			$result = array(
			'allcourses' => $output,
			'paginaterows' => $output_totalrows['totalrow'],
			'message' => '',
			'status' => 'SUCCESS'
			);

		}
		catch (Exception $e) {
			$this->dbconn->rollBack();
			$result = array(
			'allstudents' => '',
			'paginaterows' => '',
			'message' => $e,
			'status' => 'ERROR'
			);
		}
		return $result;
	}

	public function GetSingleCourse($data){

		$result = array();

		try{

			$this->dbconn->beginTransaction();

			$fSQL = $this->dbconn->prepare("SELECT * FROM course_details 
				WHERE course_id='".$data['course_id']."' AND delete_flag=0");
			$fSQL->execute();
			$output = $fSQL->fetchAll(PDO::FETCH_ASSOC);

			$this->dbconn->commit();

			$result = array(
			'data' => $output,
			'message' => '',
			'status' => 'SUCCESS'
			);
		}
		catch (Exception $e) {
			$this->dbconn->rollBack();
			$result = array(
			'data' => '',
			'paginaterows' => '',
			'message' => $e,
			'status' => 'ERROR'
			);
		}

		return $result;	
	}

	public function UpdateCourse($data){

		$result = array();

		try{

			$this->dbconn->beginTransaction();

			// insert sql prepare statement
			$update_statement = $this->dbconn->prepare("UPDATE course_details 
				SET course_name = :course_name, course_details = :course_details, 
				modified_datetime = :modified_datetime WHERE course_id = :course_id");
			
			$currentDate = date('Y-m-d H:i:s');

    		//execute insert sql prepate statement
			$update_statement->execute([
			    'course_name' => $data['coursename'],
			    'course_details' => $data['course_details'],
			    'modified_datetime' => $currentDate,
			    'course_id' => $data['course_id']
			]);

			$this->dbconn->commit();

			$result = array(
			'data' => '',
			'message' => '',
			'status' => 'SUCCESS'
			);

		}
		catch (Exception $e) {
			$this->dbconn->rollBack();
			$result = array(
			'data' => '',
			'paginaterows' => '',
			'message' => $e,
			'status' => 'ERROR'
			);
		}

		return $result;	

	}

	public function DeleteCourse($data){

		$result = array();

		try{

			$this->dbconn->beginTransaction();

			// update sql prepare statement
			$update_statement = $this->dbconn->prepare("UPDATE course_details SET delete_flag = :delete_flag, modified_datetime = :modified_datetime WHERE course_id = :course_id");
			
			$currentDate = date('Y-m-d H:i:s');

    		//execute insert sql prepate statement
			$update_statement->execute([
			    'modified_datetime' => $currentDate,
			    'delete_flag' => 1,
			    'course_id' => $data['course_id']
			]);

			$this->dbconn->commit();

			$result = array(
			'data' => '',
			'message' => '',
			'status' => 'SUCCESS'
			);
		}
		catch (Exception $e) {
			$this->dbconn->rollBack();
			$result = array(
			'data' => '',
			'paginaterows' => '',
			'message' => $e,
			'status' => 'ERROR'
			);
		}

		return $result;
	}

	public function StudentCourseData(){
		
		$result = array();

		try{
			
			$this->dbconn->beginTransaction();

			$SSQL = $this->dbconn->prepare("SELECT * FROM student_registration WHERE delete_flag=0");
			$SSQL->execute();
			$Student_output = $SSQL->fetchAll(PDO::FETCH_ASSOC);

			$CSQL = $this->dbconn->prepare("SELECT * FROM course_details WHERE delete_flag=0");
			$CSQL->execute();
			$Course_output = $CSQL->fetchAll(PDO::FETCH_ASSOC);

			$outputdata = array('students'=>$Student_output,'courses'=>$Course_output);

			$this->dbconn->commit();

			$result = array(
			'data' => $outputdata,
			'message' => '',
			'status' => 'SUCCESS'
			);
		}
		catch (Exception $e) {
			$this->dbconn->rollBack();
			$result = array(
			'data' => '',
			'paginaterows' => '',
			'message' => $e,
			'status' => 'ERROR'
			);
		}

		return $result;

	}

	public function Save_StudentCourse_Data($data){
		$result = array();

		try{
			
			$this->dbconn->beginTransaction();

			// insert sql prepare statement
			$insert_statement = $this->dbconn->prepare('INSERT INTO course_registration 
				(student_id, course_id, created_datetime, modified_datetime) 
				VALUES (:student_id, :course_id, :created_datetime, :modified_datetime)');
			
			$currentDate = date('Y-m-d H:i:s');

    		//execute insert sql prepate statement
			$insert_statement->execute([
			    'student_id' => $data['student_id'],
			    'course_id' => $data['course_id'],
			    'created_datetime' => $currentDate,
			    'modified_datetime' => $currentDate
			]);

			$this->dbconn->commit();

			$result = array(
			'data' => '',
			'message' => '',
			'status' => 'SUCCESS'
			);

		}
		catch (Exception $e) {
			$this->dbconn->rollBack();
			$result = array(
			'data' => '',
			'paginaterows' => '',
			'message' => $e,
			'status' => 'ERROR'
			);
		}

		return $result;
	}

	public function GetRegCourses($data,$start_from,$record_per_page){
		
		$result = array();

		try{
			
			$this->dbconn->beginTransaction();

			$SQL = "SELECT t2.course_name,t3.firstname,t3.lastname FROM course_registration t1 
				JOIN course_details t2 ON t2.course_id=t1.course_id
				JOIN student_registration t3 ON t3.student_id=t1.student_id ORDER BY t1.coursereg_id DESC 
				LIMIT $start_from,$record_per_page";

			$SSQL = $this->dbconn->prepare($SQL);
			$SSQL->execute();
			$output = $SSQL->fetchAll(PDO::FETCH_ASSOC);

			$SQL1 = "SELECT count(*) as totalrows FROM course_registration ";
			$tSQL = $this->dbconn->prepare($SQL1);
			$tSQL->execute();
			
			$output_totalrows = $tSQL->fetch(PDO::FETCH_ASSOC);

			$this->dbconn->commit();
			$result = array(
			'data' => $output,
			'totalrows' => $output_totalrows['totalrows'],
			'message' => 'Fetch data',
			'status' => 'SUCCESS'
			);
		}
		catch (Exception $e) {
			$this->dbconn->rollBack();
			$result = array(
			'data' => '',
			'paginaterows' => '',
			'message' => $e,
			'status' => 'ERROR'
			);
		}

		return $result;
	}
}

?>