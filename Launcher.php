<?php
namespace Gpupo\CamelSpiderBundle;
use CamelSpider\Spider\Indexer,
    CamelSpider\Spider\InterfaceCache,
    CamelSpider\Entity\FactorySubscription,
    CamelSpider\Spider\Pool,
    Symfony\Bundle\DoctrineBundle\Registry;

class Launcher
{
    protected $indexer;

    protected $logger;

    protected $cache;

    public function __construct(Indexer $indexer, InterfaceCache $cache, $logger, Registry $doctrineRegistry)
    {
        $this->indexer = $indexer;
        $this->cache = $cache;
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

    protected function processUpdates(Pool $elements)
    {
        //var_dump($elements);
        //$this->logger('Process update' . print_r($elements, true), 'info');
        foreach ($elements as $l) {

            var_dump($l);
            //pegando o objeto Link que foi serializado:
            //$link = $this->cache->getObject($l->getId()); //id do link ( sha1 da url )
            //salvar raw...
            //
            //verificar relevancia ...
            //
            //
            //salvar noticia
        }
    }

    public function checkUpdates($collection = NULL)
    {
        if(!$collection)
        {
            $collection = $this->doctrineRegistry
                            ->getRepository('GpupoCamelSpiderBundle:Subscription')
                            ->findBy(array('isActive'=> true));
            //Tests only.
            $this->logger('Gets subscription data from database', 'info');
            //$collection = $this->getSampleSubscriptions();
        }

        foreach($collection as $subscription)
        {
            $this->logger('Checking updates for the subscription [' . $subscription->getHref() . ']');
            try{
                $this->indexer->run($subscription);
                //$this->processUpdates($this->indexer->run($subscription));
            }
            catch (\Exception $e)
            {
                $this->logger('Indexer Exception:' . $e->getMessage(), 'err');
            }
        }
    }
}

