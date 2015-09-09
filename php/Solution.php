<?php


class Solution {
	protected $solution_id;
	protected $solution_name;
	protected $solution_platform;
	protected $solution_framework;
	protected $solution_contact;
	protected $solution_deadline_estimated;
	protected $solution_amount;
	protected $solution_bio;
	protected $solution_request_user_id;
	protected $solution_accepted;

	public function getValue( $key ) {
		return $this->$key;
	}

	static function newFromDetails( $solution_name, $solution_platform, $solution_framework, $solution_contact,
	                                $solution_date_estimated, $solution_amount, $solution_bio, $solution_request_user_id ) {
		$solution = new Solution;
		$solution->solution_name = $solution_name;
		$solution->solution_platform = $solution_platform;
		$solution->solution_framework = $solution_framework;
		$solution->solution_contact = $solution_contact;
		$solution->solution_deadline_estimated = $solution_date_estimated;
		$solution->solution_amount = $solution_amount;
		$solution->solution_bio = $solution_bio;
		$solution->solution_request_user_id = $solution_request_user_id;
		return $solution;

	}

	static function newFromId( $conn, $solution_id ) {
		$getCourseData = "SELECT `solution_id`, `solution_name`, `solution_platform`, `solution_framework`, `solution_contact`,
		`solution_deadline_estimated`, `solution_amount`, `solution_bio`, `solution_request_user_id`
		FROM `solution_details` WHERE `solution_id`= '$solution_id';";
		if ( $row = $conn->query( $getCourseData ) ) {
			$res = $row->fetch_assoc();
			$solution = new Solution;
			$solution->solution_id = $res['solution_id'];
			$solution->solution_name = $res['solution_name'];
			$solution->solution_platform = $res['solution_platform'];
			$solution->solution_framework = $res['solution_framework'];
			$solution->solution_contact = $res['solution_contact'];
			$solution->solution_deadline_estimated = $res['solution_deadline_estimated'];
			$solution->solution_amount = $res['solution_amount'];
			$solution->solution_bio = $res['solution_bio'];
			$solution->solution_request_user_id = $res['solution_request_user_id'];
			return $solution;

		}
		return false;
	}

	public function addToDatabase( $conn ) {
		$sqlInsert = "INSERT INTO `solution_details`(`solution_id`, `solution_name`, `solution_platform`,`solution_framework`, `solution_contact`,
				`solution_deadline_estimated`, `solution_amount`, `solution_bio`, `solution_request_user_id`, `solution_accepted` )
				VALUES ('','$this->solution_name','$this->solution_platform','$this->solution_framework', '$this->solution_contact',
				'$this->solution_deadline_estimated','$this->solution_amount', '$this->solution_bio', '$this->solution_request_user_id', 0 )";

		if ( $conn->query( $sqlInsert ) ) {
			return true;
		} else {
			return false;
		}
	}

	public function updateDb( $conn, $solution_name, $solution_platform, $solution_framework, $solution_contact,
	                          $solution_date_estimated, $solution_amount, $solution_bio ) {
		$sql = "UPDATE `solution_details` SET `solution_name` = '$solution_name', `solution_platform` = '$solution_platform',
			`solution_framework` ='$solution_framework', `solution_contact` = '$solution_contact',
			`solution_deadline_estimated` = '$solution_date_estimated', `solution_amount`='$solution_amount',
			 `solution_bio` = '$solution_bio' WHERE `solution_id`= '$this->solution_id';";
		if ( $conn->query( $sql ) ) {
			return true;
		} else {
			return false;
		}
	}

	public function isOwner( $userId ) {
		if ( $this->solution_request_user_id == $userId ) {
			return true;
		}
		return false;
	}

	public function deleteFromDb( $conn ) {
		$sql = "DELETE FROM `solution_details` WHERE `solution_id` = '$this->solution_id';";
		if ( $conn->query( $sql ) ) {
			return true;
		}
	}

	public function sendSolutionCreatedEmail( $conn, $userId, $mailgunAPIKey, $mailgunDomain ) {
		require_once( 'User.php' );
		require_once( 'vendor/mailgun-php/vendor/autoload.php' );

		$user = User::newFromUserId( $userId, $conn );
		$userEmailId = $user->getValue( 'user_email' );

		$emailBody = "Hello There,
		\n Greetings from ThinkFOSS. Thank you for adding in your solution request  $this->solution_name. We will be reviewing the solution details for its quality, and will take it up/drop it in a short time.
		\n The admins have been notified about the same, and if you dont hear from us in 24 hours - please respond to this email with your concern. You are welcome to add in more courses, or enroll to courses out there so that we can spread the light of FOSS. \n
		\n Pleased to serve you here.
		\n With <3 to FOSS, \n The ThinkFOSS Team";

		$mg = new \Mailgun\Mailgun( $mailgunAPIKey );
		$mg->sendMessage( $mailgunDomain, array(
			'from'  => 'admin@thinkfoss.com',
			'cc' => 'admin@thinkfoss.com',
			'to'    => $userEmailId,
			'subject' => 'ThinkFOSS: You have just added a new course',
			'text'  => $emailBody
		) );

		return true;
	}

}