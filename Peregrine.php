<?php
/**
 * @package Peregrine
 * @author Michael Botsko, Trellis Development, LLC
 * @license Mozilla Public License, 1.1
 */

/**
 * @package Peregrine
 */
class CageBase {

	/**
	 * @var array Holds the source array for the raw incoming data.
	 * @access private
	 */
	private $_raw;


	/**
	 * Loads the incoming source array to the raw private variable.
	 * 
	 * @param array $arr
	 * @access public
	 */
	public final function __construct($arr){
		if(is_array($arr)){
			$this->_raw = $arr;
		}
	}

// @keyexists

	/**
	 * Determines whethe or not a specific key exists
	 * in the raw array. If it does it returns its value,
	 * otherwise it returns false.
	 *
	 * @param string $key
	 * @return mixed
	 * @access public
	 */
	private function getKey($key){
		if(array_key_exists($key, $this->_raw)){
			return $this->_raw[$key];
		}
		return false;
	}


	/**
	 *
	 * @param <type> $method
	 * @param <type> $args
	 * @return <type> mixed
	 */
	public function __call($method, $args){

		// $key should be first arg
		$key = false;
		if(array_key_exists(0, $args)){
			$key = $args[0];
		}

		if($key !== false && strpos($method, 'is') !== false){
			$real_method = str_replace('is', 'get', $method);
			if(method_exists($this, $real_method)){
				return $this->{$real_method}($key) === $this->getRaw($key);
			}
		}
		return NULL;
	}


	/**
	 * WARNING: AVOID USING THIS!
	 * @param string $key
	 * @return <type>
	 * @access public
	 */
	public function getRaw($key = false){
		return $this->getKey($key);
	}

	// @todo getRawSource();

	/***********************************************************
	 * CUSTOM DATA CHECK METHODS
	 ***********************************************************/

	 /**
	  *
	  * @param <type> $value
	  * @return <type> 
	  */
	public function isEmpty($key){
		$val = $this->getRaw($key);
		return empty($val);
	}

//		function isEmpty($key, $count_as_empty = false)
//	{
//
//		// if key does not exist
//		if (!$this->keyExists($key)) {
//			return true;
//		} else {
//
//			$val = $this->_getValue($key);
//
//			// replace any extra "count as empty" chars
//			if($count_as_empty){
//				$val = str_replace($count_as_empty, '', $val);
//			}
//
//			// the key is set, so we do need to process it no matter what
//			return Inspekt::isEmpty($val);
//
//		}
//	}


//	function isSetAndEmpty($key)
//	{
//		if ($this->keyExists($key)) {
//			return Inspekt::isEmpty($this->_getValue($key));
//		}
//		return false;
//	}

//
//	function isSetAndNotEmpty($key)
//	{
//		if ($this->keyExists($key)) {
//			return Inspekt::isNotEmpty($this->_getValue($key));
//		}
//		return false;
//	}


	/**
	 *
	 * @param <type> $key
	 * @param <type> $min
	 * @param <type> $max
	 * @param <type> $inc
	 * @return <type> 
	 */
	public function isBetween($key, $min, $max, $inc = true){
		$val = $this->getRaw($key);
		if ($val > $min && $val < $max) {
			return true;
		}
		if ($inc && $val >= $min && $val <= $max) {
			return true;
		}
		return false;
	}


	/**
	 *
	 * @param string $key
	 * @param <type> $min
	 * @return <type> 
	 */
	public function isGreaterThan($key, $min){
		$val = $this->getRaw($key);
		return ($val > $min);
	}


	/**
	 *
	 * @param string $key
	 * @param <type> $max
	 * @return <type> 
	 */
	public function isLessThan($key, $max){
		$val = $this->getRaw($key);
		return ($val < $max);
	}


	/**
	 *
	 * @param string $key
	 * @return <type>
	 */
	public function isEmail($key){
		$val = $this->getRaw($key);
		return (bool) preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/', $val);
	}


	/**
	 *
	 * @param string $key
	 * @return <type> 
	 */
	public function isIP($key){
		$val = $this->getRaw($key);
		return (bool) ip2long($val);
	}


	/**
	 *
	 * @param string $key
	 * @param <type> $allowed
	 * @return <type> 
	 */
	public function isInArray($key, $allowed = NULL){
		// @todo: make this work recursively
		$val = $this->getRaw($key);
		if(is_array($allowed)){
			return in_array($val, $allowed);
		}
		return NULL;
	}


