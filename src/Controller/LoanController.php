<?php

namespace App\Controller;

use App\Entity\Loan;
use App\Form\LoanType;
use App\Repository\LoanRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


class LoanController extends AbstractController
{
    /**
     * @Route("/", name="home_page", methods={"GET"})
     * @Route("/loan/", name="loan_index", methods={"GET"})
     */
    public function index(LoanRepository $loanRepository): Response
    {
        return $this->render('loan/index.html.twig', [
            'loans' => $loanRepository->findAll(),
        ]);
    }

    /**
     * @Route("/loan/new", name="loan_new", methods={"GET","POST"})
     */
    public function new(Request $request, Security $security): Response
    {
        $loan = new Loan();
        $form = $this->createForm(LoanType::class, $loan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Set logged in user as owner of loan
            $loan->setUser($security->getUser());
            //New record should have status new
            $loan->setStatus(Loan::LOAN_STATUS_NEW);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($loan);
            $entityManager->flush();

            return $this->redirectToRoute('loan_index');
        }

        return $this->render('loan/new.html.twig', [
            'loan' => $loan,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/loan/{id}", name="loan_show", methods={"GET"})
     */
    public function show(Loan $loan): Response
    {
        return $this->render('loan/show.html.twig', [
            'loan' => $loan,
        ]);
    }

    /**
     * @Route("/loan/{id}/edit", name="loan_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Loan $loan): Response
    {
        $form = $this->createForm(LoanType::class, $loan, ['show_status_field' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('loan_index');
        }

        return $this->render('loan/edit.html.twig', [
            'loan' => $loan,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/loan/{id}", name="loan_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Loan $loan): Response
    {
        if ($this->isCsrfTokenValid('delete'.$loan->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($loan);
            $entityManager->flush();
        }

        return $this->redirectToRoute('loan_index');
    }
}
