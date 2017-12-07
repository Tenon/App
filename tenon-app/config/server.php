<?php

/**
 * 服务模式配置
 */
return [
    'ip' => '0.0.0.0',
    'port' => '20000',
    'is_daemon' => false,  //is_daemon config or "-d" command params
    'server_type' => 'swoole',
    'runtime_path'  => '/data/app/runtime/tenon_service/',  //server运行时目录
    'server_config' => [
        'reactor_num' => 2,
        'work_num' => 4,
        'max_request' => 50000,
        'task_worker_num' => 2,
    ],
];