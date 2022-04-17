<?php

namespace App\Form;

use App\Entity\Chantier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChantierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('nom', TextType::class, ['attr' => ['class' => 'form-control'],'error_bubbling' => true]);
        $builder->add('adresse', TextType::class, ['attr' => ['class' => 'form-control'],'error_bubbling' => true]);
        $builder->add('dateDebut', DateType::class,[
            'widget'=>'single_text',
            'required'=>true,
            'constraints' => [
                new NotBlank()],
            'attr' => ['class' => 'form-control'],
            'error_bubbling' => true]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chantier::class,
        ]);
    }
}
