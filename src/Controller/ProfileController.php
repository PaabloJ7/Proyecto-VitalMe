<?php

// Controlador para la gestión de perfil de usuario
namespace App\Controller;

use App\Entity\Usuarios;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProfileController extends AbstractController
{
    // Ruta para la página de perfil de usuario
    #[Route('/perfil', name: 'app_profile')]
    public function index(Request $request, EntityManagerInterface $entityManager, UserInterface $user): Response
    {
        // Obtiene el usuario actual
        $usuario = $user;

        // Crea el formulario de edición de perfil
        $form = $this->createFormBuilder($usuario)
            ->add('username', TextType::class, ['label' => 'Nombre de usuario'])
            ->add('email', TextType::class, ['label' => 'Email'])
            ->add('genero', ChoiceType::class, [
                'choices' => [
                    'Masculino' => 'masculino',
                    'Femenimo' => 'femenino',
                ],
                'label' => 'Género',
            ])
            ->add('altura', IntegerType::class, ['label' => 'Altura (cm)'])
            ->add('peso', IntegerType::class, ['label' => 'Peso (kg)'])
            ->add('edad', IntegerType::class, ['label' => 'Edad'])
            ->add('intensidadFisica', ChoiceType::class, [
                'choices' => [
                    'Sedentario' => 'sedentario',       
                    'Actividad ligera' => 'actividad ligera',
                    'Activo' => 'activo',
                    'Muy activo' => 'muy activo',
                ],
                'label' => 'Intensidad Física',
            ])
            ->add('save', SubmitType::class, ['label' => 'Guardar Cambios'])
            ->getForm();

        // Maneja la solicitud del formulario
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                // Guarda los cambios en la base de datos
                $entityManager->persist($usuario);
                $entityManager->flush();

                // Establece un mensaje flash de éxito
                $this->addFlash('success', 'Perfil actualizado correctamente');
            } catch (\Exception $e) {
                // Si ocurre un error, establece un mensaje flash de error
                $this->addFlash('error', 'Error al actualizar el perfil');
            }

            // Redirige nuevamente a la página de perfil
            return $this->redirectToRoute('app_profile');
        }

        // Renderiza la plantilla del perfil con el formulario
        return $this->render('perfil/perfil.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
