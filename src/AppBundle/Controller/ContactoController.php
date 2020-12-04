<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactoController extends Controller
{

    public function indexAction(Request $request)
    {
        return $this->render('@App/layout.html.twig');
    }

    public function viewAllAction() {
        $em = $this->getDoctrine()->getManager();
        $contacto_repo = $em->getRepository("AppBundle:Contacto");
        $contactos = $contacto_repo->findAll();

        return $this->render('@App/Contactos/viewAll.html.twig', [
            "contactos" => $contactos
        ]);
    }

    public function viewAction($id) {

        die();
    }

    public function addAction() {

        die();
    }

    public function editAction($id) {

        die();
    }

    public function deleteAction($id) {

        die();
    }

}
