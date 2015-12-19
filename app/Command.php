<?php

/**
 * This file is part of the CLIFramework package.
 *
 * (c) Arnaud VEBER <arnaud@veber.pw>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CLIFramework;

use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 *
 */
abstract class Command extends BaseCommand
{
    /**
     * configure
     *
     * @return void
     */
    public function configure()
    {
        $this->setName($this->getCommandName());
        $this->setDescription($this->getCommandDescription());
    }

    /**
     * Get command name
     *
     * @return string
     */
    abstract protected function getCommandName();

    /**
     * Get command description
     *
     * @return string
     */
    abstract protected function getCommandDescription();

    /**
     * Get kernel.
     *
     * @return \Symfony\Component\HttpKernel\KernelInterface
     *
     * @throws \RuntimeException
     */
    protected function getKernel()
    {
        $application = $this->getApplication();
        if (!$application instanceof \CLIFramework\Application) {
            throw new \RuntimeException('Application should be an instance of \CLIFramework\Application');
        }
        return $application->getKernel();
    }

    /**
     * Get Container.
     *
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     *
     * @throws \RuntimeException
     */
    protected function getContainer()
    {
        return $this->getKernel()->getContainer();
    }
}
