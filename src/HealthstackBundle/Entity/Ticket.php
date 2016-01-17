<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 17.01.16
 * Time: 1:16
 */

namespace HealthstackBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @ORM\Column(type="string", nullable=true)
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
     * @ORM\Column(type="string", nullable=true)
     */
    protected $symptomes;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $diagnosis;

    /**
     * @ORM\OneToMany(targetEntity="TicketItem", mappedBy="ticket", cascade="persist")
     */
    protected $items;


    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

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

    /**
     * @return mixed
     */
    public function getPatient()
    {
        return $this->patient;
    }

    /**
     * @param mixed $patient
     */
    public function setPatient($patient)
    {
        $this->patient = $patient;
    }

    /**
     * @return mixed
     */
    public function getSymptomes()
    {
        return $this->symptomes;
    }

    /**
     * @param mixed $symptomes
     */
    public function setSymptomes($symptomes)
    {
        $this->symptomes = $symptomes;
    }

    /**
     * @return mixed
     */
    public function getDiagnosis()
    {
        return $this->diagnosis;
    }

    /**
     * @param mixed $diagnosis
     */
    public function setDiagnosis($diagnosis)
    {
        $this->diagnosis = $diagnosis;
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param mixed $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

}