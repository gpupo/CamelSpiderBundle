<?php
namespace Gpupo\CamelSpiderBundle;
use CamelSpider\Spider\SpiderProcessor,
CamelSpider\Entity\Link;
class Launcher 
{
    protected $processor; 
    
    public function __construct(SpiderProcessor $processor)
    {
        $this->processor = $processor;
    }

    public function checkUpdates()
	{
		$link = new Link;
		$link->set('id', 1);
		$link->set('href', 'http://www.terra.com.br/');
		$link->set('domain', 'www.terra.com.br');
		$link->set('recursive', 1);
        
        $r = $this->processor->checkUpdates($link);
		
		return $r;
	}

		

}
 
