<?php
session_start();
include('includes/config.php');
error_reporting(0);
if (strlen($_SESSION['emplogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['apply'])) {
        // รับค่าจากฟอร์ม
        $empid = $_SESSION['eid'];
        $leavetype = $_POST['leavetype'];
        $fromdate = $_POST['fromdate'];
        $todate = $_POST['todate'];
        $description = $_POST['description'];
        $status = 0;
        $isread = 0;

        if ($fromdate > $todate) {
            $error = " ToDate should be greater than FromDate ";
        } else {
            // ตรวจสอบว่ามีการแนบไฟล์หรือไม่
            if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == UPLOAD_ERR_OK) {
                // ทำการอัปโหลดไฟล์
                $targetDir = "uploads/";
                $randomFileName = mt_rand(100000, 999999);
                $fileName = $randomFileName . "_" . basename($_FILES["fileToUpload"]["name"]);
                $targetFilePath = $targetDir . $fileName;
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

                $allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png');

                if (in_array($fileType, $allowTypes)) {
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFilePath)) {
                        // บันทึกข้อมูลการลาลงในฐานข้อมูล
                        $sql = "INSERT INTO tblleaves(LeaveType, ToDate, FromDate, Description, FileName, PostingDate, Status, IsRead, empid) 
                            VALUES(:leavetype, :todate, :fromdate, :description, :fileName, CURRENT_TIMESTAMP, :status, :isread, :empid)";
                        $query = $dbh->prepare($sql);
                        $query->bindParam(':leavetype', $leavetype, PDO::PARAM_STR);
                        $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
                        $query->bindParam(':todate', $todate, PDO::PARAM_STR);
                        $query->bindParam(':description', $description, PDO::PARAM_STR);
                        $query->bindParam(':fileName', $fileName, PDO::PARAM_STR);
                        $query->bindParam(':status', $status, PDO::PARAM_INT);
                        $query->bindParam(':isread', $isread, PDO::PARAM_INT);
                        $query->bindParam(':empid', $empid, PDO::PARAM_INT);
                        $query->execute();

                        $msg = "ลาของคุณได้รับการยื่นเรียบร้อยแล้ว";
                    } else {
                        $error = "การอัปโหลดไฟล์ล้มเหลว กรุณาลองใหม่";
                    }
                } else {
                    $error = "ขออภัย เฉพาะไฟล์ PDF, DOC, DOCX, JPG, JPEG, PNG เท่านั้นที่ได้รับอนุญาต.";
                }
            } else {
                // ถ้าไม่มีการแนบไฟล์ ก็ทำการบันทึกข้อมูลการลาเพียงอย่างเดียว
                $sql = "INSERT INTO tblleaves(LeaveType, ToDate, FromDate, Description, PostingDate, Status, IsRead, empid) 
                    VALUES(:leavetype, :todate, :fromdate, :description, CURRENT_TIMESTAMP, :status, :isread, :empid)";
                $query = $dbh->prepare($sql);
                $query->bindParam(':leavetype', $leavetype, PDO::PARAM_STR);
                $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
                $query->bindParam(':todate', $todate, PDO::PARAM_STR);
                $query->bindParam(':description', $description, PDO::PARAM_STR);
                $query->bindParam(':status', $status, PDO::PARAM_INT);
                $query->bindParam(':isread', $isread, PDO::PARAM_INT);
                $query->bindParam(':empid', $empid, PDO::PARAM_INT);
                $query->execute();

                $msg = "ลาของคุณได้รับการยื่นเรียบร้อยแล้ว";
            }
        }
    }
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <!-- Title -->
        <title>Employe | Apply Leave</title>
        <!-- Meta Tags -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta charset="UTF-8">
        <meta name="description" content="Responsive Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="Steelcoders" />
        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="assets/plugins/materialize/css/materialize.min.css" />
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet">
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
                    <div class="page-title">ใบลา</div>
                </div>
                <div class="col s12 m12 l8">
                    <div class="card">
                        <div class="card-content">
                            <form id="example-form" method="post" name="addemp" enctype="multipart/form-data">
                                <div>
                                    <h3>ใบลา</h3>
                                    <section>
                                        <div class="wizard-content">
                                            <div class="row">
                                                <div class="col m12">
                                                    <div class="row">
                                                        <?php if ($error) { ?><div class="errorWrap"><strong>ERROR </strong>:<?php echo htmlentities($error); ?> </div><?php } else if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php } ?>

                                                        <div class="input-field col s12">
                                                            <select name="leavetype" autocomplete="off">
                                                                <option value="">เลือกประเภทการลา...</option>
                                                                <?php
                                                                $sql = "SELECT LeaveType FROM tblleavetype";
                                                                $query = $dbh->prepare($sql);
                                                                $query->execute();
                                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                                if ($query->rowCount() > 0) {
                                                                    foreach ($results as $result) {
                                                                ?>
                                                                        <option value="<?php echo htmlentities($result->LeaveType); ?>"><?php echo htmlentities($result->LeaveType); ?></option>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="input-field col m6 s12">
                                                            <p>วันที่</p>
                                                            <input placeholder="" id="mask1" name="fromdate" class="masked" type="date" data-inputmask="'alias': 'date'" required>
                                                        </div>
                                                        <div class="input-field col m6 s12">
                                                            <p>ถึงวันที่</p>
                                                            <input placeholder="" id="mask1" name="todate" class="masked" type="date" data-inputmask="'alias': 'date'" required>
                                                        </div>
                                                        <div class="input-field col m12 s12">
                                                            <label for="birthdate">รายละเอียด</label>
                                                            <textarea id="textarea1" name="description" class="materialize-textarea" length="500" required></textarea>
                                                        </div>
                                                        <!-- File Upload -->
                                                        <div class="file-field input-field col m12 s12">
                                                            <div class="btn">
                                                                <span>ไฟล์</span>
                                                                <input type="file" name="fileToUpload" id="fileToUpload">
                                                            </div>
                                                            <div class="file-path-wrapper">
                                                                <input class="file-path validate" type="text">
                                                            </div>
                                                        </div>

                                                        <!-- Submit Button -->
                                                        <div class="input-field col m12 s12">
                                                            <button type="submit" name="apply" id="apply" class="waves-effect waves-light btn indigo m-b-xs">ส่ง</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </form>
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
        <script src="assets/js/alpha.min.js"></script>
        <script src="assets/js/pages/form_elements.js"></script>
        <script src="assets/js/pages/form-input-mask.js"></script>
        <script src="assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>
    </body>

    </html>
<?php } ?>