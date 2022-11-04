<?php
$appKey = is_null(env('API_KEY')) ? 'f642e3f48b8ac01323b9fa1726d1924a' : env('API_KEY');
$secretKey = is_null(env('API_SECRET_KEY')) ? '1a1d84cd2f5a0b304e62a299b8c8c218' : env('API_SECRET_KEY');
$bearer = base64_encode($appKey . ":" . md5($secretKey . time()));
return [
    'bearer' => $bearer,
    'redirect_url' => "http://127.0.0.1:8000/api/get-status"
];
