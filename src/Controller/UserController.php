<?php

namespace App\Controller;

use Symfony\Component\Security\Core\Security;
use App\Form\UserType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
use App\Repository\ProduitRepository;
use App\Repository\FactureRepository;
use App\Repository\StockRepository;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Config\Definition\Exception\Exception;
class UserController extends AbstractController
{

Private $userRepository;
public function __construct(UserRepository $userRepository)
{
    $this->userRepository = $userRepository ;
}
     /**
     * @Route("/user", name="user")
     *  @Route("/create/user", name="user_create") 
     */
    public function form(user $user = null,Request $request,EntityManagerInterface $entityManager)
    {
        $users=$this->userRepository->findAll(); 
     
        if(!$user){
            $user = new User();
        }

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

    
        return $this->render('user/index.html.twig',[
            "user"=>$users,
            'form'  => $form->createView()
            ,
             ] 
            );  
           
}
/**
     * @Route("/edit/user{id}", name="user_edit")
     */
   
    public function editUser(User $user ,Request $request,EntityManagerInterface $entityManager )
    {

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
        return $this->renderForm('user/edit.html.twig', [
            'form' => $form,
        ]);
         


}

/** 
 *  @Route("/getInfouser/{id}")
*/

public function getInfoExperience($id,EntityManagerInterface $em){
   try {
       $data = $this->em->find(Section::class,$id);

       return $this->json($data,Response::HTTP_OK);
   }catch(Exception $ex){
       return $this->json("error j",Response::HTTP_BAD_REQUEST);
   }
}

/**
 *  @Route("/modifieruser")
 */

public function modifieruser(Request $request ,EntityManagerInterface $em){
   try {
       $data = json_decode($request->getContent());
       $exp = $this->em->find(Section::class,(int)$data->id);
       $exp->setcin($data->cin);
       $exp->setusername($data->username);
       $this->em->persist($exp);
       $this->em->flush();

       return $this->json("modifier success",Response::HTTP_OK);
   }catch(Exception $ex){
       return $this->json($ex,Response::HTTP_BAD_REQUEST);
   }
}

/**
     * @Route("/user/{id}", name="user_show")
     */
    public function showUser($id)
    {
        $user=$this->userRepository->find($id);
        return $this->render('user/index.html.twig',[
        "user"=>$user
        ]
        );    
    }

/**
     * @Route("/delete/user{id}", name="user_delete")
     */
   
    public function deleteUser(User $user ,EntityManagerInterface $entityManager )
    {  
     $entityManager->remove($user);
    $entityManager->flush();
     $this->addFlash(
         'info',
         'le tag et bien ajouter'

     );
           return $this->redirectToRoute('user');
        
        }


}





