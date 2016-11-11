<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Core_Controller {
	
	public function login()	{
		// If logged in, redirect to homepage
		if ($this->_isLogged()) {
			$this->load->helper('url');
			redirect('/', 'refresh');
		}
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			return;
			$cookieHash = md5($id . '_' . $_SERVER['HTTP_USER_AGENT']);
			setcookie('USER_CREDENTIAL', $cookieHash, time() + (60 * 60 * 24), '/'); // 1Day
			
			$memcached = $this->cacheDriver();
			$cacheKey = $cookieHash . '_crendential_check';
			$result = $memcached->save($cacheKey, '', 60 * 60 * 24);
			
			$this->load->helper('url');
			redirect('/', 'refresh'); // TODO: Load last visit page
		}
	}
	
	public function register()	{
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
	
	public function validate() {
		
	}
	
	public function forgetpassword() {
		
	}
	
	public function index() {
		// Goto Mypage
	}
	
	public function mypage() {
		
	}
	
	public function history() {
		
	}
}
