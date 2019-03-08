<?php

if (!function_exists('makeResponseObject')) {
    function makeResponseObject($data, $error) {
        return ['data' => $data, 'error' => $error];
    }
};