<?php


namespace App\Controller;


use App\Entity\Product;
use App\Form\ProductFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProductController
 * @package App\Controller
 * @Route("/product", name="product")
 */
class ProductController extends AbstractController
{

    /**
     * @Route("/{page<[1-9]\d*>}", name="_index")
     */
    public function index(EntityManagerInterface $entityManager, Request $request, int $page = 1)
    {
        $repository = $entityManager->getRepository(Product::class);
        $paginator = $repository->findAllDesc($page);
        return $this->render('product/index.html.twig', [
            'paginator' => $paginator
        ]);
    }

    /**
     * @Route("/new", name="_new")
     */
    public function nuevo(EntityManagerInterface $entityManager, Request $request)
    {
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

        return $this->render('product/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/edit/{id}", name="_edit")
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
     * @Route("/delete/{id}", name="_delete", methods={"DELETE"})
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