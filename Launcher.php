<?php
namespace Gpupo\CamelSpiderBundle;
use CamelSpider\Spider\SpiderProcessor;
class Launcher 
{
    protected $processor; 
    
    public function __construct(SpiderProcessor $processor)
    {
        $this->processor = $processor;
    }

    public function checkUpdates()
	{
		$r = $this->processor->checkUpdates('http://www.terra.com.br/portal/');
		
		return $r;
	}

		

}
 