	/**
	 *
	 * @param string $key
	 * @param <type> $country
	 * @return <type> 
	 */
	public function isPhone($key, $country = 'US'){

		$val = $this->getDigits($key);

		if (!ctype_digit($val)) {
			return false;
		}

		switch ($country)
		{
			case 'US':
				if (strlen($val) != 10) {
					return false;
				}

				$areaCode = substr($val, 0, 3);

				$areaCodes = array(
					201, 202, 203, 204, 205, 206, 207, 208,
					209, 210, 212, 213, 214, 215, 216, 217,
					218, 219, 224, 225, 226, 228, 229, 231,
					234, 239, 240, 242, 246, 248, 250, 251,
					252, 253, 254, 256, 260, 262, 264, 267,
					268, 269, 270, 276, 281, 284, 289, 301,
					302, 303, 304, 305, 306, 307, 308, 309,
					310, 312, 313, 314, 315, 316, 317, 318,
					319, 320, 321, 323, 325, 330, 334, 336,
					337, 339, 340, 345, 347, 351, 352, 360,
					361, 386, 401, 402, 403, 404, 405, 406,
					407, 408, 409, 410, 412, 413, 414, 415,
					416, 417, 418, 419, 423, 424, 425, 430,
					432, 434, 435, 438, 440, 441, 443, 445,
					450, 469, 470, 473, 475, 478, 479, 480,
					484, 501, 502, 503, 504, 505, 506, 507,
					508, 509, 510, 512, 513, 514, 515, 516,
					517, 518, 519, 520, 530, 540, 541, 555,
					559, 561, 562, 563, 564, 567, 570, 571,
					573, 574, 580, 585, 586, 600, 601, 602,
					603, 604, 605, 606, 607, 608, 609, 610,
					612, 613, 614, 615, 616, 617, 618, 619,
					620, 623, 626, 630, 631, 636, 641, 646,
					647, 649, 650, 651, 660, 661, 662, 664,
					670, 671, 678, 682, 684, 700, 701, 702,
					703, 704, 705, 706, 707, 708, 709, 710,
					712, 713, 714, 715, 716, 717, 718, 719,
					720, 724, 727, 731, 732, 734, 740, 754,
					757, 758, 760, 763, 765, 767, 769, 770,
					772, 773, 774, 775, 778, 780, 781, 784,
					785, 786, 787, 800, 801, 802, 803, 804,
					805, 806, 807, 808, 809, 810, 812, 813,
					814, 815, 816, 817, 818, 819, 822, 828,
					829, 830, 831, 832, 833, 835, 843, 844,
					845, 847, 848, 850, 855, 856, 857, 858,
					859, 860, 863, 864, 865, 866, 867, 868,
					869, 870, 876, 877, 878, 888, 900, 901,
					902, 903, 904, 905, 906, 907, 908, 909,
					910, 912, 913, 914, 915, 916, 917, 918,
					919, 920, 925, 928, 931, 936, 937, 939,
					940, 941, 947, 949, 951, 952, 954, 956,
					959, 970, 971, 972, 973, 978, 979, 980,
					985, 989);

				return in_array($areaCode, $areaCodes);
				break;
			default:
				// @todo return error that country isn't supported
				return false;
				break;
		}
	}


	// @todo this need improving
	/**
	 *
	 * @param string $key
	 * @param <type> $type
	 * @return <type> 
	 */
	public function isCreditCard($key, $type = NULL){

		$value = $this->getDigits($key);
		$length = strlen($value);

		if ($length < 13 || $length > 19) {
			return false;
		}

		$sum = 0;
		$weight = 2;

		for ($i = $length - 2; $i >= 0; $i--) {
			$digit = $weight * $value[$i];
			$sum += floor($digit / 10) + $digit % 10;
			$weight = $weight % 2 + 1;
		}

		$mod = (10 - $sum % 10) % 10;

		return ($mod == $value[$length - 1]);
	}
	

