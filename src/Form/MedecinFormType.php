<?php

namespace App\Form;

use App\Entity\Medecin;
use App\Entity\Service;
use App\Entity\Specialite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MedecinFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('matricule', NULL, ['required' => false])
            ->add('nom')
            ->add('prenom')
            ->add('tel')
            ->add('date_de_naissance', DateType::class, [
                'widget' => 'single_text',
                
                'format' =>'yyyy-MM-dd'])
            ->add('service', EntityType::class,[
                'class' => Service::class
            ])
            ->add('specialite', EntityType::class,[
                'class' => Specialite::class
            ])
            
            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Medecin::class,
        ]);
    }
}
