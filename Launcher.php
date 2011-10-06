<?php
namespace Gpupo\CamelSpiderBundle;

class Launcher 
{
    protected $processor; 
    
    public function __construct(SpiderProcessor $processor)
    {
        $this->processor = $processor;
    }

    

}
 
