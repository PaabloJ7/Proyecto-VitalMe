<?php


namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObjetivoCaloriasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('objetivo', ChoiceType::class, [
                'label' => 'Selecciona tu objetivo de calorías:',
                'choices' => [
                    'Mantenimiento' => 'mantenimiento',
                    'Superávit' => 'superavit',
                    'Déficit' => 'deficit',
                ],
                'expanded' => true, 
                'multiple' => false, 
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
        ]);
    }
}
