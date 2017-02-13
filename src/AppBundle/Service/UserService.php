<?php

namespace AppBundle\Service;

use AppBundle\Entity\User;
use AppBundle\Exception\ConcurrencyException;
use AppBundle\Exception\MoneyFormatException;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;

class UserService
{
    const BALANCE_PRECISION = 2;
    const MONEY_FORMAT_REGEX = '/^\d+(\.\d+)?$/';

    /** @var EntityManager  */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /*
     * This method transfers update users balance to make a money transfer.
     * Entities are locked with an optimistic lock, so transaction will fail
     * if one of them is updated by another process during this transaction.
     *
     * QUESTION: Can we make a transaction when sender's balance is or becomes lower than 0?
     *
     */
    public function transferMoney(int $senderId, int $recipientId, string $amount): void {
        /*
         * Format check should be probably extracted to a service if is used anywhere else
         */
        if(!preg_match(self::MONEY_FORMAT_REGEX, $amount)) {
            throw new MoneyFormatException("Invalid money format '$amount'");
        }
        /** @var User $sender */
        $sender = $this->entityManager->find(User::class, $senderId, LockMode::OPTIMISTIC);
        /** @var User $recipient */
        $recipient = $this->entityManager->find(User::class, $recipientId, LockMode::OPTIMISTIC);
        $newSenderBalance = bcsub($sender->getBalance(), $amount, self::BALANCE_PRECISION);
        $newRecipientBalance = bcadd($recipient->getBalance(), $amount, self::BALANCE_PRECISION);
        $sender->setBalance($newSenderBalance);
        $recipient->setBalance($newRecipientBalance);
        try {
            $this->entityManager->flush();
        } catch (OptimisticLockException $e) {
            throw new ConcurrencyException("User was updated during transaction. Please try again.");
        }
    }
}
