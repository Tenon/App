<?php

// local config

return [
    'app_name' => 'tenon_service',
    // server config
    'server' => [
        'server_type' => 'tcp',
        'swoole_config' => [
            'reactor_num' => 4,
            'work_num' => 16,
            'max_request' => 50000,
            'task_worker_num' => 2,
        ],
    ],
    // zk
    'zk' => [
        //Todo: zk config here.
    ],
    // rpc service
    'rpc' => [
        'service_name' => [
            //Todo: rpc depend service config here
        ]
    ],
    // db pool
    'db' => [
        'pdo' => [
            //Todo:
        ],
    ],
    // redis
    // other...
];