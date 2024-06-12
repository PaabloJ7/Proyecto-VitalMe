<?php

// Controlador para la gestión de la comunidad
namespace App\Controller;

use App\Entity\Publicacion;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use DateTime;

class ComunidadController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    // Constructor del controlador
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // Ruta para la página principal de la comunidad
    #[Route('/comunidad', name: 'comunidad')]
    public function index(): Response
    {
        // Obtiene las publicaciones destacadas
        $destacadas = $this->entityManager->getRepository(Publicacion::class)->findDestacadasOrderByLikes(6); 

        // Obtiene las últimas publicaciones
        $publicaciones = $this->entityManager->getRepository(Publicacion::class)->findLatest(5);

        // Retorna la vista con las publicaciones
        return $this->render('comunidad/index.html.twig', [
            'destacadas' => $destacadas,
            'publicaciones' => $publicaciones,
        ]);
    }

    // Ruta para publicar una nueva publicación
    #[Route('/publicar', name: 'publicar', methods: ['POST'])]
    public function publicar(Request $request): Response
    {
        // Obtener el contenido de la publicación del formulario
        $contenido = $request->request->get('contenido');
    
        // Verifica que el contenido no esté vacío
        if (empty($contenido)) {
            $this->addFlash('error', 'El contenido de la publicación no puede estar vacío.');
            return $this->redirectToRoute('comunidad');
        }
    
        // Crea una nueva instancia de la entidad Publicacion
        $publicacion = new Publicacion();
        $publicacion->setContenido($contenido);
        $publicacion->setCreatedAt(new DateTime());
        $publicacion->setUsuario($this->getUser());
    
        // Guarda la nueva publicación en la base de datos
        $this->entityManager->persist($publicacion);
        $this->entityManager->flush();
    
        // Redirige con un mensaje de éxito
        $this->addFlash('success', '¡Publicación creada exitosamente!');
        return $this->redirectToRoute('comunidad');
    }

    // Ruta para dar "Me gusta" a una publicación
    #[Route('/like/{id}', name: 'like')]
    public function like(int $id): Response
    {
        // Obtiene la publicación por su ID
        $publicacion = $this->entityManager->getRepository(Publicacion::class)->find($id);

        // Verifica si la publicación existe
        if (!$publicacion) {
            throw $this->createNotFoundException('La publicación no existe');
        }

        // Verifica si el usuario ha iniciado sesión
        $usuario = $this->getUser();
        if (!$usuario) {
            throw new AccessDeniedException('Debes iniciar sesión para dar "Me gusta"');
        }

        // Incrementa los "Me gusta" en la publicación
        $publicacion->incrementLikes();
        $this->entityManager->flush();

        // Redirige de vuelta a la comunidad
        return $this->redirectToRoute('comunidad');
    }

    // Ruta para buscar publicaciones por una consulta
    #[Route('/buscar', name: 'buscar')]
    public function buscar(Request $request): Response
    {
        // Obtiene la consulta de búsqueda
        $query = $request->query->get('query');

        // Busca las publicaciones según la consulta
        $publicaciones = $this->entityManager->getRepository(Publicacion::class)->buscarPublicaciones($query);

        // Prepara los datos de las publicaciones para la respuesta JSON
        $data = [];
        foreach ($publicaciones as $publicacion) {
            $data[] = [
                'id' => $publicacion->getId(),
                'usuario' => $publicacion->getUsuario()->getUsername(),
                'contenido' => $publicacion->getContenido(),
                'fecha' => $publicacion->getCreatedAt()->format('d/m/Y H:i'),
                'likes' => $publicacion->getLikes(),
            ];
        }

        // Retorna la respuesta JSON con los datos de las publicaciones encontradas
        return new JsonResponse($data);
    }
}
