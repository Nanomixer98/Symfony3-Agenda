<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contacto;
use AppBundle\Entity\Etiqueta;
use AppBundle\Entity\Telefono;
use AppBundle\Form\ContactoType;
use AppBundle\Form\TelefonoType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Dumper\Dumper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactoController extends Controller
{

    public function indexAction(Request $request)
    {
        return $this->render('@App/layout.html.twig');
    }

    public function viewAllAction()
    {
        $em = $this->getDoctrine()->getManager();
        $contacto_repo = $em->getRepository("AppBundle:Contacto");
        $contactos = $contacto_repo->findAll();

        return $this->render('@App/Contactos/viewAll.html.twig', [
            "contactos" => $contactos
        ]);
    }
    
    public function viewAllInfoAction()
    {
        $em = $this->getDoctrine()->getManager();
        $contacto_repo = $em->getRepository("AppBundle:Contacto");
        $contactos = $contacto_repo->findAll();

        return $this->render('@App/Contactos/view.html.twig', [
            "contactos" => $contactos
        ]);
    }

    public function viewOneAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $contacto_repo = $em->getRepository("AppBundle:Contacto");
        $contacto = $contacto_repo->find($id);

        return $this->render('@App/Contactos/viewOne.html.twig', [
            "contacto" => $contacto
        ]);
    }

    public function addAction(Request $request)
    {
        $contacto = new Contacto();
        $tel = new Telefono();
        $contacto->getTelefono()->add($tel);
        $form = $this->createForm(ContactoType::class, $contacto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $contacto = new Contacto();
            $contacto->setNombre($form->get("nombre")->getData());
            $tels = $form->get("telefono")->getData();
            
            $em = $this->getDoctrine()->getManager();

            foreach ($tels as $tel) {
                $telToSave = new Telefono();
                $telToSave->setNumero($tel->getNumero());
                $telToSave->setEtiqueta($tel->getEtiqueta());
                $contacto->addTelefono($telToSave);
                $em->persist($contacto);
                $em->flush();
            }

            return $this->redirectToRoute("all_contactos");

        }

        return $this->render('@App/Contactos/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $contacto_repo = $em->getRepository("AppBundle:Contacto");
        $contacto = $contacto_repo->find($id);

        if (!$contacto) {
            throw $this->createNotFoundException('No contacto found for id '.$id);
        }

        $originalTelefonos = new ArrayCollection();

        foreach ($contacto->getTelefono() as $telefono) {
            $originalTelefonos->add($telefono);
        }

        
        $form = $this->createForm(ContactoType::class, $contacto);
        $form->handleRequest($request);
        
        // dump($contacto->getTelefono());
        // dump($form->get("telefono")->getData());
        
        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($originalTelefonos as $telefono) {
                if ( false === $contacto->getTelefono()->contains($telefono) ) {
                    $telefono->getContacto()->removeTelefono($telefono);

                    $telefono->setContacto(null);

                    $em->persist($telefono);

                    $em->remove($telefono);
                }
            }

            // $contacto->setNombre($form->get("nombre")->getData());
            
            $em->persist($contacto);
            $em->flush();
            
            // $tels = $form->get("telefono")->getData();
            // dump($tels);
            // foreach ($tels as $tel) {
            //     $contacto->addTelefono($tel);      
            //     $em = $this->getDoctrine()->getManager();
            //     $em->persist($contacto);
            //     $em->flush();
            // }

            return $this->redirectToRoute("all_contactos");

        }

        // die();
        return $this->render('@App/Contactos/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function deleteAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $contacto_repo = $em->getRepository("AppBundle:Contacto");
        $contacto = $contacto_repo->find($id);
        $em->remove($contacto);
        $em->flush();

        return $this->redirectToRoute('all_contactos');
    }
}
