<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

        return $this->render('admin/show.html.twig', [
            'persons' => $persons
        ]);
    }

    /**
     * @Route("/show/{userId}", name="user_show")
     */
    public function showAction($userId)
    {
        $em = $this->getDoctrine()->getManager();
        $person = $em->getRepository('AppBundle:Person')
            ->find($userId);

        return $this->render('admin/detail.html.twig', [
            'person' => $person
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
}