<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $plate;

    #[ORM\Column(type: 'string', length: 255)]
    private $plugType;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'cars')]
    private $user_id;

//    #[ORM\OneToMany(mappedBy: 'car', targetEntity: CarUser::class, orphanRemoval: true)]
//    private $user;

//    #[ORM\OneToMany(mappedBy: 'car', targetEntity: UserCar::class, orphanRemoval: true)]
//    private $users;

    public function __construct()
    {
        $this->user_id = new ArrayCollection();
//        $this->user = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

//    #[ORM\OneToMany(mappedBy: 'car_id', targetEntity: Booking::class)]
//    private $bookings;
//
//    public function __construct()
//    {
//        $this->bookings = new ArrayCollection();
//    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlate(): ?string
    {
        return $this->plate;
    }

    public function setPlate(string $plate): self
    {
        $this->plate = $plate;

        return $this;
    }

    public function getPlugType(): ?string
    {
        return $this->plugType;
    }

    public function setPlugType(string $plugType): self
    {
        $this->plugType = $plugType;

        return $this;
    }

//    /**
//     * @return Collection<int, Booking>
//     */
//    public function getBookings(): Collection
//    {
//        return $this->bookings;
//    }
//
//    public function addBooking(Booking $booking): self
//    {
//        if (!$this->bookings->contains($booking)) {
//            $this->bookings[] = $booking;
//            $booking->setCarId($this);
//        }
//
//        return $this;
//    }
//
//    public function removeBooking(Booking $booking): self
//    {
//        if ($this->bookings->removeElement($booking)) {
//            // set the owning side to null (unless already changed)
//            if ($booking->getCarId() === $this) {
//                $booking->setCarId(null);
//            }
//        }
//
//        return $this;
//    }

/**
 * @return Collection<int, User>
 */
public function getUserId(): Collection
{
    return $this->user_id;
}

public function addUserId(User $userId): self
{
    if (!$this->user_id->contains($userId)) {
        $this->user_id[] = $userId;
    }

    return $this;
}

public function removeUserId(User $userId): self
{
    $this->user_id->removeElement($userId);

    return $this;
}

///**
// * @return Collection<int, CarUser>
// */
//public function getUser(): Collection
//{
//    return $this->user;
//}
//
//public function addUser(CarUser $user): self
//{
//    if (!$this->user->contains($user)) {
//        $this->user[] = $user;
//        $user->setCar($this);
//    }
//
//    return $this;
//}
//
//public function removeUser(CarUser $user): self
//{
//    if ($this->user->removeElement($user)) {
//        // set the owning side to null (unless already changed)
//        if ($user->getCar() === $this) {
//            $user->setCar(null);
//        }
//    }
//
//    return $this;
//}

///**
// * @return Collection<int, UserCar>
// */
//public function getUsers(): Collection
//{
//    return $this->users;
//}
}
