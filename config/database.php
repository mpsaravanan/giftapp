
<?php
return [
    /*
    |--------------------------------------------------------------------------
    | PDO Fetch Style
    |--------------------------------------------------------------------------
    |
    | By default, database results will be returned as instances of the PHP
    | stdClass object; however, you may desire to retrieve records in an
    | array format for simplicity. Here you can tweak the fetch style.
    |
    */
    
    'fetch' => PDO::FETCH_CLASS,

    'default' => 'mysql_master',
    
    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */
    'connections' => [
        # Our primary database connection
        'mysql_master' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST'),
            'database'  => env('DB_DATABASE'),
            'username'  => env('DB_USERNAME'),
            'password'  => env('DB_PASSWORD'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
                ],
        # Our primary database connection
        'mysql_slave' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST_SLAVE'),
            'database'  => env('DB_DATABASE_SLAVE'),
            'username'  => env('DB_USERNAME_SLAVE'),
            'password'  => env('DB_PASSWORD_SLAVE'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
                ],
        ],
        'migrations' => 'migrations'
];
