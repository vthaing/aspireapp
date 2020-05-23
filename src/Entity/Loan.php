<?php

namespace App\Entity;

use App\Repository\LoanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableMethodsTrait;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

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

    const REPAYMENT_WEEKLY = 1;
    const REPAYMENT_FORTNIGHTLY = 2;
    const REPAYMENT_MONTHLY = 3;

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
    private $firstRepaymentDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $nextRepaymentDate;

    /**
     * @ORM\Column(type="smallint")
     */
    private $repaymentFrequency;

    public function __construct()
    {
        $this->loanRepayments = new ArrayCollection();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addConstraint(new Assert\Callback('validateRepaymentDateOnApprove'));
    }

    public function validateRepaymentDateOnApprove(ExecutionContextInterface $context, $payload)
    {
        if (!$this->isApproved()) {
            return true;
        }


        if ($this->getFirstRepaymentDate() === null) {
            $context->buildViolation('This field can not be empty when loan is approved')
                ->atPath('firstRepaymentDate')
                ->addViolation();
        }

        if ($this->getFirstRepaymentDate() !== null && $this->getNextRepaymentDate() !== null) {
            if ($this->getFirstRepaymentDate() > $this->getNextRepaymentDate()) {
                $context->buildViolation('Next repayment date must be greater than first repayment path')
                    ->atPath('nextRepaymentDate')
                    ->addViolation();
            }
        }
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

    public function getBirthDate(): ?\DateTime
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTime $birthDate): self
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

    public function isApproved() : bool
    {
        return $this->status === self::LOAN_STATUS_APPROVED;
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

    public function getFirstRepaymentDate(): ?\DateTime
    {
        return $this->firstRepaymentDate;
    }

    public function setFirstRepaymentDate(?\DateTime $firstRepaymentDate): self
    {
        $this->firstRepaymentDate = $firstRepaymentDate;

        return $this;
    }

    public function getNextRepaymentDate(): ?\DateTime
    {
        return $this->nextRepaymentDate;
    }

    public function setNextRepaymentDate(?\DateTime $nextRepaymentDate): self
    {
        $this->nextRepaymentDate = $nextRepaymentDate;

        return $this;
    }

    public function getRepaymentFrequency(): ?int
    {
        return $this->repaymentFrequency;
    }

    public function setRepaymentFrequency(int $repaymentFrequency): self
    {
        $this->repaymentFrequency = $repaymentFrequency;

        return $this;
    }

}
