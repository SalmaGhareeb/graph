<?php

namespace SocialGraph\Port;

use SocialGraph\Application\Service\AlgorithmsService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DFSAlgorithmCommand extends Command
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
      dd($this->algorithmsService->runDepthFirstSearch($input->getArgument('graph'), $input->getArgument('node')));
    }
}
