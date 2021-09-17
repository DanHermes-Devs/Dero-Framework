<?php

// Funcion de prueba
function to_object($array)
{
    return json_decode(json_encode($array));
}

function get_site_name()
{
    return 'Dero Framework';
}

function nowDate()
{
    return date('Y-m-d H:i:s');
}