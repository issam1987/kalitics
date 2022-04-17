<?php

    namespace App\Controller;

    use App\Entity\Pointage;
    use App\Form\PointageType;
    use App\Repository\PointageRepository;
    use App\Service\PointageHelper;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("/pointage")
     */
    class PointageController extends AbstractController
    {
        /**
         * @Route("/", name="app_pointage_index", methods={"GET"})
         */
        public function index(PointageRepository $pointageRepository): Response
        {
            return $this->render('pointage/index.html.twig', [
                'pointages' => $pointageRepository->findAll(),
            ]);
        }

        /**
         * @Route("/new", name="app_pointage_new", methods={"GET", "POST"})
         */
        public function new(Request $request, EntityManagerInterface $entityManager, PointageHelper $pointageHelper): Response
        {
            $pointage = new Pointage();
            $form = $this->createForm(PointageType::class, $pointage);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $pointage = $form->getData();
                if ($pointageHelper->parse($pointage, 'new') != '')
                    $this->addFlash('error', $pointageHelper->parse($pointage, 'new'));
                else {
                    $entityManager->persist($pointage);
                    $entityManager->flush();

                    return $this->redirectToRoute('app_pointage_index', [], Response::HTTP_SEE_OTHER);
                }
            }

            return $this->render('pointage/new.html.twig', [
                'form' => $form->createView(),
            ]);
        }


        /**
         * @Route("/{id}/edit", name="app_pointage_edit", methods={"GET", "POST"})
         */
        public function edit(Pointage $pointage, Request $request, EntityManagerInterface $entityManager, PointageHelper $pointageHelper): Response
        {

            $form = $this->createForm(PointageType::class, $pointage);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $utilisateur = $form->getData();
                if ($pointageHelper->parse($pointage, 'edit') != '') {
                    $this->addFlash('error', $pointageHelper->parse($pointage, 'edit'));

                } else {
                    $entityManager->persist($utilisateur);
                    $entityManager->flush();
                    return $this->redirectToRoute('app_pointage_index');
                }
            }

            return $this->render(
                'pointage/edit.html.twig', [
                    'form' => $form->createView(),
                ]
            );
        }

        /**
         * @Route("/{id}", name="app_pointage_delete", methods={"POST"})
         */
        public function delete(Request $request, Pointage $pointage, PointageRepository $pointageRepository): Response
        {

            $pointageRepository->remove($pointage);
            return new JsonResponse([
                'res' => 1
            ]);
        }
    }
