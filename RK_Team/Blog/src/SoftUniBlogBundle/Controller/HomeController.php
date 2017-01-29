<?php

namespace SoftUniBlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SoftUniBlogBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @Route("/", name="blog_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $articleRepository = $this->getDoctrine()->getRepository(Article::class);


        /**
         * @var $articles Article[]
         */
        $articles = $articleRepository->findAll();
        rsort($articles);
        return $this->render('blog/index.html.twig',[
            "articles" => $articles
        ]);

    }

    /**
     * @Route("/gallery", name="church_gallery")
     * @Method("GET")
     */
    public function gallery()
    {
        return $this->render('gallery/gallery.html.twig');
    }


}
