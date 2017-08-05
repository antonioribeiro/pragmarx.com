<?php

namespace App\Support;

class ServerCleaner
{
    protected $command;

    protected $protectFirst = 2;

    private $run;

    public function clean()
    {
        $this->printHeader('PURGING OLD KERNELS', true);
        $this->purgeOldKernels();

        $this->printHeader('APT AUTO REMOVING PACKAGES', true);
        $this->execShellCommand('sudo apt-get autoremove --purge', true);
    }

    private function checkFirstKernelIsCurrentKernel($currentKernel, $versions, $packages)
    {
        if ($versions[0] !== $currentKernel['version']) {
            $this->command->error('ERROR: First Linux Kernel should be '.$currentKernel['version'].' but is '.$versions[0]);

            $this->printHeader('All installed packages');

            $packages->each(function($item) {
                $this->command->info($item['package']);
            });

            $this->command->warn('aborted.');

            die;
        }
    }

    protected function execShellCommand($command, $print = false)
    {
        $output = shell_exec($command);

        if ($print) {
            $this->command->comment($output);
        }

        return $output;
    }

    protected function extractKernelVersion($line)
    {
        preg_match_all('#linux-.+-([0-9]+\.[0-9]+\.[0-9]+-[0-9]+)#', $line, $matches);

        return isset($matches[1][0]) && ($version = $matches[1][0]) != ''
            ? $version
            : null;
    }

    private function getCurrentKernel()
    {
        $currentKernel = '4.4.0-89-generic'; // $this->execShellCommand($this->getCurrentKernelShellCommand());

        $currentKernel = [
            'kernel' => $currentKernel,
            'version' => $this->extractKernelVersion('linux-version-'.$currentKernel),
        ];

        $this->command->info('Your current Kernel is '.$currentKernel['kernel']);

        return $currentKernel;
    }

    protected function getInstalledKernelPackages($currentKernel)
    {
        return collect(explode("\n", $this->getLinuxPackages()))->map(function($line) use ($currentKernel) {
            $version = $this->extractKernelVersion($line);

            if (! is_null($version)) {
                return [
                    'package' => $line,
                    'version' => $version,
                    'current' => $currentKernel['version'] == $version,
                ];
            }

            return null;
        })->filter()->sortByDesc('version');
    }

    /**
     * @return string
     */
    protected function getLinuxPackages()
    {
        return $this->execShellCommand($this->getListKernelsShellCommand());
    }

    protected function getListKernelsShellCommand()
    {
        return "dpkg -l 'linux-*' | grep 'linux-' | cut -d' ' -f 3";
    }

    protected function getCurrentKernelShellCommand()
    {
        return "uname -r";
    }

    private function getPurgePackageCommand($package)
    {
        return 'sudo apt-get purge --yes '.$package;
    }

    private function printHeader($string, $strong = false)
    {
        $method = $strong ? 'warn' : 'info';

        $line = str_repeat('-', $strong ? 80 : strlen($string));

        $this->command->{$method}('');
        $this->command->{$method}($string);
        $this->command->{$method}($line);
    }

    public function setCommand($command)
    {
        $this->command = $command;

        return $this;
    }

    protected function purgeOldKernels()
    {
        $packages = $this->getInstalledKernelPackages($currentKernel = $this->getCurrentKernel());

        $keepVersions = $packages->map(function($item) {
            return $item['version'];
        })->unique()->values();

        $this->checkFirstKernelIsCurrentKernel($currentKernel, $keepVersions, $packages);

        $discardVersions = $keepVersions->splice($this->protectFirst);

        $this->printHeader('Current kernel packages (protected)');

        $packages->each(function($package) {
            if ($package['current']) {
                $this->command->info($package['package']);
            }
        });

        $this->printHeader('All protected packages (including current)');

        $packages->whereIn('version', $keepVersions)->each(function($package) {
            $this->command->info($package['package']);
        });

        $this->printHeader('Deletable packages');

        $packages->whereIn('version', $discardVersions)->each(function($package) {
            $this->command->info($package['package']);
        });

        $this->printHeader('Purge commands');

        $packages->whereIn('version', $discardVersions)->each(function($package) {
            $this->command->info($this->getPurgePackageCommand($package['package']));
        });

        if ($this->run) {
            $this->printHeader('Purge commands');

            $packages->whereIn('version', $discardVersions)->each(function($package) {
                $command = $this->getPurgePackageCommand($package['package']);

                $this->command->info('Executing '.$command);

                $this->execShellCommand($command, true);
            });

        }
    }

    public function setRun($run)
    {
        $this->run = $run;

        return $this;
    }

    public function setProtect($protect)
    {
        $this->protectFirst = $protect;

        return $this;
    }
}
