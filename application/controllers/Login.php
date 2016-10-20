<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends Core_Controller {
	
	public function index()	{
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
	
}
