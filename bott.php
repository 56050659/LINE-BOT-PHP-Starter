<?php
$access_token = 'NJ2PLLuiyCI2LvtqdKoQRDAv4Sk+pqkE9ikF083lwSHySRlrJJBNIcGDIiKQXR3JkajNLYtgOXYd+qPvyrF0B9xclq8gNFAb4LEJzPMibkgp2kYZB76myGUoeLHZeeiewtoiOIbHXuVbbrLAt4cVcQdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
    // Loop through each event
    foreach ($events['events'] as $event) {
        // Reply only when message sent is in 'text' format
        if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
            // Get text sent
            $text = $event['message']['text'];

            // Get replyToken
            $replyToken = $event['replyToken'];

            //get from api
//            $data = file_get_contents("https://cocobyte.herokuapp.com/weather_data");
//            $dataDecode = json_decode($data, true);
//            //temp
//            $temp1 = $dataDecode['temp1'];
//            $temp2 = $dataDecode['temp2'];
//            $temp3 = $dataDecode['temp3'];
//            $temp4 = $dataDecode['temp4'];
//            $temp5 = $dataDecode['temp5'];
//
//            //date
//            $date1 = $dataDecode['date1'];
//            $date2 = $dataDecode['date2'];
//            $date3 = $dataDecode['date3'];
//            $date4 = $dataDecode['date4'];
//            $date5 = $dataDecode['date5'];

            $data = file_get_contents("https://cocobyte.herokuapp.com/que_data");
            $dataDecode = json_decode($data, true);
            //temp
            $temp1 = $dataDecode[0][1];
            $temp2 = $dataDecode[1][1];
            $temp3 = $dataDecode[2][1];
            $temp4 = $dataDecode[3][1];
            $temp5 = $dataDecode[4][1];

            //date
            $date1 = $dataDecode[0][2];
            $date2 = $dataDecode[1][2];
            $date3 = $dataDecode[2][2];
            $date4 = $dataDecode[3][2];
            $date5 = $dataDecode[4][2];

            $bufferMessage = [];

            $message1 = [
                'type' => 'text',
                'text' => 'สวัสดี'
            ];

            $message2 = [
                'type' => 'text',
                'text' => 'ว่างมากๆเลย'
            ];

            // $message3 = [
            //     'type' => 'image',
            //     'originalContentUrl' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Ash_Tree_-_geograph.org.uk_-_590710.jpg/220px-Ash_Tree_-_geograph.org.uk_-_590710.jpg',
            //     'previewImageUrl' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Ash_Tree_-_geograph.org.uk_-_590710.jpg/220px-Ash_Tree_-_geograph.org.uk_-_590710.jpg'
            // ];

            $message3 = [
                'type' => 'text',
                'text' =>   $date1 . ' : ' . $temp1 . ' องศาเซลเซียส' . "\r\n" .
                            $date2 . ' : ' . $temp2 . ' องศาเซลเซียส' . "\r\n" .
                            $date3 . ' : ' . $temp3 . ' องศาเซลเซียส' . "\r\n" .
                            $date4 . ' : ' . $temp4 . ' องศาเซลเซียส' . "\r\n" .
                            $date5 . ' : ' . $temp5 . ' องศาเซลเซียส' . "\r\n"
            ];


            if($event['message']['text'] == "สวัสดีจ้า"){
                $bufferMessage[0] = $message1;
            }

            if($event['message']['text'] == "ว่างไหม"){
                $bufferMessage[0] = $message2;
            }
            if($event['message']['text'] == "เหนื่อยไหม"){
                $bufferMessage[0] = $message3;
            }
//            if($event['message']['text'] == "ถ่ายรูปให้ดูหน่อย"){
//                $bufferMessage[0] = $message3;
//            }
//            if($event['message']['text'] == "ขอข้อมูลทั้งหมด"){
//                $bufferMessage[0] = $message1;
//                $bufferMessage[1] = $message2;
//                $bufferMessage[2] = $message3;
//            }

            // Make a POST Request to Messaging API to reply to sender
            $url = 'https://api.line.me/v2/bot/message/reply';
            $data = [
                'replyToken' => $replyToken,
                //'messages' => [$message1,$message2],
                'messages' => $bufferMessage,
            ];
            $post = json_encode($data);
            $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $result = curl_exec($ch);
            curl_close($ch);

            echo $result . "\r\n";
        }
    }
}
?>
