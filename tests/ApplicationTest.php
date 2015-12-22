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

use CLIFramework\Application;
use CLIFramework\Kernel;
use CLIFramework\Command;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Definition;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * kernel.
     *
     * @var \CLIFramework\Kernel
     */
    private $kernel = null;

    /**
     * set up
     */
    public function setUp()
    {
        $this->kernel = new Kernel('dev', true);
    }

    /**
     * tear down
     */
    public function tearDown()
    {
        $this->kernel = null;
    }

    /**
     * test construct
     */
    public function testConstruct()
    {
        // create application
        $application = new Application($this->kernel);

        // get definition
        $definition = $application->getDefinition();

        // get options
        $options = $definition->getOptions();

        // assert
        $this->assertTrue(in_array('env', array_keys($options)));
        $this->assertTrue(in_array('no-debug', array_keys($options)));
    }

    /**
     * test get kernel.
     */
    public function testGetKernel()
    {
        // create application
        $application = new Application($this->kernel);

        // assert
        $this->assertEquals($this->kernel, $application->getKernel());
    }

    /**
     * test do run
     */
    public function testDoRun()
    {
        // create application
        $application = new Application($this->kernel);

        // create input & output
        $input = new \Symfony\Component\Console\Input\ArrayInput(array('command' => 'list'));
        $output = new \Symfony\Component\Console\Output\BufferedOutput();

        // run command
        $code = $application->doRun($input, $output);

        // assert
        $this->assertEquals(0, $code);
    }

    /**
     * test register commands
     */
    public function testRegisterCommands()
    {
        // create container
        $container = new Container();

        // create service
        $container->set('test.command', new Command('test:command'));

        // set service id as parameter
        $container->setParameter('app.command.ids', array('test.command'));

        // changer kernel container
        $reflectionClass = new \ReflectionClass($this->kernel);
        $reflectionProperty = $reflectionClass->getProperty('container');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($this->kernel, $container);

        // create application
        $application = new Application($this->kernel);

        // create input & output
        $input = new \Symfony\Component\Console\Input\ArrayInput(array('command' => 'list'));
        $output = new \Symfony\Component\Console\Output\BufferedOutput();

        // run command
        $code = $application->doRun($input, $output);

        // assert
        $this->assertEquals(0, $code);
    }
}
