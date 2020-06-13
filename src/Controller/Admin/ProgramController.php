<?php

namespace App\Controller\Admin;

use App\Entity\Program;
use App\Form\ProgramType;
use App\Repository\ProgramRepository;
use App\Service\SlugifyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/program")
 */
class ProgramController extends AbstractController
{
    /**
     * @Route("/", name="program_index")
     */
    public function program(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();
        return $this->render('Admin/program/index.html.twig', [
            'programs' => $programs,
        ]);
    }
    /**
     * @Route("/new", name="program_new", methods={"GET","POST"})
     */
    public function new(Request $request, SlugifyService $slugify): Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $slug = $slugify->generateSlugify($program->getTitle());
            $program->setSlug($slug);
            $entityManager->persist($program);
            $entityManager->flush();

            return $this->redirectToRoute('program_index');
        }

        return $this->render('Admin/program/new.html.twig', [
            'program' => $program,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="program_show", methods={"GET"})
     */
    public function show(Program $program): Response
    {
        return $this->render('program/show.html.twig', [
            'program' => $program,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="program_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Program $program
     * @param SlugifyService $slugify
     * @return Response
     */
    public function edit(Request $request, Program $program, SlugifyService $slugify): Response
    {
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $slug = $slugify->generateSlugify($program->getTitle());
            $program->setSlug($slug);
            $manager->flush();

            return $this->redirectToRoute('program_index');
        }

        return $this->render('Admin/program/edit.html.twig', [
            'program' => $program,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="program_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Program $program): Response
    {
        if ($this->isCsrfTokenValid('delete'.$program->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($program);
            $entityManager->flush();
        }

        return $this->redirectToRoute('program_index');
    }
}
