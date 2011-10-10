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
		$link->set('href', 'http://economia.estadao.com.br');
        $link->set('domain', 'economia.estadao.com.br');
        $link->set('filters', array('contain' => 'tecnologia', 'notContain' => 'agrícola'));
		$link->set('recursive', 1);
        
        $r = $this->processor->checkUpdates($link);
		
		return $r;
	}

		

}
 
