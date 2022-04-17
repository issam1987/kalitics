<?php

namespace App\Controller;

use App\Entity\Chantier;
use App\Form\ChantierType;
use App\Repository\ChantierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/chantier")
 */
class ChantierController extends AbstractController
{
    /**
     * @Route("/", name="app_chantier_index", methods={"GET"})
     */
    public function index(ChantierRepository $chantierRepository): Response
    {
        ;
       // echo  $premierJour = date('Y-m-d', strtotime('last sunday', strtotime('17-04-2022')));
        return $this->render('chantier/index.html.twig', [
            'chantiers' => $chantierRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_chantier_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ChantierRepository $chantierRepository): Response
    {
        $chantier = new Chantier();
        $form = $this->createForm(ChantierType::class, $chantier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chantierRepository->add($chantier);
            return $this->redirectToRoute('app_chantier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chantier/new.html.twig', [
            'chantier' => $chantier,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_chantier_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Chantier $chantier, ChantierRepository $chantierRepository): Response
    {
        $form = $this->createForm(ChantierType::class, $chantier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chantierRepository->add($chantier);
            return $this->redirectToRoute('app_chantier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chantier/edit.html.twig', [
            'chantier' => $chantier,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_chantier_delete", methods={"POST"})
     */
    public function delete(Request $request, Chantier $chantier, ChantierRepository $chantierRepository): Response
    {

            $chantierRepository->remove($chantier);
        return new JsonResponse([
            'res' =>1
        ]);
    }
}
