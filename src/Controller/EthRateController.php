<?php

namespace App\Controller;

use App\Entity\EthRate;
use App\Form\EthRateType;
use App\Repository\EthRateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/eth/rate')]
class EthRateController extends AbstractController
{
    #[Route('/', name: 'app_eth_rate_index', methods: ['GET'])]
    public function index(EthRateRepository $ethRateRepository): Response
    {
        return $this->render('eth_rate/index.html.twig', [
            'eth_rates' => $ethRateRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_eth_rate_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EthRateRepository $ethRateRepository): Response
    {
        $ethRate = new EthRate();
        $form = $this->createForm(EthRateType::class, $ethRate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ethRateRepository->save($ethRate, true);

            return $this->redirectToRoute('app_eth_rate_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('eth_rate/new.html.twig', [
            'eth_rate' => $ethRate,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_eth_rate_show', methods: ['GET'])]
    public function show(EthRate $ethRate): Response
    {
        return $this->render('eth_rate/show.html.twig', [
            'eth_rate' => $ethRate,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_eth_rate_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EthRate $ethRate, EthRateRepository $ethRateRepository): Response
    {
        $form = $this->createForm(EthRateType::class, $ethRate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ethRateRepository->save($ethRate, true);

            return $this->redirectToRoute('app_eth_rate_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('eth_rate/edit.html.twig', [
            'eth_rate' => $ethRate,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_eth_rate_delete', methods: ['POST'])]
    public function delete(Request $request, EthRate $ethRate, EthRateRepository $ethRateRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ethRate->getId(), $request->request->get('_token'))) {
            $ethRateRepository->remove($ethRate, true);
        }

        return $this->redirectToRoute('app_eth_rate_index', [], Response::HTTP_SEE_OTHER);
    }
}
