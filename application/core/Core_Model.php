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
class Core_Model extends CI_Mapper {
	
	/**
	 * Simple lecture on function's behaviour.
	 * PUBLIC : Everyone can access. Extended classes also owns the function too.
	 * PROTECTED : Only extended classes and local class are access-able. Extended classes do not own them.
	 * PRIVATE : Only executable within local class.
	 * Thus, extended classes have ability to overwrite the behaviour in their class.
	 */
	
	/**
	 * Stores CI_DB_mysql_driver
	 */
	public $ori_db;
	
	/**
	 * Just another constructor.
	 * 
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * Returns Database Reader.
	 * 
	 * @return CI_DB_mysql_driver
	 */
	public function getDBReader() {
		static $reader;
		// Initialize only once.
		if (is_null($reader)) {
			$reader = $this->load->database('default', TRUE);
		}
		return $reader;
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
	public function save($object = '', $related_field = '') {
		// Store Previous DB Access (Read only)
		$this->ori_db = $this->db;
		
		// Enable Write Mode. (Use DB Writer)
		$this->db = $this->getDBWriter();
		
		// Call parent function.
		parent::save($object, $related_field);
		
		// Close DB Writer and Replace it with the previous DB Access (Read Only)
		// $this->db->close(); // Do not close connection 2013/09/02 (For Resource Reusability)
		$this->db = $this->ori_db;
	}
	
	/**
	 * Parent Override.
	 */
	public function update($field, $value = NULL, $escape_values = TRUE) {
		// Store Previous DB Access (Read only)
		$this->ori_db = $this->db;
		
		// Enable Write Mode. (Use DB Writer)
		$this->db = $this->getDBWriter();
		
		// Call parent function.
		parent::update($field, $value, $escape_values);
		
		// Close DB Writer and Replace it with the previous DB Access (Read Only)
		// $this->db->close(); // Do not close connection 2013/09/02 (For Resource Reusability)
		$this->db = $this->ori_db;
	}
	
	/**
	 * Returns Database Root Access.
	 */
	public function getRootAccess() {
		// Disabled.
		throw new Exception('Root Access is Disabled.');
		
	}
	
}


