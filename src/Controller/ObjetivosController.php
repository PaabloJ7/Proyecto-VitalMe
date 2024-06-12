<?php

// Controlador para la gestión de objetivos
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Usuarios;

class ObjetivosController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    // Constructor del controlador
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    // Ruta para la página de objetivos
    #[Route('/objetivos', name: 'app_objetivos')]
    public function index(Request $request): Response
    {
        // Obtiene el usuario actual
        $usuario = $this->getUser();
        // Obtiene el último peso registrado del usuario
        $ultimoPeso = $usuario->getLastWeight();
        
        $caloriasObjetivo = null; 
        
        // Si no se encuentra ningún registro de peso para el usuario, muestra un mensaje de error
        if ($ultimoPeso === null) {
            throw $this->createNotFoundException('No se encontraron registros de peso para este usuario.');
        }
        
        // Si se envió el formulario, actualiza las calorías objetivo
        if ($request->isMethod('POST')) {
            $caloriasObjetivo = $request->request->get('objetivo_calorias');
            $usuario->setObjetivoCalorias($caloriasObjetivo);
            $this->entityManager->flush();
        
            // Establecer un mensaje flash exitoso
            $this->addFlash('success', sprintf('¡Tu objetivo de calorías ha sido actualizado a %s!', $caloriasObjetivo));
        }
        
        // Calcula las calorías necesarias según el objetivo y muestra la página
        $caloriasDeficit = $this->calcularCaloriasNecesarias($usuario, 'deficit', $ultimoPeso);
        $caloriasMantenimiento = $this->calcularCaloriasNecesarias($usuario, 'mantenimiento', $ultimoPeso);
        $caloriasSuperavit = $this->calcularCaloriasNecesarias($usuario, 'superavit', $ultimoPeso);
        
        // Guardar las calorías en la base de datos
        $this->guardarCalorias($usuario, $caloriasDeficit, $caloriasMantenimiento, $caloriasSuperavit);
        
        // Retorna la vista con los datos necesarios
        return $this->render('objetivos/index.html.twig', [
            'caloriasDeficit' => $caloriasDeficit,
            'caloriasMantenimiento' => $caloriasMantenimiento,
            'caloriasSuperavit' => $caloriasSuperavit,
            'caloriasObjetivo' => $caloriasObjetivo,
        ]);
    }

    // Método para calcular las calorías necesarias según el objetivo
    private function calcularCaloriasNecesarias(Usuarios $usuario, string $objetivo, float $ultimoPeso): float
    {
        $edad = $usuario->getEdad();
        $altura = $usuario->getAltura();
        $genero = $usuario->getGenero();
        $intensidadFisica = $usuario->getIntensidadFisica();

        $factorActividadFisica = $this->calcularFactorActividadFisica($intensidadFisica);

        switch ($objetivo) {
            case 'deficit':
                $calorias = $this->calcularCaloriasMantenimiento($edad, $altura, $ultimoPeso, $genero, $factorActividadFisica) - 500;
                break;
            case 'mantenimiento':
                $calorias = $this->calcularCaloriasMantenimiento($edad, $altura, $ultimoPeso, $genero, $factorActividadFisica);
                break;
            case 'superavit':
                $calorias = $this->calcularCaloriasMantenimiento($edad, $altura, $ultimoPeso, $genero, $factorActividadFisica) + 500;
                break;
            default:
                $calorias = 0;
        }

        return round($calorias);
    }

    // Método para calcular el factor de actividad física
    private function calcularFactorActividadFisica(string $intensidadFisica): float
    {
        switch ($intensidadFisica) {
            case 'sedentario':
                return 1.2;
            case 'ligero':
                return 1.375;
            case 'moderado':
                return 1.55;
            case 'activo':
                return 1.725;
            case 'muy_activo':
                return 1.9;
            default:
                return 1.2;
        }
    }

    // Método para calcular las calorías de mantenimiento
    private function calcularCaloriasMantenimiento(int $edad, int $altura, float $peso, string $genero, float $factorActividadFisica): float
    {
        if ($genero === 'masculino') {
            $caloriasMantenimiento = (88.362 + (13.397 * $peso) + (4.799 * $altura) - (5.677 * $edad)) * $factorActividadFisica;
        } elseif ($genero === 'femenino') {
            $caloriasMantenimiento = (447.593 + (9.247 * $peso) + (3.098 * $altura) - (4.330 * $edad)) * $factorActividadFisica;
        } else {
            $caloriasMantenimiento = ((88.362 + (13.397 * $peso) + (4.799 * $altura) - (5.677 * $edad)) +
                (447.593 + (9.247 * $peso) + (3.098 * $altura) - (4.330 * $edad))) / 2 * $factorActividadFisica;
        }

        return round($caloriasMantenimiento);
    }

    // Método para guardar las calorías en la base de datos
    private function guardarCalorias(Usuarios $usuario, float $caloriasDeficit, float $caloriasMantenimiento, float $caloriasSuperavit): void
    {
        $usuario->setCaloriasDeficit($caloriasDeficit);
        $usuario->setCaloriasMantenimiento($caloriasMantenimiento);
        $usuario->setCaloriasSuperavit($caloriasSuperavit);
        $this->entityManager->flush();
    }

    
}
