<?php

namespace App\Controller\Admin;

use App\Entity\Usuarios;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;


class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // Obtiene el correo electrónico del usuario actual
        $userEmail = $this->getUser()->getEmail();

        // Verifica si el usuario es el administrador
        if ('admin@admin.com' !== $userEmail) {
          
            return $this->render('error/admin_access_denied.html.twig');
        }

        // Si es el administrador, redirige a la página de administración de usuarios
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UsuariosCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('VitalMe');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home', 'homepage');
        yield MenuItem::section('Usuarios');
        yield MenuItem::linkToCrud('Usuarios', 'fas fa-user', Usuarios::class);

    }
}