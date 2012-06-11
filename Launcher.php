<?php

/**
 * This file is part of CamelSpider Bundle.
 *
 * (c) Gilmar Pupo <gpupo@g1mr.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
    Funpar\AdminBundle\Logger\Logger as FunparLogger;

/**
 * Start a capture and save in DB.
 *
 */
class Launcher
{
    protected $indexer;

    protected $logger;

    protected $cache;

    protected $doctrineRegistry;

    protected $captureLog;

    /**
     * @var Funpar\AdminBundle\Logger\Logger
     */
    protected $funparLogger;

    public function __construct(
        Indexer $indexer,
        InterfaceCache $cache,
        $logger,
        Registry $doctrineRegistry = null,
        FunparLogger $funparLogger = null
    ) {
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

    protected function addCaptureLog($string)
    {
        $log = "\n\n" .$string;
        echo $log;
        $this->captureLog  .= $log;
    }

    protected function getCaptureLog()
    {
        return trim($this->captureLog);
    }

    protected function getSampleSubscriptions()
    {
        return FactorySubscription::buildCollectionFromDomain(
            array(
                'noticias.terra.com.br'
            )
        );
    }

    protected function documentInfoLi($document)
    {

        return ' - [' . $document['title']
            . '](' . $document['uri'] . ") (Relevancy:"
            . $document['relevancy'] . ")\n\n";
    }

    /**
     * Process Capture after spider works
     *
     * @param array                 $links        Many records os Link Object
     * @param InterfaceSubscription $subscription Information about the subscription
     *
     * @return bool true;
     */
    protected function processUpdates(
        array $links,
        InterfaceSubscription $subscription
    ) {
        $this->logger('Process update Links count:' . count($links), 'info');
        $add = $descart = $duplicated = '';

        foreach ($links as $l) {

            $_proc = array();
            if ($l instanceof Link) {

                //id do link ( sha1 da url )
                $link = $this->cache->getObject($l->getId('string'));

                if (!$link instanceof InterfaceLink) {
                    $this->logger('Invalid Link', 'err');
                    continue;
                }

                //Verifying that the Url has been previously captured
                try {
                    $count = $this->doctrineRegistry
                        ->getRepository('GpupoCamelSpiderBundle:News')
                        ->countByLink($link);
                    if ($count > 0) {
                        $_proc['existing'] = $count;
                        goto discard;
                    }
                } catch (\Exception $e) {
                    $this->logger('Url Check with error: ' . $e->getMessage(), 'err', 1);
                    $count = 0;
                }

                $document =  $link->getDocument();

                if (is_array($document)) {

                    $manager = $this->doctrineRegistry->getEntityManager();

                    $this->logger(
                        'Process update saving Raw: '
                        . $document['title'], 'info'
                    );

                    try {
                        $rawNews = new RawNews();
                        $rawNews->setTitle($document['title']);
                        $rawNews->setUri($document['uri']);
                        $rawNews->setRelevancy($document['relevancy']);
                        $rawNews->setDate(new \DateTime('now'));
                        $rawNews->setRawdata($document['raw']);
                        $rawNews->setHtml($document['html'] . '');
                        $rawNews->setTxt($document['text'] . '');
                        $rawNews->setSubscription($subscription);
                        $manager->persist($rawNews);
                        $manager->flush();
                    } catch (\Exception $exc) {
                        $this->logger(
                            'Process update saving Raw: '
                            . $exc->getTraceAsString()
                        );
                    }

                    $this->logger(
                        'Check relevancy of document',
                        'info'
                    );

                    if ($document['relevancy'] > 2) {

                        $this->logger(
                            'Process update saving News: '
                            . $document['title'], 'info'
                        );
                        try {
                            $add .= $this->documentInfoLi($document);
                            $news = new News();
                            $news->setTitle($document['title']);
                            $news->setCategory($subscription->getCategory());
                            $news->setModeration('PENDING');
                            $news->setUri($document['uri']);
                            $news->setSlug($document['slug']);
                            $news->setDate(new \DateTime('now'));
                            $f = $subscription->getFormat();
                            $f = empty($f) ? 'html' : $f;
                            $news->setContent($document[$f]);
                            $news->setSubscription($subscription);
                            //$news->setRawnews($rawNews);
                            $manager->persist($news);
                            $manager->flush();
                        } catch (\Exception $exc) {
                            $this->logger(
                                'Process update saving News: '
                                . $exc->getTraceAsString()
                            );
                        }

                    } else {
                        $descart .= $this->documentInfoLi($document);
                    }

                } else {
                    $this->logger(
                        'Object wrong, on processUpdates. Array Expected!',
                        'err'
                    );
                }
            } else {
                $this->logger(
                    'Object wrong, on processUpdates. Link expected!',
                    'err'
                );
            }

            discard:
            if (isset($_proc['existing'])) {
                $this->logger('Document had been inserted', 'info');
                $duplicated .= ' - *' . $link['href'] . '* (' . $_proc['existing'] . ')' . "\n\n";
            }



        }

        empty($add) ?: $this->addCaptureLog(
            'Documentos adicionados:'
            . "\n\n" . $add
        );
        empty($duplicated) ?: $this->addCaptureLog(
            'Documentos descartados por já terem sido '
            .'capturados e sem modificação relevante:'
            . "\n\n"
            . $duplicated
        );

        empty($descart) ?: $this->addCaptureLog(
            'Documentos descartados por não conter palavras de relevância:'
            . "\n\n"
            . $descart
        );
    }

    /**
     * Run the spider for every subscription
     *
     * @param int                 $subscription_id ID of subscription
     * @param \DoctrineCollection $collection      List of subscriptions
     *
     * @return bool true
     */
    public function checkUpdates($subscription_id = null, $collection = null)
    {
        if (!$this->doctrineRegistry) {

            //Tests only.
            $this->logger('Gets subscription data from database', 'info');
            $collection = $this->getSampleSubscriptions();

        } elseif (!is_null($subscription_id)) {

            $collection = $this->doctrineRegistry
                ->getRepository('GpupoCamelSpiderBundle:Subscription')
                ->findById($subscription_id);

        } else {

            $collection = $this->doctrineRegistry
                ->getRepository('GpupoCamelSpiderBundle:Subscription')
                ->findByScheduledSubscriptions();
        }

        foreach ($collection as $subscription) {
            if (!$subscription instanceof InterfaceSubscription) {
                throw new \Exception(
                    "Subscription need implement InterfaceSubscription"
                );
            }

            $this->logger(
                'Checking updates for the subscription ['
                . $subscription->getHref()
                . ']'
            );
            try{
                $updates =  $this->indexer->run($subscription);
                $this->captureLog = $updates['log'];
                $this->processUpdates($updates['pool'], $subscription);
                $this->funparLogger->doLog(
                    'CAPTURE',
                    $this->getCaptureLog(), null, $subscription
                );
            }
            catch (\Exception $e)
            {
                $this->logger('Indexer Exception:' . $e->getMessage(), 'err');
            }
        }
    }
}

