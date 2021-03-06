<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Immobilier
 *
 * @ORM\Table(name="immobilier")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImmobilierRepository")
 */
class Immobilier
{

  /*  public function __toString()
    {
        return $this->utilisateur;
    }*/

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=50)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=20)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="bien", type="string", length=20)
     */
    private $bien;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="bientype")
     * @ORM\JoinColumn(name="typebien_id", referencedColumnName="id")
     */
    private $typebien;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $utilisateur;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Commune")
     * @ORM\JoinColumn(name ="commune_id", referencedColumnName="id")
     */

    private $commune;

    /**
     * @var int
     *
     * @ORM\Column(name="prix", type="integer")
     */

    private $prix;

    /**
     * @var int
     *
     * @ORM\Column(name="piece", type="integer", nullable=true)
     */
    private $piece;

    /**
     * @var int
     *
     * @ORM\Column(name="chambre", type="integer", nullable=true)
     */
    private $chambre;

    /**
     * @var int
     *
     * @ORM\Column(name="douche", type="integer", nullable=true)
     */
    private $douche;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
    * 
    * @ORM\Column(name="datecreation",type="datetime")
    */
    private $datecreation;

    /**
    * 
    * @ORM\Column(name="datemodif",type="datetime")
    */
    private $datemodifcation;

    /**
     * @ORM\Column(name="is_send", type="boolean")
     */
    private $etat;


    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $imageImmo;


    /**
     * @return string
     */
    public function getImageImmo()
    {
        return $this->imageImmo;
    }

    /**
     * @param string $imageImmo
     *
     * @return  Immobilier
     */
    public function setImageImmo($imageImmo)
    {
        $this->imageImmo = $imageImmo;
        return $this;
    }

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $imageImmo2;


    /**
     * @return string
     */
    public function getImageImmo2()
    {
        return $this->imageImmo2;
    }

    /**
     * @param string $imageImmo2
     *
     * @return  Immobilier
     */
    public function setImageImmo2($imageImmo2)
    {
        $this->imageImmo2 = $imageImmo2;
        return $this;
    }

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $imageImmo3;


    /**
     * @return string
     */
    public function getImageImmo3()
    {
        return $this->imageImmo3;
    }

    /**
     * @param string $imageImmo3
     *
     * @return  Immobilier
     */
    public function setImageImmo3($imageImmo3)
    {
        $this->imageImmo3 = $imageImmo3;
        return $this;
    }



    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Immobilier
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Immobilier
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set bien
     *
     * @param string $bien
     *
     * @return Immobilier
     */
    public function setBien($bien)
    {
        $this->bien = $bien;
        return $this;
    }

    /**
     * Get bien
     *
     * @return string
     */
    public function getBien()
    {
        return $this->bien;
    }
    

    /**
     * Set prix
     *
     * @param integer $prix
     *
     * @return Immobilier
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return int
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set piece
     *
     * @param integer $piece
     *
     * @return Immobilier
     */
    public function setPiece($piece)
    {
        $this->piece = $piece;

        return $this;
    }

    /**
     * Get piece
     *
     * @return int
     */
    public function getPiece()
    {
        return $this->piece;
    }

    /**
     * Set chambre
     *
     * @param integer $chambre
     *
     * @return Immobilier
     */
    public function setChambre($chambre)
    {
        $this->chambre = $chambre;

        return $this;
    }

    /**
     * Get chambre
     *
     * @return int
     */
    public function getChambre()
    {
        return $this->chambre;
    }

    /**
     * Set douche
     *
     * @param integer $douche
     *
     * @return Immobilier
     */
    public function setDouche($douche)
    {
        $this->douche = $douche;

        return $this;
    }

    /**
     * Get douche
     *
     * @return int
     */
    public function getDouche()
    {
        return $this->douche;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Immobilier
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set commune
     *
     * @param \AppBundle\Entity\Commune $commune
     *
     * @return Immobilier
     */
    public function setCommune(\AppBundle\Entity\Commune $commune = null)
    {
        $this->commune = $commune;

        return $this;
    }

    /**
     * Get commune
     *
     * @return \AppBundle\Entity\Commune
     */
    public function getCommune()
    {
        return $this->commune;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->commune = new \Doctrine\Common\Collections\ArrayCollection();
        $this->etat = false;
    }

    /**
     * Add commune
     *
     * @param \AppBundle\Entity\Commune $commune
     *
     * @return Immobilier
     */
    public function addCommune(\AppBundle\Entity\Commune $commune)
    {
        $this->commune[] = $commune;

        return $this;
    }

    /**
     * Remove commune
     *
     * @param \AppBundle\Entity\Commune $commune
     */
    public function removeCommune(\AppBundle\Entity\Commune $commune)
    {
        $this->commune->removeElement($commune);
    }

    /**
     * Set typebien
     *
     * @param \AppBundle\Entity\bientype $typebien
     *
     * @return Immobilier
     */
    public function setTypebien(\AppBundle\Entity\bientype $typebien = null)
    {
        $this->typebien = $typebien;

        return $this;
    }

    /**
     * Get typebien
     *
     * @return \AppBundle\Entity\bientype
     */
    public function getTypebien()
    {
        return $this->typebien;
    }

    /**
     * Set utilisateur
     *
     * @param \AppBundle\Entity\User $utilisateur
     *
     * @return Immobilier
     */
    public function setUtilisateur(\AppBundle\Entity\User $utilisateur = null)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return \AppBundle\Entity\User
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Set datecreation
     *
     * @param \DateTime $datecreation
     *
     * @return Immobilier
     */
    public function setDatecreation($datecreation)
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    /**
     * Get datecreation
     *
     * @return \DateTime
     */
    public function getDatecreation()
    {
        return $this->datecreation;
    }

    /**
     * Set datemodifcation
     *
     * @param \DateTime $datemodifcation
     *
     * @return Immobilier
     */
    public function setDatemodifcation($datemodifcation)
    {
        $this->datemodifcation = $datemodifcation;

        return $this;
    }

    /**
     * Get datemodifcation
     *
     * @return \DateTime
     */
    public function getDatemodifcation()
    {
        return $this->datemodifcation;
    }

    /**
     * Set isSend
     *
     * @param boolean $isSend
     *
     * @return Immobilier
     */
    public function setIsSend($isSend)
    {
        $this->isSend = $isSend;

        return $this;
    }

    /**
     * Get isSend
     *
     * @return boolean
     */
    public function getIsSend()
    {
        return $this->isSend;
    }

    /**
     * Set etat
     *
     * @param boolean $etat
     *
     * @return Immobilier
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return boolean
     */
    public function getEtat()
    {
        return $this->etat;
    }
}
