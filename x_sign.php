<?php
$x_signature = 'gg';

$data = array();
foreach ($_POST as $key => $value) {
    if ($key === 'x_signature') {
        continue;
    }
    $data[] = $key.$value;
}
sort($data);
$string_data = implode('|', $data);

$hash = hash_hmac('sha256', $string_data, $x_signature);

if ($hash === $_POST['x_signature']) {
    echo 'You got a match';
}
