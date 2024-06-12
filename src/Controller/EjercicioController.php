<?php

namespace App\Controller;

use App\Entity\Ejercicio;
use App\Entity\RegistroEjercicio;
use App\Form\RegistroEjercicioType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class EjercicioController extends AbstractController
{
    private $entityManager;
    private $security;

    // Constructor del controlador
    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    // Ruta para el registro de un nuevo ejercicio
    #[Route('/registro-ejercicio', name: 'registro_ejercicio')]
    public function registroEjercicio(Request $request): Response
    {
        // Obtiene todos los ejercicios disponibles
        $ejercicios = $this->entityManager->getRepository(Ejercicio::class)->findAll();
    
        // Crea una nueva instancia de RegistroEjercicio y establece la fecha actual
        $registroEjercicio = new RegistroEjercicio();
        $registroEjercicio->setFecha(new \DateTime()); 
    
        // Obtiene el usuario actual
        $usuario = $this->security->getUser();
        $registroEjercicio->setUsuario($usuario);
    
        // Crea el formulario de registro de ejercicio
        $form = $this->createForm(RegistroEjercicioType::class, $registroEjercicio);
    
        // Maneja el envío del formulario
        $form->handleRequest($request);
    
        // Si el formulario es enviado y es válido
        if ($form->isSubmitted() && $form->isValid()) {
            // Persiste el registro del ejercicio en la base de datos
            $this->entityManager->persist($registroEjercicio);
            $this->entityManager->flush();
    
            // Calcula las calorías quemadas
            $duracionMinutos = $registroEjercicio->getDuracionMinutos();
            $ejercicio = $registroEjercicio->getEjercicio();
            $caloriasPorMinuto = $ejercicio->getCaloriasPorMinuto();
            $caloriasQuemadas = $duracionMinutos * $caloriasPorMinuto;
    
            // Mensaje flash de éxito
            $this->addFlash('success', 'El ejercicio ha sido registrado exitosamente.');
    
            // Redirige a la página de registro de ejercicio con las calorías quemadas como parámetro
            return $this->redirectToRoute('registro_ejercicio', [
                'caloriasQuemadas' => $caloriasQuemadas, 
            ]);
        }
    
        // Retorna la vista del formulario de registro de ejercicio
        return $this->render('ejercicio/registro_ejercicio.html.twig', [
            'form' => $form->createView(),
            'caloriasQuemadas' => $request->query->getInt('caloriasQuemadas'),
        ]);
    }
}
