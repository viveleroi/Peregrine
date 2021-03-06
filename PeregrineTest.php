<?php
/**
 * @package  Peregrine
 * @author   Michael Botsko, Trellis Development, LLC
 *
 * Peregrine is a class that aims to improve PHP superglobal security
 * by transferring the raw incoming values to private member variables.
 * You may then access the data using a wide array of higher security
 * filtering functions.
 */
require_once 'Peregrine.php';

define('ALL_CHAR_STRING', 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789~!@#$%^&*()_+=-[]{}|\\:"\'?/>.<,');

/**
 * @package PeregrineTest
 */
class PeregrineTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */
	public function test_ensureSanitizeDestroysOrigArray() {
		$my_arr = array('test'=>ALL_CHAR_STRING);
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(NULL, $my_arr);
	}
	
	
	/**
	 * 
	 */
	public function test_combine() {
		$my_arr = array('month'=>'04','day'=>'01','year'=>'2010');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals('2010-04-01', $arr->combine('%s-%s-%s', array('year','month','day'), 'getDate', array('Y-m-d')));
	}
	

	/**
	 * 
	 */
	public function test_getRaw() {
		$my_arr = array('test'=>ALL_CHAR_STRING);
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(ALL_CHAR_STRING, $arr->getRaw('test'));
	}


	/**
	 *
	 */
	public function test_isEmpty() {
		$my_arr = array('test'=>0,'test2'=>'full','arr'=>array(''),'multi'=>array(array('')));
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(true, $arr->isEmpty('test'));
		$this->assertEquals(false, $arr->isEmpty('test2'));
		$this->assertEquals(true, $arr->isEmpty('fake'));
		$this->assertEquals(true, $arr->isEmpty('test2','full')); // count "full" as empty
		$this->assertEquals(true, $arr->isEmpty('arr'));
		$this->assertEquals(true, $arr->isEmpty('multi'));
	}


	/**
	 *
	 */
	public function test_isSetAndEmpty() {
		$my_arr = array('test'=>0,'test2'=>'notempty');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(true, $arr->isSetAndEmpty('test'));
		$this->assertEquals(false, $arr->isSetAndEmpty('test2'));
		$this->assertEquals(false, $arr->isSetAndEmpty('test3'));
	}


	/**
	 *
	 */
	public function test_isSetAndNotEmpty() {
		$my_arr = array('test'=>0,'test2'=>'notempty');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(false, $arr->isSetAndNotEmpty('test'));
		$this->assertEquals(true, $arr->isSetAndNotEmpty('test2'));
		$this->assertEquals(false, $arr->isSetAndNotEmpty('test3'));
	}
	
	
	/**
	 *
	 */
	public function test_strlen() {
		$my_arr = array('test'=>'testing');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(7, $arr->strlen('test'));
	}


	/**
	 *
	 */
	public function test_match() {
		$my_arr = array(1,1,2,true);
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(true, $arr->match(0,1));
		$this->assertEquals(false, $arr->match(1,2));
		$this->assertEquals(true, $arr->match(0,3));
		$this->assertEquals(false, $arr->match(0,3, true));
	}
	
	
	/**
	 *
	 */
	public function test_equals() {
		$my_arr = array(1,1,'2');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(true, $arr->equals(0,1));
		$this->assertEquals(false, $arr->equals(1,2));
		$this->assertEquals(true, $arr->equals(2,2));
		$this->assertEquals(false, $arr->equals(2,2,true));
	}
	

	/**
	 *
	 */
	public function test_isBetween() {
		$my_arr = array('test'=>5);
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(true, $arr->isBetween('test', 4, 6));
		$this->assertEquals(true, $arr->isBetween('test', 3, 5));
		$this->assertEquals(false, $arr->isBetween('test', 3, 5, false));
	}


	/**
	 *
	 */
	public function test_getBetween() {
		$my_arr = array('test'=>5);
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(5, $arr->getBetween('test', 4, 6));
		$this->assertEquals(5, $arr->getBetween('test', 3, 5));
		$this->assertEquals(false, $arr->getBetween('test', 3, 5, false));
	}

	
	/**
	 *
	 */
	public function test_isGreaterThan() {
		$my_arr = array('test'=>5,'test2'=>5.56);
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(false, $arr->isGreaterThan('test', 5));
		$this->assertEquals(true, $arr->isGreaterThan('test', 3));
		$this->assertEquals(true, $arr->isGreaterThan('test2', 5));
	}


	/**
	 *
	 */
	public function test_getGreaterThan() {
		$my_arr = array('test'=>5,'test2'=>5.56);
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(false, $arr->getGreaterThan('test', 5));
		$this->assertEquals(5, $arr->getGreaterThan('test', 3));
		$this->assertEquals(5.56, $arr->getGreaterThan('test2', 5));
	}


	/**
	 *
	 */
	public function test_isLessThan() {
		$my_arr = array('test'=>5,'test2'=>4.99);
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(false, $arr->isLessThan('test', 4));
		$this->assertEquals(true, $arr->isLessThan('test', 6));
		$this->assertEquals(true, $arr->isLessThan('test2', 5));
	}


	/**
	 *
	 */
	public function test_getLessThan() {
		$my_arr = array('test'=>5,'test2'=>4.99);
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(false, $arr->getLessThan('test', 4));
		$this->assertEquals(5, $arr->getLessThan('test', 6));
		$this->assertEquals(4.99, $arr->getLessThan('test2', 5));
	}


	/**
	 *
	 */
	public function test_isEmail() {
		$my_arr = array('test','test@','test@test','fake@test.com','test+test@test.com','	bob@bob.com');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(false, $arr->isEmail(0));
		$this->assertEquals(false, $arr->isEmail(1));
		$this->assertEquals(false, $arr->isEmail(2));
		$this->assertEquals(true, $arr->isEmail(3));
		$this->assertEquals(true, $arr->isEmail(4));
		$this->assertEquals(false, $arr->getEmail(5));
	}


	/**
	 *
	 */
	public function test_getEmail() {
		$my_arr = array('test','test@','test@test','fake@test.com','test+test@test.com','	bob@bob.com');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(false, $arr->getEmail(0));
		$this->assertEquals(false, $arr->getEmail(1));
		$this->assertEquals(false, $arr->getEmail(2));
		$this->assertEquals('fake@test.com', $arr->getEmail(3));
		$this->assertEquals('test+test@test.com', $arr->getEmail(4));
		$this->assertEquals(false, $arr->getEmail(5));
		$this->assertEquals(false, $arr->getEmail(6));
	}


	/**
	 *
	 */
	public function test_isIP() {
		$my_arr = array('127.0.0.1','1.2.2.','1.2.F','0.0.0.0');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(true, $arr->isIP(0));
		$this->assertEquals(false, $arr->isIP(1));
		$this->assertEquals(false, $arr->isIP(2));
		$this->assertEquals(false, $arr->isIP(2));
	}


	/**
	 *
	 */
	public function test_getIP() {
		$my_arr = array('127.0.0.1','1.2.2.','1.2.F','0.0.0.0');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals('127.0.0.1', $arr->getIP(0));
		$this->assertEquals(false, $arr->getIP(1));
		$this->assertEquals(false, $arr->getIP(2));
		$this->assertEquals(false, $arr->getIP(2));
	}


	/**
	 *
	 */
	public function test_isInArray() {
		$my_arr = array('fruits'=>array('apple','banana'));
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(true, $arr->isInArray('fruits', 'apple'));
		$this->assertEquals(NULL, $arr->isInArray('fruits','pear'));
	}


	/**
	 *
	 */
	public function test_getInArray() {
		$my_arr = array('fruits'=>array('apple','banana'));
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(array('apple','banana'), $arr->getInArray('fruits', 'apple'));
		$this->assertEquals(NULL, $arr->getInArray('fruits','pear'));
	}


	/**
	 *
	 */
	public function test_isPhone() {
		$my_arr = array('503AAAA','5031239999','(503) 123-4567');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(false, $arr->isPhone(0));
		$this->assertEquals(true, $arr->isPhone(1));
		$this->assertEquals(true, $arr->isPhone(2));
	}


	/**
	 *
	 */
	public function test_getPhone() {
		$my_arr = array('503AAAA','5031239999','','(503) 123-4567');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(false, $arr->getPhone(0));
		$this->assertEquals('5031239999', $arr->getPhone(1));
		$this->assertEquals(false, $arr->getPhone(2));
		$this->assertEquals('(503) 123-4567', $arr->getPhone(3));
		$this->assertEquals('5031234567', $arr->getPhone(3, true));
	}


	/**
	 *
	 */
	public function test_isCreditCard() {
		$my_arr = array('4111111111111111','4111-1111-1111-1111','KTP');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(true, $arr->isCreditCard(0));
		$this->assertEquals(true, $arr->isCreditCard(1));
		$this->assertEquals(false, $arr->isCreditCard(2));
	}


	/**
	 *
	 */
	public function test_getCreditCard() {
		$my_arr = array('4111111111111111','4111-1111-1111-1111','KTP','');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals('4111111111111111', $arr->getCreditCard(0));
		$this->assertEquals('4111-1111-1111-1111', $arr->getCreditCard(1));
		$this->assertEquals(false, $arr->isCreditCard(2));
		$this->assertEquals(false, $arr->isCreditCard(3));
	}


	/**
	 *
	 */
	public function test_isUri() {
		$my_arr = array(
						'http://www.google.com',
						'ftp://user@google.com',
						'https://site.com',
						'bob',
						'http://127.0.0.1:80/users/~bob',
						'http://127.0.0.1:80/a_path',
						'');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(true, $arr->isUri(0));
		$this->assertEquals(true, $arr->isUri(1));
		$this->assertEquals(true, $arr->isUri(2));
		$this->assertEquals(false, $arr->isUri(3));
		$this->assertEquals(true, $arr->isUri(4));
		$this->assertEquals(true, $arr->isUri(5));
		$this->assertEquals(false, $arr->isUri(6));
	}


	/**
	 *
	 */
	public function test_getUri() {
		$my_arr = array(
						'http://www.google.com',
						'ftp://user@google.com',
						'https://site.com',
						'bob',
						'http://127.0.0.1:80/users/~bob',
						'http://127.0.0.1:80/a_path',
						'');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals('http://www.google.com', $arr->getUri(0));
		$this->assertEquals('ftp://user@google.com', $arr->getUri(1));
		$this->assertEquals('https://site.com', $arr->getUri(2));
		$this->assertEquals(false, $arr->getUri(3));
		$this->assertEquals('http://127.0.0.1:80/users/~bob', $arr->getUri(4));
		$this->assertEquals('http://127.0.0.1:80/a_path', $arr->getUri(5));
		$this->assertEquals(false, $arr->getUri(6));
	}


	/**
	 *
	 */
	public function test_isTopLevelDomain() {
		$my_arr = array(
						'http://www.google.com',
						'bob',
						'www.domain.com:80/users/~bob',
						'domain.com:80/a_path',
						'www.domain.com:80',
						'domain.com');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(false, $arr->isTopLevelDomain(0));
		$this->assertEquals(false, $arr->isTopLevelDomain(1));
		$this->assertEquals(false, $arr->isTopLevelDomain(2));
		$this->assertEquals(false, $arr->isTopLevelDomain(3));
		$this->assertEquals(false, $arr->isTopLevelDomain(4));
		$this->assertEquals(true, $arr->isTopLevelDomain(5));
	}


	/**
	 *
	 */
	public function test_getTopLevelDomain() {
		$my_arr = array(
						'http://www.google.com',
						'bob',
						'www.domain.com:80/users/~bob',
						'domain.com:80/a_path',
						'www.domain.com:80',
						'domain.com');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals('', $arr->getTopLevelDomain(0));
		$this->assertEquals('', $arr->getTopLevelDomain(1));
		$this->assertEquals('', $arr->getTopLevelDomain(2));
		$this->assertEquals('', $arr->getTopLevelDomain(3));
		$this->assertEquals('', $arr->getTopLevelDomain(4));
		$this->assertEquals('domain.com', $arr->getTopLevelDomain(5));
	}


	/***********************************************************
	 * SANITIZING RETURN METHOD TESTS
	 ***********************************************************/
	

	/**
	 *
	 */
	public function test_getAlpha() {
		$my_arr = array('test'=>ALL_CHAR_STRING,'');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', $arr->getAlpha('test'));
		$this->assertEquals('default', $arr->getAlpha('nonexist-key', 'default'));
		$this->assertEquals(false, $arr->getAlpha(1));
	}


	/**
	 *
	 */
	public function test_isAlpha() {
		$my_arr = array('test'=>ALL_CHAR_STRING,'test2'=>'abc');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(false, $arr->isAlpha('test'));
		$this->assertEquals(true, $arr->isAlpha('test2'));
	}


	/**
	 *
	 */
	public function test_getName() {
		$my_arr = array('Bob-bob O\'Mally III.','&^%Bobby','');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals('Bob-bob O\'Mally III.', $arr->getName(0));
		$this->assertEquals('Bobby', $arr->getName(1));
		$this->assertEquals(false, $arr->getName(2));
	}


	/**
	 *
	 */
	public function test_isName() {
		$my_arr = array('Bob O\'Mally III.','&^%Bobby');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(true, $arr->isName(0));
		$this->assertEquals(false, $arr->isName(1));
	}
	
	
	/**
	 *
	 */
	public function test_getAddress() {
		$my_arr = array('123 Fake Street','?','','050 P.0.-BOX CROSS & CROSS', '?^*@!%<>{}[]()','BOX A, BOX B');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals('123 Fake Street', $arr->getAddress(0));
		$this->assertEquals('', $arr->getAddress(1));
		$this->assertEquals('', $arr->getAddress(2));
		$this->assertEquals('050 P.0.-BOX CROSS & CROSS', $arr->getAddress(3));
		$this->assertEquals('', $arr->getAddress(4));
		$this->assertEquals('BOX A, BOX B', $arr->getAddress(5));
	}


	/**
	 *
	 */
	public function test_isAddress() {
		$my_arr = array('123 Fake Street','?','','050 P.0.-BOX CROSS & CROSS', '?^*@!%<>{}[]()','BOX A, BOX B');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(true, $arr->isAddress(0));
		$this->assertEquals(false, $arr->isAddress(1));
		$this->assertEquals(false, $arr->isAddress(2));
		$this->assertEquals(true, $arr->isAddress(3));
		$this->assertEquals(false, $arr->isAddress(4));
		$this->assertEquals(true, $arr->isAddress(5));
	}


	/**
	 *
	 */
	public function test_getElemId() {
		$my_arr = array('Element ID','&^%Elem098ID','');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals('element_id', $arr->getElemId(0));
		$this->assertEquals('elem098id', $arr->getElemId(1));
		$this->assertEquals(false, $arr->getElemId(2));
	}


	/**
	 *
	 */
	public function test_isElemId() {
		$my_arr = array('Element ID','&^%Elem098ID', 'elem_id');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(false, $arr->isElemId(0));
		$this->assertEquals(false, $arr->isElemId(1));
		$this->assertEquals(true, $arr->isElemId(2));
	}

	
	/**
	 *
	 */
	public function test_getAlnum() {
		$my_arr = array('test'=>ALL_CHAR_STRING);
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', $arr->getAlnum('test'));
	}


	/**
	 *
	 */
	public function test_isAlnum() {
		$my_arr = array('test'=>ALL_CHAR_STRING,'test2'=>'abc123');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(false, $arr->isAlnum('test'));
		$this->assertEquals(true, $arr->isAlnum('test2'));
	}


	/**
	 *
	 */
	public function test_getInt_string() {
		$my_arr = array('test'=>ALL_CHAR_STRING);
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(0, $arr->getInt('test'));
	}


	/**
	 *
	 */
	public function test_getInt_int() {
		$my_arr = array('test'=>123);
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(123, $arr->getInt('test'));
		$this->assertEquals(0, $arr->getInt('nonexist-key', 0));
	}


	/**
	 *
	 */
	public function test_isInt() {
		$my_arr = array('test'=>ALL_CHAR_STRING,'test2'=>123);
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(false, $arr->isInt('test'));
		$this->assertEquals(true, $arr->isInt('test2'));
	}


	/**
	 *
	 */
	public function test_getInt_float() {
		$my_arr = array('test'=>123.02);
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(123, $arr->getInt('test'));
	}


	/**
	 *
	 */
	public function test_getDigits() {
		$my_arr = array('test'=>'ABC10.123','empty'=>'');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals('10123', $arr->getDigits('test'));
		$this->assertEquals('', $arr->getDigits('empty'));
		$this->assertEquals(0, $arr->getDigits('nonexist-key', 0));
	}


	/**
	 *
	 */
	public function test_isDigits() {
		$my_arr = array('test'=>ALL_CHAR_STRING,'test2'=>123,'empty'=>'');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(false, $arr->isDigits('test'));
		$this->assertEquals(true, $arr->isDigits('test2'));
		$this->assertEquals(false, $arr->isDigits('empty'));
	}


	/**
	 *
	 */
	public function test_getFloat() {
		$my_arr = array('test'=>'AB10.123','test2'=>123,'test3'=>123.00,'test4'=>127.27);
		$arr = Peregrine::sanitize( $my_arr );
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
		$my_arr = array('test'=>ALL_CHAR_STRING,'test2'=>123.02);
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(false, $arr->isFloat('test'));
		$this->assertEquals(true, $arr->isFloat('test2'));
	}


	/**
	 *
	 */
	public function test_getCurrency() {
		$my_arr = array('test'=>'$1,000.00','test2'=>1000,'test3'=>'*&^$UUU123');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals('$1,000.00', $arr->getCurrency('test'));
		$this->assertEquals(1000, $arr->getCurrency('test2'));
		$this->assertEquals('$123', $arr->getCurrency('test3'));
	}


	/**
	 *
	 */
	public function test_isCurrency() {
		$my_arr = array('test'=>'$1,000.00','test2'=>1000,'test3'=>'*&^$UUU123',100.235);
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(true, $arr->isCurrency('test'));
		$this->assertEquals(true, $arr->isCurrency('test2'));
		$this->assertEquals(false, $arr->isCurrency('test3'));
		$this->assertEquals(true, $arr->isCurrency(0));
		$this->assertEquals(false, $arr->isCurrency(4));
	}


	/**
	 *
	 */
	public function test_getDate() {
		$my_arr = array('January 12, 2009','Purple','07:07:09','2009-06-02 22:89:13','2009-06-02 22:15:07','');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals('Mon, 12 Jan 09 00:00:00 -0800', $arr->getDate(0));
		$this->assertEquals(false, $arr->getDate(1));
		$this->assertEquals('07:07:09', $arr->getDate(2, 'h:i:s'));
		$this->assertEquals(false, $arr->getDate(3));
		$this->assertEquals('Tue, 02 Jun 09 22:15:07 -0700', $arr->getDate(4));
		$this->assertEquals(false, $arr->getDate(5));
	}


	/**
	 *
	 */
	public function test_isDate() {
		$my_arr = array('January 12, 2009','Mon, 12 Jan 09 00:00:00 -0800');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(true, $arr->isDate(0,'Mdy'));
		$this->assertEquals(true, $arr->isDate(1));
	}


	/**
	 *
	 */
	public function test_getZip() {
		$my_arr = array('12345','AAA12345','');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals('12345', $arr->getZip(0));
		$this->assertEquals('12345', $arr->getZip(1));
		$this->assertEquals('12345', $arr->getZip('nonexist-key', '12345'));
		$this->assertEquals(false, $arr->getZip(2));
	}

	
	/**
	 *
	 */
	public function test_isZip() {
		$my_arr = array('12345','AAA12345');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(true, $arr->isZip(0));
		$this->assertEquals(false, $arr->isZip(1));
	}
	
	
	/**
	 *
	 */
	public function test_getSsn() {
		$my_arr = array('12345','520645555','520 64 5555','520-64-5555');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals('', $arr->getSsn(0));
		$this->assertEquals('520645555', $arr->getSsn(1));
		$this->assertEquals('12345', $arr->getSsn('nonexist-key', '12345'));
		$this->assertEquals('520645555', $arr->getSsn(2));
		$this->assertEquals('520645555', $arr->getSsn(3));
	}

	
	/**
	 *
	 */
	public function test_isSsn() {
		$my_arr = array('12345','520645555','520 64 5555','520-64-5555');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(false, $arr->isSsn(0));
		$this->assertEquals(true, $arr->isSsn(1));
		$this->assertEquals(true, $arr->isSsn(2));
		$this->assertEquals(true, $arr->isSsn(3));
	}
	
	
	/**
	 *
	 */
	public function test_getUuid() {
		$my_arr = array('12345','ae91e300-76a6-11e0-a1f0-0800200c9a66','ae91e30076a611e0a1f00800200c9a66');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals('', $arr->getUuid(0));
		$this->assertEquals('ae91e300-76a6-11e0-a1f0-0800200c9a66', $arr->getUuid(1));
		$this->assertEquals('', $arr->getUuid(2));
	}

	
	/**
	 *
	 */
	public function test_isUuid() {
		$my_arr = array('12345','ae91e300-76a6-11e0-a1f0-0800200c9a66','ae91e30076a611e0a1f00800200c9a66');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(false, $arr->isUuid(0));
		$this->assertEquals(true, $arr->isUuid(1));
		$this->assertEquals(false, $arr->isUuid(2));
	}
	
	
	/**
	 *
	 */
	public function test_getTime() {
		$my_arr = array('12345','12:00','00:00','00:00pm');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals('', $arr->getTime(0));
		$this->assertEquals('12:00', $arr->getTime(1));
		$this->assertEquals('00:00', $arr->getTime(2));
		$this->assertEquals('', $arr->getTime(3));
	}

	
	/**
	 *
	 */
	public function test_isTime() {
		$my_arr = array('12345','12:00','00:00','00:00pm');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(false, $arr->isTime(0));
		$this->assertEquals(true, $arr->isTime(1));
		$this->assertEquals(true, $arr->isTime(2));
		$this->assertEquals(false, $arr->isTime(3));
	}


	/**
	 *
	 */
	public function test_getPath() {
		$my_arr = array('12345','A path','/_apath','/a~path','/usr/local/bin','');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals('12345', $arr->getPath(0));
		$this->assertEquals('Apath', $arr->getPath(1));
		$this->assertEquals('/_apath', $arr->getPath(2));
		$this->assertEquals('/a~path', $arr->getPath(3));
		$this->assertEquals('/usr/local/bin', $arr->getPath(4));
		$this->assertEquals(false, $arr->getPath(5));
	}


	/**
	 *
	 */
	public function test_isPath() {
		$my_arr = array('12345','A path','/_apath','/a~path','/usr/local/bin','?&^%$');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(true, $arr->isPath(0));
		$this->assertEquals(false, $arr->isPath(1));
		$this->assertEquals(true, $arr->isPath(2));
		$this->assertEquals(true, $arr->isPath(3));
		$this->assertEquals(true, $arr->isPath(4));
		$this->assertEquals(false, $arr->isPath(5));
	}


	/**
	 *
	 */
	public function test_getQueryString() {
		$my_arr = array('12345','A path','/_apath','/a~path','/usr/local/bin','/a/subfolder?test=test','/a/subfolder?test[]={el-em:value}','','\'SQL\'');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals('12345', $arr->getQueryString(0));
		$this->assertEquals('Apath', $arr->getQueryString(1));
		$this->assertEquals('/_apath', $arr->getQueryString(2));
		$this->assertEquals('/a~path', $arr->getQueryString(3));
		$this->assertEquals('/usr/local/bin', $arr->getQueryString(4));
		$this->assertEquals('/a/subfolder?test=test', $arr->getQueryString(5));
		$this->assertEquals('/a/subfolder?test[]={el-em:value}', $arr->getQueryString(6));
		$this->assertEquals(false, $arr->getQueryString(7));
		$this->assertEquals('SQL', $arr->getQueryString(8));
	}


	/**
	 *
	 */
	public function test_isQueryString() {
		$my_arr = array('12345','A path','/_apath','/a~path','/usr/local/bin','/a/subfolder?test=test','/a/subfolder?test[]={elem:value}','','\'SQL\'');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(true, $arr->isQueryString(0));
		$this->assertEquals(false, $arr->isQueryString(1));
		$this->assertEquals(true, $arr->isQueryString(2));
		$this->assertEquals(true, $arr->isQueryString(3));
		$this->assertEquals(true, $arr->isQueryString(4));
		$this->assertEquals(true, $arr->isQueryString(5));
		$this->assertEquals(true, $arr->isQueryString(6));
		$this->assertEquals(false, $arr->isQueryString(7));
		$this->assertEquals(false, $arr->isQueryString(8));
	}


	/**
	 *
	 */
	public function test_getServerName() {
		$my_arr = array('12345','domain.com','www.domain.com','?var=test','localhost','\'INSERT INTO\'','127.0.0.1');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals('12345', $arr->getServerName(0));
		$this->assertEquals('domain.com', $arr->getServerName(1));
		$this->assertEquals('www.domain.com', $arr->getServerName(2));
		$this->assertEquals('', $arr->getServerName(3));
		$this->assertEquals('localhost', $arr->getServerName(4));
		$this->assertEquals('', $arr->getServerName(5));
		$this->assertEquals('127.0.0.1', $arr->getServerName(6));
	}


	/**
	 *
	 */
	public function test_isServerName() {
		$my_arr = array('12345','domain.com','www.domain.com','?var=test','localhost','\'INSERT INTO\'','127.0.0.1');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(true, $arr->isServerName(0));
		$this->assertEquals(true, $arr->isServerName(1));
		$this->assertEquals(true, $arr->isServerName(2));
		$this->assertEquals(false, $arr->isServerName(3));
		$this->assertEquals(true, $arr->isServerName(4));
		$this->assertEquals(false, $arr->isServerName(5));
		$this->assertEquals(true, $arr->isServerName(6));
	}


	/**
	 *
	 */
	public function test_getArray() {
		$my_arr = array(array(1,2), false, 'bob');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(array(1,2), $arr->getArray(0));
		$this->assertEquals(false, $arr->getArray(1));
		$this->assertEquals(false, $arr->getArray(2));
	}


	/**
	 *
	 */
	public function test_isArray() {
		$my_arr = array(array(1,2), false, 'bob');
		$arr = Peregrine::sanitize( $my_arr );
		$this->assertEquals(true, $arr->isArray(0));
		$this->assertEquals(false, $arr->isArray(1));
		$this->assertEquals(false, $arr->isArray(2));
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