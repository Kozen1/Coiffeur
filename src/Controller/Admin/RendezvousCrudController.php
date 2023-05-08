<?php

namespace App\Controller\Admin;

use App\Entity\Rendezvous;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RendezvousCrudController extends AbstractCrudController {
    public static function getEntityFqcn(): string {
        return Rendezvous::class;
    }

    public function configureFields( string $pageName ): iterable {
        return [
            IdField::new( 'id' )->hideOnForm(),
            DateField::new('date', 'Date du rendez-vous')->setFormat('dd/MM/yyyy'),
            TimeField::new('time', 'Heure du rendez-vous')->setFormat('HH:mm'),
            AssociationField::new('employe'),
            AssociationField::new('user'),
            AssociationField::new('prestations'),
        ];
    }

}
