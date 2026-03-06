<?php
session_start();
require_once "../connection.php";




extract($_POST);

$dt1 = new DateTime($startDate);
$sd = $dt1->format('Y-m-d H:i:s');


$sql = "insert into survey (sry_name, sry_question, sry_start_time) values ('$poll_name','$poll_question', '$sd')";
if (mysqli_query($conn, $sql)) {
    echo "Poll added<br>";
    $poll_id = mysqli_insert_id($conn);
    if (empty($poll_id)) {
        exit("An error occured");
    }
} else {

    exit("An error occured");
}

foreach ($poll_options as $option) {
    $query_for_option = "insert into survey_answers (sry_no, sry_answer) values ($poll_id, '$option')";
    if (mysqli_query($conn, $query_for_option)) {
        echo "Option : $option Added <br>";
    } else {
        exit("An error occured");
    }
}

header("location:{$_SERVER['HTTP_REFERER']}");


?>