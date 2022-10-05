<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom de famille'
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse e-mail'
            ])
            ->add('subject', TextType::class, [
                'label' => 'Objet de la demande'
            ])
            ->add('message', TextareaType::class)
            // ->add('submit', SubmitType::class, [
            //     'attr' => [
            //         'class' => 'btn btn-outline-dark btn-lg px-5 mt-5 login-button'
            //     ],
            //     'label' => 'Envoyer mon formulaire'            
            // ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
