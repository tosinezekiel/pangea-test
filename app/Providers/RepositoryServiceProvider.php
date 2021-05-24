<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\{TopicRepository, SubscriberRepository};
use App\Repositories\Eloquent\{TopicRepositoryImpl, SubscriberRepositoryImpl};

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(TopicRepository::class, TopicRepositoryImpl::class);
        $this->app->bind(SubscriberRepository::class, SubscriberRepositoryImpl::class);
    }
}
