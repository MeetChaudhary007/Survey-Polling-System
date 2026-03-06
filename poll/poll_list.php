<?php
session_start();
?>
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
    /* Add your custom CSS styles here */
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

  <main id="main">
    <div class="container p-5">
      <div class="Survey for">
        <h1 class='text-dark'>View Survey</h1><br>
        <table class='table' id="survey-table">
          <tr>
            <th>Survey Name</th>
            <th>Survey Question</th>
            <th>Survey Start Time</th>
          </tr>
          <?php
          include_once '../connection.php';

          $sql = "SELECT sry_no, sry_name, sry_question, sry_start_time FROM survey";
          if ($result = mysqli_query($conn, $sql)) {
            if (!empty($result) && $result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td><a href='view_poll.php?pollId={$row['sry_no']}' class='link'>{$row['sry_name']}</a></td><td>{$row['sry_question']}</td>
                        <td>{$row['sry_start_time']}</td>";
                echo "</tr>";
              }
            } else {
              echo "<td colspan='4' style='text-align:center;'>No result found</td>";
            }
          }
          ?>
        </table>
      </div>
    </div>
  </main>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    $(document).ready(function() {
      $.ajax({
        url: 'https://yourapiendpoint.com/surveydata',
        type: 'GET',
        success: function(response) {
          $('#survey-table').html(response);
        },
        error: function(xhr, status, error) {
          console.log('Error: ' + error);
        }
      });
    });
  </script>

</body>

</html>