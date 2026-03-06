<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Survey-Polling System</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <?php include "../css.php"; ?>
  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">

  <style>
    #field {
      margin-bottom: 20px;
    }

    .card-hover:hover {
      transform: scale(1.05);
      /* Scale up on hover */
      box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.1);
      /* Add a subtle downward shadow */
      z-index: 1;
      /* Bring the card above other elements */
      transition: 300ms;
    }

    @media (max-width: 768px) {
      .card {
        margin: 10px 0;
      }
    }

    /* Media query for small screens (up to 767px) */
    @media (max-width: 767px) {
      .nav-tabs {
        flex-direction: column;
      }

      .nav-link {
        width: 100%;
        text-align: left;
      }

      .tab-pane {
        padding: 10px;
      }

      .box,
      .box-2 {
        width: 100%;
        margin: 0;
      }

      .options label,
      .options input {
        width: 100%;
      }
    }

    /* Media query for medium screens (768px to 991px) */
    @media (min-width: 768px) and (max-width: 991px) {
      .nav-tabs {
        flex-direction: row;
      }

      .nav-link {
        flex: 1;
        text-align: center;
      }
    }

    /* Media query for large screens (992px and above) */
    @media (min-width: 992px) {
      .nav-tabs {
        flex-direction: row;
      }

      .nav-link {
        /* Adjust the width based on your preference */
        flex: 1;
        text-align: center;
      }
    }

    @media (max-width: 767px) {
      .card-title {
        font-size: 1rem;
      }

      .place-card__content_header {
        margin-bottom: 0.5rem;
      }

      .card-icon {
        font-size: 40px;
      }

      .dropdown-menu {
        min-width: 150px;
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

  require_once "../connection.php";
  ?>

  <div class="container p-5">
    <div class="poll for">
      <h1 class='text-dark'>Create Survey</h1><br>
      <form id="pollForm" action="../poll/poll_create_db.php" method="post" enctype="multipart/form-data">
        <div class="row justify-content-center">
          <div class="col-xl-8">

            <div class="row mb-3">
              <label class="col-md-2 col-form-label text-dark" for="short_description">Poll Name</label>
              <div class="col-md-10">
                <input type="text" class="form-control" name="poll_name" required>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-md-2 col-form-label text-dark" for="short_description">Creation Time</label>
              <div class="col-md-10">
                <input type="datetime-local" class="StartDateTime form-control" name="startDate" required>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-md-2 col-form-label text-dark" for="poll_question">Poll question</label>
              <div class="col-md-10 mt-2">
                <input type="text" class="form-control" id="poll_question" name="poll_question" required>
              </div>
            </div>

            <!-- Poll options -->

            <div class="row mb-5">
              <label class="col-md-2 col-form-label text-dark">Options</label>
              <div class="col-md-10 mt-2" id="pollOptions">
                <input type="text" class="form-control mb-4" name="poll_options[]" placeholder="+ Option" id="option1" required>
                <input type="text" class="form-control mb-4" name="poll_options[]" placeholder="+ Option" id="option2" required>
                <span id="addMoreBtn" class="btn btn-primary">Add more</span>
              </div>
            </div>
          </div>
          <div class="text-center">
            <button type="button" id="createBtn" class="btn btn-primary">Create</button>
          </div>
        </div>
    </div>
    </form>
  </div>


  </main>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/main.js"></script>

  <script>
    $(document).ready(function() {

      window.addEventListener("load", function() {
        // Autofill current dates to date input fields
        var now = new Date();
        var year = now.getFullYear();
        var month = now.getMonth() + 1;
        var day = now.getDate();
        var hour = now.getHours();
        var minute = now.getMinutes();
        var localDatetime = year + "-" + (month < 10 ? "0" + month.toString() : month) + "-" + (day < 10 ? "0" + day.toString() : day) + "T" + (hour < 10 ? "0" + hour.toString() : hour) + ":" + (minute < 10 ? "0" + minute.toString() : minute);

        $('.StartDateTime').each((i, e) => {
          $(e).val(localDatetime);
        });
      });

      // Add option input fields dynamically
      var next = 3;
      $("#addMoreBtn").on("click", function() {
        var nextId = "option" + next;
        var inputBox = `<div id="` + nextId + `" class="row"><div class="col-11"><input type="text" class="form-control mb-4" name="poll_options[]" placeholder="+ Option" required></div><div class="col-1"><span class="btn btn-primary removeOption" value="` + nextId + `">&#10006;</span></div></div>`;
        $(inputBox).insertBefore("#addMoreBtn");
        next += 1;
      });

      // Remove dynamically added option input fields
      $("#pollOptions").on("click", ".removeOption", function(e) {
        var elem = $(e.target).attr("value");
        $('#' + elem).remove();
      });

      // AJAX form submission
      $("#createBtn").on("click", function() {
        var isValid = true;
        $('input[required]').each(function() {
          if ($(this).val() === '') {
            isValid = false;
          }
        });

        if (isValid) {
          $.ajax({
            type: "POST",
            url: "../poll/poll_create_db.php",
            data: $("#pollForm").serialize(),
            success: function(response) {
              alert("Survey created successfully!");
              location.reload();
            },
            error: function(xhr, status, error) {
              alert("Error creating survey. Please try again.");
            }
          });
        } else {
          alert("Please fill out all the required fields.");
        }
      });
    });
  </script>
</body>

</html>