<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TelefonoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        $builder
        ->add('numero', TextType::class, [
            "label" => "Teléfono:",
            "attr" => [
                "class" => "form-control"
            ]
        ])
        ->add('etiqueta', EntityType::class, [
            "label" => "Etiqueta:",
            "class" => "AppBundle:Etiqueta",
            "attr" => [
                "class" => "form-control"
            ]
        ]);


    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Telefono'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_telefono';
    }


}
