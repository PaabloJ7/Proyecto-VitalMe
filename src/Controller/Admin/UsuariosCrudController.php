<?php

namespace App\Controller\Admin;

use App\Entity\Usuarios;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;



class UsuariosCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
{
    return Usuarios::class;
}

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::DELETE);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['nombre', 'email']);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('Usuario'));
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('username'),
            EmailField::new('email'),
            ChoiceField::new('genero')->setChoices(['Masculino' => 'Masculino', 'Femenino' => 'Femenino']),
            IntegerField::new('altura'),
            IntegerField::new('objetivoCalorias')
        ];
    }

    
}
