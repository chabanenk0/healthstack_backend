<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 17.01.16
 * Time: 1:16
 */

namespace HealthstackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tickets")
 */
class Ticket
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $hash;

    /**
     * @ORM\ManyToOne(targetEntity="Patient", inversedBy="tickets")
     * @ORM\JoinColumn(name="patient_id", referencedColumnName="id")
     */
    protected $patient;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $visitDate;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $activeStatus;

    /**
     * @ORM\OneToMany(targetEntity="TicketItem", mappedBy="ticket")
     */
    protected $items;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param mixed $hash
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    /**
     * @return mixed
     */
    public function getVisitDate()
    {
        return $this->visitDate;
    }

    /**
     * @param mixed $visitDate
     */
    public function setVisitDate($visitDate)
    {
        $this->visitDate = $visitDate;
    }

    /**
     * @return mixed
     */
    public function getActiveStatus()
    {
        return $this->activeStatus;
    }

    /**
     * @param mixed $activeStatus
     */
    public function setActiveStatus($activeStatus)
    {
        $this->activeStatus = $activeStatus;
    }
}