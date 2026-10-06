<?php
session_start();

include('conf/config.php');
include('conf/checklogin.php');

check_login();

$client_id = $_SESSION['client_id'];
?>

<!DOCTYPE html>
<html>

<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<?php include("dist/_partials/head.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">

  <div class="wrapper">

    <!-- Navbar -->
    <?php include("dist/_partials/nav.php"); ?>
    <!-- /.navbar -->


    <!-- Main Sidebar Container -->
    <?php include("dist/_partials/sidebar.php"); ?>


    <!-- Content Wrapper -->
    <div class="content-wrapper">

      <!-- Content Header -->
      <section class="content-header">
        <div class="container-fluid">

          <div class="row mb-2">

            <div class="col-sm-6">
              <h1>My Accounts</h1>
            </div>

            <div class="col-sm-6">

              <ol class="breadcrumb float-sm-right">

                <!-- ================================================= -->
                <!-- TESTPLUS DEMO BUG #1: BROKEN INTERNAL LINK        -->
                <!-- Original: pages_dashboard.php                    -->
                <!-- ================================================= -->

                <li class="breadcrumb-item">
                  <a href="pages_dashboard_DOES_NOT_EXIST.php">
                    Dashboard
                  </a>
                </li>

                <li class="breadcrumb-item">
                  <a href="pages_manage_acc_openings.php">
                    iBank Accounts
                  </a>
                </li>

                <li class="breadcrumb-item active">
                  My Accounts
                </li>

              </ol>

            </div>

          </div>

        </div>
      </section>


      <!-- Main Content -->
      <section class="content">

        <div class="row">

          <div class="col-12">

            <div class="card">

              <div class="card-header">
                <h3 class="card-title">
                  iBanking Accounts
                </h3>
              </div>


              <div class="card-body">

                <table
                  id="example1"
                  class="table table-bordered table-hover table-striped"
                >

                  <thead>

                    <tr>

                      <th>#</th>

                      <th>Name</th>

                      <th>Account No.</th>

                      <th>Rate</th>

                      <th>Acc. Type</th>

                      <th>Acc. Balance</th>

                      <th>Date Opened</th>

                    </tr>

                  </thead>


                  <tbody>

                    <?php

                    /*
                     * Fetch all accounts belonging to
                     * the currently authenticated client.
                     */

                    $client_id = $_SESSION['client_id'];


                    $ret = "
                      SELECT
                        ba.*,
                        c.name AS client_name,
                        ba.acc_amount,
                        at.name AS acc_type,
                        at.rate AS acc_rates

                      FROM iB_bankAccounts ba

                      JOIN iB_clients c
                        ON ba.client_id = c.client_id

                      JOIN iB_acc_types at
                        ON ba.acc_type_id = at.acctype_id

                      WHERE ba.client_id = ?
                    ";


                    $stmt = $mysqli->prepare($ret);

                    $stmt->bind_param(
                      'i',
                      $client_id
                    );

                    $stmt->execute();

                    $res = $stmt->get_result();

                    $cnt = 1;


                    while ($row = $res->fetch_object()) {

                      $dateOpened = $row->created_at;

                    ?>

                      <tr>

                        <td>
                          <?php echo $cnt; ?>
                        </td>


                        <td>
                          <?php echo $row->acc_name; ?>
                        </td>


                        <td>
                          <?php echo $row->account_number; ?>
                        </td>


                        <td>
                          <?php echo $row->acc_rates; ?>%
                        </td>


                        <td>
                          <?php echo $row->acc_type; ?>
                        </td>


                        <td>
                          <?php echo number_format(
                            $row->acc_amount,
                            2
                          ); ?>
                        </td>


                        <td>
                          <?php
                          echo date(
                            "d-M-Y",
                            strtotime($dateOpened)
                          );
                          ?>
                        </td>

                      </tr>

                    <?php

                      $cnt = $cnt + 1;

                    }

                    ?>

                  </tbody>

                </table>

              </div>
              <!-- /.card-body -->

            </div>
            <!-- /.card -->

          </div>
          <!-- /.col -->

        </div>
        <!-- /.row -->

      </section>
      <!-- /.content -->


      <!-- ======================================================= -->
      <!-- TESTPLUS DEMO BUG #2: INTERNAL DEBUG INFORMATION        -->
      <!--                                                        -->
      <!-- Intentionally placed in DOM but hidden visually.        -->
      <!-- Gemini should potentially recognise this as internal    -->
      <!-- information that should not be exposed client-side.     -->
      <!-- ======================================================= -->

      <div
        id="internal-debug-information"
        style="display: none;"
      >

        INTERNAL_DEBUG_INFO

        database=internetbanking

        environment=development

        debug_mode=true

        application=DigiBankX

      </div>


    </div>
    <!-- /.content-wrapper -->


    <?php include("dist/_partials/footer.php"); ?>


    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">

      <!-- Control sidebar content -->

    </aside>
    <!-- /.control-sidebar -->


  </div>
  <!-- ./wrapper -->


  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>


  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>


  <!-- DataTables -->
  <script src="plugins/datatables/jquery.dataTables.js"></script>

  <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>


  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>


  <!-- AdminLTE Demo -->
  <script src="dist/js/demo.js"></script>


  <!-- DataTables Initialization -->

  <script>

    $(function () {

      $("#example1").DataTable();


      $('#example2').DataTable({

        "paging": true,

        "lengthChange": false,

        "searching": false,

        "ordering": true,

        "info": true,

        "autoWidth": false

      });

    });

  </script>


  <!-- ======================================================= -->
  <!-- TESTPLUS DEMO BUG #3: UNHANDLED JAVASCRIPT EXCEPTION    -->
  <!--                                                        -->
  <!-- Playwright pageerror should capture this deterministic  -->
  <!-- runtime failure.                                       -->
  <!-- ======================================================= -->

  <script>

    setTimeout(function () {

      throw new Error(
        "Account page failed to initialise transaction module"
      );

    }, 500);

  </script>


</body>

</html>
