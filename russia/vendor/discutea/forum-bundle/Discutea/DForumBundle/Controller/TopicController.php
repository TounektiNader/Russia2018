<?php
namespace Discutea\DForumBundle\Controller;


use Discutea\DForumBundle\Controller\Base\BaseTopicController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Discutea\DForumBundle\Form\Type\TopicEditType;
use Discutea\DForumBundle\Entity\Forum;
use Discutea\DForumBundle\Entity\Topic;
use Symfony\Component\HttpFoundation\Request;

/**
 * TopicController 
 * 
 * This class contains useful methods for the proper functioning of the topic controller and not method actions.
 * This class extends BaseController.
 * 
 * @package  DForumBundle
 * @author   David Verdier <contact@discutea.com>
 * @access   public
 */
class TopicController extends BaseTopicController
{

    /**
     * infos:  Display the topics of a forum
     * 
     * @Route("/cat/{slug}", name="discutea_forum_topic")
     * @ParamConverter("forum")
     * @Security("is_granted('CanReadForum', forum)")
     * 
     */
    public function topicAction(Request $request, Forum $forum)
    {
        $topics = $forum->getTopics(); 
        
        $pagination = $this->get('discutea.forum.pagin')->pagignate('topics', $topics);
        
        if (($form = $this->generateTopicForm($forum)) !== NULL) {
            $form->handleRequest($request);

            if (($form->isSubmitted()) && ($form->isValid())) 
            {
                $content = $form->get('content')->getData();
                $post = $this->createPost($content, $this->topic);
                $em = $this->getEm();


                /**
                 *@var UploadedFile $file
                 */
                $file=$this->topic->getImage();
                //  if($file->guessExtension()=='jpeg' || $file->guessExtension()=='png' || $file->guessExtension()=='JPEG' ||$file->guessExtension()=='PNG')
                //{
                $fileName=md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $this->getParameter('image_directory'),$fileName
                );
                $this->topic->setImage($fileName);




                $em->persist($this->topic);
                $em->persist($post);
                $em->flush();

                $request->getSession()->getFlashBag()->add('success', $this->getTranslator()->trans('discutea.forum.topic.create'));
                return $this->redirect($this->generateUrl('discutea_forum_post', array('slug' => $this->topic->getSlug())));
            }

            $form = $form->createView();
        }
        
        return $this->render('DForumBundle::topic.html.twig', array(
            'forum' => $forum,
            'pagination' => $pagination,
            'form' => $form
        ));
    }

    /**
     * @Route("/topic/delete/{id}", name="discutea_forum_topic_delete")
     * @ParamConverter("topic")
     * @Security("is_granted('CanReadTopic', topic)")
     */
    public function deleteAction(Request $request, Topic $topic)
    {
        $forumSlug = $topic->getForum()->getSlug();
        $em = $this->getEm();
        $em->remove($topic);
        $em->flush();
        $request->getSession()->getFlashBag()->add('success', $this->getTranslator()->trans('discutea.forum.topic.delete'));
        return $this->redirect($this->generateUrl('discutea_forum_topic', array('slug' => $forumSlug)));       
 
    }

    /**
     * @Route("/topic/edit/{id}", name="discutea_forum_topic_edit")
     * @ParamConverter("topic")
     * @Security(" is_granted('CanReadTopic', topic)")
     * 
     */
    public function editAction(Request $request, Topic $topic)
    {
        $form = $this->createForm(TopicEditType::class, $topic);
        
        $form->handleRequest($request);
        
        if (($form->isSubmitted()) && ($form->isValid())) 
        {
            $forumSlug = $topic->getForum()->getSlug();

            $em = $this->getEm();

            /**
             *@var UploadedFile $file
             */
            $file=$topic->getImage();
            //  if($file->guessExtension()=='jpeg' || $file->guessExtension()=='png' || $file->guessExtension()=='JPEG' ||$file->guessExtension()=='PNG')
            //{
            $fileName=md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('image_directory'),$fileName
            );
            $topic->setImage($fileName);




            $em->persist($topic);

            $em->flush();


            $request->getSession()->getFlashBag()->add('success', $this->getTranslator()->trans('discutea.forum.topic.edit'));
            return $this->redirect($this->generateUrl('discutea_forum_topic', array('slug' => $forumSlug)));
        }
         
        return $this->render('DForumBundle::Form/topic_edit.html.twig', array(
            'form'  => $form->createView()
        ));
    }

}