	/**
	 *
	 * @param string $key
	 * @return <type> 
	 */
	public function isUri($key){

		$regex = '&';
		$regex .= '^(ftp|http|https):';					// protocol
		$regex .= '(//)';								// authority-start
		$regex .= '([-a-z0-9/~;:@=+$,.!*()\']+@)?';		// userinfo
		$regex .= '(';
		$regex .= '((?:[^\W_]((?:[^\W_]|-){0,61}[^\W_])?\.)+[a-zA-Z]{2,6}\.?)';		// domain name
		$regex .= '|';
		$regex .= '([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?(\.[0-9]{1,3})?)';	// OR ipv4
		$regex .= ')';
		$regex .= '(:([0-9]*))?';						// port
		$regex .= '(/((%[0-9a-f]{2}|[-a-z0-9/~;:@=+$,.!*()\'\&]*)*)/?)?';	// path
		$regex .= '(\?[^#]*)?';							// query
		$regex .= '(#([-a-z0-9_]*))?';					// anchor (fragment)
		$regex .= '$&i';
			
		$res = preg_match($regex, $this->getRaw($key), $matches);
		return (bool) $res;

	}


	/**
     * Returns TRUE if value is a valid hostname, FALSE otherwise.
     * Depending upon the value of $allow, Internet domain names, IP
     * addresses, and/or local network names are considered valid.
     * The default is HOST_ALLOW_ALL, which considers all of the
     * above to be valid.
     *
     * @param mixed $value
     * @param integer $allow bitfield for ISPK_HOST_ALLOW_DNS, ISPK_HOST_ALLOW_IP, ISPK_HOST_ALLOW_LOCAL
     * @return boolean
     *
     * @tag validator
     * @static
     */
	 //define ('ISPK_HOST_ALLOW_DNS',   1);
	 //define ('ISPK_HOST_ALLOW_ALL',   7);
	 //define ('ISPK_HOST_ALLOW_IP',    2);
	 //define ('ISPK_HOST_ALLOW_LOCAL', 4);
	 //define ('ISPK_URI_ALLOW_COMMON', 1);
	 //define ('ISPK_DNS_VALID', '/^(?:[^\W_]((?:[^\W_]|-){0,61}[^\W_])?\.)+[a-zA-Z]{2,6}\.?$/');
//	static function isHostname($value, $allow = ISPK_HOST_ALLOW_ALL)
//	{
//		if (!is_numeric($allow) || !is_int($allow)) {
//			user_error('Illegal value for $allow; expected an integer', E_USER_WARNING);
//		}
//
//		if ($allow < ISPK_HOST_ALLOW_DNS || ISPK_HOST_ALLOW_ALL < $allow) {
//			user_error('Illegal value for $allow; expected integer between ' . ISPK_HOST_ALLOW_DNS . ' and ' . ISPK_HOST_ALLOW_ALL, E_USER_WARNING);
//		}
//
//		// determine whether the input is formed as an IP address
//		$status = self::isIp($value);
//
//		// if the input looks like an IP address
//		if ($status) {
//			// if IP addresses are not allowed, then fail validation
//			if (($allow & ISPK_HOST_ALLOW_IP) == 0) {
//				return FALSE;
//			}
//
//			// IP passed validation
//			return TRUE;
//		}
//
//		// check input against domain name schema
//		$status = @preg_match('/^(?:[^\W_]((?:[^\W_]|-){0,61}[^\W_])?\.)+[a-zA-Z]{2,6}\.?$/', $value);
//		if ($status === false) {
//			user_error('Internal error: DNS validation failed', E_USER_WARNING);
//		}
//
//		// if the input passes as an Internet domain name, and domain names are allowed, then the hostname
//		// passes validation
//		if ($status == 1 && ($allow & ISPK_HOST_ALLOW_DNS) != 0) {
//			return TRUE;
//		}
//
//		// if local network names are not allowed, then fail validation
//		if (($allow & ISPK_HOST_ALLOW_LOCAL) == 0) {
//			return FALSE;
//		}
//
//		// check input against local network name schema; last chance to pass validation
//		$status = @preg_match('/^(?:[^\W_](?:[^\W_]|-){0,61}[^\W_]\.)*(?:[^\W_](?:[^\W_]|-){0,61}[^\W_])\.?$/',
//		$value);
//		if ($status === FALSE) {
//			user_error('Internal error: local network name validation failed', E_USER_WARNING);
//		}
//
//		if ($status == 0) {
//			return FALSE;
//		} else {
//			return TRUE;
//		}
//	}

