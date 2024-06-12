<?php
// Controlador para la página de inicio
namespace App\Controller;

use App\Entity\Usuarios;
use App\Form\ObjetivoCaloriasType;
use App\Repository\RegistroAlimentoRepository;
use App\Repository\RegistroEjercicioRepository;
use App\Repository\UsuariosRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormView;

class HomeController extends AbstractController
{
    // Ruta para la página de inicio
    #[Route('/home', name: 'app_home')]
    public function index(
        Request $request,
        RegistroAlimentoRepository $registroAlimentoRepository,
        RegistroEjercicioRepository $registroEjercicioRepository,
        UsuariosRepository $usuariosRepository
    ): Response {
        // Obtiene el usuario actual
        $usuario = $this->getUser();
    
        // Obtiene la fecha de hoy
        $hoy = new DateTime();
        
        // Busca los registros de alimentos del usuario para hoy
        $registrosHoy = $registroAlimentoRepository->findByDateAndUser($usuario, $hoy);
        
        // Busca los registros de ejercicio del usuario para hoy
        $registrosEjercicioHoy = $registroEjercicioRepository->findByDateAndUser($usuario, $hoy);
        
        // Calcula el total de calorías consumidas hoy
        $totalCaloriasHoy = 0;
        foreach ($registrosHoy as $registro) {
            $totalCaloriasHoy += $registro->getCalorias();
        }

        // Calcula el total de calorías quemadas hoy
        $totalCaloriasQuemadasHoy = 0;
        foreach ($registrosEjercicioHoy as $registroEjercicio) {
            $totalCaloriasQuemadasHoy += $registroEjercicio->getDuracionMinutos() * $registroEjercicio->getEjercicio()->getCaloriasPorMinuto();
        }

        // Calcula el balance neto de calorías hoy
        $caloriasNetasHoy = $totalCaloriasHoy - $totalCaloriasQuemadasHoy;

        // Obtiene los datos del objetivo de calorías del usuario
        $caloriasDeficitUsuario = $usuario->getCaloriasDeficit();
        $mantenimientoUsuario = $usuario->getCaloriasMantenimiento();
        $superavitUsuario = $usuario->getCaloriasSuperavit();
        $caloriasObjetivoUsuario = $usuario->getObjetivoCalorias();

        // Retorna la vista con los datos necesarios
        return $this->render('home/prueba.html.twig', [
            'registros' => $registrosHoy,
            'totalCalorias' => $totalCaloriasHoy,
            'caloriasQuemadas' => $totalCaloriasQuemadasHoy,
            'caloriasNetas' => $caloriasNetasHoy,
            'caloriasDeficit' => $caloriasDeficitUsuario,
            'caloriasObjetivo' => $caloriasObjetivoUsuario,
            'mantenimiento' => $mantenimientoUsuario,
            'superavit' => $superavitUsuario,
            'registrosEjercicio' => $registrosEjercicioHoy,
        ]);
    }
}
