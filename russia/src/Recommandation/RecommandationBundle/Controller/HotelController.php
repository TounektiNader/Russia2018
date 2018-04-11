<?php
/**
 * Created by PhpStorm.
 * User: Ouss'Hr
 * Date: 19/03/2018
 * Time: 14:46
 */

namespace Recommandation\RecommandationBundle\Controller;
use Ivory\GoogleMap\Overlay\Animation;
use Ivory\GoogleMap\Overlay\Icon;
use Ivory\GoogleMap\Overlay\InfoWindow;
use Ivory\GoogleMap\Overlay\InfoWindowType;
use Ivory\GoogleMap\Overlay\MarkerShape;
use Ivory\GoogleMap\Base\Size;
use Ivory\GoogleMap\Overlay\MarkerShapeType;
use Ivory\GoogleMap\Overlay\Polygon;
use Ivory\GoogleMap\Overlay\Symbol;
use Ivory\GoogleMap\Overlay\SymbolPath;
use Recommandation\RecommandationBundle\Form\HotelForm;
use Recommandation\RecommandationBundle\Form\rechercheHotelForm;
use Recommandation\RecommandationBundle\RecommandationRecommandationBundle;
use Skies\QRcodeBundle\Generator\Generator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Russia\RussiaBundle\Entity\Hotels;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Base\Bound;
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\MapTypeId;
use Ivory\GoogleMap\Overlay\Marker;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use function Symfony\Component\VarDumper\Tests\Fixtures\bar;
use WhiteOctober\TCPDFBundle\WhiteOctoberTCPDFBundle;
use WhiteOctober\TCPDFBundle\DependencyInjection\WhiteOctoberTCPDFExtension;

class HotelController extends Controller
{
    public function ListAction()
    {
        $em = $this->getDoctrine()->getManager();
        $hotel = $em->getRepository('RussiaRussiaBundle:Hotels')->findAll();
        return $this->render('@RecommandationRecommandation/Hotel/affichehotel.html.twig', array("hotel" => $hotel));
    }

    public function ListadminAction()
    {
        $em = $this->getDoctrine()->getManager();
        $hotel = $em->getRepository('RussiaRussiaBundle:Hotels')->findAll();
        return $this->render('@RecommandationRecommandation/Hotel/affichehoteladmin.html.twig', array("hotels" => $hotel));
    }

    public function detAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $hotel = $em->getRepository("RussiaRussiaBundle:Hotels")->find($id);
        $cv = $em->getRepository('RussiaRussiaBundle:Hotels')->cafeville($hotel->getIdville());
        $ss = $em->getRepository('RussiaRussiaBundle:Stades')->stadehotel($hotel->getIdville());
        $coor = $hotel->getPositionhotel();
        $coor1 = $ss[0]->getPositionstade();
        $lat = array_map('intval', explode(',', $coor));
        $lat1 = array_map('intval',explode(',',$coor1));
        $map = new Map();
        $map->setVariable('map');
        $map->setHtmlId('map_canvas');
        $map->setAutoZoom(false);
        $map->setCenter(new Coordinate(($lat[0]+$lat1[0])/2, ($lat[1]+$lat1[1])/2));
        $map->setMapOption('zoom', 2);
        $marker = new Marker(
            new Coordinate($lat[0], $lat[1]),
            Animation::BOUNCE,
            new Icon(),
            new Symbol(SymbolPath::CIRCLE),
            new MarkerShape(MarkerShapeType::CIRCLE, [1.1, 2.1, 1.4]),
            ['clickable' => false]
        );
        $map->getOverlayManager()->addMarker($marker);
        $marker1 = new Marker(
            new Coordinate($lat1[0], $lat1[1]),
            Animation::BOUNCE,
            new Icon(),
            new Symbol(SymbolPath::CIRCLE),
            new MarkerShape(MarkerShapeType::CIRCLE, [1.1, 2.1, 1.4]),
            ['clickable' => false]
        );
        $polygon = new Polygon(
            [
                new Coordinate($lat[0], $lat[1]),
                new Coordinate($lat1[0], $lat1[1]),
            ],
            ['fillOpacity' => 0.5]
        );
        $polygon->setVariable('polygon');
        $map->getOverlayManager()->addPolygon($polygon);
        $map->getOverlayManager()->addMarker($marker1);
        $map->addLibrary('drawing');
        $map->setMapOption('mapTypeId', MapTypeId::ROADMAP);
        $map->setStaticOption('maptype', MapTypeId::ROADMAP);
        $map->setStaticOption('styles', [
            [
                'feature' => 'road.highway', // Optional
                'element' => 'geometry',     // Optional
                'rules' => [               // Mandatory (at least one rule)
                    'color' => '0xc280e9',
                    'visibility' => 'simplified',
                ],
            ],
            [
                'feature' => 'transit.line',
                'rules' => [
                    'visibility' => 'simplified',
                    'color' => '0xbababa',
                ]
            ],
        ]);

