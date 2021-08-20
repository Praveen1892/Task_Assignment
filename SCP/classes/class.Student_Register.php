<?php

require_once('../models/class.DB_Model.php');

class Student_Register {

	public function __construct()
	{
		$this->db_model = new DB_Model();
	}

	public function Insert_Student_Data($data){
		
		$result = array();

		try{
			//insert student registration
			if($data['form'] == 'insert'){
				
				$db_res = $this->db_model->Save_Students_Data($data);

				if($db_res['status'] == 'SUCCESS'){
					$result = array(
					'data' => '',
					'message' => 'Student registration is successfull',
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
				'message' => 'Student registration Failed due to internal error',
				'status' => '500'
			);
		}
		
		return $result;
	}

	public function Get_Student_Data($data){
		
		$record_per_page = (int)1;
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

				$db_res = $this->db_model->GetAllStudents($data,$start_from,$record_per_page);

				if($db_res['status'] == 'SUCCESS'){
					
					$total_records = $db_res['paginaterows']['totalrow'];
					$total_pages = ceil($total_records/$record_per_page);

					for($i=1;$i<=$total_pages;$i++){
						$paginate_output .= "<span class='pagination_link' style='cursor:pointer;padding:6px;border:1px solid #ccc;' id='".$i."'>".$i."</span>"; 
					}		
					
					$result = array(
					'data' => $db_res['allstudents'],
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

	public function Get_Individual_Student_Data($data){

		$result = array();

		try{
			//insert student registration
			if($data['form'] == 'edit'){

				$db_res = $this->db_model->GetSingleStudent($data);
				
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

	public function Update_Student_Data($data){

		$result = array();

		try{
			//insert student registration
			if($data['form'] == 'update'){
				
				$db_res = $this->db_model->UpdateStudent($data);

				if($db_res['status'] == 'SUCCESS'){
					$result = array(
					'data' => '',
					'message' => 'Student updated successfully',
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
				'message' => 'Student update Failed due to internal error',
				'status' => '500'
			);
		}
		
		return $result;
	}

	public function Delete_Student_Data($data){
		$result = array();

		try{
			//insert student registration
			if($data['form'] == 'delete'){
					
				$db_res = $this->db_model->DeleteStudent($data);

				if($db_res['status'] == 'SUCCESS'){
					$result = array(
					'data' => '',
					'message' => 'Student removed successfully',
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
				'message' => 'Student delete Failed due to internal error',
				'status' => '500'
			);
		}
		
		return $result;
	}
}