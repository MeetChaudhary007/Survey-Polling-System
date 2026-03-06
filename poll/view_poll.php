<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Survey-Polling System</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="../assets/css/style.css" rel="stylesheet">

    <style>
        /* Media query for tablets */
        @media (max-width: 768px) {
            /* Add styles specific for tablets here */
            /* You can adjust font sizes, paddings, margins, etc. */
        }

        /* Media query for mobile devices */
        @media (max-width: 576px) {

            /* Add styles specific for mobile devices here */
            /* You can further adjust font sizes, paddings, margins, etc. */
            body {
                font-size: 14px;
                /* Example: Decrease the default font size for better readability on smaller screens */
            }

            .card-title {
                font-size: 18px;
                /* Example: Adjust the card title font size for smaller screens */
            }

            .modal-dialog {
                max-width: 90%;
                /* Example: Make the modal content occupy 90% of the screen width on mobile */
            }

            /* Add more specific styles as needed for a better mobile experience */
        }

        /* Media query for small screens */
        @media (max-width: 767px) {
            .card {
                width: 90%;
                /* Make the card full width on small screens */
            }

            .card-body {
                padding: 1rem;
                /* Adjust padding inside the card body */
            }

            .card-title {
                font-size: 1.25rem;
                /* Adjust the card title font size */
            }

            .btn-primary {
                width: 100%;
                /* Make the button full width on small screens */
                margin-bottom: 0.5rem;
                /* Add some bottom margin between buttons */
            }

            /* Adjust other button styles if necessary */
        }

        .modal-dialog {
            position: fixed;
            margin: auto;
            margin-top: 20px;
            width: 90%;
            /* Adjust the width as needed */
            height: auto;
            right: 0;
            left: 0;
        }

        /* Media query for smaller screens (e.g., tablets) */
        @media (max-width: 768px) {
            .modal-dialog {
                width: 100%;
                /* Set modal width to 100% for smaller screens */
                margin-top: 0;
                margin-bottom: 0;
                max-height: calc(100% - 30px);
                /* Set max height for the modal */
            }
        }

        /* Media query for even smaller screens (e.g., mobile phones) */
        @media (max-width: 576px) {
            .modal-dialog {
                width: 100%;
                /* Set modal width to 100% for even smaller screens */
                margin-top: 0;
                margin-bottom: 0;
                max-height: calc(100% - 15px);
                /* Set max height for the modal */
            }
        }

        .navbar-nav .nav-link {
            transition: transform 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            transform: scale(1.1);
        }
    </style>
</head>


