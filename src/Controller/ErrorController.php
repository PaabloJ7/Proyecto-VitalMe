<?php
// src/Controller/ErrorController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
   
     #[Route("/error", name: "error")]
     
    public function showError(): Response
    {
        return $this->render('error/error404.html.twig');
    }
}
