<?php
/**
 * Created by PhpStorm.
 * User: Amouri Aziz
 * Date: 29/03/2018
 * Time: 23:11
 */

namespace Equipe\EquipeBundle;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadDrapeau
{
    private $targetDir;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($this->getTargetDir(), $fileName);

        return $fileName;
    }

    public function getTargetDir()
    {
        return $this->targetDir;
    }
}