<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="create_poll.php" style="color: white;">Create</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="poll_list.php" style="color: white;">Attempt</a>
                </li>
            </ul>
        </div>
    </nav>
    <?php


    date_default_timezone_set('Asia/Kolkata');
    require_once "../connection.php";


    $sql = "SELECT * FROM survey WHERE sry_no = '{$_GET['pollId']}'";
    $result = mysqli_query($conn, $sql);
    echo $result->num_rows;
    if ($result->num_rows > 0) {
        $_SESSION['Survey'] = $result->fetch_assoc();
    } else {
        die("<h5>Please refresh page</h5>");
    }
    ?>


    <main id="main" class="main ps-0">

        <div class="modal fade bd-example-modal-lg " id="mod1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body p-4">
                        <div class="text-center">
                            <i class="ri-error-warning-line text-primary h2"></i>
                            <p class="mt-2 text-dark">Are You Sure Want To Delete?</p>
                            <p class="mt-2 text-dark" id="modalCourseName">
                                <?= $_SESSION['Survey']['sry_name'] ?>
                            </p>
                            <button type="button" class="btn btn-secondary my-2 close">Close</button>
                            <a class="icon" href="poll_delete.php?pollId=<?= $_SESSION['Survey']['sry_no'] ?>" id="modalDeleteBtn"><button type="button" class="btn btn-danger my-2" data-dismiss="modal">Delete</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="card ms-4 col-11">
            <div class="card-body">
                <div class="row">
                    <div class="col-10  ">
                        <h5 class="card-title"><i class="ri-clipboard-fill h5 align-middle me-1"></i>
                            <?php echo $_SESSION['Survey']['sry_name']; ?>
                        </h5>
                    </div>
                    <?php
                    echo "
                            <div class='col-4 mt-3'>
                            <button id='del' class='btn btn-primary'>Delete</button>
                            </div>
                            ";
                    ?>
                </div>

                <div class="mb-4"></div>
                <span class="text-dark h6"><b>Created on: </b>
                    <?php echo date("d-m-Y h:i:s A", strtotime($_SESSION['Survey']['sry_start_time'])); ?>
                </span>
                <hr class="text-dark">

                <!-- Poll Code started here  -->
                <div class="container-fluid pe-5">
                    <h5 class="text-dark">
                        <b>Question:</b>
                        <?= $_SESSION['Survey']['sry_question']; ?>
                    </h5>
                    <h6 class='h6 text-dark'>
                        <?php
                        $sql_count = "SELECT sum(selection_count) as totalCount FROM survey_answers WHERE sry_no = {$_GET['pollId']}";
                        if ($result = mysqli_query($conn, $sql_count)) {
                            if (!empty($result) && $result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                echo "Total responses: {$row['totalCount']}";
                            }
                        }
                        ?>
                    </h6>
                    <?php
                    // 	sry_no	sry_answer	selection_count	
                    $sql = "select * from survey_answers where sry_no = {$_SESSION['Survey']['sry_no']}";
                    // echo $sql;
                    if ($result = mysqli_query($conn, $sql)) {
                        if ($result->num_rows > 0) {
                            $cnt = 0;
                            while ($data = $result->fetch_assoc()) {
                                echo "<form action='poll_answer_submit.php' method='post'>
                                           <div class='container-fluid mt-3 border border-3 rounded-start border-primary px-5 py-2'>
                                            <div class='container-fluid d-flex align-items-center py-1'>
                                               <input type='radio' class='form-check-input' id='opt" . $cnt . "' name='option' value='{$data['sry_ans_no']}''>
                                               <label for='opt" . $cnt . "' class='text-dark ps-2'>{$data['sry_answer']}</label>
                                            </div>";
                                if ($data['selection_count'] > 0) {
                                    echo "<div class='progress mt-3'>
                                                <div class='progress-bar progress-bar bg-primary' role='progressbar' style='width: 50%;font-size:15px;' data-option='{$data['selection_count']}' aria-valuenow='5' aria-valuemin='0' aria-valuemax='100'></div>
                                                </div>";
                                } else {
                                    echo "<div class='progress mt-3'>
                                        <div class='progress-bar progress-bar bg-danger' role='progressbar' style='width: 100%' data-option='{$data['selection_count']}' aria-valuenow='5' aria-valuemin='0' aria-valuemax='100'></div>
                                        </div>";
                                }
                                echo "</div>";
                                $cnt++;
                            }
                        }
                    }
                    ?>
                    <script>
                        //Code to select option which is selected by student
                        // console.log(document.querySelector('input[type="radio"][value="' + <?= $option_id; ?> +'"]'));
                        optionid = <?= $option_id; ?>;
                        console.log(optionid);
                        if (optionid != null) {
                            document.querySelector('input[type="radio"][value="' + optionid + '"]').setAttribute("checked", "true");
                        }
                    </script>
                    <div class='mt-3'>
                        <button type='submit' class='btn btn-primary'>Submit</button>
                    </div>

                </div>

                <!-- Poll Code Ended here -->
            </div>
        </div>
    </main>





    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/chart.js/chart.umd.js"></script>
    <script src="../assets/vendor/echarts/echarts.min.js"></script>
    <script src="../assets/vendor/quill/quill.min.js"></script>
    <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="../assets/vendor/php-email-form/validate.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>



    <!-- Template Main JS File -->
    <script src="../assets/js/main.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#del').click(function(e) {
            $('#mod1').modal('show');
        });

        $('.close').click(function() {
            $('#mod1').modal('hide');
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        const progressBars = document.querySelectorAll('[role="progressbar"]');
        let totalValue = 0;
        
        progressBars.forEach((progressBar) => {
            totalValue += parseInt(progressBar.getAttribute("data-option"));
        });

        progressBars.forEach((progressBar, index) => {
            const percentage1 = (parseInt(progressBar.getAttribute("data-option")) / totalValue) * 100;
            const percentage = percentage1.toFixed(2);

            if (percentage != "NaN" && percentage != 0) {
                progressBar.setAttribute("style", "width:" + percentage + "%");
                progressBar.innerHTML = "<p class='text-white' style='padding-top:15px;font-size:15px'>" + percentage + "%</p>";
            } else {
                progressBar.innerHTML = "<p class='text-white' style='padding-top:15px;font-size:15px'>0%</p>";
            }
        });
    });
</script>


</body>

</html>