<?php
namespace Gpupo\CamelSpiderBundle;
use CamelSpider\Spider\Indexer,
    CamelSpider\Spider\InterfaceCache,
    CamelSpider\Entity\FactorySubscription,
    CamelSpider\Entity\Pool,
    CamelSpider\Entity\InterfaceLink,
    CamelSpider\Entity\Link,
    CamelSpider\Entity\Document,
    CamelSpider\Entity\InterfaceSubscription,
    Symfony\Bundle\DoctrineBundle\Registry,
    Gpupo\CamelSpiderBundle\Entity\RawNews,
    Gpupo\CamelSpiderBundle\Entity\News,
    Funpar\AdminBundle\Logger\Logger as FunparLogger
    ;

class Launcher
{
    protected $indexer;

    protected $logger;

    protected $cache;

    protected $doctrineRegistry;

    /**
     * @var Funpar\AdminBundle\Logger\Logger
     */
    protected $funparLogger;

    public function __construct(Indexer $indexer, InterfaceCache $cache, $logger, Registry $doctrineRegistry = null, FunparLogger $funparLogger)
    {
        $this->indexer = $indexer;
        $this->cache = $cache;
        $this->logger = $logger;
        $this->doctrineRegistry = $doctrineRegistry;
        $this->funparLogger = $funparLogger;
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
        $this->logger('Process update Links count:' . count($links), 'info');
        foreach ($links as $l) {

            if ($l instanceof Link) {

                $link = $this->cache->getObject($l->getId('string')); //id do link ( sha1 da url )

                $count = $this->doctrineRegistry
                    ->getRepository('GpupoCamelSpiderBundle:News')
                    ->countByLink($link);

                if($count > 0) {
                    $this->logger('Document had been inserted', 'info');
                    continue;
                }

                $document =  $link->getDocument();



                if (is_array($document)) {

                    $manager = $this->doctrineRegistry->getEntityManager();

                    $this->logger('Process update saving Raw: ' . $document['title'], 'info');

                    try {
                        $rawNews = new RawNews();
                        $rawNews->setTitle($document['title']);
                        $rawNews->setUri($link->getHref());
                        $rawNews->setRelevancy($document['relevancy']);
                        $rawNews->setDate(new \DateTime(date("now"))); // Falta DATA
                        $rawNews->setRawdata($document['raw']);
                        $rawNews->setHtml($document['html'] . '');
                        $rawNews->setTxt($document['text'] . '');
                        $rawNews->setSubscription($subscription);
                        $manager->persist($rawNews);
                        $manager->flush();
                    } catch (Exception $exc) {
                        $this->logger('Process update saving Raw: ' . $exc->getTraceAsString());
                    }

                    if ($document['relevancy'] > 2) {
                        $this->logger('Process update saving News: ' . $document['title'], 'info');
                        try {
                            $news = new News();
                            $news->setTitle($document['title']);
                            $news->setCategory($subscription->getCategory());
                            $news->setModeration('PENDING');
                            $news->setUri($link->getHref());
                            $news->setSlug($document['slug']);
                            $news->setDate(new \DateTime(date('Y-m-d'))); // Falta DATA
                            $f = $subscription->getFormat();
                            $f = empty($f) ? 'html' : $f;
                            $news->setContent($document[$f]);
                            $news->setSubscription($subscription);
                            $news->setRawnews($rawNews);
                            $manager->persist($news);
                            $manager->flush();
                        } catch (\Exception $exc) {
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
                $process = $this->processUpdates($this->indexer->run($subscription), $subscription);
                $this->funparLogger->doLog('CAPTURE', $process['log'], null, $subscription);
            }
            catch (\Exception $e)
            {
                $this->logger('Indexer Exception:' . $e->getMessage(), 'err');
            }
        }
    }
}

