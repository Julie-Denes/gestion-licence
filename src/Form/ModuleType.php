<?php

namespace App\Form;

use App\Entity\Module;
use App\Entity\BlocEnseignement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class, [
                'label' => 'Code du module',
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom du module',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
            ])
            ->add('nbHeure', NumberType::class, [
                'label' => 'Nombre d\'heures',
            ])
            ->add('projetFilRouge', CheckboxType::class, [
                'label' => 'Projet fil rouge ?',
                'required' => false,
            ])
            ->add('blocEnseignement', EntityType::class, [
                'class' => BlocEnseignement::class,
                'choice_label' => 'nom',
                'label' => 'Bloc d\'enseignement',
                'placeholder' => 'Sélectionnez un bloc',
            ])
            ->add('parent', EntityType::class, [
                'class' => Module::class,
                'choice_label' => function (Module $module) {
                    return $module->getCode() . ' - ' . $module->getNom();
                },
                'label' => 'Module parent (facultatif)',
                'placeholder' => 'Aucun parent',
                'required' => false,
                // on évite qu’un module soit parent de lui-même
                'query_builder' => function ($repo) use ($options) {
                    $qb = $repo->createQueryBuilder('m')
                        ->orderBy('m.code', 'ASC');

                    if (!empty($options['data']) && $options['data']->getId() !== null) {
                        $qb->andWhere('m.id != :current')
                        ->setParameter('current', $options['data']->getId());
                    }

                    return $qb;
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Module::class,
        ]);
    }
}
