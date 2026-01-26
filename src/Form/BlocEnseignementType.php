<?php

namespace App\Form;

use App\Entity\BlocEnseignement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlocEnseignementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class, [
                'label' => 'Code du bloc d\'enseignement',
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom du bloc d\'enseignement',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
            ])
            ->add('nbHeure', NumberType::class, [
                'label' => 'Nombre d\'heure',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BlocEnseignement::class,
        ]);
    }
}