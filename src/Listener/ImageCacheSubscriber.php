<?php
namespace App\Listener;

use App\Entity\Concerts;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class ImageCacheSubscriber implements EventSubscriber {

    /**
     * @var CacheManager
     */
    private CacheManager $cacheManager;
    /**
     * @var UploaderHelper
     */
    private UploaderHelper $uploaderHelper;

    public function __construct(CacheManager $cacheManager, UploaderHelper $uploaderHelper) {
        $this->cacheManager = $cacheManager;
        $this->uploaderHelper = $uploaderHelper;
    }

    public function getSubscribedEvents(): array
    {
        return [
                'preRemove',
                'preUpdate'
            ];
    }

    public function preRemove(LifecycleEventArgs $args) {
        $programmation = $args->getEntity();
        if(!$programmation instanceof Concerts) {
            return;
        }
        $this->cacheManager->remove($this->uploaderHelper->asset($programmation, 'imageFile'));

    }

    public function preUpdate(PreUpdateEventArgs $args) {
        $programmation = $args->getEntity();
        if(!$programmation instanceof Concerts) {
            return;
        }
        if($programmation->getImageFile() instanceof UploadedFile){
            $this->cacheManager->remove($this->uploaderHelper->asset($programmation, 'imageFile'));
        }
    }
}
