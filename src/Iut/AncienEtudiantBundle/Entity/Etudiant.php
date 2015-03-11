<?php

namespace Iut\AncienEtudiantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etudiant
 *
 * @ORM\Table(name="etudiant")
 * @ORM\Entity(repositoryClass="Iut\AncienEtudiantBundle\Entity\EtudiantRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Etudiant 
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
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;
    
     /**
   * @ORM\OneToMany(targetEntity="Iut\AncienEtudiantBundle\Entity\Formation", mappedBy="etudiant",cascade={"persist", "remove"})
   */
    private $formations; //   un etudiant a plusieurs formations !
    
    /**
   * @ORM\OneToMany(targetEntity="Iut\AncienEtudiantBundle\Entity\Experience", mappedBy="etudiant",cascade={"persist", "remove"})
   */
    private $experiences; //   un etudiant a plusieurs experiences !

    /**
     * @ORM\ManyToOne(targetEntity="Iut\AncienEtudiantBundle\Entity\Promotion", inversedBy="etudiants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $promotion;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateModif", type="date")
     */
    private $dateModif;
    
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
     * Set nom
     *
     * @param string $nom
     * @return Utilisateur
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }
    
    
    /**
     * Set prenom
     *
     * @param string $prenom
     * @return Utilisateur
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }
    
    
    /**
     * Set email
     *
     * @param string $email
     * @return Utilisateur
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->formations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->experiences = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add formations
     *
     * @param \Iut\AncienEtudiantBundle\Entity\Formation $formation
     * @return Etudiant
     */
    public function addFormation(\Iut\AncienEtudiantBundle\Entity\Formation $formation)
    {
        $this->formations[] = $formation;
        //$formation->setEtudiant($this);
        return $this;
    }

    /**
     * Remove formations
     *
     * @param \Iut\AncienEtudiantBundle\Entity\Formation $formation
     */
    public function removeFormation(\Iut\AncienEtudiantBundle\Entity\Formation $formation)
    {
        $this->formations->removeElement($formation);
    }

    /**
     * Get formations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFormations()
    {
        return $this->formations;
    }

    /**
     * Add experiences
     *
     * @param \Iut\AncienEtudiantBundle\Entity\Experience $experience
     * @return Etudiant
     */
    public function addExperience(\Iut\AncienEtudiantBundle\Entity\Experience $experience)
    {
        $this->experiences[] = $experience;
        //$experience->setEtudiant($this);
        return $this;
    }

    /**
     * Remove experiences
     *
     * @param \Iut\AncienEtudiantBundle\Entity\Experience $experience
     */
    public function removeExperience(\Iut\AncienEtudiantBundle\Entity\Experience $experience)
    {
        $this->experiences->removeElement($experience);
    }

    /**
     * Get experiences
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getExperiences()
    {
        return $this->experiences;
    }

    /**
     * Set promotion
     *
     * @param \Iut\AncienEtudiantBundle\Entity\Promotion $promotion
     * @return Etudiant
     */
    public function setPromotion(\Iut\AncienEtudiantBundle\Entity\Promotion $promotion)
    {
        $this->promotion = $promotion;

        return $this;
    }

    /**
     * Get promotion
     *
     * @return \Iut\AncienEtudiantBundle\Entity\Promotion 
     */
    public function getPromotion()
    {
        return $this->promotion;
    }
    
    /**
    * @ORM\PreUpdate
    */
    public function updateDate()
    {
        $this->setDateModif(new \Datetime());
    }

    /**
     * Set dateModif
     *
     * @param \DateTime $dateModif
     * @return Etudiant
     */
    public function setDateModif($dateModif)
    {
        $this->dateModif = $dateModif;

        return $this;
    }

    /**
     * Get dateModif
     *
     * @return \DateTime 
     */
    public function getDateModif()
    {
        return $this->dateModif;
    }
    
    
}
