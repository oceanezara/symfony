<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EpisodeContrllerController extends AbstractController
{
    #[Route('/episode/contrller', name: 'episode_contrller')]
    public function index(): Response
    {
        return $this->render('episode_contrller/index.html.twig', [
            'controller_name' => 'EpisodeContrllerController',
        ]);
    }
}
