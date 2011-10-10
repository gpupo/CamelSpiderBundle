<?php

namespace Gpupo\CamelSpiderBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CacheCleanCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('camelSpider:cache:clean')
            ->setDescription('Clean All Cache');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
	
	    $cache = $this->getContainer()->get('camel_spider.cache');
	    $cache->clean();
		
        $output->writeln('Cache clean done');
    }
}
