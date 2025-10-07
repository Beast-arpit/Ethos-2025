<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if ($data && isset($data['enrollment_no'], $data['email'], $data['status'])) {
    $enrollment_no = $data['enrollment_no'];
    $email = $data['email'];
    $status = $data['status'];
    $latitude = $data['latitude'] ?? '';
    $longitude = $data['longitude'] ?? '';
    $timestamp = date('Y-m-d H:i:s');

    $file = __DIR__ . '/student_status.csv';
    $file_exists = file_exists($file);

    $fp = fopen($file, 'a');
    if (!$fp) {
        echo json_encode(['success'=>false,'message'=>'Cannot open file']);
        exit;
    }

    if (!$file_exists) {
        fputcsv($fp, ['Enrollment No','Email','Status','Latitude','Longitude','Timestamp']);
    }

    fputcsv($fp, [$enrollment_no,$email,$status,$latitude,$longitude,$timestamp]);
    fclose($fp);

    echo json_encode(['success'=>true,'message'=>"Status saved for $email"]);

} else {
    echo json_encode(['success'=>false,'message'=>'Invalid data received']);
}
