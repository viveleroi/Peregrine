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
	public function test_isGreaterThan() {
		$peregrine = new Peregrine;
		$my_arr = array('test'=>5);
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals(false, $arr->isGreaterThan('test', 5));
		$this->assertEquals(true, $arr->isGreaterThan('test', 3));
	}


	/**
	 *
	 */
	public function test_isLessThan() {
		$peregrine = new Peregrine;
		$my_arr = array('test'=>5);
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals(false, $arr->isLessThan('test', 4));
		$this->assertEquals(true, $arr->isLessThan('test', 6));
	}


	/**
	 *
	 */
	public function test_isEmail() {
		$peregrine = new Peregrine;
		$my_arr = array('test','test@','test@test','fake@test.com','test+test@test.com');
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals(false, $arr->isEmail(0));
		$this->assertEquals(false, $arr->isEmail(1));
		$this->assertEquals(false, $arr->isEmail(2));
		$this->assertEquals(true, $arr->isEmail(3));
		$this->assertEquals(true, $arr->isEmail(4));
	}


	/**
	 *
	 */
	public function test_isIP() {
		$peregrine = new Peregrine;
		$my_arr = array('127.0.0.1','1.2.2.','1.2.F','0.0.0.0');
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals(true, $arr->isIP(0));
		$this->assertEquals(false, $arr->isIP(1));
		$this->assertEquals(false, $arr->isIP(2));
		$this->assertEquals(false, $arr->isIP(2));
	}


	/**
	 *
	 */
	public function test_isInArray() {
		$peregrine = new Peregrine;
		$my_arr = array('apple');
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals(true, $arr->isInArray(0, array('apple', 'banana')));
		$this->assertEquals(NULL, $arr->isInArray(0, 'hello'));
	}


	/**
	 *
	 */
	public function test_isPhone() {
		$peregrine = new Peregrine;
		$my_arr = array('503AAAA','5031239999');
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals(false, $arr->isPhone(0));
		$this->assertEquals(true, $arr->isPhone(1));
	}


	/**
	 *
	 */
	public function test_isCreditCard() {
		$peregrine = new Peregrine;
		$my_arr = array('4111111111111111','4111-1111-1111-1111');
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals(true, $arr->isCreditCard(0));
		$this->assertEquals(true, $arr->isCreditCard(1));
	}


	/**
	 *
	 */
	public function test_isUri() {
		$peregrine = new Peregrine;
		$my_arr = array(
						'http://www.google.com',
						'ftp://user@google.com',
						'https://site.com',
						'bob',
						'http://127.0.0.1:80/users/~bob');
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals(true, $arr->isUri(0));
		$this->assertEquals(true, $arr->isUri(1));
		$this->assertEquals(true, $arr->isUri(2));
		$this->assertEquals(false, $arr->isUri(3));
		$this->assertEquals(true, $arr->isUri(4));
	}


	/***********************************************************
	 * SANITIZING RETURN METHOD TESTS
	 ***********************************************************/
	

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


	/**
	 *
	 */
	public function test_getDigits() {
		$peregrine = new Peregrine;
		$my_arr = array('test'=>'ABC10.123');
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals('10123', $arr->getDigits('test'));
	}


	/**
	 *
	 */
	public function test_isDigits() {
		$peregrine = new Peregrine;
		$my_arr = array('test'=>ALL_CHAR_STRING,'test2'=>123);
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals(false, $arr->isDigits('test'));
		$this->assertEquals(true, $arr->isDigits('test2'));

	}


	/**
	 *
	 */
	public function test_getFloat() {
		$peregrine = new Peregrine;
		$my_arr = array('test'=>'AB10.123','test2'=>123,'test3'=>123.00,'test4'=>127.27);
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals('10.123', $arr->getFloat('test'));
		$this->assertEquals('123', $arr->getFloat('test2'));
		$this->assertEquals('123.00', $arr->getFloat('test3'));
		$this->assertEquals('127.27', $arr->getFloat('test4'));
	}


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


	/**
	 *
	 */
	public function test_getZip() {
		$peregrine = new Peregrine;
		$my_arr = array('12345','AAA12345');
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals('12345', $arr->getZip(0));
		$this->assertEquals('12345', $arr->getZip(1));
	}

	
	/**
	 *
	 */
	public function test_isZip() {
		$peregrine = new Peregrine;
		$my_arr = array('12345','AAA12345');
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals(true, $arr->isZip(0));
		$this->assertEquals(false, $arr->isZip(1));
	}


	/***********************************************************
	 * SUPERGLOBAL CAGE TESTS
	 ***********************************************************/


	/**
	 *
	 */
	public function test_serveCage() {
		$peregrine = new Peregrine;
		$peregrine->init();

		$this->assertEquals(NULL, $_SERVER);
		$this->assertEquals(true, is_string($peregrine->server->getRaw('HOSTNAME')));
	}
}
?>