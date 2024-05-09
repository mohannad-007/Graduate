<?php

namespace App\Providers;

use App\Repositories\Admin\AdminRepository;
use App\Repositories\Admin\AdminRepositoryInterface;
use App\Repositories\Diagnosis\DiagnosisRepository;
use App\Repositories\Diagnosis\DiagnosisRepositoryInterface;
use App\Repositories\Patient\PatientRepository;
use App\Repositories\Patient\PatientRepositoryInterface;
use App\Repositories\Section\SectionRepository;
use App\Repositories\Section\SectionRepositoryInterface;
use App\Repositories\Student\StudentRepository;
use App\Repositories\Student\StudentRepositoryInterface;
use App\Repositories\Supervisor\SupervisorRepository;
use App\Repositories\Supervisor\SupervisorRepositoryInterface;
use App\Services\Admin\AdminService;
use App\Services\Diagnosis\DiagnosisService;
use App\Services\Patient\PatientService;
use App\Services\Section\SectionService;
use App\Services\Student\StudentService;
use App\Services\Supervisor\SupervisorService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(PatientRepositoryInterface::class, PatientRepository::class);
        $this->app->bind(PatientService::class, function ($app) {
            return new PatientService($app->make(PatientRepositoryInterface::class));
        });

        $this->app->bind(StudentRepositoryInterface::class, StudentRepository::class);
        $this->app->bind(StudentService::class, function ($app) {
            return new StudentService($app->make(StudentRepositoryInterface::class));
        });

        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
        $this->app->bind(AdminService::class, function ($app) {
            return new AdminService($app->make(AdminRepositoryInterface::class));
        });

        $this->app->bind(SupervisorRepositoryInterface::class, SupervisorRepository::class);
        $this->app->bind(SupervisorService::class, function ($app) {
            return new SupervisorService($app->make(SupervisorRepositoryInterface::class));
        });

        $this->app->bind(DiagnosisRepositoryInterface::class, DiagnosisRepository::class);
        $this->app->bind(DiagnosisService::class, function ($app) {
            return new DiagnosisService($app->make(DiagnosisRepositoryInterface::class));
        });


        $this->app->bind(SectionRepositoryInterface::class, SectionRepository::class);
        $this->app->bind(SectionService::class, function ($app) {
            return new SectionService($app->make(SectionRepositoryInterface::class));
        });


    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
