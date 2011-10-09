<?php

namespace Gpupo\CamelSpiderBundle;
use Zend\Cache\Cache as Zend_Cache;
class Cache
{
    protected $logger;
    public $cache;
    
    protected function logger($string, $type = 'info')
	{
		return $this->logger->$type('#CamelSpiderCache ' . $string);
    }


    public function __construct($cache_dir, $logger)
    {
    
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
        'lifetime' => 7200,
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

    public function save($id, $data)
    {
        return $this->cache->save($data, $id);
    }

    public function getObject($id)
    {
        return $this->cache->load($id);
    }

}
