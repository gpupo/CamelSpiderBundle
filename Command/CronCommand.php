<?php

namespace Gpupo\CamelSpiderBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CronCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('camelSpider:cron')
            ->setDescription('Run updates for subscriptions');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $launcher = $this->getContainer()->get('camel_spider.launcher');
        $r = $launcher->checkUpdates();
        $output->writeln($r);
    }
}
