<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sample extends Core_Controller {
	public function index()	{
		$this->render('nested/sample/index');
	}
}
