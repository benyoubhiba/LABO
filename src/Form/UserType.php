<?php

namespace App\Form;
use App\Entity\User;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;                                        
use EasyCorp\Bundle\EasyAdminBundle\Form\Type  ;                
 use Symfony\Component\Form\ChoiceList\ChoiceList;
 use Symfony\Component\Form\Extension\Core\Type\HiddenType;
 use Symfony\Component\OptionsResolver\OptionsResolverInterface;
 use Symfony\Component\OptionsResolver\OptionsResolver;
 use Symfony\Component\Validator\Constraints\Length;
class UserType extends AbstractType
{
     
    public function buildForm(FormBuilderInterface $builder, array $form): void
    {
      
        {
           $builder
           ->add('username', TextType::class)
           ->add('email', TextType::class)
           ->add('cin', TextType::class)
           ->add('password', TextType::class)  ->add('save', SubmitType::class, ['label' => 'Valider']);
         
          
        }
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            
        ]);
    }
}