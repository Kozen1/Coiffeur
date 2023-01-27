<?php

namespace App\Controller\Admin;

use App\Entity\Type;
use App\Entity\Employe;
use App\Entity\Prestations;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use App\Controller\Admin\PrestationsCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {

    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator
            ->setController(PrestationsCrudController::class)
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Coiffeur - Administration');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('L\'atelier du barbier');

        yield MenuItem::section('Prestations');

        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Add prestations', 'fas fa-plus', Prestations::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show prestations', 'fas fa-eye', Prestations::class)
        ]);

        yield MenuItem::section('Type');

        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Add Type', 'fas fa-plus', Type::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show Type', 'fas fa-eye', Type::class)
        ]);

        yield MenuItem::section('Employe');

        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Add Employe', 'fas fa-plus', Employe::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show Employe', 'fas fa-eye', Employe::class)
        ]);
        
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
