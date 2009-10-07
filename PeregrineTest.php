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
		$this->assertEquals(true, $arr->isEmpty('fake'));
		$this->assertEquals(true, $arr->isEmpty('test2','full')); // count "full" as empty
	}


	/**
	 *
	 */
	public function test_isSetAndEmpty() {
		$peregrine = new Peregrine;
		$my_arr = array('test'=>0,'test2'=>'notempty');
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals(true, $arr->isSetAndEmpty('test'));
		$this->assertEquals(false, $arr->isSetAndEmpty('test2'));
		$this->assertEquals(false, $arr->isSetAndEmpty('test3'));
	}


	/**
	 *
	 */
	public function test_isSetAndNotEmpty() {
		$peregrine = new Peregrine;
		$my_arr = array('test'=>0,'test2'=>'notempty');
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals(false, $arr->isSetAndNotEmpty('test'));
		$this->assertEquals(true, $arr->isSetAndNotEmpty('test2'));
		$this->assertEquals(false, $arr->isSetAndNotEmpty('test3'));
	}


	/**
	 *
	 */
	public function test_match() {
		$peregrine = new Peregrine;
		$my_arr = array(1,1,2,true);
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals(true, $arr->match(0,1));
		$this->assertEquals(false, $arr->match(1,2));
		$this->assertEquals(true, $arr->match(0,3));
		$this->assertEquals(false, $arr->match(0,3, true));
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
		$my_arr = array('test'=>5,'test2'=>5.56);
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals(false, $arr->isGreaterThan('test', 5));
		$this->assertEquals(true, $arr->isGreaterThan('test', 3));
		$this->assertEquals(true, $arr->isGreaterThan('test2', 5));
	}


	/**
	 *
	 */
	public function test_isLessThan() {
		$peregrine = new Peregrine;
		$my_arr = array('test'=>5,'test2'=>4.99);
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals(false, $arr->isLessThan('test', 4));
		$this->assertEquals(true, $arr->isLessThan('test', 6));
		$this->assertEquals(true, $arr->isLessThan('test2', 5));
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
		$this->assertEquals('default', $arr->getAlpha('nonexist-key', 'default'));
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
		$this->assertEquals('default', $arr->isAlpha('nonexist-key', 'default'));
	}


	/**
	 *
	 */
	public function test_getName() {
		$peregrine = new Peregrine;
		$my_arr = array('Bob-bob O\'Mally III.','&^%Bobby');
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals('Bob-bob O\'Mally III.', $arr->getName(0));
		$this->assertEquals('Bobby', $arr->getName(1));
	}


	/**
	 *
	 */
	public function test_isName() {
		$peregrine = new Peregrine;
		$my_arr = array('Bob O\'Mally III.','&^%Bobby');
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals(true, $arr->isName(0));
		$this->assertEquals(false, $arr->isName(1));
	}


	/**
	 *
	 */
	public function test_getElemId() {
		$peregrine = new Peregrine;
		$my_arr = array('Element ID','&^%Elem098ID');
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals('element_id', $arr->getElemId(0));
		$this->assertEquals('elem098id', $arr->getElemId(1));
	}


	/**
	 *
	 */
	public function test_isElemId() {
		$peregrine = new Peregrine;
		$my_arr = array('Element ID','&^%Elem098ID', 'elem_id');
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals(false, $arr->isElemId(0));
		$this->assertEquals(false, $arr->isElemId(1));
		$this->assertEquals(true, $arr->isElemId(2));
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
		$this->assertEquals(0, $arr->getInt('nonexist-key', 0));
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
		$this->assertEquals(0, $arr->getDigits('nonexist-key', 0));
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
		$this->assertEquals(0, $arr->getFloat('nonexist-key', 0));
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
	public function test_getCurrency() {
		$peregrine = new Peregrine;
		$my_arr = array('test'=>'$1,000.00','test2'=>1000,'test3'=>'*&^$UUU123');
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals('$1,000.00', $arr->getCurrency('test'));
		$this->assertEquals(1000, $arr->getCurrency('test2'));
		$this->assertEquals('$123', $arr->getCurrency('test3'));
	}


	/**
	 *
	 */
	public function test_isCurrency() {
		$peregrine = new Peregrine;
		$my_arr = array('test'=>'$1,000.00','test2'=>1000,'test3'=>'*&^$UUU123',100.235);
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals(true, $arr->isCurrency('test'));
		$this->assertEquals(true, $arr->isCurrency('test2'));
		$this->assertEquals(false, $arr->isCurrency('test3'));
		$this->assertEquals(true, $arr->isCurrency(4));
	}


	/**
	 *
	 */
	public function test_getDate() {
		$peregrine = new Peregrine;
		$my_arr = array('January 12, 2009','Purple','07:07:09','2009-06-02 22:89:13','2009-06-02 22:15:07');
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals('Mon, 12 Jan 09 00:00:00 -0800', $arr->getDate(0));
		$this->assertEquals(false, $arr->getDate(1));
		$this->assertEquals('07:07:09', $arr->getDate(2, 'h:i:s'));
		$this->assertEquals(false, $arr->getDate(3));
		$this->assertEquals('Tue, 02 Jun 09 22:15:07 -0700', $arr->getDate(4));
	}


	/**
	 *
	 */
	public function test_isDate() {
		$peregrine = new Peregrine;
		$my_arr = array('January 12, 2009','Mon, 12 Jan 09 00:00:00 -0800');
		$arr = $peregrine->sanitize( $my_arr );
		$this->assertEquals(false, $arr->isDate(0));
		$this->assertEquals(true, $arr->isDate(1));
		$this->assertEquals(false, $arr->isDate(0));
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
		$this->assertEquals('12345', $arr->getFloat('nonexist-key', '12345'));
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