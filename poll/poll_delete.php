<?php
session_start();
require_once ("../connection.php");
$sql = "delete from survey where sry_no = {$_GET['pollId']}";
if (mysqli_query($conn, $sql)) {
    echo "Poll Deleted";
} else {
    exit("An error occured");
}
header("location:poll_list.php");
?>