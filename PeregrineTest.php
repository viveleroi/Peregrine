<?php

require_once 'Peregrine.php';

define('ALL_CHAR_STRING', 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789~!@#$%^&*()_+=-[]{}|\\:"\'?/>.<,');

/**
 * 
 */
class PeregrineTest extends PHPUnit_Framework_TestCase {


	/**
	 *
	 */
	public function test_ensureSanitizeDestroysOrigArray() {
		$peregrine = new Peregrine;
		$my_arr = array('test'=>ALL_CHAR_STRING);
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals(NULL, $my_arr);
	}
	

	/**
	 * 
	 */
	public function test_getRaw() {
		$peregrine = new Peregrine;
		$my_arr = array('test'=>ALL_CHAR_STRING);
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals(ALL_CHAR_STRING, $arr->getRaw('test'));
	}


	/**
	 *
	 */
	public function test_getAlpha() {
		$peregrine = new Peregrine;
		$my_arr = array('test'=>ALL_CHAR_STRING);
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', $arr->getAlpha('test'));
	}

	
	/**
	 *
	 */
	public function test_getAlnum() {
		$peregrine = new Peregrine;
		$my_arr = array('test'=>ALL_CHAR_STRING);
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', $arr->getAlnum('test'));
	}


	/**
	 *
	 */
	public function test_getInt_string() {
		$peregrine = new Peregrine;
		$my_arr = array('test'=>ALL_CHAR_STRING);
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals(0, $arr->getInt('test'));
	}


	/**
	 *
	 */
	public function test_getInt_int() {
		$peregrine = new Peregrine;
		$my_arr = array('test'=>123);
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals(123, $arr->getInt('test'));
	}


	/**
	 *
	 */
	public function test_getInt_float() {
		$peregrine = new Peregrine;
		$my_arr = array('test'=>123.02);
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals(123, $arr->getInt('test'));
	}
}
?>