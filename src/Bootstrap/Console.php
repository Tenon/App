<?php
namespace Tenon\Bootstrap;

use Tenon\Contracts\Bootstrap\BootstrapContract;
use Tenon\Contracts\Application\ContainerContract;


final class Console implements BootstrapContract
{

    /**
     * @var ContainerContract
     */
    private $app;

    public function __construct(ContainerContract $app)
    {
        $this->app = $app;
    }

    public function run()
    {
        // TODO: Implement run() method.
    }

}