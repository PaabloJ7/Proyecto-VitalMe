<?php
namespace App\Form;

use App\Entity\Ejercicio;
use App\Entity\RegistroEjercicio;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RegistroEjercicioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('ejercicio', EntityType::class, [
            'class' => 'App\Entity\Ejercicio',
            'choice_label' => 'nombre',
            'multiple' => false, 
            'expanded' => false, 
        ])
            ->add('duracionMinutos', IntegerType::class, [
                'attr' => ['min' => 1],
        
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RegistroEjercicio::class,
        ]);
    }
}
