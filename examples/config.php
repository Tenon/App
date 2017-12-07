<?php

return [
    'app_name'  => 'tenon_service',  //应用名
    'base_path' => dirname(__DIR__), //基础路径,
    // server config
    'server' => [
        'is_daemon' => false,  //is_daemon config or "-d" command params
        'server_type' => 'swoole',
        'runtime_path'  => '/data/app/runtime/tenon_service/',  //server运行时目录
        'server_config' => [
            'reactor_num' => 2,
            'work_num' => 4,
            'max_request' => 50000,
            'task_worker_num' => 2,
        ],
    ],
];