<?php

namespace App\Services\GitHub;

use GrahamCampbell\GitHub\GitHubFactory as GrahamCampbellGitHubFactory;

class GitHubFactory extends GrahamCampbellGitHubFactory
{
    /**
     * Get the http client builder.
     *
     * @param string[] $config
     *
     * @return \GrahamCampbell\GitHub\Http\ClientBuilder
     */
    protected function getBuilder(array $config)
    {
        $builder = parent::getBuilder($config);

        $builder->addPlugin(new AcceptPreviewPlugin());

        return $builder;
    }
}
