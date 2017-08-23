<?php
    /**
     * Created by PhpStorm.
     * User: Buwaneka.Kalansuriya
     * Date: 8/21/2017
     * Time: 1:06 PM
     */
    return [

            /*
    |--------------------------------------------------------------------------
    |Table Name
    |--------------------------------------------------------------------------
    |
    | Table name of the route log
    |
    |
    |
    */
        'table_name' => 'trn_route_log',


            /*
    |--------------------------------------------------------------------------
    |Time Zone
    |--------------------------------------------------------------------------
    |
    | Set the timezone to be saved at the route log
    |
    |
    |
    */
        'timezone' => 'Asia/Colombo',

    /*
   |--------------------------------------------------------------------------
   |Available Columns
   |--------------------------------------------------------------------------
   |
   | Identify the required columns and set them as true, else false
   |
   |
   |
   */
        'columns'  => [
            'ip'     => true,
            'url'    => true,
            'method' => true,
            'agent'  => true,
            'query'  => true,
        ]

    ];