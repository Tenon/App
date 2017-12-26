<?php

/**
 * 服务模式配置
 */
return [
    'ip' => '0.0.0.0',
    'port' => '20000',
    'server_type' => 'swoole',
    'server_config' => [
        'reactor_num' => 2,
        'worker_num' => 4,
        'max_request' => 50000,
        'task_worker_num' => 2,
    ],
];