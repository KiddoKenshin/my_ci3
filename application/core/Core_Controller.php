<?php 

// CodeIgniter's default validation.
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

/**
 * The simple, main controller.
 * Ensure to extend this controller when adding new controller.
 * @author S.LEE
 * @since 2013/08/14
 */
class Core_Controller extends CI_Controller {
	
	/**
	 * Simple lecture on function's behaviour.
	 * PUBLIC : Everyone can access. Extended classes also owns the function too.
	 * PROTECTED : Only extended classes and local class are access-able. Extended classes do not own them.
	 * PRIVATE : Only executable within local class.
	 * Thus, extended classes have ability to overwrite the behaviour in their class.
	 */
	
	public $_allowedMethod = array('GET', 'POST');
	protected $_userData = NULL;
	private $_dumpData = '';
	
	/**
	 * Constructor (Simple Validate)
	 */
	public function __construct() {
		// Load parent constructor
		parent::__construct();
	}
	
	public function collectDump($mixed) {
		if (ENVIRONMENT !== 'development') {
			// Never perform debug in non-development environment
			return;
		}
		ob_start();
		var_dump($mixed);
		$this->_dumpData .= ob_get_clean();
	}
	
	/**
	 * ! PROTECTED ! Prevent user to do nasty work like load different view.
	 * Renders page with header and footer. (My customized load->view)
	 * 
	 * @param string $view : View to load
	 * @param array $data : Parameters to pass to view
	 * @param string $layout : Layout to use. (Refer views/layout)
	 * @return void
	 */
	protected function render($view, $data = array(), $layout = 'default_layout') {
		// Inherit $data and pass $view to load. 
		$viewParams = $data;
		$viewParams['content'] = $view;
		
		if (!isset($viewParams['metad'])) {
			$viewParams['metad'] = '';
		}
		
		if (!isset($viewParams['metak'])) {
			$viewParams['metak'] = '';
		}
		
		if (!isset($viewParams['pagetitle'])) {
			$viewParams['pagetitle'] = '';
		}
		
		if (ENVIRONMENT === 'development' && !empty($this->_dumpData)) {
			$viewParams['debug'] = $this->_dumpData;
		}
		
		// Uses Responsive design
		$layoutToUse = 'layouts/' . $layout; 
		if (@isset($_GET['plain']) && @$_GET['plain'] == 1) {
			$layoutToUse = 'layouts/plain_layout';
		}
		
		/*
		// Cache Control Headers
		header("Cache-Control: no-cache, must-revalidate"); // HTTP 1.1
		header("Pragma: no-cache"); // HTTP 1.0
		header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
		//*/
		
		// Load page
		$this->load->view($layoutToUse, $viewParams);
	}
	
	/**
	 * Loads the (Memcached) Cache driver and returns the Cache Object.
	 * 
	 * @return CI_Cache_memcached (Memcached CacheDriver's Object)
	 */
	protected function cacheDriver() {
		static $driver;
		// Initialize only once.
		if (is_null($driver)) {
			// Load memcached cache driver.
			$this->load->driver('cache', array('adapter' => 'memcached'));
			
			// Place driver into the static variable
			if ($this->cache->memcached->is_supported() === TRUE) {
				$driver = $this->cache->memcached;
			} else {
				// When memcached is not supported...
				throw new Exception('Initialization of MemcachedD Cache Driver failed.');
			}
		}
		// Return the object.
		return $driver;
	}
	
	protected function _isLogged() {
		static $ret;
		if (is_null($ret)) {
			$ret = FALSE;
			
			// Read from Cookie + Cached
			$credential = @$_COOKIE['USER_CREDENTIAL']; // MD5 Encoded Credential(UniqueID)
			if (!is_null($credential)) {
				// Credential Available
				// Proceed to Cached Verification
				$cacheKey = $credential . '_crendential_check';
				$memcached = $this->cacheDriver();
				$userData = $memcached->get($cacheKey);
				if ($userData !== FALSE) {
					$ret = TRUE;
				}
			}
		}
		return $ret;
	}
}


