<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 17.01.16
 * Time: 1:40
 */

namespace HealthstackBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ticket_items")
 */
class TicketItem
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Ticket", inversedBy="items")
     * @ORM\JoinColumn(name="ticket_id", referencedColumnName="id")
     */
    protected $ticket;

    /**
     * @ORM\ManyToOne(targetEntity="Medicine")
     * @ORM\JoinColumn(name="medicine_id", referencedColumnName="id")
     */
    protected $medicine;

    /**
     * @ORM\Column(type="integer")
     */
    protected $countPerDay;

    /**
     * @ORM\Column(type="integer")
     */
    protected $totalDays;

    /**
     * @ORM\Column(type="string")
     */
    protected $dose;

    /**
     * @ORM\Column(type="integer")
     */
    protected $doseAmount;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    protected $takeTime1;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    protected $takeTime2;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    protected $takeTime3;

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
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * @param mixed $ticket
     */
    public function setTicket($ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * @return mixed
     */
    public function getMedicine()
    {
        return $this->medicine;
    }

    /**
     * @param mixed $medicine
     */
    public function setMedicine($medicine)
    {
        $this->medicine = $medicine;
    }

    /**
     * @return mixed
     */
    public function getCountPerDay()
    {
        return $this->countPerDay;
    }

    /**
     * @param mixed $countPerDay
     */
    public function setCountPerDay($countPerDay)
    {
        $this->countPerDay = $countPerDay;
    }

    /**
     * @return mixed
     */
    public function getTotalDays()
    {
        return $this->totalDays;
    }

    /**
     * @param mixed $totalDays
     */
    public function setTotalDays($totalDays)
    {
        $this->totalDays = $totalDays;
    }

    /**
     * @return mixed
     */
    public function getDose()
    {
        return $this->dose;
    }

    /**
     * @param mixed $dose
     */
    public function setDose($dose)
    {
        $this->dose = $dose;
    }

    /**
     * @return mixed
     */
    public function getDoseAmount()
    {
        return $this->doseAmount;
    }

    /**
     * @param mixed $doseAmount
     */
    public function setDoseAmount($doseAmount)
    {
        $this->doseAmount = $doseAmount;
    }

    /**
     * @return mixed
     */
    public function getTakeTime1()
    {
        return $this->takeTime1;
    }

    /**
     * @param mixed $takeTime1
     */
    public function setTakeTime1($takeTime1)
    {
        $this->takeTime1 = $takeTime1;
    }

    /**
     * @return mixed
     */
    public function getTakeTime2()
    {
        return $this->takeTime2;
    }

    /**
     * @param mixed $takeTime2
     */
    public function setTakeTime2($takeTime2)
    {
        $this->takeTime2 = $takeTime2;
    }

    /**
     * @return mixed
     */
    public function getTakeTime3()
    {
        return $this->takeTime3;
    }

    /**
     * @param mixed $takeTime3
     */
    public function setTakeTime3($takeTime3)
    {
        $this->takeTime3 = $takeTime3;
    }
}