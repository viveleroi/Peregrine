<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//error_reporting(E_ALL);
//ini_set('display_errors', true);
/**
 * Description of Minicage
 *
 * @author michaelbotsko
 */
class CageBase {

	/**
	 *
	 * @var <type> 
	 */
	private $_raw;

	/**
	 *
	 * @var <type>
	 */
	private $_type;


	/**
	 *
	 * @param <type> $type 
	 */
	public final function __construct($type = 'post'){
		$this->_type = strtolower($type);
		$this->makeCage();
	}


	/**
	 *
	 * @param <type> $type 
	 */
	private function makeCage(){
		switch($this->_type){
			case 'post':
				$this->makeCage_post();
				break;
			case 'get':
				$this->makeCage_get();
				break;
		}
	}


	/**
	 * 
	 */
	private function makeCage_post(){
		$this->_raw = $_POST;
		unset($_POST);
	}


	/**
	 * 
	 */
	private function makeCage_get(){
		$this->_raw = $_GET;
		unset($_GET);
	}


	/**
	 *
	 * @param <type> $key
	 * @return <type> 
	 */
	private function getKey($key){
		if(array_key_exists($key, $this->_raw)){
			return $this->_raw[$key];
		}
	}


	/**
	 *
	 * @param <type> $key
	 * @return <type>
	 */
	public function getRaw($key = false){
		return $this->getKey($key);
	}


	/**
	 *
	 * @param <type> $key
	 * @return <type>
	 */
	public function getAlpha($key = false){
		return preg_replace('/[^[:alpha:]]/', '', $this->getKey($key));
	}


	/**
	 *
	 * @param <type> $key
	 * @return <type>
	 */
	public function getAlnum($key = false){
		return preg_replace('/[^[:alnum:]]/', '', $this->getKey($key));
	}


	/**
	 *
	 * @param <type> $key
	 * @return <type>
	 */
	public function getInt($key = false){
		return (int) $this->getKey($key);
	}

}


/**
 * 
 */
class Minicage {

	/**
	 *
	 * @return CageBase
	 */
	static public function post(){
		return new CageBase('post');
	}

	/**
	 *
	 * @return CageBase 
	 */
	static public function get(){
		return new CageBase('get');
	}
}
?>
