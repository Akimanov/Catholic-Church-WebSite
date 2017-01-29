<?php

namespace SoftUniBlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SoftUniBlogBundle\Entity\Message;
use SoftUniBlogBundle\Form\MessageType;
use Symfony\Component\HttpFoundation\Request;

class MessageController extends Controller
{
    /**
     * @param Request $request
     *
     * @Route("/message/create", name="message_create")
     *
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     */
    public function create(Request $request)
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            return $this->redirectToRoute('contacts_view',array('id' => 1));
        }

        return $this->render('message/create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/message/delete/{id}", name="message_delete")
     */
    public function deleteMessage($id, Request $request)
    {
        $message = $this->getDoctrine()->getRepository(Message::class)->find($id);

        $currentUser = $this->getUser();
        if (!$currentUser->isAdmin()) {
            return $this->redirectToRoute('blog_index');
        }

        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($message);
            $em->flush();
            return $this->redirectToRoute('messages_index');
        }

        return $this->render('message/delete.html.twig', array(
            'message' => $message,
            'form' => $form->createView()
        ));


    }

    /**
     * @Route("/admin/messages", name="messages_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $messageRepository = $this->getDoctrine()->getRepository(Message::class);

        /**
         * @var $messages Message[]
         */
        $messages = $messageRepository->findAll();
        return $this->render('message/show.html.twig',[
            "messages" => $messages
        ]);

    }

}
