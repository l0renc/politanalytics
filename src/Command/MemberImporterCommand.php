<?php
// src/Command/ImportMembersCommand.php


namespace App\Command;

use App\Service\MemberImporterService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MemberImporterCommand extends Command
{
    protected static $defaultName = 'app:import-members';
    protected static $defaultDescription = 'Imports Members and their profile information.';

    private MemberImporterService $importerService;

    public function __construct(MemberImporterService $importerService)
    {
        parent::__construct();
        $this->importerService = $importerService;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Importing Members with their profile information');

        try {
            $this->importerService->importMembers();
            $io->success('The Members have been successfully imported.');
        } catch (\Exception $exception) {
            $io->error('An error occurred during the import: ' . $exception->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
