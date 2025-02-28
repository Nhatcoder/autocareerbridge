<?php

namespace App\Services\Job;

use App\Helpers\LogHelper;
use App\Helpers\StorageHelper;
use Exception;
use App\Mail\SendMailStudent;
use App\Mail\NewJobPostedMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailRejectJobCompany;
use App\Mail\SendMailUniversityApplyJob;
use App\Repositories\Job\JobRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\Notification\NotificationService;
use App\Repositories\Major\MajorRepositoryInterface;
use App\Repositories\Company\CompanyRepositoryInterface;
use App\Repositories\UserJob\UserJobRepositoryInterface;
use App\Repositories\University\UniversityRepositoryInterface;
use App\Repositories\Notification\NotificationRepositoryInterface;
use App\Repositories\Collaboration\CollaborationRepositoryInterface;
use App\Repositories\Cv\CvRepositoryInterface;

class JobService
{
    use LogHelper;
    protected $jobRepository;
    protected $majorRepository;
    protected $collaborationRepository;
    protected $notificationRepository;
    protected $universityRepository;
    protected $notificationService;
    protected $companyRepository;
    protected $userRepository;
    protected $userJobRepository;
    protected $storageHelper;
    protected $cvRepository;

    public function __construct(
        CompanyRepositoryInterface       $companyRepository,
        JobRepositoryInterface           $jobRepository,
        MajorRepositoryInterface         $majorRepository,
        CollaborationRepositoryInterface $collaborationRepository,
        NotificationRepositoryInterface  $notificationRepository,
        UniversityRepositoryInterface    $universityRepository,
        NotificationService              $notificationService,
        UserRepositoryInterface          $userRepository,
        UserJobRepositoryInterface       $userJobRepository,
        StorageHelper                    $storageHelper,
        CvRepositoryInterface            $cvRepository,

    ) {
        $this->companyRepository = $companyRepository;
        $this->jobRepository = $jobRepository;
        $this->majorRepository = $majorRepository;
        $this->collaborationRepository = $collaborationRepository;
        $this->notificationRepository = $notificationRepository;
        $this->universityRepository = $universityRepository;
        $this->notificationService = $notificationService;
        $this->userRepository = $userRepository;
        $this->userJobRepository = $userJobRepository;
        $this->storageHelper = $storageHelper;
        $this->cvRepository = $cvRepository;
    }

    public function getAll()
    {
        return $this->jobRepository->getAll();
    }
    public function totalRecord()
    {
        return $this->jobRepository->totalRecord();
    }

    public function getJobs(array $filters)
    {
        return $this->jobRepository->getJobs($filters);
    }

    public function getMajors()
    {
        return $this->majorRepository->getAll();
    }

    public function findJob($slug)
    {
        return $this->jobRepository->findJob($slug);
    }

    public function checkStatus(array $data)
    {
        return $this->jobRepository->checkStatus($data);
    }

