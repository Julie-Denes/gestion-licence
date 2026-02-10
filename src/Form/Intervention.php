<?php 
namespace App\Form;

use App\Entity\Intervention;
use App\Entity\Module;
use App\Entity\TypeIntervention;
use App\Entity\CorpsEnseignant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;


class InterventionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDebut', DateTimeType::class, [
                'label' => 'Date de début',
                'widget' => 'single_text',
            ])
            ->add('dateFin', DateTimeType::class, [
                'label' => 'Date de fin',
                'widget' => 'single_text',
            ])
            ->add('titre', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Length(max: 255, maxMessage: 'Le titre ne peut pas dépasser {{ limit }} caractères.'),
                ]
            ])
            ->add('module', EntityType::class, [
                'class' => Module::class,
                'choice_label' => 'nom',
                'placeholder' => 'Choisir un module'
            ])
            ->add('typeIntervention', EntityType::class, [
                'class' => TypeIntervention::class,
                'choice_label' => 'nom',
            ])
            ->add('corpsEnseignants', EntityType::class, [
                'class' => CorpsEnseignant::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => false,
            ])
            ->add('visio', CheckboxType::class, [
                'required' => false,
                'label' => 'Intervention en visio'
            ]);
    }
}
