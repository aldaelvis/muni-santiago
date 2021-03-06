<?php


namespace App\Controller;


use App\Entity\Product;
use App\Form\ProductFormType;
use App\Repository\MedidaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProductController
 * @package App\Controller
 */
class ProductController extends AbstractController
{

    /**
     * @Route("product/{page<[1-9]\d*>}", name="product_index")
     */
    public function index(EntityManagerInterface $entityManager, Request $request, int $page = 1)
    {
        $repository = $entityManager->getRepository(Product::class);

        $qdescription = $request->query->get('search');

        if (!is_null($qdescription)) {
            $paginator = $repository->findDescriptionDesc($page, $qdescription);
        } else {
            $paginator = $repository->findAllDesc($page);
        }

        return $this->render('product/index.html.twig', [
            'paginator' => $paginator
        ]);
    }

    /**
     * @Route("product/new", name="product_new")
     */
    public function nuevo(EntityManagerInterface $entityManager, MedidaRepository $medidaRepository, Request $request)
    {
        $medidas = $medidaRepository->findAll();
        $form = $this->createForm(ProductFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Product $product */
            $product = $form->getData();

            $entityManager->persist($product);
            $entityManager->flush();
            $this->addFlash('success', 'Articulo creado correctamente');
            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("product/edit/{id}", name="product_edit")
     */
    public function editar(Product $product, Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(ProductFormType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();
            $this->addFlash('success', 'Articulo actualizado');

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/edit.html.twig', [
            'form' => $form->createView(),
            'product' => $product
        ]);
    }

    /**
     * @Route("product/delete/{id}", name="product_delete", methods={"DELETE"})
     */
    public function eliminar(Request $request, Product $product, EntityManagerInterface $entityManager)
    {
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->request->get('_token'))) {
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_index');
    }

}