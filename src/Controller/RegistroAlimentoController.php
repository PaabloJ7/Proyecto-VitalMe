<?php

// Controlador para la gestión de registros de alimentos
namespace App\Controller;

use App\Entity\RegistroAlimento;
use App\Form\RegistroAlimentoFormType;
use App\Service\EdamamFoodDatabaseApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpClient\HttpClient;

class RegistroAlimentoController extends AbstractController
{
    private $entityManager;
    private $edamamApi;
    private $httpClient;

    public function __construct(EntityManagerInterface $entityManager, EdamamFoodDatabaseApiService $edamamApi)
    {
        $this->entityManager = $entityManager;
        $this->edamamApi = $edamamApi;
        $this->httpClient = HttpClient::create();
    }

    // Ruta para buscar información sobre un alimento
    #[Route('/buscar-alimento', name: 'buscar_alimento')]
    public function buscarAlimento(Request $request): Response
    {
        // Inicializa la información del alimento como nula
        $alimentoInfo = null;
        $alimentoBuscado = $request->query->get('nombreAlimento');
        $cantidad = $request->query->get('cantidad');

        // Busca información sobre el alimento
        if ($alimentoBuscado) {
            $alimentoInfo = $this->edamamApi->buscarAlimentoPorPalabraClave($alimentoBuscado);
        }

        // Registra el alimento si se proporciona la cantidad
        if ($alimentoBuscado && $cantidad) {
            try {
                $calorias = $this->edamamApi->consultarCalorias($alimentoBuscado, $cantidad);
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

        // Renderiza la plantilla de búsqueda de alimentos con la información obtenida
        return $this->render('registro_alimento/buscar.html.twig', [
            'alimentoInfo' => $alimentoInfo,
        ]);
    }

    // Método para proporcionar sugerencias de autocompletado para la búsqueda de alimentos
    public function autocomplete(Request $request): JsonResponse
    {
        $query = $request->query->get('q');

        // Realiza una solicitud HTTP para obtener sugerencias de autocompletado desde la API de Edamam
        $url = 'https://api.edamam.com/auto-complete';
        $response = $this->httpClient->request('GET', $url, [
            'query' => [
                'app_id' => '1fa1656f',
                'app_key' => '4e1b7ae7b93a9531743412a735586015',
                'q' => $query,
                'limit' => 5 
            ]
        ]);

        // Decodifica la respuesta JSON y devuelve las sugerencias como una respuesta JSON
        $data = json_decode($response->getContent(), true);

        return new JsonResponse($data);
    }
}
