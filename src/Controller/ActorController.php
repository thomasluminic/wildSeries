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
     * @Route("/actor/{id}", requirements={"id", "[0-9]+"}, name="show_actor")
     * @param $id
     */
    public function showActor($id)
    {
        $actor = $this->getDoctrine()->getRepository(Actor::class)->find($id);
            dump($actor);
        return $this->render('Actor/show.html.twig', [
            'actor' => $actor,
        ]);
    }
}
