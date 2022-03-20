<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\DBAL\Driver\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CRUDController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("crudIndex", name="crudIndex")
     */
    public function crudIndex()
    {
        $users = $this->em->getRepository(User::class)->getAllUsers();

        return $this->render('crud/index.html.twig',["users"=>$users]);
    }

    /**
     * @Route("getInfoUser/{id}", name="getInfoUser")
     */
    public function getInfoUser($id)
    {
        try{

            $user = $this->em->getRepository(User::class)->getOneUser((int)$id);

            return $this->json($user[0],Response::HTTP_OK);
        }catch(Exception $ex){
            return $this->json($ex->getMessage(),Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("codeEditUser", name="codeEditUser")
     */
    public function codeEditUser(Request $request)
    {
        try{
            $data = json_decode($request->getContent());

            $user = $this->em->find(User::class,(int)$data->id);
            $user->setUsername($data->username);
            $user->setEmail($data->email);
            $user->setCin($data->cin);
            $user->setPhone($data->phone);
            $user->setRoles([$data->role]);
            $user->setIsVerified($data->verified);

            $this->em->persist($user);
            $this->em->flush();

            return $this->json("success",Response::HTTP_OK);
        }catch(Exception $ex){
            return $this->json($ex->getMessage(),Response::HTTP_BAD_REQUEST);
        }
    }
}
