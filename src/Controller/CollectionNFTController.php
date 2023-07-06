<?php

namespace App\Controller;

use App\Entity\CollectionNFT;
use App\Form\CollectionNFTType;
use App\Repository\CollectionNFTRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/collection/n/f/t')]
class CollectionNFTController extends AbstractController
{
    #[Route('/', name: 'app_collection_n_f_t_index', methods: ['GET'])]
    public function index(CollectionNFTRepository $collectionNFTRepository): Response
    {
        return $this->render('collection_nft/index.html.twig', [
            'collection_n_f_ts' => $collectionNFTRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_collection_n_f_t_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CollectionNFTRepository $collectionNFTRepository): Response
    {
        $collectionNFT = new CollectionNFT();
        $form = $this->createForm(CollectionNFTType::class, $collectionNFT);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $collectionNFTRepository->save($collectionNFT, true);

            return $this->redirectToRoute('app_collection_n_f_t_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('collection_nft/new.html.twig', [
            'collection_n_f_t' => $collectionNFT,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_collection_n_f_t_show', methods: ['GET'])]
    public function show(CollectionNFT $collectionNFT): Response
    {
        return $this->render('collection_nft/show.html.twig', [
            'collection_n_f_t' => $collectionNFT,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_collection_n_f_t_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CollectionNFT $collectionNFT, CollectionNFTRepository $collectionNFTRepository): Response
    {
        $form = $this->createForm(CollectionNFTType::class, $collectionNFT);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $collectionNFTRepository->save($collectionNFT, true);

            return $this->redirectToRoute('app_collection_n_f_t_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('collection_nft/edit.html.twig', [
            'collection_n_f_t' => $collectionNFT,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_collection_n_f_t_delete', methods: ['POST'])]
    public function delete(Request $request, CollectionNFT $collectionNFT, CollectionNFTRepository $collectionNFTRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$collectionNFT->getId(), $request->request->get('_token'))) {
            $collectionNFTRepository->remove($collectionNFT, true);
        }

        return $this->redirectToRoute('app_collection_n_f_t_index', [], Response::HTTP_SEE_OTHER);
    }
}
