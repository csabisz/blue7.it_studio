<?php

$tasks_encoded = json_encode(file_get_contents('./test.json'),true);
$tasks = json_decode($tasks_encoded,true);


