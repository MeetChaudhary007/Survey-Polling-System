<?php
session_start();
require_once "../connection.php";


extract($_POST);
$sql = null;
$sql = "update survey_answers set selection_count = selection_count + 1 where sry_ans_no = {$option}";
echo "$sql<br>";

if (!empty($sql) && mysqli_query($conn, $sql)) {
    echo "Poll answer submitted";
} else {
    echo mysqli_error($conn);
}

header("location:{$_SERVER['HTTP_REFERER']}");
