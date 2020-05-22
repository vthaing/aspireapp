<?php

namespace App\Entity;

use App\Repository\LoanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableMethodsTrait;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;

/**
 * @ORM\Entity(repositoryClass=LoanRepository::class)
 */
class Loan implements TimestampableInterface
{
    use TimestampableTrait;

    const LOAN_STATUS_NEW = 1;
    const LOAN_STATUS_APPROVED = 2;
    const LOAN_STATUS_CANCELLED_BY_CUSTOMER = 3;
    const LOAN_STATUS_REJECTED = 4;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="date")
     */
    private $birthDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $province;

    /**
     * @ORM\Column(type="float")
     */
    private $monthlyNetIncome;

    /**
     * @ORM\Column(type="float")
     */
    private $loanAmount;

    /**
     * @ORM\Column(type="smallint")
     */
    private $loanTerm;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="loans")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="smallint")
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=LoanRepayment::class, mappedBy="loan")
     */
    private $loanRepayments;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $interestRate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $firstRepaymentPate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $nextRepaymentDate;

    public function __construct()
    {
        $this->loanRepayments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getProvince(): ?string
    {
        return $this->province;
    }

    public function setProvince(string $province): self
    {
        $this->province = $province;

        return $this;
    }

    public function getMonthlyNetIncome(): ?float
    {
        return $this->monthlyNetIncome;
    }

    public function setMonthlyNetIncome(float $monthlyNetIncome): self
    {
        $this->monthlyNetIncome = $monthlyNetIncome;

        return $this;
    }

    public function getLoanAmount(): ?float
    {
        return $this->loanAmount;
    }

    public function setLoanAmount(float $loanAmount): self
    {
        $this->loanAmount = $loanAmount;

        return $this;
    }

    public function getLoanTerm(): ?int
    {
        return $this->loanTerm;
    }

    public function setLoanTerm(int $loanTerm): self
    {
        $this->loanTerm = $loanTerm;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getStatusLabel()
    {
        foreach (self::getStatuses() as $label => $key) {
            if ($key === $this->getStatus()) {
                return $label;
            }
        }
    }

    public static function getStatuses()
    {
        return [
            'New' => self::LOAN_STATUS_NEW,
            'Approved' => self::LOAN_STATUS_APPROVED,
            'Cancelled' => self::LOAN_STATUS_CANCELLED_BY_CUSTOMER,
            'Rejected' => self::LOAN_STATUS_REJECTED
        ];
    }

    /**
     * @return Collection|LoanRepayment[]
     */
    public function getLoanRepayments(): Collection
    {
        return $this->loanRepayments;
    }

    public function addLoanRepayment(LoanRepayment $loanRepayment): self
    {
        if (!$this->loanRepayments->contains($loanRepayment)) {
            $this->loanRepayments[] = $loanRepayment;
            $loanRepayment->setLoan($this);
        }

        return $this;
    }

    public function removeLoanRepayment(LoanRepayment $loanRepayment): self
    {
        if ($this->loanRepayments->contains($loanRepayment)) {
            $this->loanRepayments->removeElement($loanRepayment);
            // set the owning side to null (unless already changed)
            if ($loanRepayment->getLoan() === $this) {
                $loanRepayment->setLoan(null);
            }
        }

        return $this;
    }

    public function getInterestRate(): ?float
    {
        return $this->interestRate;
    }

    public function setInterestRate(?float $interestRate): self
    {
        $this->interestRate = $interestRate;

        return $this;
    }

    public function getFirstRepaymentPate(): ?\DateTimeInterface
    {
        return $this->firstRepaymentPate;
    }

    public function setFirstRepaymentPate(?\DateTimeInterface $firstRepaymentPate): self
    {
        $this->firstRepaymentPate = $firstRepaymentPate;

        return $this;
    }

    public function getNextRepaymentDate(): ?\DateTimeInterface
    {
        return $this->nextRepaymentDate;
    }

    public function setNextRepaymentDate(\DateTimeInterface $nextRepaymentDate): self
    {
        $this->nextRepaymentDate = $nextRepaymentDate;

        return $this;
    }
}
