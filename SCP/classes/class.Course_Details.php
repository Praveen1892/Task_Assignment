<?php

require_once('../models/class.DB_Model.php');

class Course_Details {

	public function __construct()
	{
		$this->db_model = new DB_Model();
	}

	public function Insert_Course_Data($data){
		
		$result = array();

		try{
			//insert student registration
			if($data['form'] == 'insert'){
				
				$db_res = $this->db_model->Save_Course_Data($data);

				if($db_res['status'] == 'SUCCESS'){
					$result = array(
					'data' => '',
					'message' => 'Course Data added successfully',
					'status' => '200'
				);	
				}else{
					$result = array(
					'data' => '',
					'message' => 'DB Error, could not save',
					'status' => '403'
					);
				}
				
			}else{
				$result = array(
					'data' => '',
					'message' => 'Invalid form submission',
					'status' => '403'
				);
			}
				
		}
		catch (Exception $e) {
			$result = array(
				'data' => '',
				'message' => 'Course Data Failed due to internal error',
				'status' => '500'
			);
		}
		
		return $result;
	}

	public function Get_Course_Data($data){
		
		$record_per_page = (int)2;
		$page = '';
		$paginate_output = '';

		if(isset($data['page'])){
			$page = $data['page'];
		}else{
			$page = 1;
		}

		$start_from = ($page - 1)*$record_per_page;
		$start_from = (int)$start_from;

		$result = array();

		try{
			//insert student registration
			if($data['form'] == 'fetch'){

				$db_res = $this->db_model->GetAllCourses($data,$start_from,$record_per_page);

				if($db_res['status'] == 'SUCCESS'){
					
					$total_records = $db_res['paginaterows'];
					$total_pages = ceil($total_records/$record_per_page);

					for($i=1;$i<=$total_pages;$i++){
						$paginate_output .= "<span class='pagination_link' style='cursor:pointer;padding:6px;border:1px solid #ccc;' id='".$i."'>".$i."</span>"; 
					}		
					
					$result = array(
					'data' => $db_res['allcourses'],
					'paginate' => $paginate_output,
					'message' => 'Fetched all data',
					'status' => '200'
					);

				}else{
					$result = array(
					'data' => '',
					'paginate' => '',
					'message' => 'No data found',
					'status' => '404'
					);
				}

			}
			else{
				$result = array(
					'data' => '',
					'message' => 'Invalid form submission',
					'status' => '403'
				);
			}
		}
		catch (Exception $e) {
			$result = array(
				'data' => '',
				'message' => 'Unable to get data, Failed due to internal error',
				'status' => '500'
			);
		}
		
		return $result;
	}

	public function Get_Individual_Course_Data($data){

		$result = array();

		try{
			//insert student registration
			if($data['form'] == 'edit'){
				
				$db_res = $this->db_model->GetSingleCourse($data);
				
				$result = array(
					'data' => $db_res['data'],
					'message' => 'Fetched data',
					'status' => '200'
				);

			}
			else{
				$result = array(
					'data' => '',
					'message' => 'Invalid form submission',
					'status' => '403'
				);
			}
		}
		catch (Exception $e) {
			$result = array(
				'data' => '',
				'message' => 'Unable to get data, Failed due to internal error',
				'status' => '500'
			);
		}
		
		return $result;	
	}

	public function Update_Course_Data($data){

		$result = array();

		try{
			//insert student registration
			if($data['form'] == 'update'){
				
				$db_res = $this->db_model->UpdateCourse($data);

				if($db_res['status'] == 'SUCCESS'){
					$result = array(
					'data' => '',
					'message' => 'Course updated successfully',
					'status' => '200'
					);	
				}else{
					$result = array(
					'data' => '',
					'message' => 'DB Error, could not save',
					'status' => '403'
					);
				}

			}else{
				$result = array(
					'data' => '',
					'message' => 'Invalid form submission',
					'status' => '403'
				);
			}
				
		}
		catch (Exception $e) {
			$result = array(
				'data' => '',
				'message' => 'Course update Failed due to internal error',
				'status' => '500'
			);
		}
		
		return $result;
	}

	public function Delete_Course_Data($data){
		$result = array();

		try{
			//insert student registration
			if($data['form'] == 'delete'){
				
				$db_res = $this->db_model->DeleteCourse($data);

				if($db_res['status'] == 'SUCCESS'){
					$result = array(
					'data' => '',
					'message' => 'Course removed successfully',
					'status' => '200'
					);	
				}else{
					$result = array(
					'data' => '',
					'message' => 'DB Error, could not save',
					'status' => '403'
					);
				}

				
			}else{
				$result = array(
					'data' => '',
					'message' => 'Invalid form submission',
					'status' => '403'
				);
			}
				
		}
		catch (Exception $e) {
			$result = array(
				'data' => '',
				'message' => 'Course delete Failed due to internal error',
				'status' => '500'
			);
		}
		
		return $result;
	}

	public function GetStudentCourseData(){
		
		$result = array();

		try{

			$db_res = $this->db_model->StudentCourseData();

			if($db_res['status'] == 'SUCCESS'){
				$result = array(
				'data' => $db_res['data'],
				'message' => 'Fetched data',
				'status' => '200'
				);	
			}else{
				$result = array(
				'data' => '',
				'message' => 'DB Error, could not save',
				'status' => '403'
				);
			}

			
		}
		catch (Exception $e) {
			$result = array(
				'data' => '',
				'message' => 'Could not fetch data, Failed due to internal error',
				'status' => '500'
			);
		}
		
		return $result;
	}

	public function Register_StudentCourse_Data($data){
		$result = array();

		try{
			if($data['form'] == 'insertcourse'){
				
				$db_res = $this->db_model->Save_StudentCourse_Data($data);

				if($db_res['status'] == 'SUCCESS'){
					$result = array(
					'data' => '',
					'message' => 'Data added successfully',
					'status' => '200'
				);	
				}else{
					$result = array(
					'data' => '',
					'message' => 'DB Error, could not save',
					'status' => '403'
					);
				}

			}else{
				$result = array(
					'data' => '',
					'message' => 'Invalid form submission',
					'status' => '403'
				);
			}
		}
		catch (Exception $e) {
			$result = array(
				'data' => '',
				'message' => 'Could not insert data, Failed due to internal error',
				'status' => '500'
			);
		}
		
		return $result;
	}

	public function Reg_Course_Data($data){

		$record_per_page = (int)2;
		$page = '';
		$paginate_output = '';

		if(isset($data['page'])){
			$page = $data['page'];
		}else{
			$page = 1;
		}

		$start_from = ($page - 1)*$record_per_page;
		$start_from = (int)$start_from;

		$result = array();

		try{

			$db_res = $this->db_model->GetRegCourses($data,$start_from,$record_per_page);

			if($db_res['status'] == 'SUCCESS'){
				
				$total_records = $db_res['totalrows'];
				// $total_records = $fSQL->rowCount();
				$total_pages = ceil($total_records/$record_per_page);

				for($i=1;$i<=$total_pages;$i++){
					$paginate_output .= "<span class='pagination_link' style='cursor:pointer;padding:6px;border:1px solid #ccc;' id='".$i."'>".$i."</span>"; 
				}

				$result = array(
					'data' => $db_res['data'],
					'paginate' => $paginate_output,
					'trecs' => $total_records,
					'tp' => $total_pages,
					'message' => 'Fetched all data',
					'status' => '200'
				);

			}
				
		}
		catch (Exception $e) {
			$result = array(
				'data' => '',
				'message' => 'Could not fetch data, Failed due to internal error',
				'status' => '500'
			);
		}
		
		return $result;
	}
}