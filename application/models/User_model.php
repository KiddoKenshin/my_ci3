<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class User_model extends Core_Model {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function getUser($email, $rawPassword) {
		
	}
}