	/***********************************************************
	 * SANITIZING RETURN METHODS
	 ***********************************************************/


	/**
	 *
	 * @param string $key
	 * @return <type>
	 */
	public function getAlpha($key = false){
		return preg_replace('/[^[:alpha:]]/', '', $this->getKey($key));
	}
	

	/**
	 *
	 * @param string $key
	 * @return <type>
	 */
	public function getAlnum($key = false){
		return preg_replace('/[^[:alnum:]]/', '', $this->getKey($key));
	}

	// @todo get name: allow alpha, space


	/**
	 *
	 * @param string $key
	 * @return <type>
	 */
	public function getInt($key = false){
		return (int) $this->getKey($key);
	}


	/**
	 *
	 * @param string $key
	 * @return <type>
	 */
	public function getDigits($key = false){
		// We need to mimic the type back to the user that they gave us
		$type = gettype($this->getKey($key));
		$clean = preg_replace('/[^\d]/', '', $this->getKey($key));
		settype($clean, $type);
		return $clean;
	}


	/**
	 *
	 * @param string $key
	 * @return <type>
	 */
	public function getFloat($key = false){
		// We need to mimic the type back to the user that they gave us
		$type = gettype($this->getKey($key));
		$clean = preg_replace('/[^\d\.]/', '', $this->getKey($key));
		settype($clean, $type);
		return $clean;
	}


	/**
	 *
	 * @param string $key
	 * @return <type> 
	 */
	public function getZip($key){
		preg_match('/(^\d{5}$)|(^\d{5}-\d{4}$)/', $this->getDigits($key), $matches);
		if(is_array($matches)){
			return $matches[0];
		}
		return false;
	}


	// @todo getDate

}


/**
 * 
 */
class Peregrine {

	/**
	 *
	 * @var <type>
	 */
	public $post;

	/**
	 *
	 * @var <type>
	 */
	public $get;

	/**
	 *
	 * @var <type>
	 */
	public $session;

	/**
	 *
	 * @var <type>
	 */
	public $env;

	/**
	 *
	 * @var <type>
	 */
	public $files;

	/**
	 *
	 * @var <type>
	 */
	public $cookie;

	/**
	 *
	 * @var <type>
	 */
	public $server;


	/**
	 * 
	 */
	public function init(){
		$this->get_cage();
		$this->post_cage();
//		$this->session_cage();
		$this->cookie_cage();
		$this->server_cage();
		$this->env_cage();
		$this->files_cage();
	}


	/**
	 *
	 * @param <type> $var
	 * @return <type> 
	 */
	public function sanitize( &$var ){
		$tmp = new CageBase($var);
		$var = null;
		return $tmp;
	}


	/**
	 *
	 */
	private function get_cage(){
		$tmp = $this->sanitize($_GET);
		$GLOBALS['HTTP_GET_VARS'] = NULL;
		$this->get = $tmp;
	}


	/**
	 *
	 */
	private function post_cage(){
		$tmp = $this->sanitize($_POST);
		$GLOBALS['HTTP_POST_VARS'] = NULL;
		$this->post = $tmp;
	}


	/**
	 * @todo detect session update
	 */
//	private function session_cage(){
//		$tmp = $this->sanitize($_SESSION);
//		$GLOBALS['HTTP_SESSION_VARS'] = NULL;
//		$this->_session = $tmp;
//	}


	/**
	 *
	 */
	private function cookie_cage(){
		$tmp = $this->sanitize($_COOKIE);
		$GLOBALS['HTTP_COOKIE_VARS'] = NULL;
		$this->cookie = $tmp;
	}
	

	/**
	 *
	 */
	private function server_cage(){
		$tmp = $this->sanitize($_SERVER);
		$GLOBALS['HTTP_SERVER_VARS'] = NULL;
		$this->server = $tmp;
	}


	/**
	 *
	 */
	private function env_cage(){
		$tmp = $this->sanitize($_ENV);
		$GLOBALS['HTTP_ENV_VARS'] = NULL;
		$this->env = $tmp;
	}


	/**
	 *
	 */
	private function files_cage(){
		$tmp = $this->sanitize($_FILES);
		$GLOBALS['HTTP_POST_FILES'] = NULL;
		$this->files = $tmp;
	}
}
?>
