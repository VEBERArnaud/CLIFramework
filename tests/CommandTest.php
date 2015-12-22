<?php

/**
 * This file is part of the CLIFramework package.
 *
 * (c) Arnaud VEBER <arnaud@veber.pw>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests;

use CLIFramework\Command;
use Symfony\Component\DependencyInjection\Container;

class CommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * command
     *
     * @var \CLIFramework\Command
     */
    private $command = null;

    /**
     * set up
     */
    protected function setUp()
    {
        // Create command
        $this->command = new Command('cli:test:command');
    }

    /**
     * tear down
     */
    protected function tearDown()
    {
        $this->command = null;
    }

    /**
     * test configure
     */
    public function testSetContainer()
    {
        // set container
        $container = new Container();
        $this->command->setContainer($container);

        // change getContainer accessibility for test
        $reflectionClass = new \ReflectionClass($this->command);
        $reflectionProperty = $reflectionClass->getProperty('container');
        $reflectionProperty->setAccessible(true);

        // assert
        $this->assertEquals($container, $reflectionProperty->getValue($this->command));
    }

    /**
     * test configure
     */
    public function testGetContainer()
    {
        // set container
        $container = new Container();
        $this->command->setContainer($container);

        // Reflection Class Command
        $reflectionClass = new \ReflectionClass($this->command);

        // change getContainer accessibility for test
        $reflectionProperty = $reflectionClass->getProperty('container');
        $reflectionProperty->setAccessible(true);

        // change getContainer accessibility for test
        $reflectionMethod = $reflectionClass->getMethod('getContainer');
        $reflectionMethod->setAccessible(true);

        // set container property
        $reflectionProperty->setValue($this->command, $container);

        // assert
        $this->assertEquals($container, $reflectionMethod->invoke($this->command));
    }
}
