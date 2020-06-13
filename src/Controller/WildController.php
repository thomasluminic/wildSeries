<?php


namespace App\Controller;


use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Category;
use App\Entity\Season;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class WildController extends AbstractController
{
    /**
     * Show all rows from Program’s entity
     *
     * @Route("/program", name="index")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        if (!$programs) {
            throw $this->createNotFoundException(
                'No program found in program\'s table.'
            );
        }
        return $this->render('Program/all.html.twig', [
            'programs' => $programs,
        ]);
    }

    /**
    * Getting a program with a formatted slug for title
    *
    * @param string $slug The slugger
    * @Route("/show/{slug<^[a-z0-9-]+$>}", defaults={"slug" = null}, name="show")
    * @return Response
    */
    public function show(?string $slug):Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with '.$slug.' title, found in program\'s table.'
            );
        }

        return $this->render('Program/show.html.twig', [
            'program' => $program,
            'slug'  => $slug,
        ]);
    }

    /**
     * Getting a category
     *
     * @param string $categoryName
     * @Route("/category/{categoryName}", name="category")
     * @return Response
     */
    public function showByCategory(string $categoryName): Response
    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name' => $categoryName]);
        if (!$category) {
            throw $this->createNotFoundException(
                'Cette '. $categoryName . 'n\'existe pas'
            );
        }
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(['category' => $category->getId()], ['id' => 'DESC'], 3);

        return $this->render('Category/showByCategory.html.twig', [
            'category' => $category,
            'programs' => $programs,
        ]);
    }
    /**
     * Getting a program
     *
     * @param string $programSlug
     * @Route("/program/{programSlug<[a-z-]+>}", name="program")
     * @return Response
     */
    public function showByProgram($programSlug): Response
    {
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findoneBy(['slug' => $programSlug]);
        return $this->render('Program/show.html.twig', [
            'program' => $program,
        ]);
    }

    /**
     * Getting a season
     *
     * @param int $seasonId
     * @Route("/program/season/{seasonId<^[0-9]+$>}", name="season")
     * @return Response
     */
    public function showBySeason(int $seasonId): Response
    {
        $season = $this->getDoctrine()
            ->getRepository(Season::class)
            ->find($seasonId);
        return $this->render('Season/show.html.twig', [
            'season' => $season,
        ]);
    }

    /**
     * @param Request $request
     * @Route ("/add/category", name="cateogry_add")
     * @return Response
     */
    public function addCategory(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        $message = '';
        if ($form->isSubmitted()) {
            $entityManager = $this->getDoctrine()->getManager();
            $data = $form->getData();
            $entityManager->persist($data);
            $entityManager->flush();
            $message = 'Your category is added ! Well play';
        }
        $allCategory = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();
        return $this->render('Category/add.html.twig', [
            'form' => $form->createView(),
            'message' => $message,
            'categories' => $allCategory,
        ]);
    }

    /**
     * @param string $slug
     * @Route ("/episode/{slug}", name="episode")
     * @return Response
     */
    public function showEpisode(string $slug): Response
    {
        $episode = $this->getDoctrine()
            ->getRepository(Episode::class)
            ->findOneBy(['slug' => $slug]);
        $season = $episode->getSeason();
        $program = $season->getProgram();
        return $this->render('Episode/show.html.twig', [
            'episode' => $episode,
            'season' => $season,
            'program' => $program,
        ]);
    }
}
