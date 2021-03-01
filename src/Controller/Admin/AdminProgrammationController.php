<?php

namespace App\Controller\Admin;

use App\Entity\Concerts;
use App\Form\ProgrammationType;
use App\Repository\ConcertsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminProgrammationController extends AbstractController {

    /**
     * @var ConcertsRepository
     */
    private ConcertsRepository $repository;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;


    public function __construct(ConcertsRepository $repository, EntityManagerInterface $em) {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin", name="admin.programmation.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index() { /* methode */
        $programmations = $this->repository->findAll();
        return $this->render('admin/programmation/index.html.twig', compact('programmations'));
    }

    /**
     * @Route("/admin/programmation/create", name="admin.programmation.new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request) {
        $programmation = new Concerts();
        $form = $this->createForm(ProgrammationType::class, $programmation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($programmation);
            $this->em->flush();
            $this->addFlash('success', 'Bien créé avec succès');
            return $this->redirectToRoute('admin.programmation.index');
        }
        return $this->render('admin/programmation/new.html.twig', [
            'programmation' => $programmation,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/programmation/{id}", name="admin.programmation.edit", methods="GET|POST")
     * @param Concerts $programmation
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Concerts $programmation, Request $request) {
        $form = $this->createForm(ProgrammationType::class, $programmation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Bien modifié avec succès');
            return $this->redirectToRoute('admin.programmation.index');
        }

        return $this->render('admin/programmation/edit.html.twig', [
            'programmation' => $programmation,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/programmation/{id}", name="admin.programmation.delete", methods="DELETE")
     * @param Concerts $programmation
     * @param Request $request
     * @return Response
     */
    public function delete(Concerts $programmation, Request $request) {
        if ($this->isCsrfTokenValid('delete' . $programmation->getId(), $request->get('_token'))) {
            $this->em->remove($programmation);
            $this->em->flush();
            $this->addFlash('success', 'Bien supprimé avec succès');
        }
        return $this->redirectToRoute('admin.programmation.index');
    }
}
