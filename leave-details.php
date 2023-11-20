<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['emplogin']) == 0) {
    header('location:index.php');
} else {




?>
    <!DOCTYPE html>
    <html lang="en">

    <head>

        <!-- Title -->
        <title>Employee | Leave Details </title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta charset="UTF-8">
        <meta name="description" content="Responsive Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="Steelcoders" />

        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="assets/plugins/materialize/css/materialize.min.css" />
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet">
        <link href="assets/plugins/datatables/css/jquery.dataTables.min.css" rel="stylesheet">

        <link href="assets/plugins/google-code-prettify/prettify.css" rel="stylesheet" type="text/css" />
        <!-- Theme Styles -->
        <link href="assets/css/alpha.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/custom.css" rel="stylesheet" type="text/css" />
        <style>
            .errorWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #fff;
                border-left: 4px solid #dd3d36;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            }

            .succWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #fff;
                border-left: 4px solid #5cb85c;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            }
        </style>
    </head>

    <body>
        <?php include('includes/header.php'); ?>

        <?php include('includes/sidebar.php'); ?>
        <main class="mn-inner">
            <div class="row">
                <div class="col s12">
                    <div class="page-title" style="font-size:24px;">รายละเอียดการลา</div>
                </div>

                <div class="col s12 m12 l12">
                    <div class="card">
                        <div class="card-content">
                            <span class="card-title">รายละเอียด</span>
                            <?php if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong> : <?php echo htmlentities($msg); ?> </div><?php } ?>
                            <table id="example" class="display responsive-table ">


                                <tbody>
                                    <?php
                                    $lid = intval($_GET['leaveid']);
                                    $sql = "SELECT
            tblleaves.id as lid,
            tblemployees.FirstName,
            tblemployees.LastName,
            tblemployees.EmpId,
            tblemployees.id,
            tblemployees.Gender,
            tblemployees.Phonenumber,
            tblemployees.EmailId,
            tblleaves.LeaveType,
            tblleaves.ToDate,
            tblleaves.FromDate,
            tblleaves.Description,
            tblleaves.FileName,
            tblleaves.PostingDate,
            tblleaves.AdminRemarkDate
        FROM
            tblleaves
        JOIN
            tblemployees ON tblleaves.empid = tblemployees.id
        WHERE
            tblleaves.id = :lid";

                                    $query = $dbh->prepare($sql);
                                    $query->bindParam(':lid', $lid, PDO::PARAM_STR);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt = 1;

                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $result) {
                                            $fileName = $result->FileName;
                                    ?>

                                            <tr>
                                                <td style="font-size:16px;"> <b>ชื่อพนักงาน :</b></td>
                                                <td>
                                                    <?php echo htmlentities($result->FirstName . " " . $result->LastName); ?></td>
                                                <td style="font-size:16px;"><b>รหัสพนักงาน :</b></td>
                                                <td><?php echo htmlentities($result->EmpId); ?></td>
                                                <td style="font-size:16px;"><b>เพศ :</b></td>
                                                <td><?php echo htmlentities($result->Gender); ?></td>
                                            </tr>

                                            <tr>
                                                <td style="font-size:16px;"><b>อีเมล :</b></td>
                                                <td><?php echo htmlentities($result->EmailId); ?></td>
                                                <td style="font-size:16px;"><b>เบอร์โทรศัพท์ :</b></td>
                                                <td><?php echo htmlentities($result->Phonenumber); ?></td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td style="font-size:25px; color: red;"><b>ลาวันที่ :</b></td>
                                                <td style="font-size:25px; color: red;">วันที่ <?php echo htmlentities($result->FromDate); ?> ถึง <?php echo htmlentities($result->ToDate); ?></td>
                                                <td style="font-size:25px; color: red;"><b>จำนวนวัน :</b></td>
                                                <td style="font-size:25px; color: red;">
                                                    <?php
                                                    $fromDate = new DateTime($result->FromDate);
                                                    $toDate = new DateTime($result->ToDate);

                                                    $days = 0;

                                                    // Iterate through each day
                                                    while ($fromDate <= $toDate) {
                                                        // Exclude weekends (Saturday and Sunday)
                                                        if ($fromDate->format('N') < 6) {
                                                            $days++;
                                                        }

                                                        // Move to the next day
                                                        $fromDate->add(new DateInterval('P1D'));
                                                    }

                                                    echo $days . ' วัน';
                                                    ?>
                                                </td>
                                                <td style="font-size:16px;"><b>โพสต์เมื่อ</b></td>
                                                <td><?php echo htmlentities($result->PostingDate); ?></td>
                                            </tr>

                                            <tr>
                                                <td style="font-size:16px;"><b>รายละเอียด : </b></td>
                                                <td colspan="5"><?php echo htmlentities($result->Description); ?></td>

                                            </tr>

                                            <tr>
                                                <td style="font-size:16px;"><b>Files :</b></td>
                                                <td>
                                                    <?php
                                                    $filePath = 'uploads/' . rawurlencode($fileName);

                                                    if (file_exists($filePath)) {
                                                        // File exists, proceed with displaying the link and PDF viewer
                                                    ?>
                                                        <a href="<?php echo $filePath; ?>" target="_blank"><?php echo $fileName; ?></a><br>

                                                        <!-- PDF viewer using <embed> -->
                                                        <!-- <embed src="<?php echo $filePath; ?>" type="application/pdf" width="100%" height="500"> -->

                                                    <?php
                                                    } else {
                                                        // File does not exist, handle this case (e.g., display an error message)
                                                        echo 'File not found: ' . $filePath;
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            </form>
                                            </tr>
                                    <?php $cnt++;
                                        }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        </div>
        <div class="left-sidebar-hover"></div>

        <!-- Javascripts -->
        <script src="assets/plugins/jquery/jquery-2.2.0.min.js"></script>
        <script src="assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
        <script src="assets/js/alpha.min.js"></script>
        <script src="assets/js/pages/table-data.js"></script>
        <script src="assets/js/pages/ui-modals.js"></script>
        <script src="assets/plugins/google-code-prettify/prettify.js"></script>

    </body>

    </html>
<?php } ?>