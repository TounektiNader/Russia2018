<?php

namespace Equipe\EquipeBundle\EventListener;
use Equipe\EquipeBundle\UploadDrapeau;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Equipe\EquipeBundle\Entity\Equipe;


class UploadDrapeauListener
{
    private $uploader;

    public function __construct(UploadDrapeau $uploader)
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
        if (!$entity instanceof Equipe) {
            return;
        }

        $file = $entity->getDrapeau();

        // only upload new files
        if (!$file instanceof UploadedFile) {
            return;
        }

        $fileName = $this->uploader->upload($file);
        $entity->setDrapeau($fileName);
    }
}