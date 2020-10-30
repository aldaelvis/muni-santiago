<?php


namespace App\Controller;


use App\Entity\Entry;
use App\Entity\Salida;
use App\Repository\EntryRepository;
use App\Repository\SalidaRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ReporteController extends AbstractController
{

    /**
     * @Route("/reportes", name="reporte_index")
     */
    public function index(SalidaRepository $salidaRepository, EntryRepository $entryRepository, Request $request)
    {

        $date1 = null;
        $date2 = null;
        $date3 = null;
        $salidas = [];
        $entradas = [];
        if (!empty($request->query->get('date1')) && !empty($request->query->get('date2')) ||
            !empty($request->query->get('date3'))) {
            $date1 = $request->query->get('date1');
            $date2 = $request->query->get('date2');
            $date3 = $request->query->get('date3');

            /** @var Salida $salidas */
            $salidas = $salidaRepository->findAllBetweenReporteDesc($date1, $date2, $date3);
            /** @var Entry $entradas */
            $entradas = $entryRepository->findAllBetweenReporteDesc($date1, $date2, $date3);
        }


        if ($request->getMethod() == Request::METHOD_POST) {
            $options = new Options();
            $options->set('defaultFont', 'Arial');
            $dompdf = new Dompdf($options);

            $html = $this->renderView('pdf/pdf.html.twig', [
                'fecha' => $date3,
                'fechaentre' => $date1 . '-' . $date2,
                'salidas' => $salidas,
                'entradas' => $entradas,
            ]);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $dompdf->stream('reporte.pdf', [
                'Attachment' => false
            ]);

            $response = new \Symfony\Component\HttpFoundation\Response();

            $response->setContent($dompdf->output());
            $response->setStatusCode(200);
            $response->headers->set('Content-Type', 'application/pdf');

            return $response;
        }

        return $this->render('reporte/reportes.html.twig', [
            "salidas" => $salidas,
            "entradas" => $entradas
        ]);
    }

}