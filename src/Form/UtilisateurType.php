<?php

    namespace App\Form;

    use App\Entity\Utilisateur;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;

    class UtilisateurType extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options)
        {

            $builder->add('nom', TextType::class, ['attr' => ['class' => 'form-control'],'error_bubbling' => true]);
            $builder->add('prenom', TextType::class, ['attr' => ['class' => 'form-control'],'error_bubbling' => true]);
            $builder->add('matricule', TextType::class, ['attr' => ['class' => 'form-control'],'error_bubbling' => true]);
        }

        public function configureOptions(OptionsResolver $resolver)
        {
            $resolver->setDefaults(
                [
                    'data_class' =>Utilisateur::class,
                ]
            );
        }
    }
