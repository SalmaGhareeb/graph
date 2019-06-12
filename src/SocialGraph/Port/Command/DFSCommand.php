<?php

namespace SocialGraph\Port\Command;

use SocialGraph\Application\Service\AlgorithmsService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class DFSCommand
 *
 * @package SocialGraph\Port\Command
 */
class DFSCommand extends Command
{
    protected static $defaultName = 'algorithms:DFS';

    protected $algorithmsService;

    public function __construct(AlgorithmsService $algorithmsService, string $name = null)
    {
        $this->algorithmsService = $algorithmsService;
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('graph', InputArgument::REQUIRED, 'Graph name?')
            ->addArgument('node', InputArgument::REQUIRED, 'Node name?');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        try {
            $result = $this->algorithmsService->runDepthFirstSearch(
                $input->getArgument('graph'),
                $input->getArgument('node')
            );

            $io->writeln('<bg=yellow;options=bold>Distances for each node to root</>');
            $io->table(
                array_keys($result['dist']),
                [array_values($result['dist'])]
            );

            if ($result['parent']) {
                $io->writeln('<bg=yellow;options=bold>Parents for each node.</>');
                $io->table(
                    array_keys($result['parent']),
                    [array_values($result['parent'])]
                );
            }

            if ($result['discovered']) {
                $io->writeln('<bg=yellow;options=bold>Discovered.</>');
                $io->table(
                    [],
                    [array_values($result['discovered'])]
                );
            }
        } catch (\Exception $e) {
            $io->error($e->getMessage());
        }
    }
}
