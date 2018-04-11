<?php
namespace Discutea\DForumBundle\Controller;

use Discutea\DForumBundle\Controller\Base\BaseController;
use Discutea\DForumBundle\Entity\Topic;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

use Discutea\DForumBundle\Entity\Category;
use Discutea\DForumBundle\Entity\Forum;
use Discutea\DForumBundle\Form\Type\ForumType;
use Discutea\DForumBundle\Form\Type\Remover\RemoveForumType;


/**
 * ForumController 
 * 
 * This class contains actions methods for forum.
 * This class extends BaseForumController.
 * 
 * @package  DForumBundle
 * @author   David Verdier <contact@discutea.com>
 * @access   public
 */
class ForumController extends BaseController
{

    /**
     *
     * @Route("", name="discutea_forum_homepage")
     * 
     * @return objet Symfony\Component\HttpFoundation\Response
     * 
     */
    public function indexAction(Request $request)
    {
        $categories = $this->getEm()
            ->getRepository('DForumBundle:Category')
            ->findBy(array('name'=>"Russia2018"))
        ;


         $lasttopic=$this->getEm()->getRepository(Topic::class)->findLast(2);

        $paginator  = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $categories, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 5)/*page number*/

        );


        $nombre= $this->getEm()->getRepository(Forum::class)->nombresujet($categories);

        return $this->render('DForumBundle::index.html.twig', array(
            'categories' => $result,'nombres'=>$nombre,'last'=>$lasttopic
        ));
    }


    /**
     *
     * @Route("/2", name="discutea_forum_homepage2")
     *
     * @return objet Symfony\Component\HttpFoundation\Response
     *
     */
    public function index2Action(Request $request)
    {
        $categories = $this->getEm()
            ->getRepository('DForumBundle:Category')
            ->findBy(array('name'=>"foot"))
        ;
        $lasttopic=$this->getEm()->getRepository(Topic::class)->findLast(2);
        $paginator  = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $categories, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 5)/*page number*/

        );
        $nombre= $this->getEm()->getRepository(Forum::class)->nombresujet($categories);


return $this->render('DForumBundle::index2.html.twig', array(
            'categories' => $result,'nombres'=>$nombre,'last'=>$lasttopic
        ));


    }




    /**
     * 
     * @Route("/forum/new/{id}", name="discutea_forum_create_forum")
     * @ParamConverter("category")
     *
     * 
     * @param object $request Symfony\Component\HttpFoundation\Request
     * @param objct $category Discutea\DForumBundle\Entity\Category
     * 
     * @return object Symfony\Component\HttpFoundation\RedirectResponse redirecting moderator's dashboard
     * @return objet Symfony\Component\HttpFoundation\Response
     * 
     */
    public function newForumAction(Request $request, Category $category)
    {

        $forum = new Forum();
        $forum->setCategory($category);
        
        $form = $this->createForm(ForumType::class, $forum);

        $form->handleRequest($request);
        
        if (($form->isSubmitted()) && ($form->isValid())) 
        {
            $em = $this->getEm();

            /**
             *@var UploadedFile $file
             */
            $file=$forum->getImage();
          //  if($file->guessExtension()=='jpeg' || $file->guessExtension()=='png' || $file->guessExtension()=='JPEG' ||$file->guessExtension()=='PNG')
            //{
                $fileName=md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $this->getParameter('image_directory'),$fileName
                );
                $forum->setImage($fileName);
            $em->persist($forum);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', $this->getTranslator()->trans('discutea.forum.forum.created'));
            return $this->redirect($this->generateUrl('discutea_forum_homepage'));
        }

        return $this->render('DForumBundle::Admin/forum.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * 
     * @Route("forum/edit/{id}", name="discutea_forum_edit_forum")
     * @ParamConverter("forum")
     *
     * 
     * @param object $request Symfony\Component\HttpFoundation\Request
     * @param objct $forum Discutea\DForumBundle\Entity\Forum
     * 
     * @return object Symfony\Component\HttpFoundation\RedirectResponse redirecting moderator's dashboard
     * @return objet Symfony\Component\HttpFoundation\Response
     * 
     */
    public function editForumAction(Request $request, Forum $forum)
    {
        
        $form = $this->createForm(ForumType::class, $forum);

        $form->handleRequest($request);
        
        if (($form->isSubmitted()) && ($form->isValid())) 
        {
            $em = $this->getEm();
            $em->persist($forum);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', $this->getTranslator()->trans('discutea.forum.forum.edit'));
            return $this->redirect($this->generateUrl('discutea_forum_admin_dashboard'));
        }

        return $this->render('DForumBundle::Admin/forum.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * 
     * @Route("forum/remove/{id}", name="discutea_forum_remove_forum")
     * @ParamConverter("forum")
     *
     * 
     * @param object $request Symfony\Component\HttpFoundation\Request
     * @param objct $forum Discutea\DForumBundle\Entity\Forum
     * 
     * @return object Symfony\Component\HttpFoundation\RedirectResponse moderator's dashboard
     * @return objet Symfony\Component\HttpFoundation\Response
     * 
     */

    public function removeForumAction(Request $request, Forum $forum)
    {

        $form = $this->createForm(RemoveForumType::class);
        $em = $this->getEm();
        $form->handleRequest($request);
        
        if (($form->isSubmitted()) && ($form->isValid())) 
        {
            if ($form->getData()['purge'] === false) {
                $newFor = $em->getRepository('DForumBundle:Forum')->find($form->getData()['movedTo']) ;
                
                foreach ($forum->getTopics() as $topic) { $topic->setForum($newFor); }
                
                $em->flush();
                $em->clear();
                $request->getSession()->getFlashBag()->add('success', $this->getTranslator()->trans('discutea.forum.forum.movedtopics'));
            }
            
            
            $forum = $em->getRepository('DForumBundle:Forum')->find($forum->getId()); // Fix detach error
            $em->remove($forum);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', $this->getTranslator()->trans('discutea.forum.forum.delete'));
            return $this->redirect($this->generateUrl('discutea_forum_admin_dashboard'));
        }
 
        return $this->render('DForumBundle::Admin/remove_forum.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
