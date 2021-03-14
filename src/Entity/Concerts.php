<?php

namespace App\Entity;

use App\Repository\ConcertsRepository;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
// Définition du namespace
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ConcertsRepository::class)
 * @UniqueEntity("artiste")
 * @Vich\Uploadable()
 */
class Concerts
{
    const JOUR =  [
        0 => 'Vendredi',
        1 => 'Samedi',
        2 => "Dimanche"
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $filename; // Création de la propriété privée pour le nom du fichier

    /**
     * @var File|null
     * @Assert\Image(
     *     mimeTypes="image/jpeg"
     *              )
     * @Vich\UploadableField(mapping="concerts_image", fileNameConcerts="filename")
     */
    private $imageFile; // Création de la propriété privée de type fichier et des limites d'upload ici jpeg

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $artiste;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $jour;

    /**
     * @ORM\Column(type="time")
     */
    private $heure;

    /**
     * @ORM\OneToOne(targetEntity=Scene::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $scene;

    public function __construct() { /* ajout */
        $this->heure = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArtiste(): ?string
    {
        return $this->artiste;
    }

    public function setArtiste(string $artiste): self
    {
        $this->artiste = $artiste;

        return $this;
    }

    public function getSlug(): string {
        return (new Slugify())->slugify($this->artiste);
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getJour(): ?string
    {
        return $this->jour;
    }

    public function setJour(string $jour): self
    {
        $this->jour = $jour;

        return $this;
    }
    public function getJourType(): string{
        return self::JOUR[$this->jour];
    }

    public function getHeure(): ?\DateTimeInterface
    {
        return $this->heure;
    }

    public function setHeure(\DateTimeInterface $heure): self
    {
        $this->heure = $heure;

        return $this;
    }
    /* public function getFormattedHours(): string {
        return date($this->heure, date('H'), 'h', date('i'));
    } */

    public function getScene(): ?Scene
    {
        return $this->scene;
    }

    public function setScene(Scene $scene): self
    {
        $this->scene = $scene;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * @param string|null $filename
     * @return Concerts
     */
    public function setFilename(?string $filename): Concerts
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile(): ?\Symfony\Component\HttpFoundation\File\File
    {
        return $this->imageFile;
    }

    /**
     * @param File|null $imageFile
     * @return Concerts
     */
    public function setImageFile(File $imageFile): Concerts
    {
        $this->imageFile = $imageFile;
        if ($this ->imageFile instanceof UploadedFile) {
            $this->updated_At = new \DateTime('now'); //Si image est uploadée mise à jour du updated_At pour éviter bug images
        }
        return $this;
    }




}
