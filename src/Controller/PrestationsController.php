<?php

namespace App\Controller;

use App\Entity\Prestations;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PrestationsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PrestationsController extends AbstractController
{
    #[Route('/prestations', name: 'app_prestations')]  
    public function index(PrestationsRepository $prestationsRepository): Response
    {
        $error_message = "";
        $cheveux = array();
        $barbe = array();
        $forfaits = array();
        $techniques = array();

        $cheveux = $prestationsRepository->findBy(['type' => '1']);
        $barbe = $prestationsRepository->findBy(['type' => '2']);
        $forfaits = $prestationsRepository->findBy(['type' => '3']);
        $techniques = $prestationsRepository->findBy(['type' => '4']);
        
        
        return $this->render('prestations/index.html.twig', [       
            'cheveux' => $cheveux,
            'barbe' => $barbe,
            'forfaits' => $forfaits,
            'techniques' => $techniques,
            'error_message' => $error_message,
        ]);
    }
}
