<?php

class Order {
	public $orderId;
	public $userId;
	public $courseId;
	public $checkoutTimestamp;
	public $checkedOut;

	public static function newOrderFromId( $conn, $orderId ) {
		$order = new Order;
		$order->orderId = $orderId;

		$sqlSelect = "SELECT `course_id`, `user_id`, `course_enrolled`, `course_enrollment_timestamp`, FROM
		`course_enrollment` WHERE `checkout_order_id` = '$orderId' ";
		if ( $row = $conn->query( $sqlSelect ) ) {
			while ( $res = $row->fetch_assoc() ) {
				$order->courseId =  $res['course_id'];
				$order->userId =  $res['user_id'];
				$order->checkoutTimestamp =  $res['course_enrollment_timestamp'];
				$order->checkedOut = $res['course_enrolled'];
			}
		}
		return $order;
	}

	public function checkoutOrder( $conn ) {
		$sql = "UPDATE `course_enrollment` SET `course_enrolled`= 1 WHERE `checkout_order_id` = '$this->orderId'";
		if ( $conn->query( $sql ) ) {
			return true;
		} else {
			return false;
		}

	}

	public function getValue( $key ) {
		return $this->$key;
	}

}