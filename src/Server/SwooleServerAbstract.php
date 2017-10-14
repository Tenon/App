<?php
namespace Tenon\Server;

use Tenon\Contracts\Server\ServerContract;
use Closure;
use Tenon\Support\Output;


abstract class SwooleServerAbstract implements ServerContract
{
    protected $pid;
    protected $pidFile = '/tmp/pid';

    protected $port;

    protected $beforeCb = null;

    protected $settings;

    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    public function setBeforeRunCallback(Closure $callback)
    {
        $this->beforeCb = $callback;
    }

    /**
     * save pid into file
     */
    protected function flushPid($pid)
    {
        $this->pid = $pid;
        $writeFlag = file_put_contents($this->pidFile, $this->pid);
        if (!$writeFlag) {
            Output::error(['Server.flushPid' => 'write pid file fail', 'pidFile' => $this->pidFile]);
        } else {
            Output::debug(['Server.flushPid' => 'write pid file success', 'pidFile' => $this->pidFile]);
        }
    }

    public function beforeRun()
    {
        if ($this->beforeCb && $this->beforeCb instanceof Closure) {
            Output::debug(['Server.beforeRun' => 'do beforeCb']);
            $this->beforeCb();
        }
    }

    /**
     * init
     * @return array
     */
    abstract public function init();

    abstract public function run();
}