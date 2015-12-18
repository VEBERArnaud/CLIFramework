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
class Command extends BaseCommand
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
     * Get kernel.
     *
     * @return \Symfony\Component\HttpKernel\KernelInterface
     */
    protected function getKernel()
    {
        return $this->getApplication()->getKernel();
    }

    /**
     * Get Container.
     *
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected function getContainer()
    {
        return $this->getApplication()->getKernel()->getContainer();
    }
}
