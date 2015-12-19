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

class CommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * command mock
     *
     * @var \CLIFramework\Command
     */
    private $command = null;

    /**
     * set up
     */
    public function setUp()
    {
        // mock command
        $this->command = $this->getMockBuilder('\CLIFramework\Command')
            ->disableOriginalConstructor()
            ->setMethods(array('getCommandName', 'getCommandDescription'))
            ->getMock();
    }

    /**
     * tear down
     */
    public function tearDown()
    {
        $this->command = null;
    }

    /**
     * test configure
     */
    public function testConfigure()
    {
        // name & description
        $name = 'test:command';
        $description = 'The test command';

        // stub getCommandName
        $this->command->expects($this->once())
            ->method('getCommandName')
            ->will($this->returnValue($name));

        // stub getCommandDescription
        $this->command->expects($this->once())
            ->method('getCommandDescription')
            ->will($this->returnValue($description));

        // configure
        $this->command->configure();

        // asert
        $this->assertEquals($name, $this->command->getName());
        $this->assertEquals($description, $this->command->getDescription());
    }
}
