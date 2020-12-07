<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contacto;
use AppBundle\Entity\Etiqueta;
use AppBundle\Entity\Telefono;
use AppBundle\Form\ContactoType;
use AppBundle\Form\TelefonoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactoController extends Controller
{

    public function indexAction(Request $request)
    {
        return $this->render('@App/layout.html.twig');
    }

    public function newAction(Request $request)
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

        return $this->render('@App/Contactos/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function viewAllAction()
    {
        $em = $this->getDoctrine()->getManager();
        $contacto_repo = $em->getRepository("AppBundle:Contacto");
        $contactos = $contacto_repo->findAll();
        $telefono_repo = $em->getRepository("AppBundle:Telefono");
        $telefonos = $telefono_repo->findAll();

        return $this->render('@App/Contactos/viewAll.html.twig', [
            "contactos" => $contactos
        ]);
    }

    public function viewAction($id)
    {

        die();
    }

    public function addAction(Request $request)
    {

        $contacto = new Contacto();
        $contacto_form = $this->createForm(ContactoType::class, $contacto);
        $contacto_form->handleRequest($request);

        $telefono = new Telefono();
        $telefono_form = $this->createForm(TelefonoType::class, $telefono);
        $telefono_form->handleRequest($request);

        if ($telefono_form->isSubmitted() && $telefono_form->isValid()) {

            $contacto = new Contacto();
            $contacto->setNombre($telefono_form->get("contacto")->get("nombre")->getData());

            // Cargar la repo de etiquetas
            $em = $this->getDoctrine()->getManager();
            $etiqueta_repo = $em->getRepository("AppBundle:Etiqueta");
            $etiqueta = $etiqueta_repo->find($telefono_form->get("etiqueta")->getData());

            // Cargaar informacion para el nuevo telefono
            $telefono = new Telefono();
            $telefono->setContacto($contacto);
            $telefono->setNumero($telefono_form->get("numero")->getData());
            $telefono->setEtiqueta($etiqueta);

            // Guardar el nuevo telefono
            $em->persist($telefono);
            $em->flush();

            return $this->redirectToRoute("all_contactos");
        }

        return $this->render('@App/Contactos/addContact.html.twig', [
            "telefonoForm" => $telefono_form->createView(),
            "contactoForm" => $contacto_form->createView()
        ]);
    }

    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $telefono_repo = $em->getRepository("AppBundle:Telefono");
        $auxId = $telefono_repo->getContacto($id);
        $telefono = $telefono_repo->find($auxId);

        $contact_repo = $em->getRepository("AppBundle:Contacto");
        $contacto = $contact_repo->find($id);

        $telefono_form = $this->createForm(TelefonoType::class, $telefono);
        $telefono_form->handleRequest($request);

        if ($telefono_form->isSubmitted() && $telefono_form->isValid()) {

            $contacto->setNombre($telefono_form->get("contacto")->get("nombre")->getData());

            // Cargar la repo de etiquetas
            $em = $this->getDoctrine()->getManager();
            $etiqueta_repo = $em->getRepository("AppBundle:Etiqueta");
            $etiqueta = $etiqueta_repo->find($telefono_form->get("etiqueta")->getData());

            // Cargaar informacion para el nuevo telefono
            $telefono->setContacto($contacto);
            $telefono->setNumero($telefono_form->get("numero")->getData());
            $telefono->setEtiqueta($etiqueta);

            // Guardar el nuevo telefono
            $em->persist($telefono);
            $em->flush();

            return $this->redirectToRoute("all_contactos");
        }

        return $this->render('@App/Contactos/editContact.html.twig', [
            "telefonoForm" => $telefono_form->createView()
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
