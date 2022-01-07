<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;
use App\Repository\EpisodeRepository;
use App\Repository\SeasonRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Form\ProgramType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

/**
* @Route("/program", name="program_")
*/

class ProgramController extends AbstractController
{
   
/**
 * Show all rows from Program's entity
 *
 * @Route("/", name="index")
 *
 */

    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();

        return $this->render(
            'program/index.html.twig',
            ['programs' => $programs]
        );
    }

    /**
     * The controller for the category add form
     *
     * @Route("/new", name="new")
     */
    public function new(Request $request, ManagerRegistry $managerRegistry) : Response
    {
        // Create a new Program Object
        $program = new Program();
        // Create the associated Form
        $form = $this->createForm(ProgramType::class, $program);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $managerRegistry->getManager();
            $entityManager->persist($program);
            $entityManager->flush();
            return $this->redirectToRoute('program_index');
        }


        // Render the form
        return $this->render('program/new.html.twig', [
            "form" => $form->createView(),
        ]);
    }


    /**
    * @Route("/{id<\d+>}",name="show", methods={"GET"})
    */

    public function show(Program $program, SeasonRepository $seasonRepository): Response
    {
        $seasons = $seasonRepository->findBy(['program' => $program]);

        return $this->render('program/show.html.twig', [
            'program' => $program,
            'seasons' => $seasons
        ]);
    }

    #[Route('/{programId}/season/{seasonId}', methods: ['get'], requirements: ['programId' => '\d+', 'seasonId' => '\d+'], name: 'season_show')]
    #[Entity('program', expr: 'repository.find(programId)')]
    #[Entity('season', expr: 'repository.find(seasonId)')]
    public function showSeason(Program $program, Season $season, EpisodeRepository $episodeRepository)
    {
        $episodes = $episodeRepository->findBy(['season' => $season]);

        return $this->render('program/season_show.html.twig', [
            'program'   => $program,
            'season'    => $season,
            'episodes'  => $episodes
        ]);
    }

    /**
 * @Route("/{programId}/season/{seasonId}/episode/{episodeId}", name="episode_show")
 * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"programId": "id"}})
 * @ParamConverter("season", class="App\Entity\Season", options={"mapping": {"seasonId": "id"}})
 * @ParamConverter("episode", class="App\Entity\Episode", options={"mapping": {"episodeId": "id"}})
 */
    public function showEpisode(Program $program, Season $season, Episode $episode)
    {
        return $this->render('program/episode_show.html.twig', [
            'program'   => $program,
            'season'    => $season,
            'episode'  => $episode
        ]);
    }
}
