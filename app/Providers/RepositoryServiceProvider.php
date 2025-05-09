<?php

namespace App\Providers;

use App\Models\CvSkill;
use App\Repositories\Collaboration\CollaborationRepository;
use App\Repositories\Collaboration\CollaborationRepositoryInterface;
use App\Repositories\Company\CompanyRepository;
use App\Repositories\Company\CompanyRepositoryInterface;
use App\Repositories\Hiring\HiringRepository;
use App\Repositories\Job\JobRepository;
use App\Repositories\Job\JobRepositoryInterface;
use App\Repositories\Major\MajorRepository;
use App\Repositories\Major\MajorRepositoryInterface;
use App\Repositories\Notification\NotificationRepository;
use App\Repositories\Notification\NotificationRepositoryInterface;
use App\Repositories\Skill\SkillRepository;
use App\Repositories\Skill\SkillRepositoryInterface;
use App\Repositories\UniversityJob\UniversityJobRepository;
use App\Repositories\UniversityJob\UniversityJobRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Workshop\WorkshopRepository;
use App\Repositories\Workshop\WorkshopRepositoryInterface;
use App\Repositories\AcademicAffairs\AcademicAffairsRepository;
use App\Repositories\AcademicAffairs\AcademicAffairsRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Base\BaseRepositoryInterface;
use App\Repositories\Certificate\CertificateRepository;
use App\Repositories\Certificate\CertificateRepositoryInterface;
use App\Repositories\ChatMessage\ChatMessageRepository;
use App\Repositories\ChatMessage\ChatMessageRepositoryInterface;
use App\Repositories\Fields\FieldsRepository;
use App\Repositories\Fields\FieldsRepositoryInterface;
use App\Repositories\Hiring\HiringRepositoryInterface;
use App\Repositories\University\UniversityRepository;
use App\Repositories\University\UniversityRepositoryInterface;
use App\Repositories\Cv\CvRepository;
use App\Repositories\Cv\CvRepositoryInterface;
use App\Repositories\CvSkill\CvSkillRepository;
use App\Repositories\CvSkill\CvSkillRepositoryInterface;
use App\Repositories\Education\EducationRepository;
use App\Repositories\Education\EducationRepositoryInterface;
use App\Repositories\Experience\ExperienceRepository;
use App\Repositories\Experience\ExperienceRepositoryInterface;
use App\Repositories\Interview\InterviewRepository;
use App\Repositories\Interview\InterviewRepositoryInterface;
use App\Repositories\JobWishlist\JobWishlistRepository;
use App\Repositories\JobWishlist\JobWishlistRepositoryInterface;
use App\Repositories\Referrer\ReferrerRepository;
use App\Repositories\Referrer\ReferrerRepositoryInterface;
use App\Repositories\ScheduleInterview\ScheduleInterviewRepository;
use App\Repositories\ScheduleInterview\ScheduleInterviewRepositoryInterface;
use App\Repositories\UserJob\UserJobRepository;
use App\Repositories\UserJob\UserJobRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $models = [
            'User',
            'Student',
            'Province',
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
        $this->app->bind(HiringRepositoryInterface::class,  HiringRepository::class);
        $this->app->bind(UniversityRepositoryInterface::class, UniversityRepository::class);
        $this->app->bind(WorkshopRepositoryInterface::class, WorkshopRepository::class);
        $this->app->bind(AcademicAffairsRepositoryInterface::class, AcademicAffairsRepository::class);
        $this->app->bind(FieldsRepositoryInterface::class, FieldsRepository::class);
        $this->app->bind(CollaborationRepositoryInterface::class, CollaborationRepository::class);
        $this->app->bind(NotificationRepositoryInterface::class, NotificationRepository::class);
        $this->app->bind(CvRepositoryInterface::class, CvRepository::class);
        $this->app->bind(ExperienceRepositoryInterface::class, ExperienceRepository::class);
        $this->app->bind(EducationRepositoryInterface::class, EducationRepository::class);
        $this->app->bind(CvSkillRepositoryInterface::class, CvSkillRepository::class);
        $this->app->bind(CertificateRepositoryInterface::class, CertificateRepository::class);
        $this->app->bind(ReferrerRepositoryInterface::class, ReferrerRepository::class);
        $this->app->bind(ChatMessageRepositoryInterface::class, ChatMessageRepository::class);
        $this->app->bind(UserJobRepositoryInterface::class, UserJobRepository::class);
        $this->app->bind(JobWishlistRepositoryInterface::class, JobWishlistRepository::class);
        $this->app->bind(ScheduleInterviewRepositoryInterface::class, ScheduleInterviewRepository::class);
        $this->app->bind(InterviewRepositoryInterface::class, InterviewRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
