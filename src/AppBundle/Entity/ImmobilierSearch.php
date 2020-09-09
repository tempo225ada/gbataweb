<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * Immobilier
 *
 * @ORM\Table(name="immobilier")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImmobilierRepository")
 */
class ImmobilierSearch
{

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
     */
    private $type;

    /**
     * @var string
     *
     */
    private $bien;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="bientype")
     * @ORM\JoinColumn(name="typebien_id", referencedColumnName="id")
     */
    private $typebien;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Commune")
     * @ORM\JoinColumn(name ="commune_id", referencedColumnName="id")
     * 
     */

    private $commune;

    /**
     * @var int
     *
     */

    private $prix;

    /**
     * @var int
     *
     */
    private $piece;


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
}