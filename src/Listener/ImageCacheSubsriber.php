<?php

//Cette fonction va permettre de supprimer ou mettre à jour les différentes minitaures générer pour les concerts
namespace App\Listener;


use App\Entity\Concerts;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class ImageCacheSubsriber implements EventSubscriber //implémentation de l'interface
{
    /**
     * @var CacheManager
     */
    private $cacheManager; //Pour gérer le cache

    /**
     * @var UploaderHelper
     */
    private $uploaderHelper; //Pour gérer les uploads

    public function construct(CacheManager $cacheManager, UploaderHelper $uploaderHelper)
    {
        $this->cacheManager = $cacheManager;
        $this->uploaderHelper = $uploaderHelper;
    }

    public function getSubscribedEvents()
    {
        return [
            'preRemove', //Evenements à écouter quand elle est modifiée ou supprimée
            'preUpdate'
        ];
    }

    public function preRemove(LifecycleEventArgs $args) //Méthode qui va prendre en compte suppression
    {
        $entity = $args->getEntity();
        if (!$entity instanceof Concerts) {
            return;
        }
        $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
    }

    public function preUpdate(PreUpdateEventArgs $args) //Méthode qui va prendre en compte les mise à jours
    {
        $entity = $args->getEntity();
        if (!$entity instanceof Concerts) { //
            return;
        }
        if (!$entity->getImageFile() instanceof UploadedFile) {
            $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));

        }
    }


}