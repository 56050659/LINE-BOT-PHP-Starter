<?php
$access_token = 'XLDiuTnLS0D0Hn5Vbn1MB/eUC0B4giKw5TGg2r4UkD7Hu2GlZFAL0gZHZwRByV0f8NzEdy+nRFGI21DCjApq6Crf5wtjsO348xcBKr7r4NwkiG6p3qb1sXxYNtd9LDxlfYZOvb7erhOmgi3zOPcTJQdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;