<?php 
 
namespace App\Controller; 
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; 
use Symfony\Component\HttpFoundation\Response; 
use Symfony\Component\Routing\Attribute\Route;
 
#[Route("/")] 
class test extends AbstractController 
{ 
    #[Route("/accueil", name: "home")] 
    public function home(): Response 
    { 
        return $this->render('test.html.twig'); 
    }
}