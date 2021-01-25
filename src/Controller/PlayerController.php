<?php

namespace App\Controller;

use App\Entity\Player;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlayerController extends AbstractController
{

    /**
     * @Route("/api/player-from-game/{game_id}")
     */
    public function getFromGame(Request $request, $game_id)
    {
        if($player = $this->getDoctrine()->getRepository(Player::class)->findOneBy(['game' => $game_id])) {
            return new Response($player->getId(), 200);
        }
        return new Response('', 500);
    }
}