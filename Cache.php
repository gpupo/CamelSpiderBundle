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


    public function __construct($cache_dir, $lifetime_days, $logger)
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

    public function clean($mode = Zend_Cache::CLEANING_MODE_ALL)
    {
        return $this->cache->clean($mode);
    }

    public function save($id, $data, array $tags = array('undefined'))
    {
        if(empty($id)){
            $this->logger('Object id Empty!', 'err');
            return false;
        }
        $this->logger('Saving object ['. $id .']');
        return $this->cache->save($data, $id, $tags);
    }

    public function getObject($id)
    {
        $this->logger('Get object ['. $id .']');
        return $this->cache->load($id);
    }
    
    public function isObject($id)
    {
        $this->logger('Check object ['. $id .']');
        if($this->getObject($id) !== false){
            return true;
        }
    }

}
