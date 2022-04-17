<?php

    namespace App\Form;

    use App\Entity\Chantier;
    use App\Entity\Pointage;
    use App\Entity\Utilisateur;
    use Symfony\Bridge\Doctrine\Form\Type\EntityType;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\DateType;
    use Symfony\Component\Form\Extension\Core\Type\NumberType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;
    use Symfony\Component\Validator\Constraints\NotBlank;

    class PointageType extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options): void
        {
            $builder
                ->add('date', DateType::class, [
                        'widget' => 'single_text',
                        'attr' => ['class' => 'form-control'],
                        'required' => true,
                        'constraints' => [new NotBlank()],
                        'error_bubbling' => true
                    ]
                )
                ->add('duree', NumberType::class, ['attr' => ['class' => 'form-control'],'error_bubbling' => true])
                ->add('utilisateur', EntityType::class, [
                    'class' => Utilisateur::class,
                    'placeholder' => 'Sélectionner un utilisateur',
                    'attr' => ['class' => 'form-control'],
                    'error_bubbling' => true
                ])
                ->add('chantier', EntityType::class, [
                    'class' => Chantier::class,
                    'placeholder' => 'Sélectionner un chantier',
                    'attr' => ['class' => 'form-control'],
                    'error_bubbling' => true
                ]);
        }


        public function configureOptions(OptionsResolver $resolver): void
        {
            $resolver->setDefaults([
                'data_class' => Pointage::class,
            ]);
        }


    }
