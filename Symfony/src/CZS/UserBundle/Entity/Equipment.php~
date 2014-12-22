<?php
/**
 * Created by PhpStorm.
 * User: pbborel
 * Date: 14/11/2014
 * Time: 14:52
 */


namespace CZS\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Equipment
 *
 * @ORM\Entity
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks
 */
class Equipment
{

    public function __construct(){
        $this->dateCreate = new \Datetime();
    }


    public function bind($request){
        $this->setIdCzs($request->get('id_czs'));
        $this->setDescription($request->get('description'));
        $this->setContent($request->get('content'));
        $this->setSize($request->get('size'));
        $this->setType($request->get('type'));
    }

    /**
     * @ORM\PrePersist()
     */
    public function __prePersist(){
        $this->dateUpdate = new \Datetime();
    }

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
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreate", type="datetime")
     */
    private $dateCreate;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateUpdate", type="datetime")
     */
    private $dateUpdate;

    /**
     * @var string
     *
     * @ORM\Column(name="id_czs", type="string", length=255)
     *
     */
    private $id_czs;


    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255 , nullable=true)
     *
     */
    private $description;


    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     *
     */
    private $content;


    /**
     * @var string
     *
     * @ORM\Column(name="size", type="string", length=255, nullable=true)
     *
     */
    private $size;

    /**
     * @var string
     *
     * @ORM\Column(name="version", type="string", length=255, nullable=true)
     *
     */
    private $version;



    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer")
     *
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="CZS\UserBundle\Entity\User")
     */
    private $user;



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
     * Set dateCreate
     *
     * @param \DateTime $dateCreate
     * @return Equipment
     */
    public function setDateCreate($dateCreate)
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    /**
     * Get dateCreate
     *
     * @return \DateTime 
     */
    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    /**
     * Set dateUpdate
     *
     * @param \DateTime $dateUpdate
     * @return Equipment
     */
    public function setDateUpdate($dateUpdate)
    {
        $this->dateUpdate = $dateUpdate;

        return $this;
    }

    /**
     * Get dateUpdate
     *
     * @return \DateTime 
     */
    public function getDateUpdate()
    {
        return $this->dateUpdate;
    }

    /**
     * Set id_czs
     *
     * @param string $idCzs
     * @return Equipment
     */
    public function setIdCzs($idCzs)
    {
        $this->id_czs = $idCzs;

        return $this;
    }

    /**
     * Get id_czs
     *
     * @return string 
     */
    public function getIdCzs()
    {
        return $this->id_czs;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Equipment
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
     * Set content
     *
     * @param string $content
     * @return Equipment
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set size
     *
     * @param string $size
     * @return Equipment
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string 
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set version
     *
     * @param string $version
     * @return Equipment
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return string 
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return Equipment
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }



    /**
     * Set user
     *
     * @param \CZS\UserBundle\Entity\User $user
     * @return Equipment
     */
    public function setUser(\CZS\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \CZS\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
