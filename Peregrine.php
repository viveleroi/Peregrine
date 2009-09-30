<?php
/**
 * 
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

		if($key && strpos($method, 'is') !== false){
			$real_method = str_replace('is', 'get', $method);
			if(method_exists($this, $real_method)){
				return $this->{$real_method}($key) === $this->getRaw($key);
			}
		}
		return NULL;
	}


	/**
	 * WARNING: AVOID USING THIS!
	 * @param <type> $key
	 * @return <type>
	 * @access public
	 */
	public function getRaw($key = false){
		return $this->getKey($key);
	}



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


	/**
	 *
	 * @param <type> $val
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


	/***********************************************************
	 * SANITIZING RETURN METHODS
	 ***********************************************************/


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


	/**
	 *
	 * @param <type> $key
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
	 * @param <type> $key
	 * @return <type>
	 */
	public function getFloat($key = false){
		// We need to mimic the type back to the user that they gave us
		$type = gettype($this->getKey($key));
		$clean = preg_replace('/[^\d\.]/', '', $this->getKey($key));
		settype($clean, $type);
		return $clean;
	}


//define ('ISPK_DNS_VALID', '/^(?:[^\W_]((?:[^\W_]|-){0,61}[^\W_])?\.)+[a-zA-Z]{2,6}\.?$/');
//
///**
// * regex used to define what we're calling a valid email
// *
// * we're taking a "match 99%" approach here, rather than a strict
// * interpretation of the RFC.
// *
// * @see http://www.regular-expressions.info/email.html
// */
//define ('ISPK_EMAIL_VALID', '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/');


