<?php
namespace Tenon\Service;

use Tenon\Contracts\Application\ContainerContract;
use Tenon\Contracts\Component\ComponentContract;


abstract class BaseComponent implements ComponentContract
{
    /**
     * @var ContainerContract
     */
    private $app;

    public function __construct(ContainerContract $app)
    {
        $this->app = $app;
    }
}