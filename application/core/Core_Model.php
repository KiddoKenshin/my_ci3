<?php

// CodeIgniter's default validation.
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

/**
 * The simple, main DataMapper.
 * Ensure to extend this model when adding new model.
 * @author S.LEE
 * @since 2013/08/15
 */
class Core_Model extends CI_Model {
	
	/**
	 * Simple lecture on function's behaviour.
	 * PUBLIC : Everyone can access. Extended classes also owns the function too.
	 * PROTECTED : Only extended classes and local class are access-able. Extended classes do not own them.
	 * PRIVATE : Only executable within local class.
	 * Thus, extended classes have ability to overwrite the behaviour in their class.
	 */
	
	/**
	 * Just another constructor.
	 * 
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * Returns Database Writer.
	 * 
	 * @return CI_DB_mysql_driver
	 */
	public function getDBWriter() {
		static $writer;
		// Initialize only once.
		if (is_null($writer)) {
			$writer = $this->load->database('writeenable', TRUE);
		}
		return $writer;
	}
	
	/**
	 * Parent Override.
	 */
	public function insert($table = '', $set = NULL, $escape = NULL) {
		$this->getDBWriter()->insert($table, $set, $escape);
		return $this->getDBWriter()->insert_id();
	}
	
	/**
	 * Parent Override.
	 */
	public function update($table = '', $set = NULL, $where = NULL, $limit = NULL) {
		$this->getDBWriter()->update($table, $set, $where, $limit);
	}
	
}


