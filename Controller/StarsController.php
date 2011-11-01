<?php

namespace Gpupo\CamelSpiderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response,
    Gpupo\CamelSpiderBundle\Entity\News,
    Gpupo\CamelSpiderBundle\Entity\NewsVote
    ;

class StarsController extends Controller
{
    public function submitAction(Request $request)
    {
        $form    = $request->request->get('vote');
        $news_id = $form['news_id'];
        $rate    = $form['rate'];

        $manager = $this->getDoctrine()->getEntityManager();

        $news = $manager->getRepository('GpupoCamelSpiderBundle:News')->find($form['news_id']);

        if (!$news) {
            // Response com "erro"
            $return = array("responseCode"=>400, 'News not found');
            return new Response(json_encode($return),400);

        } else {
            // Salvar voto, tem que ser entre 1 e 5 o valor
            try {
                $vote = new NewsVote();
                $vote->setNews($news);
                $vote->getValue((int)$form['rate']);
                $manager->persist($vote);
                $manager->flush();
                $responseCode = 200;
            } catch (Exception $e) {
                $return = array("responseCode"=>400, 'Error adding vote');
                return new Response(json_encode($return),400);
            }

            $query = $manager->createQuery('SELECT v, AVG(v.value) as average FROM NewsVote WHERE v.news_id = ' . $form['news_id'] . ' GROUP BY v.news_id');
            $result = $query->getResult();
            $result->

            $return = array("responseCode"=>$responseCode, 'news_id'=> $form['news_id'],  "average"=>$average);
            return new Response(json_encode($return),200);
        }

    }

    public function submitTestAction($news_id, $rate)
    {
        $manager = $this->getDoctrine()->getEntityManager();

        $news = $manager->getRepository('GpupoCamelSpiderBundle:News')->find($news_id);

        if (!$news) {
            // Response com "erro"
            $return = array("responseCode"=>400, 'News not found');
            return new Response(json_encode($return),400);

        } else {
            // Salvar voto, tem que ser entre 1 e 5 o valor
            try {
                $vote = new NewsVote();
                $vote->setNews($news);
                $vote->setValue($rate);
                $manager->persist($vote);
                $manager->flush();
                $responseCode = 200;
            } catch (Exception $e) {
                $return = array("responseCode"=>400, 'Error adding vote');
                return new Response(json_encode($return),400);
            }

            $query = $manager->createQueryBuilder()
                    ->addSelect('AVG(v.value) as average')
                    ->from('GpupoCamelSpiderBundle:NewsVote', 'v')
                    ->join('v.news', 'n')
                    ->where('n.id = ' . $news_id)
                    ->groupBy('n.id');
            $result = $query->getQuery()->execute();

            $return = array(
                'responseCode' => $responseCode,
                'news_id'      => $news_id,
                'average'      => round($result[0]['average'], 0, PHP_ROUND_HALF_DOWN)
                );
            return new Response(json_encode($return),200);
        }

    }

}
