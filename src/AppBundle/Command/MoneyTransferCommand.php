<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MoneyTransferCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('users:money-transfer')
            ->setDescription('Transfer money between users')
            ->addArgument('sender_id', InputArgument::REQUIRED, 'Sender user id')
            ->addArgument('recipient_id', InputArgument::REQUIRED, 'Recipient user id')
            ->addArgument('amount', InputArgument::REQUIRED, 'Money amount');
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $senderId = $input->getArgument('sender_id');
        $recipientId = $input->getArgument('recipient_id');
        if(!(is_numeric($senderId) && is_numeric($recipientId))) {
            $output->writeln("ERROR: User ids must be integers");
            return;
        }
        $this->getContainer()->get('user.service')->transferMoney($senderId, $recipientId, $input->getArgument('amount'));
        $output->writeln('Done.');
    }

}
