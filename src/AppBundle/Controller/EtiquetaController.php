<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Etiqueta;
use AppBundle\Form\EtiquetaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EtiquetaController extends Controller
{

    public function indexAction(Request $request)
    {
        die();
        return $this->render('@App/layout.html.twig');
    }
    
    public function viewAllAction()
    {
        $em = $this->getDoctrine()->getManager();
        $etiqueta_repo = $em->getRepository("AppBundle:Etiqueta");
        $etiquetas = $etiqueta_repo->findAll();

        return $this->render('@App/Etiqueta/viewAll.html.twig', [
            "etiquetas" => $etiquetas
        ]);
    }

    public function addAction(Request $request)
    {
        $etiqueta = new Etiqueta();
        $form = $this->createForm(EtiquetaType::class, $etiqueta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $etiqueta = new Etiqueta();
            $etiqueta->setNombre($form->get("nombre")->getData());

            $em = $this->getDoctrine()->getManager();
            $em->persist($etiqueta);
            $em->flush();

            return $this->redirectToRoute("all_etiquetas");
        }

        return $this->render('@App/Etiqueta/add.html.twig', [
            "form" => $form->createView()
        ]);
    }

    public function editAction()
    {
        $em = $this->getDoctrine()->getManager();
        $etiqueta_repo = $em->getRepository("AppBundle:Etiqueta");
        $etiquetas = $etiqueta_repo->findAll();

        return $this->render('@App/Etiqueta/viewAll.html.twig', [
            "etiquetas" => $etiquetas
        ]);
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $etiqueta_repo = $em->getRepository("AppBundle:Etiqueta");
        $etiqueta = $etiqueta_repo->find($id);
        if ( count($etiqueta->getTelefono()) == 0 ) {
            $em->remove($etiqueta);
            $em->flush();
        }

        return $this->redirectToRoute('all_etiquetas');
    }

}
