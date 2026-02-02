<?php

namespace App\Form;

use App\Entity\CorpsEnseignant;
use App\Entity\Module;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CorpsEnseignantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('email', TextType::class, [
                'label' => 'Email',
            ])
            ->add('nbHeure', NumberType::class, [
                'label' => 'Nombre d\'heures',
            ])
             ->add('modules', EntityType::class, [
                'class' => Module::class,
                'choice_label' => function (Module $module) {
                    return $module->getCode() . ' - ' . $module->getNom();
                },
                'label' => 'Modules enseignés',
                'multiple' => true,      // plusieurs modules possibles
                'expanded' => false,      // cases à cocher
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CorpsEnseignant::class,
        ]);
    }
}