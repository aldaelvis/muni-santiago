<?php


namespace App\Controller;


use App\Entity\Medida;
use App\Repository\MedidaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MedidaController extends AbstractController
{

    /**
     * @Route("/medida", name="app_medida")
     */
    public function index(MedidaRepository $medidaRepository)
    {
        $medidas = $medidaRepository->findAll();

        return $this->render('medida/index.html.twig', [
            'medidas' => $medidas
        ]);
    }

    /**
     * @Route("/medida/nuevo", name="app_medida_nuevo")
     */
    public function nuevo(EntityManagerInterface $entityManager, Request $request)
    {

        if ($request->getMethod() === Request::METHOD_POST) {
            $nombre = $request->request->get('nombre');
            $abreviacion = $request->request->get('abreviacion');
            if (empty($nombre) || empty($abreviacion)) {
                $this->addFlash('error', 'Los campos en (*) son obligatorios 🙁');
            } else {
                $medida = new Medida();
                $medida->setNombre($nombre);
                $medida->setAbreviacion($abreviacion);
                $entityManager->persist($medida);
                $entityManager->flush();

                $this->addFlash('success', 'Se guardo la medida 😀');
                return $this->redirectToRoute('app_medida');
            }
        }

        return $this->render('medida/nuevo.html.twig', [

        ]);
    }

    /**
     * @Route("/medida/{medida}/editar", name="app_medida_editar")
     */
    public function editar(EntityManagerInterface $entityManager, Request $request, Medida $medida)
    {

        if ($request->getMethod() === Request::METHOD_POST) {
            $nombre = $request->request->get('nombre');
            $abreviacion = $request->request->get('abreviacion');
            if (empty($nombre) || empty($abreviacion)) {
                $this->addFlash('error', 'Los campos en (*) son obligatorios 🙁');
            } else {
                $medida->setNombre($nombre);
                $medida->setAbreviacion($abreviacion);
                $entityManager->persist($medida);
                $entityManager->flush();

                $this->addFlash('success', 'Se edito la medida 😀');
                return $this->redirectToRoute('app_medida');
            }
        }

        return $this->render('medida/editar.html.twig', [
            "medida" => $medida
        ]);
    }

    /**
     * @Route("/medida/{medida}/eliminar", name="app_medida_eliminar")
     */
    public function eliminar(EntityManagerInterface $entityManager, Request $request, Medida $medida)
    {

        if ($this->isCsrfTokenValid('delete' . $medida->getId(), $request->request->get('_token'))) {
            $entityManager->remove($medida);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_medida');
    }
}