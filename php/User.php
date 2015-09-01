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

}
?>