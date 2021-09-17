<?php


class errorController 
{
    function __construct(){}
    
    function index()
    {
        $data = ['titulo' => '404 Not Found'];
        View::render('404', $data);
    }
}