<?php

class Statement{
	protected $input;
	public function __construct( $input ) {
		$this->input = $input;
	}
	public function sanitize() {
		foreach( $this->input as $key => $data ) {
			$this->input[$key]= htmlspecialchars(
				stripslashes( trim( $data ) )
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
}
?>