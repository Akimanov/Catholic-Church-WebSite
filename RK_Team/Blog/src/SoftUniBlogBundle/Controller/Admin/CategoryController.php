<?php
/**
 * Created by PhpStorm.
 * User: akimanov88
 * Date: 11/9/2016
 * Time: 2:40 AM
 */

namespace SoftUniBlogBundle\Controller\Admin;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SoftUniBlogBundle\Entity\Category;
use SoftUniBlogBundle\Entity\Role;
use SoftUniBlogBundle\Entity\User;
use SoftUniBlogBundle\Form\CategoryType;
use SoftUniBlogBundle\Form\UserEditType;
use SoftUniBlogBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin/category")
 * Class CategoryController
 * @package SoftUniBlogBundle\Controller\Admin
 */
class CategoryController extends Controller
{
    /**
     * @Route("/", name="admin_category_all")
     */
    public function indexAction()
    {
        $categories =
            $this->getDoctrine()->getRepository(Category::class)
                ->findAll();

        return $this->render("admin/category/all.html.twig", ['categories' => $categories]);
    }

    /**
     * @Route("/edit/{id}", name="admin_category_edit")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction($id, Request $request)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);

        if ($category === null) {
            return $this->redirectToRoute("admin_category_all");
        }


        $form = $this->createForm(CategoryType::class, $category);


        $form->handleRequest($request);


        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute("admin_category_all");
        }

        return $this->render("admin/category/edit.html.twig", [
            'form' => $form->createView(),
            'category' => $category
        ]);

    }

    /**
     * @Route("/delete/{id}", name="admin_category_delete")
     * @param $id
     */
    public function deleteAction($id, Request $request)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);

        if ($category === null) {
            return $this->redirectToRoute("admin_category_all");
        }


        $form = $this->createForm(CategoryType::class, $category);


        $form->handleRequest($request);


        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush();

            return $this->redirectToRoute("admin_category_all");
        }

        return $this->render("admin/category/delete.html.twig", [
            'form' => $form->createView(),
            'category' => $category
        ]);
    }

    /**
     * @Route("/create", name="admin_category_create")
     * @param Request $request
     */
    public function createAction(Request $request)
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);


        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute("admin_category_all");
        }

        return $this->render("admin/category/create.html.twig", [
            'form' => $form->createView()
        ]);

    }
}