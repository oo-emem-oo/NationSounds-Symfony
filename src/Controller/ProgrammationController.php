<?php

namespace App\Controller;

use App\Entity\Concerts;
use App\Repository\ConcertsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ProgrammationController extends AbstractController {

    /**
     * @var ConcertsRepository
     */
    private ConcertsRepository $repository;

    public function __construct(ConcertsRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * @Route("/publicconcerts", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function publicConcerts (Request $request) : Response {
        $response = new Response();
        $concerts = $this->repository->findAll();
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        //var_dump($concerts);
        $jsonContent = [];
        foreach($concerts as $concert) {
            $tempJson = $serializer->serialize($concert, 'json');
          array_push($jsonContent, $tempJson);
        }
            //= $serializer->serialize($concerts, 'json');
        $response->setContent(json_encode([
            'data' => $jsonContent,
        ]));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/programmes", name="programmation.index")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response {

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
        $programmations = $paginator->paginate($this->repository->findAllQuery(),
            $request->query->getInt('page', 1),
            3
        );
        return $this->render('programmation/index.html.twig', [
            'current_menu' => 'programmations',
            'programmations' => $programmations
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
