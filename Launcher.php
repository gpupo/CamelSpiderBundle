<?php
namespace Gpupo\CamelSpiderBundle;
use CamelSpider\Spider\Indexer,
    CamelSpider\Spider\InterfaceCache,
    CamelSpider\Entity\FactorySubscription,
    CamelSpider\Entity\Pool,
    CamelSpider\Entity\Link,
    CamelSpider\Entity\Document,
    CamelSpider\Entity\InterfaceSubscription,
    Symfony\Bundle\DoctrineBundle\Registry,
    Gpupo\CamelSpiderBundle\Entity\RawNews,
    Gpupo\CamelSpiderBundle\Entity\News
    ;

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

    protected function processUpdates(array $links, InterfaceSubscription $subscription)
    {
        //var_dump($links);
        $this->logger('Process update Links count:' . count($links), 'info');
        foreach ($links as $l) {
            if ($l instanceof Link) {
                //pegando o objeto Link que foi serializado:
                $link = $this->cache->getObject($l->getId('string')); //id do link ( sha1 da url )
                $document =  $link->getDocument();
                if (is_array($document)) {

                    $manager = $this->doctrineRegistry->getEntityManager();

                    $this->logger('Process update saving Raw: ' . $document['title'], 'info');
                    //salvar raw...
                    try {
                        $rawNews = new RawNews();
                        $rawNews->setTitle($document['title']);
                        $rawNews->setUri($link->getHref());
                        $rawNews->setRelevancy($document['relevancy']);
                        $rawNews->setDate(new \DateTime(date('Y-m-d'))); // Falta DATA
                        $rawNews->setRawdata($document['raw']);
                        $rawNews->setHtml($document['html'] . '');
                        $rawNews->setTxt($document['text'] . '');
                        $rawNews->setSubscription($subscription);
                        $manager->persist($rawNews);
                        $manager->flush();
                    } catch (Exception $exc) {
                        $this->logger('Process update saving Raw: ' . $exc->getTraceAsString());
                    }

                    //verificar relevancia ...
                    if ($document['relevancy'] > 2) {
                        //echo "\n*" . $document['title'] . "\n";
                     /* salvar noticia, com valores:
                        $document['title'];
                        $document['text'];
                        $document['relevancy'];
                        $link->getHref();
                     */
                        $this->logger('Process update saving News: ' . $document['title'], 'info');
                        try {
                            $news = new News();
                            $news->setTitle($document['title']);
                            $news->setModeration('PENDING');
                            $news->setUri($link->getHref());
                            $news->setSlug($document['slug']);
                            $news->setDate(new \DateTime(date('Y-m-d'))); // Falta DATA
                            $news->setAnnotation('');
                            $news->setContent($document['text']);
                            $news->setSubscription($subscription);
                            $news->setRawnews($rawNews);
                            $manager->persist($news);
                            $manager->flush();
                        } catch (Exception $exc) {
                            $this->logger('Process update saving News: ' . $exc->getTraceAsString());
                        }
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
                ->findByActiveSubscriptions();
        }

        foreach($collection as $subscription)
        {
            if (!$subscription instanceof InterfaceSubscription) {
                throw new \Exception ("Subscription need implement InterfaceSubscription");
            }

            $this->logger('Checking updates for the subscription [' . $subscription->getHref() . ']');
            try{
                $this->processUpdates($this->indexer->run($subscription), $subscription);
            }
            catch (\Exception $e)
            {
                $this->logger('Indexer Exception:' . $e->getMessage(), 'err');
            }
        }
    }
}

