<?php
namespace App\Controller;

use App\Entity\RegistroPeso;
use App\Entity\Usuarios;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new Usuarios();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            // Persistir el usuario en la base de datos
            $entityManager->persist($user);
            $entityManager->flush();

            // Crear y persistir el registro de peso inicial
            $registroPeso = new RegistroPeso();
            $registroPeso->setUsuario($user);
            $registroPeso->setFechaPeso(new \DateTime());
            $registroPeso->setPeso($user->getPeso()); // Asume que el peso inicial está siendo capturado en el formulario de registro

            $entityManager->persist($registroPeso);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
