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

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

/**
 * Kernel.
 */
class Kernel extends BaseKernel
{
    /**
     * Construct the kernel.
     *
     * @param string $environment
     * @param boolean $debug
     *
     * @return void
     */
    public function __construct($environment, $debug)
    {
        parent::__construct($environment, $debug);

        // boot kernel
        $this->boot();
    }

    /**
     * Register bundles.
     *
     * @return array
     */
    public function registerBundles()
    {
        // register bundles for every environment
        $bundles = array(
            new \Symfony\Bundle\MonologBundle\MonologBundle(),
        );

        // register bundles for dev & test environment only
        if (in_array($this->getEnvironment(), array('dev', 'test'), true)) {
        }

        return $bundles;
    }

    /**
     * Builds the service container.
     *
     * @return \Symfony\Component\DependencyInjection\TaggedContainerInterface The compiled service container
     *
     * @throws \RuntimeException
     */
    protected function buildContainer()
    {
        $container = parent::buildContainer();
        $container->setParameter('app.command.ids', array_keys($container->findTaggedServiceIds('app.command')));

        return $container;
    }

    /**
     * Register container configuration.
     *
     * @param \Symfony\Component\Config\Loader\LoaderInterface $loader
     *
     * @return void
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(sprintf('%s/config/%s/config.yml', $this->getRootDir(), $this->getEnvironment()));
    }
}
