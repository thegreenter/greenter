<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\AddTagToChangelogReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\PushNextDevReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\PushTagReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\SetCurrentMutualDependenciesReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\SetNextMutualDependenciesReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\TagVersionReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\UpdateBranchAliasReleaseWorker;
use Symplify\MonorepoBuilder\ValueObject\Option;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    # release workers - in order to execute
    $services->set(SetCurrentMutualDependenciesReleaseWorker::class);
    $services->set(AddTagToChangelogReleaseWorker::class);
    $services->set(TagVersionReleaseWorker::class);
    $services->set(SetNextMutualDependenciesReleaseWorker::class);
    $services->set(UpdateBranchAliasReleaseWorker::class);
    $services->set(PushTagReleaseWorker::class);
//    $services->set(PushNextDevReleaseWorker::class);

    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::DATA_TO_APPEND, [
        'require-dev' => [
            'phpstan/phpstan' => '^0.12',
        ],
    ]);

    $parameters->set(Option::DIRECTORIES_TO_REPOSITORIES, [
        'packages/core' => 'https://github.com/thegreenter/core.git',
        'packages/data' => 'https://github.com/thegreenter/data.git',
        'packages/htmltopdf' => 'https://github.com/thegreenter/htmltopdf.git',
        'packages/lite' => 'https://github.com/thegreenter/lite.git',
        'packages/report' => 'https://github.com/thegreenter/report.git',
        'packages/validator' => 'https://github.com/thegreenter/validator.git',
        'packages/ws' => 'https://github.com/thegreenter/ws.git',
        'packages/xcodes' => 'https://github.com/thegreenter/xcodes.git',
        'packages/xml' => 'https://github.com/thegreenter/xml.git',
        'packages/xml-parser' => 'https://github.com/thegreenter/xml-parser.git',
    ]);
};
