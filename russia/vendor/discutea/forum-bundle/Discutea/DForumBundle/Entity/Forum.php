<?php

namespace Discutea\DForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Discutea\DForumBundle\Entity\Model\BaseForum;

/**
 * @ORM\Entity(repositoryClass="Discutea\DForumBundle\Repository\ForumRepository")
 * @ORM\Table(name="df_forum")
 */
class Forum extends BaseForum
{

}