    public function updateStatus($job, $dataRequest)
    {
        $dataRequest['is_active'] = ($dataRequest['status'] == STATUS_APPROVED) ? ACTIVE : INACTIVE;
        $companyId = $job->company_id;
        $collaborations = $this->collaborationRepository->getUniversityCollaboration($companyId);
        $company = $job->company->user;
        if ($dataRequest['status'] == STATUS_APPROVED) {
            $notification = $this->notificationRepository->create([
                'title' => 'Tin ' . $job->name . ' được phê duyệt',
                'company_id' => $companyId,
                'link' => route('company.showJob', $job->slug),
                'type' => TYPE_JOB,
            ]);

            $this->notificationService->renderNotificationRealtime($notification, $companyId);

            $notifications = [];
            $emails = [];
            foreach ($collaborations as $collaboration) {
                $universityEmail = $collaboration->university->email ?? null;
                if ($universityEmail) {
                    // Tạo thông báo và lưu vào mảng
                    $notification = $this->notificationRepository->create([
                        'title' => $company->company->name . ' vừa đăng tin ' . $job->name,
                        'university_id' => $collaboration->university->id,
                        'link' => route('university.jobDetail', $job->slug),
                        'type' => TYPE_COMPANY,
                    ]);

                    $notifications[] = [
                        'notification' => $notification,
                        'university_id' => $collaboration->university->id,
                    ];

                    $emails[] = [
                        'email' => $universityEmail,
                        'company' => $company,
                        'job' => $job,
                    ];
                }
            }

            // Gửi thông báo thời gian thực
            foreach ($notifications as $data) {
                $this->notificationService->renderNotificationRealtime(
                    $data['notification'],
                    null,
                    $data['university_id']
                );
            }

            // Gửi email
            foreach ($emails as $data) {
                Mail::to($data['email'])->queue(new NewJobPostedMail($data['company'], $data['job']));
            }
        } else {
            $notification = $this->notificationRepository->create([
                'title' => 'Tin ' . $job->name . ' bị từ chối',
                'company_id' => $companyId,
                'link' => route('company.showJob', $job->slug),
                'type' => TYPE_JOB,
            ]);
            $this->notificationService->renderNotificationRealtime($notification, $companyId);

            Mail::to($company->email)->queue(new SendMailRejectJobCompany($company, $job));
        }
        return $job->update($dataRequest);
    }

    public function getApplyJobs()
    {
        return $this->jobRepository->getApplyJobs();
    }

    public function checkApplyJob($id, $slug)
    {
        return $this->jobRepository->checkApplyJob($id, $slug);
    }

    public function filterJobByMonth()
    {
        return $this->jobRepository->filterJobByMonth();
    }

    public function filterJobByDateRange(array $data)
    {
        return $this->jobRepository->filterJobByDateRange($data);
    }

    public function getJobForUniversity($slug)
    {
        return $this->jobRepository->findJob($slug);
    }

