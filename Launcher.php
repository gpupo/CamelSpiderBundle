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

    

}
 
