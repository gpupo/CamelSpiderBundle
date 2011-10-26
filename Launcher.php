<?php
namespace Gpupo\CamelSpiderBundle;
use CamelSpider\Spider\Indexer,
    CamelSpider\Entity\FactorySubscription,
    CamelSpider\Spider\SpiderElements,
    Symfony\Bundle\DoctrineBundle\Registry;

class Launcher
{
    protected $indexer;

    protected $logger;

    /**
     * @var Symfony\Bundle\DoctrineBundle\Registry
     */
    protected $doctrineRegistry;

    public function __construct(Indexer $indexer, $logger, Registry $doctrineRegistry)
    {
        $this->indexer = $indexer;

        $this->logger = $logger;

        $this->doctrineRegistry = $doctrineRegistry;
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

    protected function processUpdates(SpiderElements $elements)
    {
    }


    public function checkUpdates($collection = NULL)
    {
        if(!$collection)
        {
            $collection = $this->doctrineRegistry
                            ->getRepository('GpupoCamelSpiderBundle:Subscription')
                            ->findBy();
            //Tests only.
            $this->logger('Gets subscription data', 'err');
            //$collection = $this->getSampleSubscriptions();
        }

        foreach($collection as $subscription)
        {
            $this->logger(
                'Checking updates fo the subscription ['
                . $subscription->getHref()
            );
            try{
                $this->processUpdates($this->indexer->checkUpdate($subscription));
            }
            catch (\Exception $e)
            {
                $this->logger($e->getMessage(), 'err');
            }
        }
    }
}