        return $this->render("@RecommandationRecommandation/Hotel/dethotel.html.twig",
            array('hotel' => $hotel, 'map' => $map,'cv'=>$cv));
    }

    public function ajoutAction(Request $request)
    {
        $hotel = new Hotels();

        $form = $this->createFormBuilder($hotel)
            ->add('nomhotel')
            ->add('detailshotel', TextareaType::class, array(
                'attr' => array('cols' => '20', 'rows' => '5'),
            ))
            ->add('positionhotel')
            ->add('photohotel', FileType::class, array('label' => false))
            ->add('idville', EntityType::class, array(
                'attr'=> array('class'=>'form-control'),
                'class' => 'Russia\RussiaBundle\Entity\Villes',
                'choice_label' => 'nomville',
                'multiple' => false,
            ))
            ->add('Ajouter', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($hotel);
            $em->flush();

            return $this->redirectToRoute('affichehoteladmin');

        }

        return $this->render('RecommandationRecommandationBundle:hotel:ajout.html.twig', array('form' => $form->createView()));
    }

    public function UpdateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $hotel = $em->getRepository('RussiaRussiaBundle:Hotels')->find($id);
        $form = $this->createForm(HotelForm::class, $hotel);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($hotel);
            $em->flush();
            return $this->redirectToRoute('affichehoteladmin');
        }
        return $this->render('RecommandationRecommandationBundle:hotel:update.html.twig', array('form' => $form->createView(), 'hotel' => $hotel));
    }

    public function DeleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $hotel = $em->getRepository('RussiaRussiaBundle:Hotels')->find($id);
        $em->remove($hotel);
        $em->flush();
        return $this->redirectToRoute('affichehoteladmin');
    }

    public function rechercheSerieDQLAction(Request $request)
    {
        $hotel = new Hotels();
        $em = $this->getDoctrine()->getManager();
        $hotels = $em->getRepository('RussiaRussiaBundle:Hotels')->findAll();
        $form = $this->createForm(rechercheHotelForm::class, $hotel);
        $form->handleRequest($request);
        if ($request->isXmlHttpRequest()) {
            $serializer = new Serializer(array(new ObjectNormalizer()));
            $hotels = $em->getRepository('RussiaRussiaBundle:Hotels')
                ->findSerieDQL($request->get('nomhotel'));
            $data = $serializer->normalize($hotels);
            return new JsonResponse($data);
        }
        return $this->render('@RecommandationRecommandation/Hotel/recherche.html.twig', array('hotels' => $hotels, 'form' => $form->createView()));

    }

    public function returnPDFResponseFromHTML($html){
        set_time_limit(60);
        // If you are not in a controller, retrieve of some way the service container and then retrieve it
        //$pdf = $this->container->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        //if you are in a controlller use :
        $pdf = $this->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetAuthor('Russia 2018');
        $pdf->SetTitle(('Russia 2018'));
        $pdf->SetSubject('Russia 2018');
        $pdf->setFontSubsetting(true);
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
        $pdf->setFooterData(array(0,64,0), array(0,64,128));
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetFont('helvetica', '', 11, '', true);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->AddPage();

        $filename = 'hotel_russia2018';

        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
        $pdf->Output($filename.".pdf",'I'); // This will output the PDF as a response directly
    }

    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $hotel = $em->getRepository("RussiaRussiaBundle:Hotels")->find($id);
        $options = array(
            'code'   => 'string to encode',
            'type'   => 'qrcode',
            'format' => 'html',
        );

        $generator = new Generator();
        $barcode = $generator->generate($options);
        $html = $this->renderView(
            '@RecommandationRecommandation/Hotel/pdf.html.twig',
            array
            (
                'hotel'=>$hotel,
                'barcode'=>$barcode
            )
        );

        $this->returnPDFResponseFromHTML($html);

    }
}