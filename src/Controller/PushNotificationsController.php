<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

class PushNotificationsController extends AbstractController
{
    /**
     * @Route("/push/send-notification/{user_id}", name="pushSend", methods={"POST"})
     */
    public function send($user_id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($user_id);
        $notification = [
            'subscription' => Subscription::create([
                'endpoint' => $user->getPushEndpoint(),
                'contentEncoding' => 'aesgcm'
            ]),
            'payload' => 'hello !',
        ];

        $auth = [
            'VAPID' => [
                'subject' => 'mailto:alexis.brohan@ynov.com', // can be a mailto: or your website address
                'publicKey' => 'BJRMRf9TvqTUBe_vfLODm7rcgUmYRoPN7rfkBwZBAA8nE4OuMNIueaVvXHEGWpwjEo4HxpuZQE834fOU0L9dO5k', // (recommended) uncompressed public key P-256 encoded in Base64-URL
                'privateKey' => 'YDfLCFzm8VvWj6BMbMW5rJ-oJ17LrepxP3mQlGKbarw', // (recommended) in fact the secret multiplier of the private key encoded in Base64-URL
            ],
        ];

        $webPush = new WebPush($auth);

        $report = $webPush->sendOneNotification(
            $notification['subscription'],
            $notification['payload']
        );

        if($report->isSuccess()) {
            return new Response('Success');
        }
        return new Response($report->getReason(), 500);
    }
}
