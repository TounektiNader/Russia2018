<?php

namespace Actualite\ActualiteBundle\Controller;


use Russia\RussiaBundle\Entity\Actualite;
use Russia\RussiaBundle\Entity\Avis;
use Russia\RussiaBundle\Entity\Commentaire;
use Russia\RussiaBundle\Form\ActualiteType;
use Russia\RussiaBundle\Form\AvisType;
use Russia\RussiaBundle\Form\CommentaireType;
use Russia\RussiaBundle\RussiaRussiaBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
Use Russia\UserBundle\Entity\User;


class ActualiteController extends Controller
{

    public function indexAction(Request $request){
        $ev=new Actualite();
        $user=$this->getUser();

        $form=$this->createForm(ActualiteType::class,$ev);
        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $ev->setUsername($this->get('security.token_storage')->getToken()->getUser());
            $em=$this->getDoctrine()->getManager();
            $ev->UploadProfilePicture2();
            $em->persist($ev);
            $em->flush();
            return $this->redirectToRoute("actualite_actualite_affiche");
        }


        return $this->render('ActualiteActualiteBundle:Default:ajouterActualiter.html.twig', array('form'=>$form->createView()));
    }

    public function ajoutAction(Request $request){
        $ev=new Actualite();
        $user=$this->getUser();

        $form=$this->createForm(ActualiteType::class,$ev);
        $form->handleRequest($request);
        if ($form->isSubmitted())
        { $ev->setUsername($this->get('security.token_storage')->getToken()->getUser());

            $em=$this->getDoctrine()->getManager();
            $ev->UploadProfilePicture2();
            $em->persist($ev);
            $em->flush();
            return $this->redirectToRoute("actualite_actualite_admin");
        }


        return $this->render('ActualiteActualiteBundle:Default:ajoutadmin.html.twig', array('form'=>$form->createView()));
    }
    public function listeAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $user=$this->get('security.token_storage')->getToken()->getUser()->getId();
        $a=$em->getRepository("Russia\RussiaBundle\Entity\Actualite")
            ->findBy(array('username'=>$user));

        $paginator  = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $a, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 4)/*page number*/

        );

        return $this->render("ActualiteActualiteBundle:Default:afficher.html.twig"
            ,array(

                'ac'=>$result
            ));
    }
    public function listeDEtouteAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();

        $a=$em->getRepository("Russia\RussiaBundle\Entity\Actualite")
            ->findAll();
        $paginator  = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $a, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 4)/*page number*/

        );

        return $this->render("ActualiteActualiteBundle:Default:affichetoute.html.twig"
            ,array(

                'ac'=>$result
            ));
    }
    public function deleteAction (Request $request, $id)
    {
        $actualite = new Actualite();
        $em = $this->getDoctrine()->getManager();
        $actualite= $em->getRepository("Russia\RussiaBundle\Entity\Actualite")->find($id);
        $em->remove($actualite);
        $em->flush();
        return $this->redirectToRoute("actualite_actualite_affiche");
    }


    public function supprimeAction (Request $request, $id)
    {
        $actualite = new Actualite();
        $em = $this->getDoctrine()->getManager();
        $actualite= $em->getRepository("Russia\RussiaBundle\Entity\Actualite")->find($id);
        $em->remove($actualite);
        $em->flush();
        return $this->redirectToRoute("actualite_actualite_admin");
    }


    public function updateAction (Request $request, $id)
    {
        $em = $this -> getDoctrine() -> getManager();
        $actualite = $em -> getRepository("Russia\RussiaBundle\Entity\Actualite")->find($id);
        $form = $this -> createForm(ActualiteType::class,$actualite);
        $form -> handleRequest($request);
        if ($form->isSubmitted())
        {
            $actualite->setUsername($this->get('security.token_storage')->getToken()->getUser());

            $em=$this->getDoctrine()->getManager();
            $actualite->UploadProfilePicture2();
            $em->persist($actualite);
            $em->flush();
            return $this->redirectToRoute("actualite_actualite_affiche");
        }
        return $this->render("ActualiteActualiteBundle:Default:modifier.html.twig",
            array('form' => $form -> createView())
        );
    }

    public function modifierAction (Request $request, $id)
    {
        $em = $this -> getDoctrine() -> getManager();
        $actualite = $em -> getRepository("Russia\RussiaBundle\Entity\Actualite")->find($id);
        $form = $this -> createForm(ActualiteType::class,$actualite);
        $form -> handleRequest($request);
        if ($form->isSubmitted())
        {
            $em->persist($actualite);
            $em->flush();
            return $this->redirectToRoute("actualite_actualite_admin");
        }
        return $this->render("ActualiteActualiteBundle:Default:modifier.html.twig",
            array('form' => $form -> createView())
        );
    }


    public function aminAction(){

        $em=$this->getDoctrine()->getManager();

        $a=$em->getRepository("Russia\RussiaBundle\Entity\Actualite")
            ->findAll();


        return $this->render("ActualiteActualiteBundle:Default:affiche.html.twig",array(

            'ac'=>$a
        ));
    }

    public function divaffAction (Request $request,$id)
    {
        $em = $this -> getDoctrine() -> getManager();
        $a = $em -> getRepository("Russia\RussiaBundle\Entity\Actualite")->find($id);
        /*$Avis=new Avis();*/
        /* $form=$this->createForm(AvisType::class,$Avis);*/
        /*$form->handleRequest($request);*/
        /*$ef = $this->getDoctrine()->getManager();*/

        /* $result = $ef->createQuery("select AVG (a.rating)
                         from RussiaRussiaBundle:Avis a
                         where a.Actualite='$id'
                         ")->getResult();

         $nbr = $result;*/
        /* if ($form->isSubmitted())
         {
             $Avis->setUser($this->get('security.token_storage')->getToken()->getUser());
             $em=$this->getDoctrine()->getManager();
             $Avis->setActualite($id);

             $em->persist($Avis);
             $em->flush();
         }*/
        $user=$this->get('security.token_storage')->getToken()->getUser();
        $Commenatires=$em->getRepository("RussiaRussiaBundle:Commentaire")->findBy(array('idActualite' =>$a));

        $comm= new Commentaire();
        $ModelForm = $this->createForm(CommentaireType::class, $comm);
        $ModelForm->handleRequest($request);
        if ($ModelForm->isValid()) {
            $comm->setIdUser($user=$this->getUser());
            $comm->setIdActualite($a);
            $comm->setDatec(new \DateTime('now'));
            $em = $this->getDoctrine()->getManager();


            $em->persist($comm);
            $em->flush();
            return $this->redirectToRoute('actualite_actualite_affichetoute');

        }

        return $this->render("ActualiteActualiteBundle:Default:detailleactualite.html.twig",
            array('a'=>$a,'com'=>$Commenatires,"form"=>$ModelForm->createView()));

    }


    public function returnPDFResponseFromHTML($html){
        //set_time_limit(30); uncomment this line according to your needs
        // If you are not in a controller, retrieve of some way the service container and then retrieve it
        //$pdf = $this->container->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        //if you are in a controlller use :
        $pdf = $this->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetAuthor('Our Code World');
        $pdf->SetTitle(('Our Code World Title'));
        $pdf->SetSubject('Our Code World Subject');
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('helvetica', '', 11, '', true);
        //$pdf->SetMargins(20,20,40, true);
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
        $pdf->setFooterData(array(0,64,0), array(0,64,128));
        $pdf->AddPage();

        $filename = 'ourcodeworld_pdf_demo';

        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
        $pdf->Output($filename.".pdf",'I'); // This will output the PDF as a response directly
    }

    public function pdfAction($id){
        // You can send the html as you want


        $em = $this->getDoctrine()->getManager();
        $Actualite = $em->getRepository("RussiaRussiaBundle:Actualite")->find($id);
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $options = array(
            'code'   => 'string to encode',
            'type'   => 'qrcode',
            'format' => 'html',
        );



        $html= $this->renderView("ActualiteActualiteBundle:Default:pdf.html.twig",array("Actualite"=>$Actualite,"user"=>$user));
        $this->returnPDFResponseFromHTML($html);
        }


    public function newActuJAction($titre,$texte,$id)
    { $em = $this->getDoctrine()->getManager();
        $Actualite = new Actualite();
        $Actualite->setTitre($titre);
        $Actualite->setTexte($texte);


        $user = $em->getRepository('UserBundle:User')->find($id);
        $Actualite->setUsername($user);


        $em->persist($Actualite);
        $em->flush();
        $encoder = new JsonResponse();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($object){
            return $object->getId();
        });
        $serializer = new Serializer(array($normalizer, $encoder));
        $formatted = $serializer->normalize($Actualite);
        return new JsonResponse($formatted);

    }

    public function accAction()
    {$tasks = $this->getDoctrine()->getManager()
        ->getRepository('RussiaRussiaBundle:Actualite')
        ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);

    }
    public function deleteactuAction ( $id)
    {
        $em = $this->getDoctrine()->getManager();
        $actualite= $em->getRepository("RussiaRussiaBundle:Actualite")->find($id);
        $em->remove($actualite);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($actualite);
        return new JsonResponse($formatted);

    }
}
