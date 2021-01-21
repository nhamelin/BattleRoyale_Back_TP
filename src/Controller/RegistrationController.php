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
        if(!isset($content['email'], $content['password'])) {
            return new Response('', 400);
        }
        $user = new User();
        $user->setEmail($content['email']);
        $user->setName($content['name']);
        $user->setFirstname($content['firstname']);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $content['password']));
        $em = $this->getDoctrine()->getManager();
        if($em->getRepository(User::class)->findOneBy(['email' => $user->getEmail()])) {
            return new Response('', 409);
        }
        $em->persist($user);
        $em->flush();

        return new Response();
    }
    /**
     * @Route("/api/getCurrentUser", name="CurrentUser", methods="get")
     */
     public function getCurrentUser(){
        $userId = $this->getUser()->getId();
        return new Response($userId, '200');

     }


}