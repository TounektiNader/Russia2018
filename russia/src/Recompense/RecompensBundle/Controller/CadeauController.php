<?php

namespace Recompense\RecompensBundle\Controller;

use Recompense\RecompensBundle\Entity\Cadeau;
use Recompense\RecompensBundle\Entity\Recompense;
use Match\MatchBundle\Entity\User;
use Recompense\RecompensBundle\Entity\Promo;
use Recompense\RecompensBundle\Form\PromoType;
use Recompense\RecompensBundle\Entity\Tag;
use Beelab\TagBundle\Tag\TagInterface;
use Recompense\RecompensBundle\Form\CadeauType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\DateTime;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CadeauController extends Controller
{

    public function allAction()
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository('RecompenseRecompensBundle:Cadeau')
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }
    public function deletemobileAction($coupon,$iduser,$total)
    {
        $em=$this->getDoctrine()->getManager();
        $promo2=$em->getRepository("RecompenseRecompensBundle:Promo")->findBy([
            "coupon" => $coupon

        ]);
        $hours=2;
        $user=$em->getRepository("UserBundle:User")->find($iduser);
        $reduction=$promo2[0]->getPromotion();
        $date=$promo2[0]->getExpiration();
        $date2=new \DateTime( "Now" ,new \DateTimeZone("Africa/Tunis"));
        $date2->sub(new \DateInterval('PT'.$hours.'H'));
        if($date<$date2)
        {
            $em->remove($promo2[0]);
            $em->flush();
        }
        else
        {
            $user->setJeton($user->getJeton()+ceil($total*$reduction/100));
            $em->persist($user);
            $em->remove($promo2[0]);
            $em->flush();
        }
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($promo2[0]);
        return new JsonResponse($formatted);
    }
    public function allpromoAction()
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository('RecompenseRecompensBundle:Promo')
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }
    public function allrecAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository("UserBundle:User")->find($id);
        $recompense = $em->getRepository("RecompenseRecompensBundle:Recompense")->findBy([
            "username" => $user

        ]);
        /*dump($recompense);
        exit();*/
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($recompense);
        return new JsonResponse($formatted);
    }
    public function AdddAction($idcadeau,$iduser)
    {
        $em=$this->getDoctrine()->getManager();
        $cadeau=$em->getRepository("RecompenseRecompensBundle:Cadeau")->find($idcadeau);
        $user=$em->getRepository("UserBundle:User")->find($iduser);
        $recompense= new Recompense();
        $recompense->setUsername($user);
        $recompense->setIdcadeau($cadeau);
        if($user->getJeton()>=$cadeau->getJeton())
        {
            $user->setJeton($user->getJeton()-$cadeau->getJeton());
            $em->persist($recompense);
            $em->persist($user);
            $em->flush();

        }
        else
        {

        }
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($recompense);
        return new JsonResponse($formatted);
    }
    function random($car){
        $string = "";
        $chaine = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        srand((double)microtime()*1000000);
        for($i=0; $i<$car; $i++) {
            $string .= $chaine[rand()%strlen($chaine)];
        }
        return $string;
    }
    public function AddpromoAction()
    {
        $em=$this->getDoctrine()->getManager();
        $nb_min = 1;
        $nb_max = 50;
        $nombre = mt_rand($nb_min,$nb_max);
        $promo= new Promo();
        $promo->setCoupon($this->random(4));
        $minutes_to_add = 30;
        $hours=2;
        $hour=1;
        $date=new \DateTime( "Now" ,new \DateTimeZone("Africa/Tunis"));
        $date->add(new \DateInterval('PT' . $minutes_to_add . 'M'));
        $date->sub(new \DateInterval('PT'.$hour.'H'));
        $promo->setExpiration($date);
        $promo->setPromotion($nombre);



        $promo2=$em->getRepository('RecompenseRecompensBundle:Promo')
            ->findBy(array(), array('expiration' => 'asc'));
        $debut=count($promo2);


        foreach ($promo2 as $item)
        {
            $date2=new \DateTime( "Now" ,new \DateTimeZone("Africa/Tunis"));
            $date2->add(new \DateInterval('PT'.$hours.'H'));
            var_dump($item->getExpiration() < $date2);
            dump($date2);
            if($item->getExpiration() < $date2)
            {
                $em->remove($item);
                $em->flush();
            }

        }
        $promo3=$em->getRepository('RecompenseRecompensBundle:Promo')
            ->findBy(array(), array('expiration' => 'asc'));

        $fin=count($promo3);
        $debut=$debut;
        if($fin<$debut or $fin==$debut)
        {

            $em->persist($promo);
            $em->flush();
        }

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($promo);
        return new JsonResponse($formatted);
    }

    public function DeletePromoAction(Request $request)
    {
        $user=$this->getUser();
        if($request->isMethod('post'))
        {
            $promo=$request->get('coupon');
            $total=$request->get('total');
            if(empty($promo))
                return $this->redirectToRoute('RecompenseUser');

        }

        $em=$this->getDoctrine()->getManager();
        $promo2=new Promo();
        $promo2=$em->getRepository("RecompenseRecompensBundle:Promo")->findBy([
            "coupon" => $promo

        ]);
        $reduction=$promo2[0]->getPromotion();
        $date=$promo2[0]->getExpiration();
        $date2=new \DateTime( "Now" ,new \DateTimeZone("Africa/Tunis"));
        if($date<$date2)
        {
            $em->remove($promo2[0]);
            $em->flush();
        }
        else
        {
            $user->setJeton($user->getJeton()+ceil($total*$reduction/100));
            $em->persist($user);
            $em->remove($promo2[0]);
            $em->flush();
        }
        return $this->redirectToRoute('RecompenseUser');
    }
    public function AjoutPromoAction(Request $request)
    {
        $user=$this->getUser();
        $promo =new Promo();
        $form = $this->createFormBuilder($promo)
            ->add('coupon', TextType::class)
            ->add('promotion', IntegerType::class)
            ->add('expiration',DateTimeType::class)
            ->add('captcha', CaptchaType::class, array(
                'width' => 200,
                'height' => 50,
                'length' => 6,
            ))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $promo = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($promo);
            $entityManager->flush();
            return $this->redirectToRoute("AjouterPromo");
        }
        return $this->render('RecompenseRecompensBundle::ajoutpromo.html.twig', array(
            'form' => $form->createView(),'user'=>$user
        ));


    }
    public function AjoutAction($id)
    {
        $user=$this->getUser();

        $em=$this->getDoctrine()->getManager();
        $cadeau=$em->getRepository("RecompenseRecompensBundle:Cadeau")->find($id);
        $recompense= new Recompense();
        $recompense->setUsername($user);
        $recompense->setIdcadeau($cadeau);

        if($user->getJeton()>$cadeau->getJeton())
        {
            $user->setJeton($user->getJeton()-$cadeau->getJeton());
            $em->persist($recompense);
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute("RecompenseUser");
        }
        else
        {
            return $this->redirectToRoute("CadeauxModele");
        }


    }
    public function RecompenseAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $user=$this->getUser();
        $recompense = $em->getRepository("RecompenseRecompensBundle:Recompense")->findBy([
            "username" => $user

        ]);
        $promo=$em->getRepository('RecompenseRecompensBundle:Promo')
            ->findBy(array(), array('expiration' => 'desc'));
        foreach ($promo as $item)
        {
            $date2=new \DateTime( "Now" ,new \DateTimeZone("Africa/Tunis"));
            if($item->getExpiration()<$date2)
            {
                $em->remove($item);
                $em->flush();
            }
            elseif ($item->getExpiration()==$date2)
                return $this->render('RecompenseRecompensBundle::affichagerecompense.html.twig',array('promo'=>$item,'recompense'=>$recompense));

            elseif($item->getExpiration()>=$date2)
                return $this->render('RecompenseRecompensBundle::affichagerecompense.html.twig',array('promo'=>$item,'recompense'=>$recompense));


        }
        $item=null;
        return $this->render('RecompenseRecompensBundle::affichagerecompense.html.twig',array('promo'=>$item,'recompense'=>$recompense));
    }
    public function ajouterAction(Request $request)
    {
        $user=$this->getUser();
        $cadeau =new Cadeau();

      $tag =new Tag();

        $form = $this->createFormBuilder($cadeau)
            ->add('categorie', ChoiceType::class, array(
                'choices'  => array(
                    'Voiture' => 'Voiture',
                    'Telephone' => 'Telephone',
                    'Bon_Achat' => 'Bon_Achat',
                    'Ticket' => 'Ticket'
                )))
            ->add('type', TextType::class)
            ->add('jeton', IntegerType::class)
            ->add('image', FileType::class)
            ->add('tagsText', TextType::class, ['required' => false, 'label' => 'Tags'])
            ->add('captcha', CaptchaType::class, array(
                'width' => 200,
                'height' => 50,
                'length' => 6,
            ))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $cadeau = $form->getData();


            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cadeau);
            $entityManager->flush();

            return $this->redirectToRoute("AjouterModele");
        }
        return $this->render('RecompenseRecompensBundle::ajout.html.twig', array(
            'form' => $form->createView(),'user'=>$user
        ));
    }

    public function ListAction()
    {
        $user=$this->getUser();
        $cadeau=new Cadeau();
        $em=$this->getDoctrine()->getManager();
        $cadeau=$em->getRepository("RecompenseRecompensBundle:Cadeau")->findAll();
        return $this->render('RecompenseRecompensBundle::afficher.html.twig',array('cadeaus'=>$cadeau,'user'=>$user));
    }
    public function ListPromoAction()
    {
        $user=$this->getUser();
        $em=$this->getDoctrine()->getManager();
        $cadeau=$em->getRepository("RecompenseRecompensBundle:Promo")->findAll();

        return $this->render('RecompenseRecompensBundle::afficherpromo.html.twig',array('cadeaus'=>$cadeau,'user'=>$user));
    }
    public function effacerPromoAction($id)
    {
        $promo2= new Promo();
        $em=$this->getDoctrine()->getManager();
        $promo2=$em->getRepository("RecompenseRecompensBundle:Promo")->find($id);
        $em->remove($promo2);
        $em->flush();
        return $this->redirectToRoute("PromoModele");
    }

    public function CadeauAction()
    {
        $em=$this->getDoctrine()->getManager();
        $user=$this->getUser();

        $user=$this->getUser();
        $cadeau=new Cadeau();


        $em=$this->getDoctrine()->getManager();
        $tag=$em->getRepository("RecompenseRecompensBundle:Tag")->findAll();
        $cadeau=$em->getRepository("RecompenseRecompensBundle:Cadeau")->findAll();

        return $this->render('RecompenseRecompensBundle::cadeau.html.twig',array('tags'=>$tag,'cadeaus'=>$cadeau,'user'=>$user));
    }
    public function CadeauTagAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $user=$this->getUser();

        $user=$this->getUser();
        $cadeau=new Cadeau();

        $cadeau= array();
        $em=$this->getDoctrine()->getManager();
        $tag=$em->getRepository("RecompenseRecompensBundle:Tag")->find($id);
        $cadeau2=$em->getRepository("RecompenseRecompensBundle:Cadeau")->findAll();
        $tags=$em->getRepository("RecompenseRecompensBundle:Tag")->findAll();
        foreach($cadeau2 as $nn)
        {
            $n=$nn->hasTag($tag);


            if($n === true)
             array_push($cadeau,$nn);
        }



        return $this->render('RecompenseRecompensBundle::cadeau.html.twig',array('tags'=>$tags,'cadeaus'=>$cadeau,'user'=>$user));
    }
    public function DeleteAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $cadeau=$em->getRepository("RecompenseRecompensBundle:Cadeau")->find($id);
        $url='uploads/images/';
        $i=$cadeau->getImage();
        $total=$url.$i;
        @unlink($total);
        $em->remove($cadeau);
        $em->flush();
        return $this->redirectToRoute("AffichageModele");
    }
    public function UpdateAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();

        $cadeau=$em->getRepository("RecompenseRecompensBundle:Cadeau")->find($id);
        $i=$cadeau->getImage();
        $cadeau->setImage(null);
        $form=$this->createForm(CadeauType::class,$cadeau)->add('categorie', ChoiceType::class, array(
        'choices' => array(
            'Votre choix' => array(
                $cadeau->getCategorie() =>$cadeau->getCategorie()
            ),
            'choix'  => array(
                'Voiture' => 'Voiture',
                'Telephone' => 'Telephone',
                'Bon_Achat' => 'Bon_Achat',
                'Ticket' => 'Ticket'

            ),
        ),
    ))
            ->add('image',FileType::class);
        $url='http://localhost/russia/web/uploads/images/';


        $image=$url.$i;
        if ($form->HandleRequest($request)->isValid()) {

            $em=$this->getDoctrine()->getManager();

            $em->persist($cadeau);
            $em->flush();
            return $this->redirectToRoute("AffichageModele");
        }
         return $this->render("RecompenseRecompensBundle::update.html.twig",array('form'=>$form->createView(),'cad'=>$image));

    }

}
