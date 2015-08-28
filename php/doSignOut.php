<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 26/8/15
 * Time: 10:55 PM
 */

session_start();
session_destroy();
header( 'Location: '.'../index.php');