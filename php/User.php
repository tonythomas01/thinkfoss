<?php

class User {
	protected $user_id;
	protected $user_first_name;
	protected $user_last_name;
	protected $user_email;
	protected $user_dob;
	protected $user_gender;

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