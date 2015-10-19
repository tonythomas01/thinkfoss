<?php
	session_start();

	if ( !isset( $_SESSION['loggedin_user'] ) ) {
		header( 'Location: ../../signup.php');
	}

	if ( !$_SERVER['REQUEST_METHOD'] == 'POST' ) {
		header( 'Location: viewMyCourses.php');
		return false;
	}

	$loggedInUser = $_SESSION['loggedin_user_id'];

	require_once('../../assets/php/Statement.php');
	$preparedPost = new Statement( $_POST );
	if ( $preparedPost->checkIfEmptyPost() ) {
		$_SESSION['error'] = "Please make sure you add in all required details";
		header('Location: ' . 'viewMyCourses.php');
		return;
	}

	require_once('../../assets/php/Token.php');
	require_once('../../assets/php/access/accessTokens.php');


	$postInputRow = $preparedPost->getValue( 'courseid_token' );
	$postRaw = explode( '_', $postInputRow );
	$courseId = base64_decode( $postRaw[0] );
	$csrfToken = new Token( $courseId.$csrfSecret );

	if( ! $csrfToken->validateCSRFToken( $postRaw[1] ) ) {
		$_SESSION['error'] = "Error: Invalid CSRF Token. Please contact one of the admins, or try againsss";
		header( 'Location: '.'viewMyCourses.php');
		return false;
	}

	require_once('../../assets/php/access/accessDB.php');
	require_once('../../assets/php/User.php');
	require_once('../../assets/php/Course.php');


?>
		<table class="table table-bordered table-responsive">
			<thead>
				<th>Name</th>
				<th>Email Id</th>
				<th>Enrollment Timestamp</th>
			</thead>
			<tbody>
				<?php
				$course = Course::newFromId( $conn, $courseId );
				$sql = "SELECT `user_id`,`course_enrollment_timestamp` FROM `course_enrollment` WHERE `course_id` = '$courseId' AND `course_enrolled` = 1";
				$res = $conn->query( $sql );
				if ( $res->num_rows > 0 ) {
					while ( $row = $res->fetch_assoc() ) {
						$userId = $row['user_id'];
						$user = User::newFromUserId($userId, $conn);
						echo
							'<tr><td style="text-align: left"> ' . $user->getValue('user_first_name') . ' ' . $user->getValue('user_last_name') . '</td>
							 <td style="text-align: left"> <a href="mailto:' . $user->getValue('user_email') . '">' . $user->getValue('user_email') . '</a></td>
							 <td style="text-align: left"> ' . $course->getEnrollmentTime($conn, $userId) . '</td></tr>';
					}
				} else {echo '</tbody>';
					echo "<p style='color: red'>Nobody in that list</p>";
				}


				?>

			</tbody>


		</table>