<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends Core_Controller {
	
	public function index()	{
		// If logged in, redirect to homepage
		if ($this->_isLogged()) {
			$this->load->helper('url');
			redirect('/', 'refresh');
		}
		
		/* Work In Progress
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$errorMessages = array();
			$allowedPost = array(
				'name',
				'email'
			);
			$insertData = array(
				'uuid' => uuid_create(UUID_TYPE_RANDOM), // a0c10823-d07b-41c7-8ec0-f07193a6a03b
				'enc_password' => 'pending',
				'create_datetime' => date('Y-m-d H:i:s'),
				'update_datetime' => date('Y-m-d H:i:s')
			);
			foreach ($allowedPost as $key) {
				$insertData[$key] = $_POST[$key];
			}
			
			// Validate input
			if (filter_var($insertData['email'], FILTER_VALIDATE_EMAIL) === FALSE || strlen($insertData['email']) > 256) {
				// Error
				$errorMessages[] = 'EMAIL_ERR';
			}
			
			if (str_replace(' ', '', str_replace('　', '', $insertData['name'])) === '' || strlen($insertData['name']) > 128) {
				$errorMessages[] = 'NAME_ERR';
			}
			
			if (count($errorMessages) === 0) {
				$this->load->model('User_model', 'umodel');
				$recordId = $this->umodel->insert('user', $insertData);
				
				if ($recordId !== 0) {
					
				} else {
					// Error on Registration
				}
				// mail($insertData['email'], 'Validate your registration', 'Contents with Token URL', 'From: admin@yoursite.com', '-fadmin@yoursite.com');
			} else {
				// Show Error
			}
			
		}
		//*/
		exit;
	}
	
}
