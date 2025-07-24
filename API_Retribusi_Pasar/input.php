<?php
    $content    = file_get_contents("php://input");
    $content    = mb_convert_encoding($content, 'UTF-8');
    $data       = json_decode($content,TRUE);