<?php

namespace App\Controller;

use App\Entity\DetalleSalida;
use App\Entity\Product;
use App\Entity\Salida;
use App\Repository\SalidaRepository;
use Doctrine\DBAL\ConnectionException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SalidaController
 * @package App\Controller
 * @Route ("/salida")
 */
class SalidaController extends AbstractController
{
    /**
     * @Route("/{page<[1-9]\d*>}", name="salida_index")
     */
    public function index(Request $request, SalidaRepository $salidaRepository, $page = 1)
    {
        $date1 = $request->query->get('date1');
        $date2 = $request->query->get('date2');

        $descripcion = null;
        if ($request->query->has('descripcion')) {
            $descripcion = $request->query->get('descripcion');
        }

        if (!is_null($date1) && !is_null($date2)) {
            $paginator = $salidaRepository->findAllBetweenDesc($page, $date1, $date2);
        } else {
            $paginator = $salidaRepository->findAllDesc($page, $descripcion);
        }

        return $this->render('salida/index.html.twig', [
            'paginator' => $paginator,
        ]);
    }

    /**
     * @Route ("/new", name="salida_new")
     */
    public function new(EntityManagerInterface $entityManager, Request $request)
    {
        $products = $entityManager
            ->getRepository(Product::class)
            ->findAll();


        if ($request->getMethod() == Request::METHOD_POST) {
            $idt = $request->request->get('idt');
            $quantityt = $request->request->get('quantityt');
            $total = $request->request->get('totalt');
            $name = $request->request->get('name');
            $salida = new Salida();

            if (is_null($idt) || is_null($quantityt)) {
                $this->addFlash('error', 'No selecciono ningun articulo. ☹');
            } else if (is_null($total)) {
                $this->addFlash('error', 'Error de total de articulos. ☹');
            } else if (is_null($name)) {
                $this->addFlash('error', 'Error ponga el descripcion de la salida ☹');
            } else {
                $entityManager->getConnection()->beginTransaction();
                try {
                    $salida->setDate(new \DateTime());
                    $salida->setTotal($total);
                    $salida->setName($name);

                    $count = 0;
                    while ($count < count($request->request->get('idt'))) {
                        $detail = new DetalleSalida();
                        $product = $entityManager->getRepository(Product::class)->find($idt[$count]);
                        $detail->setProduct($product);
                        $detail->setSalida($salida);
                        $detail->setQuantity($quantityt[$count]);
                        $entityManager->persist($detail);
                        $count++;
                    }

                    $entityManager->persist($salida);
                    $entityManager->flush();
                    $entityManager->getConnection()->commit();
                    $this->addFlash('success', 'Sálida guardada con éxito. 😀');
                } catch (\Exception $e) {
                    $entityManager->getConnection()->rollBack();
                    throw $e;
                }
            }
        }

        return $this->render('salida/new.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/show/{id}", name="salida_show", methods={"GET"})
     */
    public function show(Salida $salida): Response
    {
        return $this->render('salida/show.html.twig', [
            'salida' => $salida,
        ]);
    }
}
