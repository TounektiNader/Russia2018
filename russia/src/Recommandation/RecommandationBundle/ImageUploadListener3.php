<?php
/**
 * Created by PhpStorm.
 * User: Ouss'Hr
 * Date: 23/03/2018
 * Time: 11:46
 */

namespace Recommandation\RecommandationBundle;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Russia\RussiaBundle\Entity\Stades;
use Recommandation\RecommandationBundle\ImageUpload;

class ImageUploadListener3

{ private $uploader;

    public function __construct(ImageUpload $uploader)
    {
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    private function uploadFile($entity)
    {
        // upload only works for Product entities
        if (!$entity instanceof Stades) {
            return;
        }

        $file = $entity->getPhotostade();

        // only upload new files
        if (!$file instanceof UploadedFile) {
            return;
        }

        $fileName = $this->uploader->upload($file);
        $entity->setPhotostade($fileName);
    }

}