    public function applyJob($job_id, $university_id)
    {
        try {
            $university = $this->universityRepository->find($university_id);
            $job = $this->jobRepository->find($job_id);

            if (empty($university) && empty($job)) {
                return null;
            }

            $company = $job->company;
            $resultUniversityApplyJob = $this->jobRepository->applyJob($job_id, $university_id);

            if ($resultUniversityApplyJob && $company) {
                $notification = $this->notificationRepository->create([
                    'title' => $university->name . ' ứng tuyển ' . $job->name,
                    'company_id' => $company->id,
                    'link' => route('company.showJob', $job->slug),
                    'type' => TYPE_UNIVERSITY,
                ]);
                $this->notificationService->renderNotificationRealtime($notification, $company->id);

                Mail::to($company->user->email)
                    ->queue(new SendMailUniversityApplyJob($university, $company, $job));
                return $resultUniversityApplyJob;
            } else {
                return null;
            }
        } catch (Exception $e) {
            Log::error($e->getFile() . ':' . $e->getLine() . ' - ' . 'Lỗi khi xử lý ứng tuyển: ' . ' - ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Creates a new job and sends a notification to the admin.
     *
     * @param array $data The job data, including name, slug, details, major, end date, and related information.
     * @param array $skills The list of skills to associate with the job.
     * @return bool Returns `true` if the job is created successfully, `false` if there is an error during the creation process.
     *
     * @throws \Exception If an error occurs during the transaction or job creation.
     */
    public function createJob(array $data, array $skills)
    {
        DB::beginTransaction();
        try {

            $job = [
                'name' => $data['name'],
                'slug' => $data['slug'],
                'detail' => $data['detail'],
                'major_id' => $data['major_id'],
                'end_date' => $data['end_date'],
                'user_id' => Auth::guard('admin')->user()->id,
                'company_id' => Auth::guard('admin')->user()->hiring->company_id ?? Auth::guard('admin')->user()->company->id,
                'status' => STATUS_PENDING,
                'is_active' => INACTIVE
            ];

            $admin = $this->userRepository->getAdmin();
            if (!$admin) {
                return false;
            }
            $detail = $this->jobRepository->create($job);
            if (!$detail) {
                return false;
            }
            $company = $detail->company;

            $notification = $this->notificationRepository->create([
                'title' => $company->name . ' vừa tạo công việc ' . $detail->name,
                'link' => route('admin.jobs.show', $detail->slug),
                'type' => TYPE_COMPANY,
                'admin_id' => $admin->id,
            ]);

            $this->notificationService->renderNotificationRealtime($notification, null, null, $admin->id);

            $detail->skills()->detach();
            foreach ($skills as $skill) {
                $detail->skills()->attach($skill);
            }
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Lỗi tạo bài tuyển dụng', $e->getMessage());
            return false;
        }
    }

    public function updateJob(string $id, array $data, array $skills)
    {
        $job = $this->jobRepository->find($id);

        if (!$job) {
            return back()->with('status_fail', 'Không tìm thấy bài tuyển dụng, không thể cập nhật!');
        }

        $data = [
            'name' => $data['name'],
            'slug' => $data['slug'],
            'detail' => $data['detail'],
            'major_id' => $data['major_id'],
            'end_date' => $data['end_date'],
        ];
        $this->jobRepository->update($id, $data);

        $job->skills()->detach();
        foreach ($skills as $skill) {
            $job->skills()->attach($skill);
        }
    }

    public function getJob($slug)
    {
        return $this->jobRepository->getJob($slug);
    }

    public function find($id)
    {
        return $this->jobRepository->find($id);
    }

    public function deleteJob($id)
    {
        return $this->jobRepository->delete($id);
    }

    public function getPostsByCompany(array $filters)
    {
        return $this->jobRepository->getPostsByCompany($filters);
    }

    public function getAllJobs()
    {
        return $this->jobRepository->getAllJobs();
    }

    public function getWishlistJobs()
    {
        return $this->jobRepository->getWishlistJobs();
    }

    public function getAppliedJobs($university_id)
    {
        return $this->jobRepository->getAppliedJobs($university_id);
    }

    public function manageUniversityJob()
    {
        $comany_id = auth()->guard('admin')->user()->company->id ?? auth()->guard('admin')->user()->hiring->company_id;
        return $this->jobRepository->getUniversityJob($comany_id);
    }

    public function updateStatusUniversityJob($id, $status)
    {
        try {
            $universityJob = $this->jobRepository->findUniversityJob($id);
            $universityId = $universityJob->university_id;
            $jobId = $universityJob->job_id;
            $job = $this->jobRepository->find($jobId);
            if ($status == STATUS_APPROVED) {
                $notification = $this->notificationRepository->create([
                    'title' => 'Công việc ' . $job->name . ' được doanh nghiệp chấp nhận',
                    'university_id' => $universityId,
                    'link' => route('university.jobDetail', $job->slug),
                    'type' => TYPE_JOB,
                ]);
                $this->notificationService->renderNotificationRealtime($notification, null, $universityId);

                $university = $this->universityRepository->getStudentMatchingJob($jobId, $universityId);
                if ($university) {
                    foreach ($university->students as $student) {
                        Mail::to($student->email)
                            ->queue(new SendMailStudent($job, $job->company));
                    }
                }
            } else {
                $notification = $this->notificationRepository->create([
                    'title' => 'Công việc ' . $job->name . ' bị doanh nghiệp từ chối',
                    'university_id' => $universityId,
                    'link' => route('university.jobDetail', $job->slug),
                    'type' => TYPE_JOB,
                ]);
                $this->notificationService->renderNotificationRealtime($notification, null, $universityId);
            }
            return $this->jobRepository->updateStatusUniversityJob($id, $status);
        } catch (Exception $e) {
            Log::error($e->getFile() . ':' . $e->getLine() . ' - ' . 'Lỗi khi xử lý ứng tuyển: ' . ' - ' . $e->getMessage());
            return null;
        }
    }

    public function searchJobs($keySearch, $province, $major, $fields, $skills)
    {
        return $this->jobRepository->searchJobs($keySearch, $province, $major, $fields, $skills);
    }

    public function getJobChart($dateFrom, $dateTo)
    {
        $records =  $this->jobRepository->getJobChart($dateFrom, $dateTo);
        $jobApperoved = [];
        $jobDelete = [];
        $date = [];

        foreach ($records as $value) {
            array_push($jobApperoved, $value->total_approved_jobs);
            array_push($jobDelete, $value->total_deleted_jobs);
            array_push($date, $value->created_date);
        }

        return [
            'jobApperoved' => $jobApperoved,
            'jobDelete' => $jobDelete,
            'date' => $date
        ];
    }

    public function updateToggleActive(int $id, array $data)
    {
        $data['is_active'] = $data['status'] == 'active' ? ACTIVE : INACTIVE;
        return $this->jobRepository->updateToggleActive($id, $data);
    }

    public function bulkUpdateStatusJobs($jobIds, $dataRequest)
    {
        DB::beginTransaction();
        try {
            $jobs = $this->jobRepository->getPendingJobsByIds($jobIds);

            foreach ($jobs as $job) {
                $this->updateStatus($job, $dataRequest);
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getFile() . ':' . $e->getLine() . ' - Lỗi khi xử lý job: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Allows a user to apply for a job.
     * @author Tran Van Nhat
     * @param array $data The job application data, including job_id and other relevant details.
     * @return mixed The result of creating the job application in the repository.
     */
    public function userApplyJob($data)
    {
        $user = Auth::guard('web')->user();
        $dataApply = [
            'user_id' => $user->id,
            'job_id' => $data['job_id'],
            'cv_id' => $data['cv_id'],
        ];

        DB::beginTransaction();
        try {
            $dataUploadCv = [
                'user_id' => $user->id,
                'type' => TYPE_CV_UPLOAD,
            ];

            if ($data['file_cv']) {
                $uploadFileCV = $this->storageHelper->storageFileUpload($data['file_cv'], 'cvs/pdf');
                if ($uploadFileCV) {
                    $dataUploadCv['upload'] = $uploadFileCV['path'];
                    $name = explode('.pdf', $uploadFileCV['name']);
                    $dataUploadCv['title'] = $name[0];
                }

                $result = $this->cvRepository->create($dataUploadCv);
                $dataApply['cv_id'] = $result->id;
            }

            $userJob = $this->userJobRepository->create($dataApply);

            $updateUser = [];
            if ($data['phone']) {
                $updateUser['phone'] = $data['phone'];
            }

            if ($data['name']) {
                $updateUser['name'] = $data['name'];
            }

            if (count($updateUser) > 0) {
                $userUpdate =  $this->userRepository->update($user->id, $updateUser);
            }

            if ($userJob) {
                $notification = $this->notificationRepository->create([
                    'title' => ($userJob->user->name ?? $userUpdate->name) . ' ứng tuyển ' . $userJob->job->name,
                    'company_id' => $userJob->job->company->id,
                    'link' => route('company.manageUserApplyJob', ['tab' => 'all']),
                    'type' => TYPE_UNIVERSITY,
                ]);
                $this->notificationService->renderNotificationRealtime($notification, $userJob->job->company->id);
            }

            DB::commit();
            return $userJob;
        } catch (Exception $e) {
            DB::rollBack();
            $this->logExceptionDetails($e);
            throw $e;
        }
    }

    /**
     * This function handles customer job applications.
     * @author Tran Van Nhat
     */
    public function custommerApplicateJob()
    {
        $companyId = auth()->guard('admin')->user()->company->id ?? auth()->guard('admin')->user()->hiring->company_id;
        $userJobs = $this->jobRepository->getUserApplyJob($companyId);

        return $userJobs;
    }

    /**
     * This function handles change status of a user job applying
     * @author Tran Van Nhat
     */
    public function changeStatusUserAplly($data)
    {
        $userJob = $this->userJobRepository->find($data['id']);
        if (empty($userJob)) {
            return null;
        }

        $status = '';
        if ($data['status'] == STATUS_UNFIT) {
            $status .= 'chưa phù hợp';
        } elseif ($data['status'] == STATUS_HIRED) {
            $status .= 'đã tuyển';
        }

        switch ($data['status']) {
            case STATUS_FIT:
                $this->userJobRepository->update($userJob->id, [
                    'interview_time' => $data['interview_time'],
                    'status' => $data['status'],
                ]);
                $notification = $this->notificationService->create([
                    'user_id' => $userJob->user_id,
                    'title' => ($userJob->job->company->name ? $userJob->job->company->name : NAME_COMPANY) . ' vừa cập nhật trạng thái CV của bạn là Phù hợp',
                    'link' => route('detailJob', $userJob->job->slug),
                ]);
                $this->notificationService->renderNotificationRealtimeClient($notification);
                break;
            default:
                $this->userJobRepository->update($userJob->id, [
                    'status' => $data['status'],
                ]);

                $notification = $this->notificationService->create([
                    'user_id' => $userJob->user_id,
                    'title' => ($userJob->job->company->name ? $userJob->job->company->name : NAME_COMPANY) . ' vừa cập nhật trạng thái CV của bạn là ' . $status,
                    'link' => route('detailJob', $userJob->job->slug),
                ]);
                $this->notificationService->renderNotificationRealtimeClient($notification);
                break;
        }
        return $userJob;
    }

    /**
     * Update the status of user job interviews.
     * @author Tran Van Nhat
     * @return mixed
     */
    public function scheduleUpdateStatusUserJobInterView()
    {
        try {
            $userJobs = $this->userJobRepository->updateStatusUserJobInterView();

            if (!empty($userJobs)) {
                foreach ($userJobs as $job) {
                    $notification = $this->notificationService->create([
                        'user_id' => $job->user_id,
                        'title' => ($job->job->company->name ? $job->job->company->name : NAME_COMPANY) . ' có cuộc phỏng vấn với bạn vị trí ' . $job->job->name . ', vào lúc ' . date('d/m/Y H:i', strtotime($job->interview_time)),
                        'link' => route('detailJob', $job->job->slug),
                    ]);
                    $this->notificationService->renderNotificationRealtimeClient($notification);
                }
            }

            return $userJobs;
        } catch (Exception $e) {
            $this->logExceptionDetails($e);
            throw $e;
        }
    }

    /**
     * This function checks if the user has seen a job application or not.
     * @author Tran Van Nhat
     * @param array $data The job application data, including job_id and other relevant details.
     * @return mixed The result of checking if the user has seen the job application in the repository.
     */
    public function checkUserJobSeen($data)
    {
        $userJob = $this->userJobRepository->find($data['id']);
        if (empty($userJob)) {
            return null;
        }

        return $userJob;
    }

    /**
     * This function marks a job application as seen by a user.
     * @author Tran Van Nhat
     * @param array $data The job application data, including job_id and other relevant details.
     * @return mixed The result of marking the job application as seen in the repository.
     */
    public function markCvAsSeen($data)
    {
        $userJob = $this->userJobRepository->find($data['id']);
        if (empty($userJob)) {
            return null;
        }

        DB::beginTransaction();
        try {
            $result = $this->userJobRepository->update($userJob->id, [
                'is_seen' => SEEN,
            ]);

            if ($userJob->is_seen == UNSEEN) {
                $notification = $this->notificationService->create([
                    'user_id' => $userJob->user_id,
                    'title' => ($userJob->job->company->name ? $userJob->job->company->name : NAME_COMPANY) . ', Vừa xem CV của bạn',
                    'link' => route('historyJobApply'),
                ]);
                $this->notificationService->renderNotificationRealtimeClient($notification);
            }

            DB::commit();
            return $result;
        } catch (Exception $e) {
            DB::rollBack();
            $this->logExceptionDetails($e);
            throw $e;
        }
    }
}
