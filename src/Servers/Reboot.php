<?php

namespace Sven\ForgeCLI\Servers;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Reboot extends Command
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('reboot:server')
            ->setDescription('Reboot one of your servers.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        //
    }
}
