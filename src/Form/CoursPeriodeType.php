<?php
namespace App\Form;

use App\Entity\CoursPeriode;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CoursPeriodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
       $builder
    ->add('dateDebut', DateType::class, [
        'label' => 'Date de début',
        'widget' => 'single_text',  
        'input' => 'datetime',       
        'constraints' => [
            new Assert\NotBlank(),
        ],
    ])
    ->add('dateFin', DateType::class, [
        'label' => 'Date de fin',
        'widget' => 'single_text',
        'input' => 'datetime',       
        'constraints' => [
            new Assert\NotBlank(),
        ],
    ]);
    }
}
