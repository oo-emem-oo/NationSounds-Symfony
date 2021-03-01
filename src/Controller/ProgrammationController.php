<?php

namespace App\Controller;

use App\Entity\Concerts;
use App\Repository\ConcertsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgrammationController extends AbstractController {

    /**
     * @var ConcertsRepository
     */
    private ConcertsRepository $repository;

    public function __construct(ConcertsRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * @Route("/programmes", name="programmation.index")
     * @return Response
     */
    public function index(): Response {

        /* $repository = $this->getDoctrine()->getRepository(Concerts::class);
        dump($repository); */

        /* $concert = new Concerts();
        $heure = new \DateTime();
        $concert->setArtiste('Manu Chao')
            ->setDescription('Devenu une figure majeure du rock français et de la musique latine avec son groupe Mano Negra, il accomplit depuis plusieurs années une carrière solo internationale à succès et se produit dans le monde entier avec son nouveau groupe : Radio Bemba.')
            ->setJour('Vendredi')
            ->setHeure($heure->setTime(19, 00));
        $em= $this->getDoctrine()->getManager();
        $em->persist($concert);
        $em->flush(); */

        /* $programmation = $this->repository->findAll();
        dump($programmation); */

        return $this->render('programmation/index.html.twig', [
            'current_menu' => 'programmations'
        ]);
    }

    /**
     * @Route("/programmes/{slug}-{id}", name="programmation.show", requirements={"slug": "[a-z0-9\-]*" })
     * @param Concerts $programmation
     * @return Response
     */
    public function show(Concerts $programmation, string $slug): Response {
        if($programmation->getSlug() !== $slug) {
            return $this->redirectToRoute('programmation.show', [
                'id' => $programmation->getId(),
                'slug' => $programmation->getSlug()
            ], 301);
        }
        /* $programmation = $this->repository->find($id); */
        return $this->render('programmation/show.html.twig', [
            'programmation' => $programmation,
            'current_menu' => 'programmations'
        ]);
    }
}
