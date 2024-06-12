<?php
// Controlador para la gestión de alimentos
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\EdamamFoodDatabaseApiService;
use Symfony\Component\HttpFoundation\JsonResponse;

class FoodController extends AbstractController
{
    private $edamamApiService;

    // Constructor del controlador
    public function __construct(EdamamFoodDatabaseApiService $edamamApiService)
    {
        $this->edamamApiService = $edamamApiService;
    }

    // Ruta para buscar un alimento
    #[Route('/buscar-alimento', name: 'buscar_alimento')]
    public function buscarAlimento(Request $request): Response
    {
        $alimentoInfo = null;
        $alimentoBuscado = $request->query->get('nombreAlimento');
        $cantidad = $request->query->get('cantidad');

        // Si se proporciona un nombre de alimento, buscar información sobre el alimento
        if ($alimentoBuscado) {
            $alimentoInfo = $this->edamamApiService->buscarAlimentoPorPalabraClave($alimentoBuscado);
        }

        // Si se proporciona un nombre de alimento y una cantidad, registrar el alimento
        if ($alimentoBuscado && $cantidad) {
            try {
                $calorias = $this->edamamApiService->consultarCalorias($alimentoBuscado, $cantidad);
                $registroAlimento = new RegistroAlimento();
                $registroAlimento->setNombreAlimento($alimentoBuscado);
                $registroAlimento->setCantidad($cantidad);
                $registroAlimento->setCalorias($calorias);
                $registroAlimento->setUsuario($this->getUser());

                $this->entityManager->persist($registroAlimento);
                $this->entityManager->flush();

                $this->addFlash('success', 'Alimento registrado exitosamente.');
            } catch (\Exception $e) {
                $error = $e->getMessage();
                $this->addFlash('error', $error);
            }
        }

        // Retorna la vista con la información del alimento buscado
        return $this->render('registro_alimento/buscar.html.twig', [
            'alimentoInfo' => $alimentoInfo,
        ]);
    }

    // Ruta para mostrar más información sobre un alimento
    #[Route('/mostrar-mas-informacion', name: 'mostrar_mas_informacion')]
    public function mostrarMasInformacion(Request $request): Response
    {
        $alimentoInfo = null;
        $alimentoBuscado = $request->query->get('nombreAlimento');

        // Si se proporciona un nombre de alimento, buscar información adicional sobre el alimento
        if ($alimentoBuscado) {
            $alimentoInfo = $this->edamamApiService->buscarAlimentoPorPalabraClave($alimentoBuscado);
        }

        // Retorna la vista con la información adicional del alimento
        return $this->render('registro_alimento/mostrar_mas_informacion.html.twig', [
            'alimentoInfo' => $alimentoInfo, 
        ]);
    }

    // Ruta para autocompletar la búsqueda de alimentos
    #[Route('/autocomplete', name: 'autocomplete')]
    public function autocomplete(Request $request): JsonResponse
    {
        $query = $request->query->get('q');

        // Si no se proporciona ninguna consulta, retorna una respuesta vacía
        if (!$query) {
            return new JsonResponse([]);
        }

        // Busca alimentos que coincidan con la consulta y retorna sugerencias
        $resultado = $this->edamamApiService->buscarAlimentoPorPalabraClave($query);
        $sugerencias = array_map(function ($item) {
            return $item['food']['label'];
        }, $resultado['hints']);    

        // Retorna las sugerencias como respuesta JSON
        return new JsonResponse($sugerencias);
    }
}
