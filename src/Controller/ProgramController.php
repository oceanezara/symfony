<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/program", name="program_")
*/

class ProgramController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('program/index.html.twig', [
            'website' => 'Donkey Séries',
         ]);
    }

    /**
    * @Route("/{id<\d+>}",name="show", methods={"GET"})
    */
    public function show(): Response
    {
        return $this->render('program/show.html.twig', ['id'=> 4]);
    }
}
