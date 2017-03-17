<?php
$access_token = 'XLDiuTnLS0D0Hn5Vbn1MB/eUC0B4giKw5TGg2r4UkD7Hu2GlZFAL0gZHZwRByV0f8NzEdy+nRFGI21DCjApq6Crf5wtjsO348xcBKr7r4NwkiG6p3qb1sXxYNtd9LDxlfYZOvb7erhOmgi3zOPcTJQdB04t89/1O/w1cDnyilFU=';

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



            $data = file_get_contents("https://cocobit.herokuapp.com/getapi");
            $dataDecode = json_decode($data, true);
			
			$data2 = file_get_contents("https://cocobit.herokuapp.com/getpicrpi");
            $dataDecode2 = json_decode($data2, true);
			
			
			
			$img = $dataDecode2[0];
                        

			//date
			$date1 = $dataDecode[0][0];
			
						
			//temp
			$temp1 = $dataDecode[0][1];
           								
                      
            //weather
            $weather1 = $dataDecode[0][3];
            

            //Air pressure
            $pressure1 = $dataDecode[0][4];
			
			//humidity
            $humidity = $dataDecode[0][2];
			
			//humidityd
            $humidityd = $dataDecode[0][7];
			
			
            
						

            $bufferMessage = [];

            $message1 = [
                'type' => 'text',
                'text' => 'สวัสดี'
            ];

            $message2 = [
                'type' => 'text',
                'text' => 'ตรวจงานอยู่'
            ];

            
            $message3 = [
                'type' => 'text',
                'text' =>   "Date " . $date1 . "\r\n" .
							"อุณหภูมิ : " . $temp1 . "Celcius" . "\r\n" .
							"สภาพอากาศ : " . $weather1 . "\r\n" .
                            "ความกดอากาศ: " . $pressure1 . " pha" . "\r\n" .
							"ความชื้นของอากาศ : " . $humidity . " %" . "\r\n" .
							"ความชื้นในดิน : " . $humidityd . "\r\n"
							
			];
			$picture = [
				'type' => 'image',
				'originalContentUrl' => $img,
				'previewImageUrl' => $img
			];


            if($event['message']['text'] == "hello"){
                $bufferMessage[0] = $message1;
            }

            if($event['message']['text'] == "ว่างไหม"){
                $bufferMessage[0] = $message2;
            }
            if($event['message']['text'] == "อากาศ"){
                $bufferMessage[0] = $message3;
				$bufferMessage[1] = $picture;
            }
			


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
