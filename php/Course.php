<?php

/**
 * Created by PhpStorm.
 * User: tony
 * Date: 30/8/15
 * Time: 12:10 AM
 */
class Course {
	public $course_id;
	public $course_name;
	public $course_bio;
	public $course_lang;
	public $course_difficulty;
	public $course_date_from;
	public $course_time_from;
	public $course_date_to;
	public $course_time_to;
	public $course_fees;
	public $course_mentor;

	public function addToDatabase( $conn ) {
		$sql = "INSERT INTO `course_details`(`course_id`, `course_name`, `course_bio`, `course_lang`, `course_difficulty`,
 		`course_date_from`, `course_time_from`, `course_date_to`, `course_time_to`, `course_fees`, `course_approved` )
  		VALUES ('','$this->course_name','$this->course_bio','$this->course_lang','$this->course_difficulty',
  		'$this->course_date_from','$this->course_time_from','$this->course_date_to','$this->course_time_to', '$this->course_fees', 0 );";

		if ( $conn->query( $sql ) ) {
			$sql = "SELECT `course_id` FROM `course_details` WHERE `course_name` = '$this->course_name';";
			$res = $conn->query( $sql );
			$courseId = 0;
			foreach( $res as $row ) {
				$courseId = $row['course_id'];
			}
			$this->course_id = $courseId;
			return true;
		}
		return false;
	}

	public function UpdateDatabase( $conn, $course_name, $course_bio, $course_lang, $course_difficulty, $course_date_from,
	                                $course_time_from,$course_date_to, $course_time_to,$course_amount ) {
		$sql = "UPDATE `course_details` SET `course_name` = '$course_name', `course_bio` = '$course_bio',
			`course_lang` = '$course_lang', `course_difficulty` = '$course_difficulty',
 		`course_date_from` = '$course_date_from', `course_time_from` ='$course_time_from', `course_date_to` ='$course_date_to',
 		 `course_time_to` ='$course_time_to', `course_fees`='$course_amount' WHERE `course_id` = '$this->course_id' ";

		if ( $conn->query( $sql ) ) {
			return true;
		}
		return false;
	}

	public function getCourseId() {
		return $this->course_id;
	}

	public function addToMentorMap( $conn, $course_mentor ) {
		$sqlAddtoMap = "INSERT INTO `course_mentor_map` (`course_id`, `mentor_id` ) VALUES ( '$this->course_id','$course_mentor' );";
		if ( $conn->query( $sqlAddtoMap ) ) {
			return true;
		}
		return false;
	}

	public function deleteFromDb( $conn ) {
		$sql = "DELETE FROM `course_details` WHERE `course_id` = '$this->course_id'";
		if ( $conn->query( $sql ) ) {
			$sqlRemove = "DELETE FROM `course_mentor_map` WHERE `course_id` = '$this->course_id'";
			if ( $conn->query( $sqlRemove ) ) {
				return true;
			}
		}
	}

	public function removeCourseByAdmin( $conn, $adminId ) {
		$this->deleteFromDb( $conn );
		$sql = "INSERT INTO `course_administration_log`(`course_id`, `admin_id`, `course_approval` )
			VALUES ( '$this->course_id', '$adminId', 0 )";
		if ( $conn->query( $sql ) ) {
			return true;
		}
	}

	public function approveCourseByAdmin( $conn, $adminId ) {
		$sqlApprove = "UPDATE `course_details` SET `course_approved`= 1 WHERE `course_id` = '$this->course_id';";
		if ( $conn->query( $sqlApprove ) ) {
			$sql = "INSERT INTO `course_administration_log`(`course_id`, `admin_id`, `course_approval` )
			VALUES ( '$this->course_id', '$adminId', 1 )";
			if ( $conn->query( $sql ) ) {
				return true;
			}
 		}
	}

	static function newFromDetails( $course_name, $course_bio, $course_lang, $course_difficulty, $course_date_from, $course_time_from, $course_date_to, $course_time_to, $course_fees, $course_mentor ) {
		$course = new Course;
		$course->course_name = $course_name;
		$course->course_bio = $course_bio;
		$course->course_lang = $course_lang;
		$course->course_difficulty = $course_difficulty;
		$course->course_date_from = $course_date_from;
		$course->course_time_from = $course_time_from;
		$course->course_date_to = $course_date_to;
		$course->course_time_to = $course_time_to;
		$course->course_fees = $course_fees;

		return $course;
	}

	static function newFromDbObject( $res ) {
		$course = new Course;
		$course->course_id = $res['course_id'];
		$course->course_name = $res['course_name'];
		$course->course_bio = $res['course_bio'];
		$course->course_lang = $res['course_lang'];
		$course->course_difficulty = $res['course_difficulty'];
		$course->course_date_from = $res['course_date_from'];
		$course->course_time_from = $res['course_time_from'];
		$course->course_time_to = $res['course_time_to'];
		$course->course_fees = $res['course_fees'];
		return $course;
	}

	public function getCourseName() {
		return $this->course_name;
	}

	public function enrollUser( $conn, $userId ) {
		$insertStatement = "INSERT INTO `course_enrollment`(`course_id`, `user_id`,  `course_enrolled` ) VALUES ( '$this->course_id', '$userId', FALSE );";
		if ( $conn->query( $insertStatement ) ) {
			return true;
		}
		return false;
	}

	public function checkoutCourse( $conn, $userId ) {
		$checkoutStatement = "UPDATE `course_enrollment` SET `course_enrolled` = TRUE WHERE `course_id` = '$this->course_id'
			AND `user_id` =  '$userId';";
		if ( $conn->query( $checkoutStatement ) ) {
			return true;
		}
		return false;
	}

	public function getValue( $key ) {
		return $this->$key;
	}

	static function newFromId( $conn, $courseId ) {
		$getCourseData = "SELECT `course_id`, `course_name`, `course_bio`, `course_lang`, `course_difficulty`,
		`course_date_from`, `course_time_from`, `course_date_to`, `course_time_to`, `course_fees` FROM
		`course_details` WHERE `course_id` = '$courseId';";
		if ( $row = $conn->query( $getCourseData ) ) {
			$res = $row->fetch_assoc();
			$course = new Course;
			$course->course_id = $res['course_id'];
			$course->course_name = $res['course_name'];
			$course->course_bio = $res['course_bio'];
			$course->course_lang = $res['course_lang'];
			$course->course_difficulty = $res['course_difficulty'];
			$course->course_date_from = $res['course_date_from'];
			$course->course_date_to = $res['course_date_to'];
			$course->course_time_from = $res['course_time_from'];
			$course->course_time_to = $res['course_time_to'];
			$course->course_fees = $res['course_fees'];
			$course->course_mentor = self::getCourseMentor( $conn, $course->course_id );

			return $course;
		}
		return false;
	}

	static function getCourseMentor( $conn, $courseId ) {
		$sql = "SELECT `mentor_id` FROM `course_mentor_map` WHERE `course_id` = '$courseId';";
		if ( $row = $conn->query( $sql ) ) {
			while( $res = $row->fetch_assoc() ) {
				return $res['mentor_id'];
			}
		}
	}

	public function getReviews( $conn ) {
		$sql = "SELECT `cf_course_id`,`cf_user_id`,`cf_general_review`,`cf_recommend` FROM `course_feedback`
		WHERE `cf_course_id`= '$this->course_id';";
		$review = array();
		if ( $row = $conn->query( $sql ) ) {
			while( $res = $row->fetch_assoc() ) {
				$review[$this->course_id]['user_id'] = $res['cf_user_id'];
				$review[$this->course_id]['general_review']= $res['cf_general_review'];
				$review[$this->course_id]['recommend'] = $res['cf_recommend'];
			}
			return $review;
		}
		return false;

	}

	public function isOwner( $userId ) {
		if ( $this->course_mentor == $userId ) {
			return true;
		}
		return false;
	}

	public function isEnrolled( $userId, $conn ) {
		$sql = "SELECT * FROM `course_enrollment` WHERE `user_id` = '$userId' AND `course_id` = '$this->course_id'
			AND `course_enrolled` = 1;";
		if( mysqli_num_rows( $conn->query( $sql ) ) >= 1 ) {
			return true;
		}
		return false;
	}

	public function needsCheckout( $userId, $conn ) {
		$sql = "SELECT * FROM `course_enrollment` WHERE `user_id` = '$userId' AND `course_id` = '$this->course_id'
			AND `course_enrolled` = false;";
		if( mysqli_num_rows( $conn->query( $sql ) ) >= 1 ) {
			return true;
		}
		return false;
	}

	public function getNumberofStudentsEnrolled( $conn ) {
		$sql = "SELECT count( `user_id`) AS enrolledusers FROM `course_enrollment` WHERE `course_id` = '$this->course_id' AND `course_enrolled` = 1";
		if ( $row = $conn->query( $sql ) ) {
			while ( $res = $row->fetch_assoc() ) {
				return $res['enrolledusers'];
			}
		}

		return false;
	}

	public function sendCourseCreatedEmail( $conn, $userId, $mailgunAPIKey, $mailgunDomain ) {
		require_once( 'User.php' );
		require_once( 'vendor/mailgun-php/vendor/autoload.php' );
		$user = User::newFromUserId( $userId, $conn );
		$userEmailId = $user->getValue( 'user_email' );
		$emailBody = "Hello There,
		\n Greetings from ThinkFOSS. Thank you for adding in your course $this->course_name. We will be reviewing the course details for its quality, and will accept/reject in a short time.
		\n The admins have been notified about the same, and if you dont hear from us in 24 hours - please respond to this email with your concern. Please add in more courses, or enroll to courses out there so that we can spread the light of FOSS. \n
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

	public function sendCourseApprovedEmail( $conn, $mailgunAPIKey, $mailgunDomain ) {
		require_once( 'User.php' );
		require_once( 'vendor/mailgun-php/vendor/autoload.php' );
		$courseMentorId = self::getCourseMentor( $conn, $this->course_id );
		$user = User::newFromUserId( $courseMentorId, $conn );
		$userEmailId = $user->getValue( 'user_email' );
		$emailBody = "Hello There,
		\n Greetings from ThinkFOSS. We are happy to inform you that your course titled $this->course_name has been reviewed and accepted by the ThinkFOSS admin team. We might contact you for further details in this regard.
		\n You can either share your course link with interested people - or wait until some students register for the same.
		\n In case of trouble, please contact one of the admins or reply to this email. Meanwhile, please do add in more courses, or enroll to courses out there so that we can spread the light of FOSS.

		\n Pleased to serve you here.
		\n With <3 to FOSS, \n The ThinkFOSS Team";

		$mg = new \Mailgun\Mailgun( $mailgunAPIKey );
		$mg->sendMessage( $mailgunDomain, array(
			'from'  => 'admin@thinkfoss.com',
			'cc' => 'admin@thinkfoss.com',
			'to'    => $userEmailId,
			'subject' => 'ThinkFOSS: Your course has been accepted',
			'text'  => $emailBody
		) );

		return true;
	}

	public function notifyMentor( $conn, $mailgunAPIKey, $mailgunDomain ) {
		require_once( 'User.php' );
		require_once( 'vendor/mailgun-php/vendor/autoload.php' );
		$courseMentorId = self::getCourseMentor( $conn, $this->course_id );
		$user = User::newFromUserId( $courseMentorId, $conn );
		$userEmailId = $user->getValue( 'user_email' );

		$emailBody = "Hello There, \n\n Greetings from ThinkFOSS. We are happy to inform you that a user has enrolled to your course titled '$this->course_name '. \n You can see details of the user who have enrolled from your ThinkFOSS portal. We might contact you for further details in this regard. You can start communication with your mentee from now.

		\n You should schedule a preferred time for your course to take place with your mentee, and make sure that you complete in time. You are invited to use our phabricator at http://phab.thinkfoss.com to schedule and track your course. In case of trouble, please contact one of the admins or reply to this email.

		\n Meanwhile, please do add in more courses, or enroll to courses out there so that we can spread the light of FOSS.

		\n Pleased to serve you here.
		\n With <3 to FOSS, \n The ThinkFOSS Team";

		$mg = new \Mailgun\Mailgun( $mailgunAPIKey );
		$mg->sendMessage( $mailgunDomain, array(
			'from'  => 'admin@thinkfoss.com',
			'cc' => 'admin@thinkfoss.com',
			'to'    => $userEmailId,
			'subject' => 'ThinkFOSS: A new user has enrolled to your course',
			'text'  => $emailBody
		) );

		return true;
	}

	public function removeFromCart( $conn, $userId ) {
		$sql = "DELETE FROM `course_enrollment` WHERE `course_id` = '$this->course_id' AND `user_id` = '$userId';";
		if( $conn->query( $sql ) ) {
			return true;
		}
		return false;
	}

}

