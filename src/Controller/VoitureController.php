<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Voiture;
use App\Form\VoitureType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;


class VoitureController extends AbstractController
{
    /**
     * @Route("/voiture", name="voiture")
     */
    public function index(): Response
    {
        $voitures = $this->getDoctrine()->getRepository(voiture::class)->findAll();
        return $this->render('voiture/index.html.twig', [
            'voitures' => $voitures,
        ]);
    }
    /**
     * @Route("/createvoiture", name="create_voiture")
     */

    public function createVoiture(Request $request): Response
    {
        $voiture = new Voiture();
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            echo("hello");
            $voiture->setBooleen(1);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($voiture);
            $entityManager->flush();

            return $this->redirectToRoute('voiture');
        }

        return $this->render('voiture/ajouter.html.twig', ['form' => $form->createView()]);
        
    }

    /**
     * @Route("/voiture/{mat}", name="voiturebymat")
     */
    public function afficher(String $mat): Response
    {

        $voitures = $this->getDoctrine()->getRepository(voiture::class)->findBy(array('matricule' => $mat));
        return $this->render('voiture/index.html.twig', [
            'voitures' => $voitures,
        ]);
    }

    /**
     * @Route("/modifiervoiture/{mat}", name="editvoiturebymat")
     */
    public function modifier(Request $request, String $mat): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $voitures = $this->getDoctrine()->getRepository(voiture::class)->findBy(array('matricule' => $mat));
        if (!$voitures) {
            throw $this->createNotFoundException(
                'pas de voiture avec la matricule ' . $mat
            );
        }
        $voiture = $voitures[0];
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($voiture);
            $entityManager->flush();

            return $this->redirectToRoute('voiture');
        }

        return $this->render('voiture/modifier.html.twig', ['form' => $form->createView()]);
    }
    /**
     * @Route("/supprimervoiture/{mat}", name="supvoiturebymat")
     */
    public function supprimer(String $mat): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $voiture = $this->getDoctrine()->getRepository(Voiture::class)->findBy(array('matricule' => $mat));
        if (!$voiture) {
            throw $this->createNotFoundException(
                'pas de voiture avec la matricule' . $mat
            );
        }
        $entityManager->remove($voiture[0]);
        $entityManager->flush();
        return $this->redirectToRoute('voiture');
    }
}
