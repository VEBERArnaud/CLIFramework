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

/**
 *
 */
abstract class Command extends BaseCommand
{
    /**
     * Get kernel.
     *
     * @return \Symfony\Component\HttpKernel\KernelInterface
     *
     * @throws \RuntimeException
     *
     * @codeCoverageIgnore
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
     * @codeCoverageIgnore
     */
    protected function getContainer()
    {
        return $this->getKernel()->getContainer();
    }
}
