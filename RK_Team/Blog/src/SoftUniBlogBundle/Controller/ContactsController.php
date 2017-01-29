<?php

namespace SoftUniBlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use SoftUniBlogBundle\Entity\Contacts;
use SoftUniBlogBundle\Form\ContactsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactsController extends Controller
{
    /**
     * @param Request $request
     * @Route("/contacts/create", name="contacts_create")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $contacts = new Contacts();
        $form = $this->createForm(ContactsType::class, $contacts);

        $form->handleRequest($request);

        $currentUser = $this->getUser();

        if(!$currentUser->isAdmin())
        {
            return $this->redirectToRoute("blog_index");
        }


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($contacts);
            $em->flush();

            return $this->redirectToRoute('blog_index');
        }

        return $this->render("contacts/create.html.twig",
            array('form' => $form->createView()));
    }

    /**
     * @Route("/contacts/{id}", name="contacts_view")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($id)
    {
        $contactsRepository
            = $this->getDoctrine()->getRepository(
            Contacts::class
        );
        $contacts = $contactsRepository->find($id);

        return $this->render("contacts/show.html.twig", [
            "contacts" => $contacts
        ]);
    }

    /**
     * @Route("/contacts/edit/{id}", name="contacts_edit")
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     *
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editcontacts($id, Request $request)
    {
        $contacts = $this->getDoctrine()->getRepository(Contacts::class)->find($id);

        if($contacts === null){
            return $this->redirectToRoute("blog_index");
        }

        $currentUser = $this->getUser();

        if(!$currentUser->isAdmin())
        {
            return $this->redirectToRoute("blog_index");
        }

        $form = $this->createForm(ContactsType::class, $contacts);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contacts);
            $em->flush();

            return $this->redirectToRoute('contacts_view', array('id' => $contacts->getId()));
        }

        return $this->render('contacts/edit.html.twig',
            array('contacts' => $contacts,
                'form' => $form->createView()));
    }


    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
}