//$GLOBALS['HTTP_SERVER_VARS'] = NULL;
//$GLOBALS['HTTP_GET_VARS'] = NULL;
//$GLOBALS['HTTP_POST_VARS'] = NULL;
//$GLOBALS['HTTP_COOKIE_VARS'] = NULL;
//$GLOBALS['HTTP_ENV_VARS'] = NULL;
//$GLOBALS['HTTP_POST_FILES'] = NULL;
//$GLOBALS['HTTP_SESSION_VARS'] = NULL; (commented)
//
//	/**
//	 * Recursively walks an array and applies a given filter method to
//	 * every value in the array.
//	 *
//	 * This should be considered a "protected" method, and not be called
//	 * outside of the class
//	 *
//	 * @param array $input
//	 * @param string $inspektor  The name of a static filtering method, like get* or no*
//	 * @return array
//	 *
//	 */
//	static private function _walkArray($input, $method) {
//
//		if (!is_array($input)) {
//			user_error('$input must be an array', E_USER_ERROR);
//			return FALSE;
//		}
//
//		if ( !is_callable( array('Inspekt', $method) ) ) {
//			user_error('$inspektor '.$method.' is invalid', E_USER_ERROR);
//			return FALSE;
//		}
//
//		foreach($input as $key=>$val) {
//			if (is_array($val)) {
//				$input[$key]=Inspekt::_walkArray($val, $method);
//			} else {
//				$val = Inspekt::$method($val);
//				$input[$key]=$val;
//			}
//		}
//		return $input;
//	}
//
//
//
//		static function getDate($value)
//	{
//		if (is_array($value)) {
//			return Inspekt::_walkArray($value, 'getInt');
//		} else {
//			return preg_replace('/[^0-9-]/', '', $value);
//		}
//	}
//
//
//		static function isCcnum($value, $type = NULL)
//	{
//		/**
//         * @todo Type-specific checks
//         */
//
//		$value = self::getDigits($value);
//		$length = strlen($value);
//
//		if ($length < 13 || $length > 19) {
//			return FALSE;
//		}
//
//		$sum = 0;
//		$weight = 2;
//
//		for ($i = $length - 2; $i >= 0; $i--) {
//			$digit = $weight * $value[$i];
//			$sum += floor($digit / 10) + $digit % 10;
//			$weight = $weight % 2 + 1;
//		}
//
//		$mod = (10 - $sum % 10) % 10;
//
//		return ($mod == $value[$length - 1]);
//	}
//
//
//		static function isDate($value)
//	{
//		list($year, $month, $day) = sscanf($value, '%d-%d-%d');
//
//		return checkdate($month, $day, $year);
//	}
//
//
//		static function isEmail($value)
//	{
//		return (bool) preg_match(ISPK_EMAIL_VALID, $value);
//	}
//
//
//		static function isGreaterThan($value, $min)
//	{
//		return ($value > $min);
//	}
//
//
//		static function isHex($value)
//	{
//		return ctype_xdigit($value);
//	}
//
//
//		static function isIp($value)
//	{
//		return (bool) ip2long($value);
//	}
//
//
//		static function isLessThan($value, $max)
//	{
//		return ($value < $max);
//	}
//
//		static function isOneOf($value, $allowed = NULL)
//	{
//		/**
//         * @todo: Consider allowing a string for $allowed, where each
//         * character in the string is an allowed character in the
//         * value.
//         */
//
//		return in_array($value, $allowed);
//	}
//
//
//	static function isPhone($value, $country = 'US')
//	{
//
//		$value = Inspekt::getDigits($value);
//
//		if (!ctype_digit($value)) {
//			return FALSE;
//		}
//
//		switch ($country)
//		{
//			case 'US':
//				if (strlen($value) != 10) {
//					return FALSE;
//				}
//
//				$areaCode = substr($value, 0, 3);
//
//				$areaCodes = array(201, 202, 203, 204, 205, 206, 207, 208,
//				209, 210, 212, 213, 214, 215, 216, 217,
//				218, 219, 224, 225, 226, 228, 229, 231,
//				234, 239, 240, 242, 246, 248, 250, 251,
//				252, 253, 254, 256, 260, 262, 264, 267,
//				268, 269, 270, 276, 281, 284, 289, 301,
//				302, 303, 304, 305, 306, 307, 308, 309,
//				310, 312, 313, 314, 315, 316, 317, 318,
//				319, 320, 321, 323, 325, 330, 334, 336,
//				337, 339, 340, 345, 347, 351, 352, 360,
//				361, 386, 401, 402, 403, 404, 405, 406,
//				407, 408, 409, 410, 412, 413, 414, 415,
//				416, 417, 418, 419, 423, 424, 425, 430,
//				432, 434, 435, 438, 440, 441, 443, 445,
//				450, 469, 470, 473, 475, 478, 479, 480,
//				484, 501, 502, 503, 504, 505, 506, 507,
//				508, 509, 510, 512, 513, 514, 515, 516,
//				517, 518, 519, 520, 530, 540, 541, 555,
//				559, 561, 562, 563, 564, 567, 570, 571,
//				573, 574, 580, 585, 586, 600, 601, 602,
//				603, 604, 605, 606, 607, 608, 609, 610,
//				612, 613, 614, 615, 616, 617, 618, 619,
//				620, 623, 626, 630, 631, 636, 641, 646,
//				647, 649, 650, 651, 660, 661, 662, 664,
//				670, 671, 678, 682, 684, 700, 701, 702,
//				703, 704, 705, 706, 707, 708, 709, 710,
//				712, 713, 714, 715, 716, 717, 718, 719,
//				720, 724, 727, 731, 732, 734, 740, 754,
//				757, 758, 760, 763, 765, 767, 769, 770,
//				772, 773, 774, 775, 778, 780, 781, 784,
//				785, 786, 787, 800, 801, 802, 803, 804,
//				805, 806, 807, 808, 809, 810, 812, 813,
//				814, 815, 816, 817, 818, 819, 822, 828,
//				829, 830, 831, 832, 833, 835, 843, 844,
//				845, 847, 848, 850, 855, 856, 857, 858,
//				859, 860, 863, 864, 865, 866, 867, 868,
//				869, 870, 876, 877, 878, 888, 900, 901,
//				902, 903, 904, 905, 906, 907, 908, 909,
//				910, 912, 913, 914, 915, 916, 917, 918,
//				919, 920, 925, 928, 931, 936, 937, 939,
//				940, 941, 947, 949, 951, 952, 954, 956,
//				959, 970, 971, 972, 973, 978, 979, 980,
//				985, 989);
//
//				return in_array($areaCode, $areaCodes);
//				break;
//			default:
//				user_error('isPhone() does not yet support this country.', E_USER_WARNING);
//				return FALSE;
//				break;
//		}
//	}
//
//
//		static function isRegex($value, $pattern = NULL)
//	{
//		return (bool) preg_match($pattern, $value);
//	}
//
//
//
//	static function isUri($value, $mode=ISPK_URI_ALLOW_COMMON)
//	{
//		/**
//         * @todo
//         */
//		$regex = '';
//		switch ($mode) {
//
//			// a common absolute URI: ftp, http or https
//			case ISPK_URI_ALLOW_COMMON:
//
//				$regex .= '&';
//				$regex .= '^(ftp|http|https):';					// protocol
//				$regex .= '(//)';								// authority-start
//				$regex .= '([-a-z0-9/~;:@=+$,.!*()\']+@)?';		// userinfo
//				$regex .= '(';
//					$regex .= '((?:[^\W_]((?:[^\W_]|-){0,61}[^\W_])?\.)+[a-zA-Z]{2,6}\.?)';		// domain name
//				$regex .= '|';
//					$regex .= '([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?(\.[0-9]{1,3})?)';	// OR ipv4
//				$regex .= ')';
//				$regex .= '(:([0-9]*))?';						// port
//				$regex .= '(/((%[0-9a-f]{2}|[-a-z0-9/~;:@=+$,.!*()\'\&]*)*)/?)?';	// path
//				$regex .= '(\?[^#]*)?';							// query
//				$regex .= '(#([-a-z0-9_]*))?';					// anchor (fragment)
//				$regex .= '$&i';
//				//echo "<pre>"; echo print_r($regex, true); echo "</pre>\n";
//
//				break;
//
//			case ISPK_URI_ALLOW_ABSOLUTE:
//
//				user_error('isUri() for ISPK_URI_ALLOW_ABSOLUTE has not been implemented.', E_USER_WARNING);
//				return FALSE;
//				break;
//
//		}
//		$result = preg_match($regex, $value, $subpatterns);
//		return $result;
//	}
//
//
//		static function isZip($value)
//	{
//		return (bool) preg_match('/(^\d{5}$)|(^\d{5}-\d{4}$)/', $value);
//	}

}


/**
 * 
 */
class Peregrine {

	private $_post;
	private $_get;
	private $_session;
	private $_env;
	private $_files;
	private $_cookie;


	public function init(){
		// load post, get, session, server, env, cookie, file
//		$this->_post = $this->sanitize($_POST);

//		$this->_post = Peregrine::sanitize($_POST);
	}

	public function sanitize( &$var ){
		$tmp = new CageBase($var);
		$var= null;
		return $tmp;
	}
//
//	/**
//	 *
//	 * @return CageBase
//	 */
//	static public function post(){
//		return new CageBase('post');
//	}
//
//	/**
//	 *
//	 * @return CageBase
//	 */
//	static public function get(){
//		return new CageBase('get');
//	}
}
?>
