<?php

namespace AppBundle\Command;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUsersCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('users:create')
            ->setDescription('Create some users for tests');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entityManager = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        for ($i = 1; $i <= 3; $i++) {
            $user = new User();
            $user->setName("User #$i");
            $user->setBalance("1000.00");
            $entityManager->persist($user);
        }
        $entityManager->flush();
        $output->writeln('Done.');
    }

}
