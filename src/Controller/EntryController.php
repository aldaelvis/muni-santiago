<?php

namespace App\Controller;

use App\Entity\DetailEntry;
use App\Entity\Entry;
use App\Entity\Product;
use App\Repository\EntryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\DocBlock\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/entry")
 */
class EntryController extends AbstractController
{
    /**
     * @Route("/{page<[1-9]\d*>}", name="entry_index", methods={"GET"})
     */
    public function index(EntryRepository $entryRepository, Request $request, $page = 1): Response
    {
        $date1 = $request->query->get('date1');
        $date2 = $request->query->get('date2');

        if (!is_null($date1) && !is_null($date2)) {
            $paginator = $entryRepository->findAllBetweenDesc($page, $date1, $date2);
        } else {
            $paginator = $entryRepository->findAllDesc($page);
        }

        return $this->render('entry/index.html.twig', [
            'paginator' => $paginator,
        ]);
    }

    /**
     * @Route("/new", name="entry_new", methods={"GET","POST"})
     */
    public function new(EntityManagerInterface $em, Request $request): Response
    {

        $entry = new Entry();

        $products = $em
            ->getRepository(Product::class)
            ->findAll();

        if ($request->getMethod() == Request::METHOD_POST) {
            $idt = $request->request->get('idt');
            $quantityt = $request->request->get('quantityt');
            $total = $request->request->get('totalt');
            $name = $request->request->get('name');

            if (is_null($idt) || is_null($quantityt)) {
                $this->addFlash('error', 'No selecciono ningun articulo');
            } else if (is_null($total)) {
                $this->addFlash('error', 'Error de total de articulos');
            } else if (is_null($name)) {
                $this->addFlash('error', 'Error ponga el descripcion de la salida ☹');
            } else {
                $em->getConnection()->beginTransaction();
                try {
                    $entry->setDate(new \DateTime());
                    $entry->setTotal($total);
                    $entry->setName($name);

                    $count = 0;
                    while ($count < count($request->request->get('idt'))) {
                        $detail = new DetailEntry();
                        $product = $em->getRepository(Product::class)->find($idt[$count]);
                        $detail->setProduct($product);

                        $detail->setEntry($entry);
                        $detail->setQuantity($quantityt[$count]);
                        $em->persist($detail);
                        $count++;
                    }

                    $em->persist($entry);
                    $em->flush();
                    $em->getConnection()->commit();
                } catch (\Exception $e) {
                    $em->getConnection()->rollBack();
                    throw $e;
                }
            }
        }

        return $this->render('entry/new.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/show/{id}", name="entry_show", methods={"GET"})
     */
    public function show(Entry $entry): Response
    {
        return $this->render('entry/show.html.twig', [
            'entry' => $entry,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="entry_edit", methods={"GET","POST"})
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
     * @Route("/delete/{id}", name="entry_delete", methods={"DELETE"})
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

    /**
     * @Route("/product", name="entry_products_list", methods={"GET"})
     */
    public function products(Request $request, SerializerInterface $serializer)
    {
        $em = $this->getDoctrine()->getManager();

        $value = $request->query->get('search');
        $products = [];
        if (!is_null($value)) {
            $products = $em->getRepository(Product::class)->findProducts($value);
        }

        $jsonObject = $serializer->serialize($products, 'json',
            [
                'ignored_attributes' => ['detailEntries']
            ]
        );

        //return $this->json($products);
        return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
    }
}
