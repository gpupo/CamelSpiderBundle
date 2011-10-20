<?php
namespace Gpupo\CamelSpiderBundle;
use CamelSpider\Spider\Indexer,
    CamelSpider\Entity\FactorySubscription,
    CamelSpider\Spider\Pool;
class Launcher 
{
    protected $indexer; 

    protected $logger;
    
    public function __construct(Indexer $indexer, $logger)
    {
        $this->indexer = $indexer;

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
                //'economia.estadao.com.br', 
                'noticias.terra.com.br'
                //,'www.uol.com.br'
            )
        );
    }

    protected function processUpdates(Pool $elements)
    {
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
                $this->processUpdates($this->indexer->run($subscription));
            }
            catch (\Exception $e)
            {
                $this->logger($e->getMessage(), 'err');
            }
        }
    }	
}
 
