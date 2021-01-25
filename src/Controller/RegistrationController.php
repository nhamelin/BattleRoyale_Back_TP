<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class RegistrationController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/api/sign-up", name="register", methods="post")
     */
    public function register(Request $request)
    {
        
        $content = json_decode($request->getContent(), true);
        if(!isset($content['email'], $content['pseudo'], $content['password'])) {
            return new Response('', 400);
        }
        $user = new User();
        $user->setEmail($content['email']);
        $user->setPseudo($content['pseudo']);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $content['password']));
        $em = $this->getDoctrine()->getManager();
        if($em->getRepository(User::class)->findOneBy(['email' => $user->getEmail()]) || $em->getRepository(User::class)->findOneBy(['pseudo' => $user->getPseudo()])) {
            return new Response('', 409);
        }
        $em->persist($user);
        $em->flush();

        return new Response('', 200, ['Access-Control-Allow-Origin' => '*']);
    }

    /**
     * @Route("/api/current-user", name="CurrentUser", methods="get")
     */
     public function getCurrentUser(){
        $userId = $this->getUser()->getId();
        return new Response($userId, '200');

     }

     
    /**
     * @Route("/api/update-password/{id}", name="registerUpdate", methods="put")
     */
    public function registerUpdate(Request $request, $id)
    {

        $content = json_decode($request->getContent(), true);
        if(!isset($content['password'])) {
            return new Response('', 400);
        }
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        if ($user) {
            $user->setPassword($this->passwordEncoder->encodePassword($user, $content['password']));
            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }
        return new Response();
    }
}