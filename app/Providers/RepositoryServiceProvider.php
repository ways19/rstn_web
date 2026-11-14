<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Identity
use App\Modules\Identity\Contracts\UserRepositoryInterface;
use App\Modules\Identity\Repositories\UserRepository;
use App\Modules\Identity\Contracts\RoleRepositoryInterface;
use App\Modules\Identity\Repositories\RoleRepository;

// Medical
use App\Modules\Medical\Contracts\ServiceRepositoryInterface;
use App\Modules\Medical\Repositories\ServiceRepository;
use App\Modules\Medical\Contracts\DoctorRepositoryInterface;
use App\Modules\Medical\Repositories\DoctorRepository;
use App\Modules\Medical\Contracts\BedRepositoryInterface;
use App\Modules\Medical\Repositories\BedRepository;

// Content
use App\Modules\Content\Contracts\PostRepositoryInterface;
use App\Modules\Content\Repositories\PostRepository;
use App\Modules\Content\Contracts\BannerRepositoryInterface;
use App\Modules\Content\Repositories\BannerRepository;
use App\Modules\Content\Contracts\PageRepositoryInterface;
use App\Modules\Content\Repositories\PageRepository;
use App\Modules\Content\Contracts\PpidDocumentRepositoryInterface;
use App\Modules\Content\Repositories\PpidDocumentRepository;

// Patient
use App\Modules\Patient\Contracts\RegistrationRepositoryInterface;
use App\Modules\Patient\Repositories\RegistrationRepository;
use App\Modules\Patient\Contracts\ComplaintRepositoryInterface;
use App\Modules\Patient\Repositories\ComplaintRepository;

// Navigation & Core
use App\Modules\Navigation\Contracts\MenuRepositoryInterface;
use App\Modules\Navigation\Repositories\MenuRepository;
use App\Modules\Navigation\Contracts\ModuleRepositoryInterface;
use App\Modules\Navigation\Repositories\ModuleRepository;
use App\Modules\Navigation\Contracts\SettingRepositoryInterface;
use App\Modules\Navigation\Repositories\SettingRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     */
    public array $bindings = [
        // Identity
        UserRepositoryInterface::class => UserRepository::class,
        RoleRepositoryInterface::class => RoleRepository::class,

        // Medical
        ServiceRepositoryInterface::class => ServiceRepository::class,
        DoctorRepositoryInterface::class => DoctorRepository::class,
        BedRepositoryInterface::class => BedRepository::class,

        // Content
        PostRepositoryInterface::class => PostRepository::class,
        BannerRepositoryInterface::class => BannerRepository::class,
        PageRepositoryInterface::class => PageRepository::class,
        PpidDocumentRepositoryInterface::class => PpidDocumentRepository::class,

        // Patient
        RegistrationRepositoryInterface::class => RegistrationRepository::class,
        ComplaintRepositoryInterface::class => ComplaintRepository::class,

        // Navigation
        MenuRepositoryInterface::class => MenuRepository::class,
        ModuleRepositoryInterface::class => ModuleRepository::class,
        SettingRepositoryInterface::class => SettingRepository::class,
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        //
    }
}
