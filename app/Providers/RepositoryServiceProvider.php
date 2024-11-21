<?php

namespace App\Providers;
use App\Repositories\Company\CompanyRepository;
use App\Repositories\Company\CompanyRepositoryInterface;
use App\Repositories\Job\JobRepository;
use App\Repositories\Job\JobRepositoryInterface;
use App\Repositories\Major\MajorRepository;
use App\Repositories\Major\MajorRepositoryInterface;
use App\Repositories\Skill\SkillRepository;
use App\Repositories\Skill\SkillRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Workshop\WorkshopRepository;
use App\Repositories\Workshop\WorkshopRepositoryInterface;
use App\Models\Hiring;
use App\Models\University;
use App\Repositories\AcademicAffairs\AcademicAffairsRepository;
use App\Repositories\AcademicAffairs\AcademicAffairsRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Base\BaseRepositoryInterface;
use App\Repositories\Hiring\HiringRepository;
use App\Repositories\Hiring\HiringRepositoryInterface;
use App\Repositories\University\UniversityRepository;
use App\Repositories\University\UniversityRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $models = [
            'User',
            'Student'
        ];

        // phpcs:disable
        foreach ($models as $model) {
            $this->app->singleton(
                "App\\Repositories\\{$model}\\{$model}RepositoryInterface",
                "App\\Repositories\\{$model}\\{$model}Repository"
            );
        }
        // phpcs:enable
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(JobRepositoryInterface::class, JobRepository::class);
        $this->app->bind(MajorRepositoryInterface::class, MajorRepository::class);
        $this->app->bind(SkillRepositoryInterface::class, SkillRepository::class);
        $this->app->bind(WorkshopRepositoryInterface::class, WorkshopRepository::class);
        $this->app->bind(HiringRepositoryInterface::class, HiringRepository::class);
        $this->app->bind(UniversityRepositoryInterface::class, UniversityRepository::class);
        $this->app->bind(AcademicAffairsRepositoryInterface::class, AcademicAffairsRepository::class);


    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
