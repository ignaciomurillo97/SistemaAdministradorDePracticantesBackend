<?php

function getInstanceFromDB($class) {
    $instance = $class::inRandomOrder()->first() ?? factory($class)->create();
    return $instance;
}

function existsInDB ($class, $id) {
    $instance = $class::find($id);
    return isset($instance);
}
