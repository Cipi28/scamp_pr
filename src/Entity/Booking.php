<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Cassandra\Time;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'dateinterval')]
    private $duration;


    #[ORM\Column(type: 'datetime')]
    private $startTime;

    #[ORM\ManyToOne(targetEntity: Car::class, inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    private $car_id;

    #[ORM\ManyToOne(targetEntity: Plug::class)]
    #[ORM\JoinColumn(nullable: true)]
    private $plug_id;

    #[ORM\OneToOne(mappedBy: 'booking_id', targetEntity: Car::class, cascade: ['persist', 'remove'])]
    private $car;


    public function getId(): ?int
    {
        return $this->id;
    }



    public function getCarId(): ?Car
    {
        return $this->car_id;
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param mixed $duration
     */
    public function setDuration($duration): void
    {
        $this->duration = $duration;
    }

    /**
     * @return mixed
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @param mixed $startTime
     */
    public function setStartTime($startTime): void
    {
        $this->startTime = $startTime;
    }

    public function setCarId(?Car $car_id): self
    {
        $this->car_id = $car_id;

        return $this;
    }

    public function getPlugId(): ?Plug
    {
        return $this->plug_id;
    }

    public function setPlugId(?Plug $plug_id): self
    {
        $this->plug_id = $plug_id;

        return $this;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): self
    {
        // unset the owning side of the relation if necessary
        if ($car === null && $this->car !== null) {
            $this->car->setBookingId(null);
        }

        // set the owning side of the relation if necessary
        if ($car !== null && $car->getBookingId() !== $this) {
            $car->setBookingId($this);
        }

        $this->car = $car;

        return $this;
    }

}
