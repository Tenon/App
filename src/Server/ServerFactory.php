<?php
namespace Tenon\Server;

use Tenon\Contracts\Server\ServerContract;


class ServerFactory
{
    private $_servers = [];

    /**
     * @param array $settings
     * @return ServerContract
     */
    public function make(array $settings): ServerContract
    {
        if (!isset($settings['server_type'])) {
            die('server_type not exist in config.');
        }
        $server = __NAMESPACE__ . "\\" . ucwords($settings['server_type']);
        if (!isset($this->_servers[$settings['server_type']]) && !class_exists($server)) {
            die("server: {$server} not exist.");
        }
        $this->_servers[$settings['server_type']] = new $server($settings);

        return $this->_servers[$settings['server_type']];
    }
}