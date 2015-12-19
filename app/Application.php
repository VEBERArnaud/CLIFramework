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

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Application.
 */
class Application extends BaseApplication
{
    /**
     * name
     *
     * @const NAME
     */
    const NAME = 'CLIFramework';

    /**
     * version
     *
     * @const VERSION
     */
    const VERSION = '0.0.1-dev';

    /**
     * The kernel.
     *
     * @var \Symfony\Component\HttpKernel\KernelInterface $kernel
     */
    private $kernel;

    /**
     * The container.
     *
     * @var \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    private $container;

    /**
     * Construct the application.
     *
     * @param \Symfony\Component\HttpKernel\KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
        $this->container = $kernel->getContainer();

        parent::__construct(self::NAME, self::VERSION);

        if ($this->container->has('event_dispatcher')) {
            $this->setDispatcher($this->container->get('event_dispatcher'));
        }

        $this->getDefinition()->addOption(
            new InputOption('--env', '-e', InputOption::VALUE_REQUIRED, 'The Environment name.', 'dev')
        );
        $this->getDefinition()->addOption(
            new InputOption('--no-debug', null, InputOption::VALUE_NONE, 'Switches off debug mode.')
        );
    }

    /**
     * Get kernel.
     *
     * @return \Symfony\Component\HttpKernel\KernelInterface
     */
    public function getKernel()
    {
        return $this->kernel;
    }

    /**
     * Runs the current application.
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int
     */
    public function doRun(InputInterface $input, OutputInterface $output)
    {
        $this->registerCommands();

        return parent::doRun($input, $output);
    }

    /**
     * Register commands into the application
     *
     * @return void
     */
    protected function registerCommands()
    {
        if ($this->container->hasParameter('app.command.ids')) {
            foreach ($this->container->getParameter('app.command.ids') as $id) {
                $this->add($this->container->get($id));
            }
        }
    }
}
