<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Message;
use AppBundle\Entity\Person;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     */
    public function adminAction()
    {
        $em = $this->getDoctrine()->getManager();
        $persons = $em->getRepository('AppBundle:Person')
            ->findAllOrderedByName();

        return $this->render('admin/admin.html.twig', [
            'persons' => $persons
        ]);
    }

    /**
     * @Route("/show/{userId}", name="user_show")
     */
    public function showAction(Request $request, $userId)
    {
        $em = $this->getDoctrine()->getManager();
        $person = $em->getRepository('AppBundle:Person')
            ->find($userId);

        $message = new Message();

        $form = $this->createFormBuilder($message)
            ->add('topic', TextType::class)
            ->add('body', TextareaType::class)
            ->add('save', SubmitType::class, ['label' => 'Send'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setPerson($person);
            $em->persist($message);
            $em->flush();

            $mail = \Swift_Message::newInstance()
                ->setSubject($message->getTopic())
                ->setFrom('symfony@testtask.com')
                ->setTo($person->getEmail())
                ->setBody(
                    $this->renderView(
                        'admin/email.html.twig',
                        ['message' => $message]
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($mail);

            return $this->render('admin/status.html.twig', [
                'person'    => $person,
                'operation' => 'send message'
            ]);
        }

        return $this->render('admin/show.html.twig', [
            'person' => $person,
            'form'   => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{userId}", name="user_delete")
     */
    public function deleteAction($userId)
    {
        $em = $this->getDoctrine()->getManager();
        $person = $em->getRepository('AppBundle:Person')
            ->find($userId);

        $em->remove($person);
        $em->flush();

        return $this->render('admin/status.html.twig', [
            'person'    => $person,
            'operation' => 'delete'
        ]);
    }

    /**
     * @Route("/create", name="user_create")
     */
    public function createAction(Request $request)
    {
        $person = new Person();

        $form = $this->createFormBuilder($person)
            ->add('fname', TextType::class)
            ->add('lname', TextType::class)
            ->add('email', EmailType::class)
            ->add('save', SubmitType::class, ['label' => 'Create user'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();

            return $this->render('admin/status.html.twig', [
                'person'    => $person,
                'operation' => 'create'
            ]);
        }

        return $this->render('admin/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}