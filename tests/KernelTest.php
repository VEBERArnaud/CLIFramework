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

use CLIFramework\Kernel;

class KernelTest extends \PHPUnit_Framework_TestCase
{
    /**
     * test construct.
     *
     * @param string $environment
     * @param bool $debug
     *
     * @dataProvider constructProvider
     */
    public function testConstruct($environment, $debug)
    {
        // create kernel
        $kernel = new Kernel($environment, $debug);

        // assert
        $this->assertInstanceOf('\CLIFramework\Kernel', $kernel);
        $this->assertEquals($environment, $kernel->getEnvironment());
        $this->assertEquals($debug, $kernel->isDebug());
    }

    /**
     * test register bundles
     */
    public function testRegisterBundles()
    {
        // create kernel
        $kernel = new Kernel('test', true);

        // register bundles
        $bundles = $kernel->registerBundles();

        // assert
        $this->assertInstanceOf('\Symfony\Bundle\MonologBundle\MonologBundle', $bundles[0]);
    }

    /**
     * construct provider.
     *
     * @return array
     */
    public function constructProvider()
    {
        return array(
            array('test', true),
            array('test', false),
            array('dev', true),
            array('dev', false),
            array('prod', true),
            array('prod', false),
        );
    }
}
