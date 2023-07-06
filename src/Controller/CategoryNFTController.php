<?php

namespace App\Controller;

use App\Entity\CategoryNFT;
use App\Form\CategoryNFTType;
use App\Repository\CategoryNFTRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category/n/f/t')]
class CategoryNFTController extends AbstractController
{
    #[Route('/', name: 'app_category_n_f_t_index', methods: ['GET'])]
    public function index(CategoryNFTRepository $categoryNFTRepository): Response
    {
        return $this->render('category_nft/index.html.twig', [
            'category_n_f_ts' => $categoryNFTRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_category_n_f_t_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CategoryNFTRepository $categoryNFTRepository): Response
    {
        $categoryNFT = new CategoryNFT();
        $form = $this->createForm(CategoryNFTType::class, $categoryNFT);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryNFTRepository->save($categoryNFT, true);

            return $this->redirectToRoute('app_category_n_f_t_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category_nft/new.html.twig', [
            'category_n_f_t' => $categoryNFT,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_category_n_f_t_show', methods: ['GET'])]
    public function show(CategoryNFT $categoryNFT): Response
    {
        return $this->render('category_nft/show.html.twig', [
            'category_n_f_t' => $categoryNFT,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_category_n_f_t_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CategoryNFT $categoryNFT, CategoryNFTRepository $categoryNFTRepository): Response
    {
        $form = $this->createForm(CategoryNFTType::class, $categoryNFT);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryNFTRepository->save($categoryNFT, true);

            return $this->redirectToRoute('app_category_n_f_t_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category_nft/edit.html.twig', [
            'category_n_f_t' => $categoryNFT,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_category_n_f_t_delete', methods: ['POST'])]
    public function delete(Request $request, CategoryNFT $categoryNFT, CategoryNFTRepository $categoryNFTRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categoryNFT->getId(), $request->request->get('_token'))) {
            $categoryNFTRepository->remove($categoryNFT, true);
        }

        return $this->redirectToRoute('app_category_n_f_t_index', [], Response::HTTP_SEE_OTHER);
    }
}
