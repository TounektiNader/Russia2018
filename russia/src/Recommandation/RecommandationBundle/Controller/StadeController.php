<?php
/**
 * Created by PhpStorm.
 * User: Ouss'Hr
 * Date: 19/03/2018
 * Time: 15:43
 */

namespace Recommandation\RecommandationBundle\Controller;
use Ivory\GoogleMap\Overlay\Animation;
use Ivory\GoogleMap\Overlay\Icon;
use Ivory\GoogleMap\Overlay\MarkerShape;
use Ivory\GoogleMap\Overlay\MarkerShapeType;
use Ivory\GoogleMap\Overlay\Symbol;
use Ivory\GoogleMap\Overlay\SymbolPath;
use Recommandation\RecommandationBundle\Form\rechercheStadeForm;
use Recommandation\RecommandationBundle\Form\StadeForm;
use Russia\RussiaBundle\Entity\Stades;
use Skies\QRcodeBundle\Generator\Generator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Base\Bound;
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\MapTypeId;
use Ivory\GoogleMap\Overlay\Marker;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class StadeController extends Controller
{
    public function ListAction()
    {
        $em=$this->getDoctrine()->getManager();
        $stade=$em->getRepository('RussiaRussiaBundle:Stades')->findAll();
        return $this->render('@RecommandationRecommandation/Stade/affichestade.html.twig',array("stades"=>$stade));
    }

    public function ListadminAction()
    {
        $em=$this->getDoctrine()->getManager();
        $stade=$em->getRepository('RussiaRussiaBundle:Stades')->findAll();
        return $this->render('@RecommandationRecommandation/Stade/affichestadeadmin.html.twig',array("stades"=>$stade));
    }

    public function detAction ($id)
    {
        $em = $this -> getDoctrine() -> getManager();
        $stade = $em -> getRepository("RussiaRussiaBundle:Stades")->find($id);
        $cv = $em->getRepository('RussiaRussiaBundle:Stades')->cafeville($stade->getIdville());
        $coor = $stade->getPositionstade();
        $lat = array_map('intval',explode(',',$coor));
        $map = new Map();
        $map->setVariable('map');
        $map->setHtmlId('map_canvas');
        $map->setAutoZoom(false);
        $map->setCenter(new Coordinate($lat[0], $lat[1]));
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

        return $this->render("@RecommandationRecommandation/Stade/detstade.html.twig",
            array('stade'=>$stade,'map'=>$map,'cv'=>$cv));

    }

    public function ajoutAction(Request $request)
    {
        $stade = new Stades();

        $form = $this->createFormBuilder($stade)
            ->add('nomstade')
            ->add('fondationstade')
            ->add('capacitestade')
            ->add('positionstade')
            ->add('equipestade')
            ->add('photostade', FileType::class, array('label'=>false))
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
            $em->persist($stade);
            $em->flush();

            return $this->redirectToRoute('affichestadeadmin');

        }

        return $this->render('RecommandationRecommandationBundle:stade:ajout.html.twig',array('form' => $form->createView()));
    }

    public function UpdateAction(Request $request, $id)
    {
        $em=$this->getDoctrine()->getManager();
        $stade=$em->getRepository('RussiaRussiaBundle:Stades')->find($id);
        $form=$this->createForm(StadeForm::class, $stade);
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($stade);
            $em->flush();
            return $this->redirectToRoute('affichestadeadmin');
        }
        return $this->render('RecommandationRecommandationBundle:stade:update.html.twig',array('form'=>$form->createView(),'stade'=>$stade));
    }

    public function DeleteAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $stade=$em->getRepository('RussiaRussiaBundle:Stades')->find($id);
        $em->remove($stade);
        $em->flush();
        return $this->redirectToRoute('affichestadeadmin');
    }

    public function rechercheSerieDQLAction(Request $request)
    {
        $hotel = new Stades();
        $em=$this->getDoctrine()->getManager();
        $hotels=$em->getRepository('RussiaRussiaBundle:Stades')->findAll();
        $form=$this->createForm(rechercheStadeForm::class,$hotel);
        $form->handleRequest($request);
        if ($request->isXmlHttpRequest())
        {
            $serializer = new Serializer(array(new ObjectNormalizer()));
            $hotels=$em->getRepository('RussiaRussiaBundle:Stades')
                ->findSerieDQL($request->get('nomstade'));
            $data=$serializer->normalize($hotels);
            return new JsonResponse($data);
        }
        return $this->render('@RecommandationRecommandation/Stade/recherche.html.twig',array('hotels' => $hotels,'form'=>$form->createView()));

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

        $filename = 'stade_russia2018';

        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
        $pdf->Output($filename.".pdf",'I'); // This will output the PDF as a response directly
    }

    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $stade = $em->getRepository("RussiaRussiaBundle:Stades")->find($id);
        $options = array(
            'code'   => 'string to encode',
            'type'   => 'qrcode',
            'format' => 'html',
        );

        $generator = new Generator();
        $barcode = $generator->generate($options);
        $html = $this->renderView(
            '@RecommandationRecommandation/Stade/pdf.html.twig',
            array
            (
                'stade'=>$stade,
                'barcode'=>$barcode
            )
        );

        $this->returnPDFResponseFromHTML($html);

    }
}