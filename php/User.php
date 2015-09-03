<?php

class User {
	protected $user_id;
	protected $user_first_name;
	protected $user_last_name;
	protected $user_email;
	protected $user_dob;
	protected $user_gender;
	protected $user_github;
	protected $user_linkedin;
	protected $user_about;
	protected $user_occupation;
	protected $user_nation;

	static function newFromUserId( $userId, $conn ) {
		$selectUser = "SELECT `user_first_name`,`user_last_name`, `user_email`, `user_dob`, `user_gender` FROM `user_details`
		WHERE `user_id` = '$userId';";
		$res = $conn->query( $selectUser );
		if( $res->num_rows > 0 ) {
			$user = new User;
			$userData = $res->fetch_assoc();
			$user->user_first_name = $userData['user_first_name'];
			$user->user_last_name =  $userData['user_last_name'];
			$user->user_email = $userData['user_email'];
			$user->dob = $userData['user_dob'];
			$user->user_gender = $userData['user_gender'];
			$user->user_id = $userId;
			return $user;
		}
		return false;
	}

	static function newFromGoogleOauth( $userLogin ) {
		$oauthUser = new User();
		$oauthUser->user_first_name = $userLogin['givenName'];
		$oauthUser->user_last_name= $userLogin['familyName'];
		$oauthUser->user_email = $userLogin['email'];
		$oauthUser->user_gender =  $userLogin['gender'];
		return $oauthUser;
	}

	public function getExtra( $conn ) {
		$sqlStatement = "SELECT `user_id`, `user_github`, `user_linkedin`, `user_about`, `user_occupation`, `user_nation`
 		FROM `user_extra` WHERE `user_id` = '$this->user_id';";
		$res = $conn->query( $sqlStatement );
		if( $res->num_rows > 0 ) {
			$userExtra = $res->fetch_assoc();
			$this->user_github = $userExtra['user_github'];
			$this->user_linkedin= $userExtra['user_linkedin'];
			$this->user_about = $userExtra['user_about'];
			$this->user_occupation = $userExtra['user_occupation'];
			$this->user_nation = $userExtra['user_nation'];
		} else {
			return false;
		}
	}

	public function getValue( $key ) {
		return $this->$key;
	}

	public function getEnrolledCourses( mysqli $conn ) {
		$sql = "SELECT `course_id` FROM `course_enrollment` WHERE `user_id` = '$this->user_id' AND `course_enrolled` = false";
		$res = $conn->query( $sql );
		return $res->num_rows;
	}

	public function getUserId() {
		return $this->user_id;
	}

	public function getUserFreshId( $conn ) {
		$sql = "SELECT `user_id` FROM `user_details` WHERE `user_email` = '$this->user_email';";
		if ( $row = $conn->query( $sql ) ) {
			while( $res = $row->fetch_assoc() ) {
				return $res['user_id'];
			}
		}
	}

	public function isExistingMember( $conn ) {
		$sql = "SELECT * FROM `authorization` WHERE `email_id` = '$this->user_email';";
		if( mysqli_num_rows( $conn->query( $sql ) ) >= 1 ) {
			return true;
		}
		return false;
	}

	public function setPassword( $conn, $passwordHash ) {
		$sql = "INSERT INTO `authorization`(`email_id`, `password_hash`) VALUES ( '$this->user_email','$passwordHash');";
		if ( $conn->query( $sql ) ) {
			return true;
		}
		return false;
	}
	public function addToDatabase( $conn ) {
		$sql = "INSERT INTO `user_details`(`user_id`, `user_first_name`, `user_last_name`,
 			`user_email`, `user_dob`, `user_gender`) VALUES
		('','$this->user_first_name', '$this->user_last_name', '$this->user_email', '','$this->user_gender' );";
		if ( $conn->query( $sql ) ) {
			return true;
		} else {
			return false;
		}

	}
	public function sendWelcomeEmail( $password ) {
		echo "hi";
		$emailBody = "Hello $this->user_first_name, \n
			Welcome to your ThinkFOSS account. This email contains your password so that you can later login.Please note that you can either use the OAuth Login, or use your email-password combo. \n
			\n Your ThinkFOSS Password is : $password \n
			Please add in more courses, or enroll to courses out there so that we can spread the light of FOSS. \n
			\n Pleased to serve you here.
			\n With <3 to FOSS, \n The ThinkFOSS Team";


		require_once( 'access/mailgunAPIKeys.php' );
		require_once( 'vendor/mailgun-php/vendor/autoload.php' );

		$mg = new \Mailgun\Mailgun( $mailgunAPIKey );
		$mg->sendMessage( $mailgunDomain, array(
			'from'  => 'admin@thinkfoss.com',
			'to'    => $this->user_email,
			'subject' => 'Welcome to your ThinkFOSS account',
			'text'  => $emailBody
		) );

		return true;

	}

}
?>