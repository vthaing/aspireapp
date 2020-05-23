<?php

namespace App\Entity;

use App\Repository\LoanRepaymentRepository;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;

/**
 * @ORM\Entity(repositoryClass=LoanRepaymentRepository::class)
 */
class LoanRepayment implements TimestampableInterface
{
    const STATUS_NEW = 1;
    const STATUS_FAILED = 2;
    const STATUS_SUCCESS = 3;

    use TimestampableTrait;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Loan::class, inversedBy="loanRepayments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $loan;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="loanRepayments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="smallint")
     */
    private $status;

    /**
     * Value of this field will be Loan.nextRepaymentDate
     * This field is using to determine which cycle to pay for
     * @ORM\Column(type="date")
     */
    private $payForRepaymentDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLoan(): ?Loan
    {
        return $this->loan;
    }

    public function setLoan(?Loan $loan): self
    {
        $this->loan = $loan;

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

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

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

    public function getPayForRepaymentDate(): ?\DateTime
    {
        return $this->payForRepaymentDate;
    }

    public function setPayForRepaymentDate(\DateTime $payForRepaymentDate): self
    {
        $this->payForRepaymentDate = $payForRepaymentDate;

        return $this;
    }

    public function isSuccess() : bool
    {
        return $this->status === self::STATUS_SUCCESS;
    }
}
