<?php

namespace Armada\MovieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    public function indexAction()
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getEntityManager();

        $date = $request->get('date');
        if(empty($date)) {
            $date = $em->getRepository('ArmadaMovieBundle:MovieScore')
                        ->getLastDate();
        }
        else {
            $date = new \DateTime($date);
        }
        $scores = $em->getRepository('ArmadaMovieBundle:MovieScore')
            ->getRatingForDate($date);


        if($request->get('ajax')) {
            $template = 'ArmadaMovieBundle:Default:top_movies.html.twig';
        }
        else {
            $template = 'ArmadaMovieBundle:Default:index.html.twig';
        }

        return $this->render($template, array(
            'scores' => $scores,
            'ratingDate' => $date
        ));

    }
}
