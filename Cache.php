<?php

namespace Gpupo\CamelSpiderBundle;

use CamelSpider\Spider\AbstractCache,
    Zend\Cache\Cache as Zend_Cache;

class Cache extends AbstractCache
{
   
    public function __construct($cache_dir, $lifetime_days, $logger)
    {
        $this->cache_dir = $cache_dir;
        $this->logger = $logger;
        $this->checkDir();

        $frontend= array(
            'lifetime' => ((60*60) * $lifetime_days ),
            'automatic_serialization' => true
        );

        $backend= array(
            'cache_dir' => $cache_dir,
        );

        $this->cache = Zend_Cache::factory(
            'core',
            'File',
            $frontend,
            $backend
        );
    }

}
