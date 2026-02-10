<?php

namespace App\Form;

use App\Entity\AnneeScolaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Form\Extension\Core\Type\DateType;

class AnneeScolaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {


        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de l’année scolaire',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['max' => 255]),
                ],
            ])
            ->add('dateDebut', DateType::class, [
                'label' => 'Date de début',
                'widget' => 'single_text',
                'constraints' => [
                    new Assert\NotNull(),
                ],
            ])
            ->add('dateFin', DateType::class, [
                'label' => 'Date de fin',
                'widget' => 'single_text',
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\GreaterThan([
                        'propertyPath' => 'parent.all[dateDebut].data',
                        'message' => 'La date de fin doit être après la date de début',
                    ]),
                ],
            ]);
    }
}
