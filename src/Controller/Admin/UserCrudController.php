<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use  EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    
public function configureActions(Actions $actions): Actions
{
return $actions
->add(Crud::PAGE_INDEX,Action::DETAIL)
->update (Crud::PAGE_INDEX,Action::NEW,function(Action $action){
    return $action->setIcon('fa fa-user');
    })
 ->update (Crud::PAGE_INDEX,Action::EDIT,function(Action $action){
        return $action->setIcon('fa fa-edit');
        })
 ->update (Crud::PAGE_INDEX,Action::DETAIL,function(Action $action){
            return $action->setIcon('fa fa-eye');
            })
 ->update (Crud::PAGE_INDEX,Action::DELETE,function(Action $action){
                return $action->setIcon('fa fa-trash');
                });

}
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('username'),
            TextField::new('cin'),
             EmailField::new('email'),
            TextField::new('password')->hideOnIndex(),
           
            
        ];
    }
    
}
