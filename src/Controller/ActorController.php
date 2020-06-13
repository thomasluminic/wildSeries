<?php

namespace App\Controller;

use App\Entity\Actor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ActorController extends AbstractController
{
    /**
     * @Route("/actor", name="actor")
     */
    public function index()
    {
        return $this->render('Actor/index.html.twig', [
            'controller_name' => 'ActorController',
        ]);
    }

    /**
     * @Route("/actor/{slug}", requirements={"slug", "[a-z-]+"}, name="show_actor")
     * @param $slug
     */
    public function showActor($slug)
    {
        $actor = $this->getDoctrine()->getRepository(Actor::class)->findOneBy(['slug' => $slug]);
        return $this->render('Actor/show.html.twig', [
            'actor' => $actor,
        ]);
    }
}
