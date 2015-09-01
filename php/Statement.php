<?php

class Statement{
	protected $input;
	public function __construct( $input ) {
		$this->input = $input;
	}
	public function sanitize() {
		foreach( $this->input as $key => $data ) {
			$this->input[$key]= htmlspecialchars(
				stripslashes( trim( $data ) ), ENT_QUOTES
			);
		}
	}
	public function getStatement() {
		return $this->input;
	}
	public function getValue( $key ) {
		return $this->input[$key] ? : false;
	}
	function checkIfEmptyPost() {
		foreach( $this->input as $key => $value ) {
			if ( $value === '' ) {
				return true;
			}
		}
		return false;
	}
	function isValidName( $value ) {
		if( preg_match("/^[a-zA-Z ]*$/", $value ) ) {
			return true;
		}
		return false;
	}
	function isValidEmail( $value ) {
		if( filter_var( $value, FILTER_VALIDATE_EMAIL) ) {
			return true;
		}
		return false;
	}
}
?>