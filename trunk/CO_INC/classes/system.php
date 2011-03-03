<?php
class System
{

// Quote safe text
	function checkMagicQuotes($string) {
		if (!get_magic_quotes_gpc()) {
			$string = addslashes($string);
		}
		$string = str_replace('"', "&quot;", $string);
		//return htmlentities($string, ENT_QUOTES);
		return $string;
	}
	
	
	/**
	 * Returns a reference to a json object
	 *
	 * This method must be invoked as:
	 * 		<pre>  $json =& JContentEditor::getJson();</pre>
	 *
	 * @access	public
	 * @return	json  a json services object.
	 * @since	1.5
	 */
	function &getJson(){
		static $json;
		if( !is_object( $json ) ){
			if( !class_exists( 'Services_JSON' ) ){
				include_once( 'json.php' );
			}
			$json = new Services_JSON();
		}
		return $json;
	}
	/**
	 * JSON Encode wrapper for PHP function or PEAR class
	 *
	 * @access public
	 * @param string	The string to encode
	 * @return			The json encoded string
	*/
	function json_encode( $string ){
		if( function_exists( 'json_encode' ) ){
			return json_encode( $string );
		}else{
			$json =& $this->getJson();
			return $json->encode( $string );
		}
	}
	/**
	 * JSON Decode wrapper for PHP function or PEAR class
	 *
	 * @access public
	 * @param string	The string to decode
	 * @return			The json decoded string
	*/
	function json_decode( $string ){
		if( function_exists( 'json_decode' ) ){
			return json_decode( $string );
		}else{
			$json =& $this->getJson();
			return $json->decode( $string );
		}
	}
	
}

$system = new System();
?>