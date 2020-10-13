<?php

namespace App\Controller;

use App\Entity\Entry;
use App\Repository\EntryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/entry")
 */
class EntryController extends AbstractController
{
    /**
     * @Route("/", name="entry_index", methods={"GET"})
     */
    public function index(EntryRepository $entryRepository): Response
    {
        return $this->render('entry/index.html.twig', [
            'entries' => $entryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="entry_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        /*$entry = new Entry();
        $form = $this->createForm(EntryType::class, $entry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entry);
            $entityManager->flush();

            return $this->redirectToRoute('entry_index');
        } */

        return $this->render('entry/new.html.twig', []);
    }

    /**
     * @Route("/{id}", name="entry_show", methods={"GET"})
     */
    public function show(Entry $entry): Response
    {
        return $this->render('entry/show.html.twig', [
            'entry' => $entry,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="entry_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Entry $entry): Response
    {
        /*$form = $this->createForm(EntryType::class, $entry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('entry_index');
        }

        return $this->render('entry/edit.html.twig', [
            'entry' => $entry,
            'form' => $form->createView(),
        ]);*/
    }

    /**
     * @Route("/{id}", name="entry_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Entry $entry): Response
    {
        /*if ($this->isCsrfTokenValid('delete'.$entry->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($entry);
            $entityManager->flush();
        }

        return $this->redirectToRoute('entry_index');*/
    }
}
