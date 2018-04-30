<?php
/**
 * Created by PhpStorm.
 * User: Ouss'Hr
 * Date: 19/03/2018
 * Time: 15:25
 */

namespace Recommandation\RecommandationBundle\Controller;
use Http\Adapter\Guzzle6\Client;
use Ivory\GoogleMap\Overlay\Animation;
use Ivory\GoogleMap\Overlay\Icon;
use Ivory\GoogleMap\Overlay\MarkerShape;
use Ivory\GoogleMap\Overlay\MarkerShapeType;
use Ivory\GoogleMap\Overlay\Polygon;
use Ivory\GoogleMap\Overlay\Symbol;
use Ivory\GoogleMap\Overlay\SymbolPath;
use Ivory\GoogleMap\Service\Base\Location\AddressLocation;
use Ivory\GoogleMap\Service\Base\Location\CoordinateLocation;
use Ivory\GoogleMap\Service\Direction\Request\DirectionRequest;
use Ivory\GoogleMap\Service\Direction\Request\DirectionRequestInterface;
use Recommandation\RecommandationBundle\Form\CafeForm;
use Recommandation\RecommandationBundle\Form\rechercheCafeForm;
use Russia\RussiaBundle\Entity\Cafes;
use Russia\RussiaBundle\Entity\Restos;
use Skies\QRcodeBundle\Generator\Generator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Base\Bound;
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\MapTypeId;
use Ivory\GoogleMap\Overlay\Marker;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Ivory\GoogleMap\Helper\Builder\MapHelperBuilder;
use Ivory\GoogleMap\Helper\Renderer\Control\MapTypeControlStyleRenderer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Russia\RussiaBundle\Entity\Stades;


class CafeController extends Controller
{
    public function ListAction()
    {
        $em=$this->getDoctrine()->getManager();
        $cafe=$em->getRepository('RussiaRussiaBundle:Cafes')->findAll();
        return $this->render('@RecommandationRecommandation/Cafe/affichecafe.html.twig',array("cafes"=>$cafe));
    }

    public function accAction()
    {
        $tasks = $this->getDoctrine()->getManager()
        ->getRepository('RussiaRussiaBundle:Cafes')
        ->findAll();
        $normalizer = new ObjectNormalizer();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
        }

    public function differentAction($id)
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository('RussiaRussiaBundle:Cafes')
            ->find($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

    public function ListadminAction()
    {
        $em=$this->getDoctrine()->getManager();
        $cafe=$em->getRepository('RussiaRussiaBundle:Cafes')->findAll();
        return $this->render('@RecommandationRecommandation/Cafe/affichecafeadmin.html.twig',array("cafes"=>$cafe));
    }

    public function detAction ($id, Request $request)
    {
        $em = $this -> getDoctrine() -> getManager();
        $cafe = $em -> getRepository("RussiaRussiaBundle:Cafes")->find($id);
        $cv = $em->getRepository('RussiaRussiaBundle:Cafes')->cafeville($cafe->getIdville());
        $ss = $em->getRepository('RussiaRussiaBundle:Stades')->stadecafe($cafe->getIdville());

        $coor = $cafe->getPositioncafe();
        $coor1 = $ss[0]->getPositionstade();
        $lat = array_map('intval',explode(',',$coor));
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
                'rules'   => [               // Mandatory (at least one rule)
                    'color'      => '0xc280e9',
                    'visibility' => 'simplified',
                ],
            ],
            [
                'feature' => 'transit.line',
                'rules'   => [
                    'visibility' => 'simplified',
                    'color'      => '0xbababa',
                ]
            ],
        ]);

        $x = new Cafes();
        $em=$this->getDoctrine()->getManager();
        $cafes=$em->getRepository('RussiaRussiaBundle:Cafes')->findAll();
        $form=$this->createForm(rechercheCafeForm::class,$x);
        $form->handleRequest($request);
        if ($request->isXmlHttpRequest())
        {
            $serializer = new Serializer(array(new ObjectNormalizer()));
            $cafes=$em->getRepository('RussiaRussiaBundle:Cafes')
                ->findSerieDQL($request->get('nomcafe'));
            $data=$serializer->normalize($cafes);
            return new JsonResponse($data);
        }

        return $this->render("@RecommandationRecommandation/Cafe/detcafe.html.twig",
            array('cafe'=>$cafe, 'map'=>$map, 'cafes' => $cafes,'ss'=>$ss,'cv'=>$cv,'form'=>$form->createView()));
    }

    public function ajoutAction(Request $request)
    {
        $cafe = new Cafes();

        $form = $this->createFormBuilder($cafe)
            ->add('nomcafe')
            ->add('detailscafe', TextareaType::class, array(
                'attr' => array('cols' => '20', 'rows' => '5'),
            ))
            ->add('positioncafe')
            ->add('photocafe', FileType::class, array('label'=>false))
            ->add('idville', EntityType::class,array(
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
            $em->persist($cafe);
            $em->flush();

            return $this->redirectToRoute('affichecafeadmin');

        }

        return $this->render('RecommandationRecommandationBundle:Cafe:ajout.html.twig',array('form' => $form->createView()));
    }

    public function UpdateAction(Request $request, $id)
    {
        $em=$this->getDoctrine()->getManager();
        $cafe=$em->getRepository('RussiaRussiaBundle:Cafes')->find($id);
        $form=$this->createForm(CafeForm::class, $cafe);
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($cafe);
            $em->flush();
            return $this->redirectToRoute('affichecafeadmin');
        }
        return $this->render('RecommandationRecommandationBundle:Cafe:update.html.twig',array('form'=>$form->createView(),'cafe'=>$cafe));
    }

    public function DeleteAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $cafe=$em->getRepository('RussiaRussiaBundle:Cafes')->find($id);
        $em->remove($cafe);
        $em->flush();
        return $this->redirectToRoute('affichecafeadmin');
    }

    public function rechercheSerieDQLAction(Request $request)
    {
        $cafe = new Cafes();
        $em=$this->getDoctrine()->getManager();
        $cafes=$em->getRepository('RussiaRussiaBundle:Cafes')->findAll();
        $form=$this->createForm(rechercheCafeForm::class,$cafe);
        $form->handleRequest($request);
        if ($request->isXmlHttpRequest())
        {
            $serializer = new Serializer(array(new ObjectNormalizer()));
            $cafes=$em->getRepository('RussiaRussiaBundle:Cafes')
                ->findSerieDQL($request->get('nomcafe'));
            $data=$serializer->normalize($cafes);
            return new JsonResponse($data);
        }
        return $this->render('@RecommandationRecommandation/Cafe/recherche.html.twig',array('cafes' => $cafes,'form'=>$form->createView()));

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

        $filename = 'cafe_russia2018';

        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
        $pdf->Output($filename.".pdf",'I'); // This will output the PDF as a response directly
    }

    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $cafe = $em->getRepository("RussiaRussiaBundle:Cafes")->find($id);
        $options = array(
            'code'   => 'string to encode',
            'type'   => 'qrcode',
            'format' => 'html',
        );

        $generator = new Generator();
        $barcode = $generator->generate($options);
        $html = $this->renderView(
            '@RecommandationRecommandation/Cafe/pdf.html.twig',
            array
            (
                'cafe'=>$cafe,
                '$barcode'=>$barcode
            )
        );

        $this->returnPDFResponseFromHTML($html);

    }

}