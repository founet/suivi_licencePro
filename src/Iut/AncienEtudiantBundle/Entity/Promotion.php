<?php

namespace Iut\AncienEtudiantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Promotion
 *
 * @ORM\Table(name="promotion")
 * @ORM\Entity(repositoryClass="Iut\AncienEtudiantBundle\Entity\PromotionRepository")
 */
class Promotion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="annee", type="integer")
     */
    private $annee;

     /**
   * @ORM\OneToMany(targetEntity="Iut\AncienEtudiantBundle\Entity\Etudiant", mappedBy="promotion",cascade={"persist", "remove"})
   */
    private $etudiants; //   une promotion a plusieurs etudiants !
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set annee
     *
     * @param integer $annee
     * @return Promotion
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return integer 
     */
    public function getAnnee()
    {
        return $this->annee;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->etudians = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add etudiant
     *
     * @param \Iut\AncienEtudiantBundle\Entity\Etudiant $etudiant
     * @return Promotion
     */
    public function addEtudiant(\Iut\AncienEtudiantBundle\Entity\Etudiant $etudiant)
    {
        $this->etudians[] = $etudiant;

        return $this;
    }

    /**
     * Remove etudiant
     *
     * @param \Iut\AncienEtudiantBundle\Entity\Etudiant $etudiant
     */
    public function removeEtudiant(\Iut\AncienEtudiantBundle\Entity\Etudiant $etudiant)
    {
        $this->etudians->removeElement($etudiant);
    }

    /**
     * Get etudians
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEtudiants()
    {
        return $this->etudians;
    }
}
