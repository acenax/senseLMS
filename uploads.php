<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['emplogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['apply'])) {
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
            // File Upload
            $targetDir = "uploads/";  // specify your upload directory
            $fileName = basename($_FILES["fileToUpload"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            // Allow certain file formats
            $allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png');

            if (in_array($fileType, $allowTypes)) {
                // Upload file to the server
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFilePath)) {
                    // Insert file information into the database
                    $sql = "INSERT INTO tblleaves(LeaveType, ToDate, FromDate, Description, Status, IsRead, empid, FileName, FilePath) 
                            VALUES(:leavetype, :todate, :fromdate, :description, :status, :isread, :empid, :fileName, :targetFilePath)";
                    $query = $dbh->prepare($sql);
                    $query->bindParam(':leavetype', $leavetype, PDO::PARAM_STR);
                    $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
                    $query->bindParam(':todate', $todate, PDO::PARAM_STR);
                    $query->bindParam(':description', $description, PDO::PARAM_STR);
                    $query->bindParam(':status', $status, PDO::PARAM_STR);
                    $query->bindParam(':isread', $isread, PDO::PARAM_STR);
                    $query->bindParam(':empid', $empid, PDO::PARAM_STR);
                    $query->bindParam(':fileName', $fileName, PDO::PARAM_STR);
                    $query->bindParam(':targetFilePath', $targetFilePath, PDO::PARAM_STR);
                    $query->execute();

                    $msg = "Leave applied successfully";
                } else {
                    $error = "File upload failed, please try again.";
                }
            } else {
                $error = "Sorry, only PDF, DOC, DOCX, JPG, JPEG, PNG files are allowed.";
            }
        }
    }
}
?>
