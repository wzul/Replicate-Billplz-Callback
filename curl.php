<?php

$data = array(
  'amount' => $_POST['amount'],
  'collection_id' =>  $_POST['collection_id'],
  'due_at' => $_POST['due_at'],
  'email' =>  $_POST['email'],
  'id' =>  $_POST['id'],
  'mobile' =>  $_POST['mobile'],
  'name' => $_POST['name'],
  'paid_amount' => $_POST['amount'],
  'paid_at' =>  $_POST['paid_at'],
  'paid' => $_POST['paid'],
  'state' =>  $_POST['state'],
  'url' => $_POST['url']
);

if ($data['paid'] === 'false') {
    $data['paid_amount'] = '0';
}

$signing = '';
foreach ($data as $key => $value) {
    $signing.= $key . $value;
    if ($key === 'url') {
        break;
    } else {
        $signing .= '|';
    }
}

$data['x_signature'] = hash_hmac('sha256', $signing, $_POST['x_signature']);

$process = curl_init($_POST['callback_url']);
curl_setopt($process, CURLOPT_HEADER, 1);
curl_setopt($process, CURLOPT_TIMEOUT, 10);
curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($process, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($process, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($process, CURLOPT_POSTFIELDS, http_build_query($data));
 
$return = curl_exec($process);
curl_close($process);
echo $_POST['callback_url'].'<br>';
echo 'CURL Done';
echo '<br>';
echo '<pre>'.print_r($return, true).'</pre>';
