<?php
session_start();
require_once '../classes/feecreationrequest.class.php';
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/debug.log');
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $feeId = $_POST['feeId'];
    $feeName = $_POST['feeName'];
    $amount = $_POST['amount'];
    $dueDate = $_POST['dueDate'];
    $description = $_POST['description'];
    $organizationId = $_POST['organization'];
    
    $feeRequest = new FeeCreationRequest();
    $staffId = $_SESSION['staffID']; // Assuming staffID is stored in session

    $currentPeriod = $feeRequest->getCurrentAcademicPeriod();
    $schoolYear = $currentPeriod['school_year'];
    $semester = $currentPeriod['semester'];

    // Log the data being processed
    error_log("Processing Fee Request: FeeName=$feeName, Amount=$amount, OrganizationID=$organizationId, CreatedBy=$staffId");

    $result = $feeRequest->createFeeRequest($feeName, $amount, $organizationId, $staffId, $dueDate, $description, $schoolYear, $semester);

    if ($result) {
        header("Location: staff_fees.php?success=1");
        exit();
    } else {
        header("Location: staff_fees.php?error=1");
        exit();
    }
}
?>