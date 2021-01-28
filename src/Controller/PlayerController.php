<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Player;
use App\Repository\GameRepository;
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

    /**
     * @Route("/api/current-player-game/{game_id}")
     */
    public function getCurrentPlayerOfGame(Request $request, $game_id, GameRepository $gameRepository) {
        $game = $gameRepository->find($game_id);
        if($game) {
            $lastPlayer = $game->getLastPlayer();
            if($lastPlayer) {
                $orderLastPlayer = $lastPlayer->getId();
                $players = $game->getPlayers();
                $nextPlayers = [];
                foreach ($players as $player) {
                    if($player->getId() > $orderLastPlayer) {
                        $nextPlayers[$player->getId()] = $player;
                    }
                }
                $nextPlayer = $nextPlayers && isset($nextPlayers[min(array_keys($nextPlayers))]) ? $nextPlayers[min(array_keys($nextPlayers))] : $game->getOwner()->getId();
                return New Response($nextPlayer->getUser()->getId());
            }
            return new Response($game->getOwner()->getId());
        }
        return new Response('no game found', 500);
    }
}