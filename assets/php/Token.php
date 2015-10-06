<?php
class Token {
	protected $secretKey;

	public function __construct( $secretKey ){
		$this->secretKey = $secretKey;
	}

	public function getCSRFToken() {
		$unixTime = time();
		$hash = substr( hash_hmac( 'sha512', $unixTime, $this->secretKey ), 0, 63 );
		$rotatedUnixTime = str_rot13( time() );
		$csrfToken = $rotatedUnixTime . '-' . $hash;
		return $csrfToken;
	}

	public function validateCSRFToken( $token ) {
		$tokenParts = explode( '-', $token );
		$originalUnixTime =  str_rot13( $tokenParts[0] );
		$hashExpected = substr( hash_hmac( 'sha512', $originalUnixTime, $this->secretKey ), 0, 63 );

		if ( $hashExpected === $tokenParts[1] ) {
			return true;
		}
		return false;
	}
}