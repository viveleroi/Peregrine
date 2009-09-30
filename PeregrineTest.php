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
	public function test_isEmpty() {
		$peregrine = new Peregrine;
		$my_arr = array('test'=>0,'test2'=>'full');
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals(true, $arr->isEmpty('test'));
		$this->assertEquals(false, $arr->isEmpty('test2'));
	}


	/**
	 *
	 */
	public function test_isBetween() {
		$peregrine = new Peregrine;
		$my_arr = array('test'=>5);
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals(true, $arr->isBetween('test', 4, 6));
		$this->assertEquals(true, $arr->isBetween('test', 3, 5));
		$this->assertEquals(false, $arr->isBetween('test', 3, 5, false));
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
	public function test_isAlpha() {
		$peregrine = new Peregrine;
		$my_arr = array('test'=>ALL_CHAR_STRING,'test2'=>'abc');
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals(false, $arr->isAlpha('test'));
		$this->assertEquals(true, $arr->isAlpha('test2'));
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
	public function test_isAlnum() {
		$peregrine = new Peregrine;
		$my_arr = array('test'=>ALL_CHAR_STRING,'test2'=>'abc123');
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals(false, $arr->isAlnum('test'));
		$this->assertEquals(true, $arr->isAlnum('test2'));
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
	public function test_isInt() {
		$peregrine = new Peregrine;
		$my_arr = array('test'=>ALL_CHAR_STRING,'test2'=>123);
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals(false, $arr->isInt('test'));
		$this->assertEquals(true, $arr->isInt('test2'));
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


//	/**
//	 *
//	 */
//	public function test_getDigits() {
//		$peregrine = new Peregrine;
//		$my_arr = array('test'=>'ABC10.123');
//		$arr = $peregrine->sanitize( $my_arr );
//		$this->assertEquals('10123', $arr->getDigits('test'));
//	}
//
//
//	/**
//	 *
//	 */
//	public function test_isDigits() {
//		$peregrine = new Peregrine;
//		$my_arr = array('test'=>ALL_CHAR_STRING,'test2'=>123);
//		$arr = $peregrine->sanitize( $my_arr );
//		$this->assertEquals(false, $arr->isDigits('test'));
//		$this->assertEquals(true, $arr->isDigits('test2'));
//
//	}
//
//
//	/**
//	 *
//	 */
//	public function test_getFloat() {
//		$peregrine = new Peregrine;
//		$my_arr = array('test'=>'AB10.123','test2'=>123,'test3'=>123.00,'test4'=>127.27);
//		$arr = $peregrine->sanitize( $my_arr );
//		$this->assertEquals('10.123', $arr->getFloat('test'));
//		$this->assertEquals('123', $arr->getFloat('test2'));
//		$this->assertEquals('123.00', $arr->getFloat('test3'));
//		$this->assertEquals('127.27', $arr->getFloat('test4'));
//	}


	/**
	 *
	 */
	public function test_isFloat() {
		$peregrine = new Peregrine;
		$my_arr = array('test'=>ALL_CHAR_STRING,'test2'=>123.02);
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals(false, $arr->isFloat('test'));
		$this->assertEquals(true, $arr->isFloat('test2'));
	}
}
?>