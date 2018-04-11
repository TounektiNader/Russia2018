<?php
/**
 * Created by PhpStorm.
 * User: Ouss'Hr
 * Date: 19/03/2018
 * Time: 15:48
 */

namespace Recommandation\RecommandationBundle\Controller;
use Ivory\GoogleMap\Overlay\Animation;
use Ivory\GoogleMap\Overlay\Icon;
use Ivory\GoogleMap\Overlay\MarkerShape;
use Ivory\GoogleMap\Overlay\MarkerShapeType;
use Ivory\GoogleMap\Overlay\Symbol;
use Ivory\GoogleMap\Overlay\SymbolPath;
use Recommandation\RecommandationBundle\Form\rechercheVilleForm;
use Recommandation\RecommandationBundle\Form\VilleForm;
use Russia\RussiaBundle\Entity\Villes;
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


class VilleController extends Controller
{
    public function ListAction()
    {
        $em=$this->getDoctrine()->getManager();
        $ville=$em->getRepository('RussiaRussiaBundle:Villes')->findAll();
        return $this->render('@RecommandationRecommandation/Ville/afficheville.html.twig',array("villes"=>$ville));
    }

    public function ListadminAction()
    {
        $em=$this->getDoctrine()->getManager();
        $ville=$em->getRepository('RussiaRussiaBundle:Villes')->findAll();
        return $this->render('@RecommandationRecommandation/Ville/affichevilledmin.html.twig',array("villes"=>$ville));
    }

    public function detAction ($id)
    {
        $em = $this -> getDoctrine() -> getManager();
        $ville = $em -> getRepository("RussiaRussiaBundle:Villes")->find($id);
        $cv = $em->getRepository('RussiaRussiaBundle:Villes')->cafeville($ville->getIdville());
        $cv1 = $em->getRepository('RussiaRussiaBundle:Villes')->hotelville($ville->getIdville());
        $cv2 = $em->getRepository('RussiaRussiaBundle:Villes')->restoville($ville->getIdville());
        $cv3 = $em->getRepository('RussiaRussiaBundle:Villes')->stadeville($ville->getIdville());
        $coor = $ville->getCoordonnees();
        $lat = array_map('intval',explode(',',$coor));
        $map = new Map();
        $map->setVariable('map');
        $map->setHtmlId('map_canvas');
        $map->setAutoZoom(false);
        $map->setCenter(new Coordinate($lat[0], $lat[1]));
        $map->setMapOption('zoom', 0);
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
        return $this->render("@RecommandationRecommandation/Ville/detville.html.twig",
            array('ville'=>$ville,'map'=>$map,'cv'=>$cv,'cv1'=>$cv1,'cv2'=>$cv2,'cv3'=>$cv3));

    }

    public function ajoutAction(Request $request)
    {
        $ville = new Villes();

        $form = $this->createFormBuilder($ville)
            ->add('nomville')
            ->add('fondationville')
            ->add('populationville')
            ->add('coordonnees')
            ->add('timezone')
            ->add('equipelocale')
            ->add('photoville', FileType::class, array('label'=>false))
            ->add('logoville', FileType::class, array('label'=>false))
            ->add('logoequipe', FileType::class, array('label'=>false))
            ->add('Ajouter', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ville);
            $em->flush();

            return $this->redirectToRoute('affichevilleadmin');

        }

        return $this->render('RecommandationRecommandationBundle:ville:ajout.html.twig',array('form' => $form->createView()));
    }

    public function UpdateAction(Request $request, $id)
    {
        $em=$this->getDoctrine()->getManager();
        $ville=$em->getRepository('RussiaRussiaBundle:Villes')->find($id);
        $form=$this->createForm(VilleForm::class, $ville);
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($ville);
            $em->flush();
            return $this->redirectToRoute('affichevilleadmin');
        }
        return $this->render('RecommandationRecommandationBundle:ville:update.html.twig',array('form'=>$form->createView(),'ville'=>$ville));
    }

    public function DeleteAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $ville=$em->getRepository('RussiaRussiaBundle:Villes')->find($id);
        $em->remove($ville);
        $em->flush();
        return $this->redirectToRoute('affichevilleadmin');
    }

    public function rechercheSerieDQLAction(Request $request)
    {
        $hotel = new Villes();
        $em=$this->getDoctrine()->getManager();
        $hotels=$em->getRepository('RussiaRussiaBundle:Villes')->findAll();
        $form=$this->createForm(rechercheVilleForm::class,$hotel);
        $form->handleRequest($request);
        if ($request->isXmlHttpRequest())
        {
            $serializer = new Serializer(array(new ObjectNormalizer()));
            $hotels=$em->getRepository('RussiaRussiaBundle:Villes')
                ->findSerieDQL($request->get('nomville'));
            $data=$serializer->normalize($hotels);
            return new JsonResponse($data);
        }
        return $this->render('@RecommandationRecommandation/Ville/recherche.html.twig',array('hotels' => $hotels,'form'=>$form->createView()));

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

        $filename = 'ville_russia2018';

        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
        $pdf->Output($filename.".pdf",'I'); // This will output the PDF as a response directly
    }

    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $ville = $em->getRepository("RussiaRussiaBundle:Villes")->find($id);
        $options = array(
            'code'   => 'string to encode',
            'type'   => 'qrcode',
            'format' => 'html',
        );

        $generator = new Generator();
        $barcode = $generator->generate($options);
        $html = $this->renderView(
            '@RecommandationRecommandation/Ville/pdf.html.twig',
            array
            (
                'ville'=>$ville,
                'barcode'=>$barcode
            )
        );

        $this->returnPDFResponseFromHTML($html);

    }
}