<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 16/02/2018
 * Time: 04:57 PM.
 */

namespace Greenter\Notify;

use Greenter\Model\DocumentInterface;

/**
 * Class Notification.
 */
class Notification
{
    /**
     * @var Attachment[]
     */
    private $files;

    /**
     * @var DocumentInterface
     */
    private $document;

    /**
     * @return Attachment[]
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Set Attachment Files.
     *
     * @param Attachment[] $files
     *
     * @return Notification
     */
    public function setFiles($files)
    {
        $this->files = $files;

        return $this;
    }

    /**
     * @return DocumentInterface
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @param DocumentInterface $document
     *
     * @return Notification
     */
    public function setDocument($document)
    {
        $this->document = $document;

        return $this;
    }
}
