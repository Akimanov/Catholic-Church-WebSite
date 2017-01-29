<?php

namespace SoftUniBlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use SoftUniBlogBundle\Entity\Statistics;
use SoftUniBlogBundle\Form\StatisticsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class StatisticsController extends Controller
{
    /**
     * @param Request $request
     * @Route("/statistics/create", name="statistics_create")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $statistics = new Statistics();
        $form = $this->createForm(StatisticsType::class, $statistics);

        $form->handleRequest($request);

        $currentUser = $this->getUser();

        if(!$currentUser->isAdmin())
        {
            return $this->redirectToRoute("blog_index");
        }


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($statistics);
            $em->flush();

            return $this->redirectToRoute('blog_index');
        }

        return $this->render("statistics/create.html.twig",
            array('form' => $form->createView()));
    }

    /**
     * @Route("/statistics/{id}", name="statistics_view")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($id)
    {
        $statisticsRepository
            = $this->getDoctrine()->getRepository(
                Statistics::class
        );
        $statistics = $statisticsRepository->find($id);

        return $this->render("statistics/show.html.twig", [
            "statistics" => $statistics
        ]);
    }

    /**
     * @Route("/statistics/edit/{id}", name="statistics_edit")
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     *
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editStatistics($id, Request $request)
    {
        $statistics = $this->getDoctrine()->getRepository(Statistics::class)->find($id);

        if($statistics === null){
            return $this->redirectToRoute("blog_index");
        }

        $currentUser = $this->getUser();

        if(!$currentUser->isAdmin())
        {
            return $this->redirectToRoute("blog_index");
        }

        $form = $this->createForm(StatisticsType::class, $statistics);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($statistics);
            $em->flush();

            return $this->redirectToRoute('statistics_view', array('id' => $statistics->getId()));
        }

        return $this->render('statistics/edit.html.twig',
            array('statistics' => $statistics,
                'form' => $form->createView()));
    }

    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
}
