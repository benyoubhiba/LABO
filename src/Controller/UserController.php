<?php

namespace App\Controller;


use App\Form\UserType;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ProxyManager\ProxyGenerator\LazyLoadingGhost\PropertyGenerator\PrivatePropertiesMap;
use ContainerLko0jga\getManagerRegistryAwareConnectionProviderService;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Persistence\ManagerRegistry;
class UserController extends AbstractController
{

Private $userRepository;
public function __construct(UserRepository $userRepository)
{
    $this->userRepository = $userRepository ;
}




    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        $user=$this->userRepository->findAll();

        return $this->render('user/index.html.twig',[
        "user"=>$user
        ]
        );     
    }

/**
     * @Route("/user/{id}", name="user_show")
     */
    public function showUser($id)
    {
        $user=$this->userRepository->find($id);
        return $this->render('user/show.html.twig',[
        "user"=>$user
        ]
        );    
    }
/**
     * @Route("/create/user", name="user_create")
     */
   
    public function createUser(Request $request,EntityManagerInterface $entityManager )
    {
        
        $user = new User();
    
       
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()){
            $entityManager->persist($user);
            $entityManager->flush();
     $this->addFlash(
         'info',
         'le tag et bien ajouter'

     );
           return $this->redirectToRoute('user');
        
        }
        return $this->renderForm('user/add.html.twig', [
            'form' => $form,
        ]);
         





}
}