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

        if (!is_dir($cache_dir)) {
            $this->logger('Creating the directory [' . $cache_dir . ']');
            if (false === @mkdir($cache_dir, 0777, true)) {
                throw new \RuntimeException(sprintf('Unable to create the %s directory', $dir));
            }
        } elseif (!is_writable($cache_dir)) {
            throw new \RuntimeException(sprintf('Unable to write in the %s directory', $dir));
        }

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
