<?php

namespace App\Controller;

use App\Repository\ConcertsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {

    /**
     * @Route("/", name="home")
     * @param ConcertsRepository $repository
     * @return Response
     */
    public function index(ConcertsRepository $repository): Response {
        $programmations = $repository->findLatest();
        return $this->render('pages/home.html.twig', [
            'programmations' => $programmations
        ]);
    }
}
