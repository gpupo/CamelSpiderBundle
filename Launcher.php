<?php
namespace Gpupo\CamelSpiderBundle;
use CamelSpider\Spider\SpiderProcessor,
    CamelSpider\Entity\FactorySubscription;
class Launcher 
{
    protected $processor; 

    protected $logger;
    
    public function __construct(SpiderProcessor $processor, $logger)
    {
        $this->processor = $processor;

        $this->logger = $logger;

    }

	protected function logger($string, $type = 'info')
	{
		return $this->logger->$type('#CamelSpiderBundleLancher ' . $string);
    }

    private function getSampleSubscriptions()
    {
        return FactorySubscription::buildCollectionFromDomain(
            array(
                'economia.estadao.com.br', 
                'terra.com.br'
            )
        );
    }
    public function checkUpdates($collection = NULL)
    {
        if(!$collection)
        {
            //Tests only. 
            $this->logger('Using subscriptions samples', 'err');
            $collection = $this->getSampleSubscriptions();
        }

        foreach($collection as $subscription)
        {
            $this->logger(
                'Checking updates fo the subscription [' 
                . $subscription->getHref()
            );
            try{
                $this->processor->checkUpdates($subscription);
            }
            catch (\Exception $e)
            {
                $this->logger($e->getMessage(), 'err');
            }
        }
    }	
}
 
