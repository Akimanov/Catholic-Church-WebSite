<?php

namespace SoftUniBlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use SoftUniBlogBundle\Entity\About;
use SoftUniBlogBundle\Form\AboutType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AboutController extends Controller
{
    /**
     * @param Request $request
     * @Route("/about/create", name="about_create")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $about = new About();
        $form = $this->createForm(AboutType::class, $about);

        $form->handleRequest($request);

        $currentUser = $this->getUser();

        if(!$currentUser->isAdmin())
        {
            return $this->redirectToRoute("blog_index");
        }


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();


            $em->persist($about);
            $em->flush();

            return $this->redirectToRoute('blog_index');
        }

        return $this->render("about/create.html.twig",
            array('form' => $form->createView()));
    }

    /**
     * @Route("/about/{id}", name="about_view")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($id)
    {
        $aboutRepository
            = $this->getDoctrine()->getRepository(
            About::class
        );
        $about = $aboutRepository->find($id);

        return $this->render("about/show.html.twig", [
            "about" => $about
        ]);
    }

    /**
     * @Route("/about/edit/{id}", name="about_edit")
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     *
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editabout($id, Request $request)
    {
        $about = $this->getDoctrine()->getRepository(About::class)->find($id);

        if($about === null){
            return $this->redirectToRoute("blog_index");
        }

        $currentUser = $this->getUser();

        if(!$currentUser->isAdmin())
        {
            return $this->redirectToRoute("blog_index");
        }

        $form = $this->createForm(AboutType::class, $about);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($about);
            $em->flush();

            return $this->redirectToRoute('about_view', array('id' => $about->getId()));
        }

        return $this->render('about/edit.html.twig',
            array('about' => $about,
                'form' => $form->createView()));
    }


    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
}
