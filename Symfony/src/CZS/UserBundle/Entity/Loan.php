<?php
/**
 * Created by PhpStorm.
 * User: pbborel
 * Date: 14/11/2014
 * Time: 15:58
 */

namespace CZS\UserBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Loan
 *
 * @ORM\Entity(repositoryClass="CZS\UserBundle\Repository\LoanRepository")
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks
 *
 */
class Loan {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="CZS\UserBundle\Entity\Equipment")
     */
    private $equipment;


    /**
     * @ORM\ManyToMany(targetEntity="CZS\UserBundle\Entity\User")
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateBegin", type="datetime")
     */
    private $dateBegin;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEnd", type="datetime", nullable=true)
     */
    private $dateEnd;

    /**
     * Set dateBegin
     *
     * @param \DateTime $dateBegin
     * @return Loan
     */
    public function setDateBegin($dateBegin)
    {
        $this->dateBegin = $dateBegin;

        return $this;
    }

    /**
     * Get dateBegin
     *
     * @return \DateTime 
     */
    public function getDateBegin()
    {
        return $this->dateBegin;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     * @return Loan
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime 
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }



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
     * Constructor
     */
    public function __construct()
    {
        $this->equipment = new \Doctrine\Common\Collections\ArrayCollection();
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
    }

   

    /**
     * Add equipment
     *
     * @param \CZS\UserBundle\Entity\Equipment $equipment
     * @return Loan
     */
    public function addEquipment(\CZS\UserBundle\Entity\Equipment $equipment)
    {
        $this->equipment[] = $equipment;

        return $this;
    }

    /**
     * Remove equipment
     *
     * @param \CZS\UserBundle\Entity\Equipment $equipment
     */
    public function removeEquipment(\CZS\UserBundle\Entity\Equipment $equipment)
    {
        $this->equipment->removeElement($equipment);
    }

    /**
     * Get equipment
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEquipment()
    {
        return $this->equipment;
    }

    /**
     * Add user
     *
     * @param \CZS\UserBundle\Entity\User $user
     * @return Loan
     */
    public function addUser(\CZS\UserBundle\Entity\User $user)
    {
        $this->user[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \CZS\UserBundle\Entity\User $user
     */
    public function removeUser(\CZS\UserBundle\Entity\User $user)
    {
        $this->user->removeElement($user);
    }

    /**
     * Get user
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUser()
    {
        return $this->user;
    }
}
