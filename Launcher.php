<?php
namespace Gpupo\CamelSpiderBundle;
use CamelSpider\Spider\Indexer,
    CamelSpider\Spider\InterfaceCache,
    CamelSpider\Entity\FactorySubscription,
    CamelSpider\Entity\Pool,
    CamelSpider\Entity\Link,
    CamelSpider\Entity\Document,
    Symfony\Bundle\DoctrineBundle\Registry;

class Launcher
{
    protected $indexer;

    protected $logger;

    protected $cache;

    protected $doctrineRegistry;

    public function __construct(Indexer $indexer, InterfaceCache $cache, $logger, Registry $doctrineRegistry = null)
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
                'noticias.terra.com.br'
            )
        );
    }

    protected function processUpdates(array $links)
    {
        //var_dump($links);
        $this->logger('Process update Links count:' . count($links), 'info');
        foreach ($links as $l) {
            if ($l instanceof Link) {
                //pegando o objeto Link que foi serializado:
                $link = $this->cache->getObject($l->getId('string')); //id do link ( sha1 da url )
                $document =  $link->getDocument();
                if (is_array($document)) {
                    //salvar raw...
                    //verificar relevancia ...
                    if ($document['relevancy'] > 2) {
                        //salvar noticia

                        echo "#" . $document['title'];
                        echo "\n";
                        echo $document['text'];
                        echo "\n\n\n\n-----\n\n\n";
                    }

                } else {
                    $this->logger('Object wrong, on processUpdates. Array Expected!', 'err');
                }
            } else {
                $this->logger('Object wrong, on processUpdates. Link expected!', 'err');
            }
        }
    }

    public function checkUpdates($collection = NULL)
    {
        if (!$this->doctrineRegistry) {
             //Tests only.
            $this->logger('Gets subscription data from database', 'info');
            $collection = $this->getSampleSubscriptions();
        } else {
            $collection = $this->doctrineRegistry
                ->getRepository('GpupoCamelSpiderBundle:Subscription')
                ->findBy(array('isActive'=> true));
        }

        foreach($collection as $subscription)
        {
            $this->logger('Checking updates for the subscription [' . $subscription->getHref() . ']');
            try{
                $this->processUpdates($this->indexer->run($subscription));
            }
            catch (\Exception $e)
            {
                $this->logger('Indexer Exception:' . $e->getMessage(), 'err');
            }
        }
    }
}

