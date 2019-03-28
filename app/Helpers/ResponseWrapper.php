<?php

if (!function_exists('makeResponseObject')) {
    function makeResponseObject($data, $error) {
        return ['data' => $data, 'error' => $error];
    }
};

if (!function_exists('mimeTypeToExtnesion()')) {
    function mimeTypeToExtension($mimeType){
        $extensions = ['image/jpeg' => 'jpg',
                        'image/png' => 'png'];
        return $extensions[$mimeType];
    }
}

if (!function_exists('saveBase64ImageToDisk')) {
    /**
     * Save base 64 image to disk with timestamp name
     * 
     * @param string image
     * @return string path
     */
    function saveBase64ImageToDisk ($image) {
        $photo = base64_decode($image);
        $f = finfo_open();
        $mimeType = finfo_buffer($f, $photo, FILEINFO_MIME_TYPE);
        $name = time().'.'.mimeTypeToExtension($mimeType);
        $pathFromServerRoot = DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.$name;

        $file = fopen(public_path().$pathFromServerRoot, 'w');
        fwrite($file, $photo);
        fclose($file);
        return $pathFromServerRoot;
    }
}
