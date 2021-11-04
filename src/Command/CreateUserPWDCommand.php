<?php

declare(strict_types=1);

namespace ASPTest\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use ASPTest\Controllers\UserController;

class CreateUserPWDCommand extends Command
{
    protected static $defaultName = 'USER:CREATE-PWD';

    /** @var UserController $userController */
    private $userController;

    public function __construct(UserController $userController)
    {
        parent::__construct();

        $this->userController = $userController;
    }

    protected function configure()
    {
        $this
            ->setDescription('Set User Password')
            ->addArgument('ID', InputArgument::REQUIRED, 'User ID');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $userId = $input->getArgument('ID');

            $data = $this->Questions($input, $output);

            $data['id'] = $userId;
            
            $user = $this->userController->updateUserPassword($data);

            $output->writeln('Password saved successfully.');

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

        $question = new Question('Password: ');
        $question->setValidator(function ($password) {
            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $number    = preg_match('@[0-9]@', $password);
            $specialChars = preg_match('@[^\w]@', $password);
            if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 6) {
                throw new \RuntimeException(
                    'The password must contain at least 6 characters, with at least one uppercase letter, one number, and one special character.'
                );
            }
            return $password;
        });
        $question->setHidden(true);
        $question->setMaxAttempts(10);
        $password = $helper->ask($input, $output, $question);

        $question = new Question('Confirm Password: ');
        $question->setValidator(function ($confirmPassword) use ($password) {
            if ($password !== $confirmPassword) {
                throw new \RuntimeException(
                    'Passwords must match.'
                );
            }
            return $confirmPassword;
        });
        $question->setHidden(true);
        $question->setMaxAttempts(10);
        $confirmPassword = $helper->ask($input, $output, $question);

        return [
            'password' => $password,
            'confirmPassword' => $confirmPassword
        ];
    }
}