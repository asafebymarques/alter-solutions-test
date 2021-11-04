<?php

declare(strict_types=1);

namespace ASPTest\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use ASPTest\Controllers\UserController;

class CreateUserCommand extends Command
{
    protected static $defaultName = 'USER:CREATE';

    /** @var UserController $userController */
    private $userController;

    public function __construct(UserController $userController)
    {
        parent::__construct();

        $this->userController = $userController;
    }

    protected function configure()
    {
        $this->setDescription('New User');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $data = $this->Questions($input, $output);
            
            $user = $this->userController->createUser($data);
            
            $output->writeln(json_encode($user->getUser()));
            
            return Command::SUCCESS;
        } catch (\Exception $ex) {
            $output->writeln($ex->getMessage());
            
            return Command::FAILURE;
        }
    }

    private function Questions(InputInterface $input, OutputInterface $output): array
    {
        $helper = $this->getHelper('question');

        $question = new Question('First Name: ');
        $question->setValidator(function ($firstName) {
            if (strlen($firstName) < 2 || strlen($firstName) > 35) {
                throw new \RuntimeException(
                    'The firstName must contain more than 2 characters and less than 35.'
                );
            }
            return $firstName;
        });
        $question->setMaxAttempts(2);
        $firstName = $helper->ask($input, $output, $question);

        $question = new Question('Last Name: ');
        $question->setValidator(function ($lastName) {
            if (strlen($lastName) < 2 || strlen($lastName) > 35) {
                throw new \RuntimeException(
                    'The lastName must contain more than 2 characters and less than 35.'
                );
            }
            return $lastName;
        });
        $question->setMaxAttempts(2);
        $lastName = $helper->ask($input, $output, $question);

        $question = new Question('E-mail: ');
        $question->setValidator(function ($email) {
            if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new \RuntimeException(
                    'Email invalid format.'
                );
            }
            return $email;
        });
        $question->setMaxAttempts(2);
        $email = $helper->ask($input, $output, $question);

        $question = new Question('Age(optional): ', null);
        $question->setValidator(function ($age) {
            if (isset($age) && $age < 0 || $age > 150) {
                throw new \RuntimeException(
                    'Invalid age.'
                );
            }
            return $age;
        });
        $question->setMaxAttempts(2);
        $age = $helper->ask($input, $output, $question);

        return [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'age' => $age
        ];
    }
}