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
 		`course_date_from`, `course_time_from`, `course_date_to`, `course_time_to`, `course_fees`)
  		VALUES ('','$this->course_name','$this->course_bio','$this->course_lang','$this->course_difficulty','$this->course_date_from','$this->course_time_from','$this->course_date_to','$this->course_time_to', '$this->course_fees');";

		echo $sql;

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

	public function getCourseId() {
		return $this->courseId;
	}

	public function addToMentorMap( $conn, $course_mentor ) {
		$sqlAddtoMap = "INSERT INTO `course_mentor_map` (`course_id`, `mentor_id` ) VALUES ( '$this->course_id','$course_mentor' );";
		if ( $conn->query( $sqlAddtoMap ) ) {
			return true;
		}
		return false;
	}

	public function deleteFromDb( $conn ) {
		$sqlRemove = "DELETE FROM `course_mentor_map` WHERE `course_id` = '$this->course_id'";
		if ( $conn->query( $sqlRemove ) ) {
			return true;
		}
		return false;
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

	public function isOwner( $userId ) {
		if ( $this->course_mentor == $userId ) {
			return true;
		}
		return false;
	}

}

