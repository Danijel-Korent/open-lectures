<?php
require_once __DIR__ . '/config.php';
require_once REPO_PATH;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed',
    ]);
    exit;
}

$rawBody = file_get_contents('php://input');
$payload = json_decode($rawBody, true);
if (!is_array($payload)) {
    $payload = $_POST;
}

$courseId = isset($payload['course_id']) ? (int)$payload['course_id'] : 0;
if ($courseId <= 0) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid course identifier',
    ]);
    exit;
}

$viewCount = incrementCourseViews($courseId);

if ($viewCount === false) {
    http_response_code(404);
    echo json_encode([
        'success' => false,
        'message' => 'Course not found',
    ]);
    exit;
}

echo json_encode([
    'success' => true,
    'count' => $viewCount,
]);

