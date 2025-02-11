<?php

namespace App\Services\Cv;

use App\Repositories\Certificate\CertificateRepositoryInterface;
use App\Repositories\Cv\CvRepositoryInterface;
use App\Repositories\CvSkill\CvSkillRepositoryInterface;
use App\Repositories\Education\EducationRepositoryInterface;
use App\Repositories\Experience\ExperienceRepositoryInterface;
use App\Repositories\Referrer\ReferrerRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Str;

class CvService
{
    protected $cvRepository;
    protected $experienceRepository;
    protected $educationRepository;
    protected $cvSkillRepository;
    protected $certificateRepository;
    protected $referrerRepository;

    public function __construct(
        CvRepositoryInterface $cvRepository,
        ExperienceRepositoryInterface $experienceRepository,
        EducationRepositoryInterface $educationRepository,
        CvSkillRepositoryInterface $cvSkillRepository,
        CertificateRepositoryInterface $certificateRepository,
        ReferrerRepositoryInterface $referrerRepository
    ) {
        $this->cvRepository = $cvRepository;
        $this->experienceRepository = $experienceRepository;
        $this->educationRepository = $educationRepository;
        $this->cvSkillRepository = $cvSkillRepository;
        $this->certificateRepository = $certificateRepository;
        $this->referrerRepository = $referrerRepository;
    }

    public function createCv($request)
    {
        // dd($request->all());
        DB::beginTransaction();

        try {

            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                $file = $request->file('avatar');
                $avatarPath = $file->store('cvs', 'public');
                $avatarUrl  = '/storage/' . $avatarPath;
            } else {
                $avatarUrl = null;
            }


            $cv = $this->cvRepository->create([
                'template' => $request->template,
                'title' => $request->title,
                'username' => $request->name,
                'font' => $request->font,
                'color' => $request->color,
                'position' => $request->position_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'birthdate' => $request->birthdate,
                'introduce' => $request->introduce,
                'avatar' => $avatarUrl,
                'user_id' => 1
            ]);

            $companyNames  = $request->company_name;
            $schoolNames = $request->school;
            $contactNames = $request->contact_name;

            $cvId = $cv->id;

            if (!empty($companyNames)) {
                foreach ($companyNames as $index => $companyName) {
                    $this->experienceRepository->create([
                        'cv_id'          => $cvId,
                        'company_name'   => $companyName ?? null,
                        'position'       => ($request->position)[$index] ?? null,
                        'start_date' => ($request->start_date_exp)[$index] ?? null,
                        'end_date'   => ($request->end_date_exp)[$index] ?? null,
                        'description'    => ($request->description)[$index] ?? null,
                    ]);
                }
            }


            if (!empty($schoolNames)) {
                foreach ($schoolNames as $index => $school) {
                    $this->educationRepository->create([
                        'cv_id'          => $cvId,
                        'university_name'   => $school ?? null,
                        'major'       => ($request->major)[$index] ?? null,
                        'type_graduate' => ($request->degree)[$index] ?? null,
                        'start_date'   => ($request->start_date_education)[$index] ?? null,
                        'end_date'   => ($request->end_date_education)[$index] ?? null,
                    ]);
                }
            }

            $this->cvSkillRepository->create([
                'cv_id' => $cvId,
                'name' => $request->skills,
            ]);

            $this->certificateRepository->create([
                'cv_id' => $cvId,
                'description' => $request->certifications
            ]);

            if (!empty($contactNames)) {
                foreach ($contactNames as $index => $contact) {
                    $this->referrerRepository->create([
                        'cv_id'          => $cvId,
                        'name'   => $contact ?? null,
                        'company_name'       => ($request->contact_company_name)[$index] ?? null,
                        'position' => ($request->contact_position)[$index] ?? null,
                        'phone'   => ($request->contact_phone)[$index] ?? null,
                    ]);
                }
            }



            DB::commit();
            return $cv;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updateCv($request, $cvId)
    {
        DB::beginTransaction();

        try {
            $cv = $this->cvRepository->find($cvId);
            if (!$cv) {
                throw new \Exception("CV not found.");
            }

            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                $file = $request->file('avatar');
                $avatarPath = $file->store('cvs', 'public');
                $avatarUrl  = '/storage/' . $avatarPath;
            } else {
                $avatarUrl = $cv->avatar;
            }

            // update cvs
            $cv->update([
                'template' => $request->template,
                'title' => $request->title,
                'username' => $request->name,
                'font' => $request->font,
                'color' => $request->color,
                'position' => $request->position_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'birthdate' => $request->birthdate,
                'introduce' => $request->introduce,
                'avatar' => $avatarUrl,
            ]);

            // experience
            $currentExperienceIds = $cv->experiences->pluck('id')->toArray();
            $newExperienceIds = [];

            if (!empty($request->company_name)) {
                foreach ($request->company_name as $index => $companyName) {
                    $experienceData = [
                        'cv_id'        => $cvId,
                        'company_name' => $companyName ?? null,
                        'position'     => $request->position[$index] ?? null,
                        'start_date'   => $request->start_date_exp[$index] ?? null,
                        'end_date'     => $request->end_date_exp[$index] ?? null,
                        'description'  => $request->description[$index] ?? null,
                    ];

                    if (!empty($request->experience_id) && isset($request->experience_id[$index]) && !empty($request->experience_id[$index])) {
                        $experience = $this->experienceRepository->find($request->experience_id[$index]);
                        if ($experience) {
                            $experience->update($experienceData);
                            $newExperienceIds[] = $experience->id;
                        }
                    } else {
                        $newExperience = $this->experienceRepository->create($experienceData);
                        $newExperienceIds[] = $newExperience->id;
                    }
                }
            }

            // Xóa các kinh nghiệm không còn trong danh sách mới
            $this->experienceRepository->deleteByIds(array_diff($currentExperienceIds, $newExperienceIds));

            // education
            $currentEducationIds = $cv->educations->pluck('id')->toArray();
            $newEducationIds = [];

            if (!empty($request->school)) {
                foreach ($request->school as $index => $school) {
                    $educationData = [
                        'cv_id'           => $cvId,
                        'university_name' => $school ?? null,
                        'major'           => $request->major[$index] ?? null,
                        'type_graduate'   => $request->degree[$index] ?? null,
                        'start_date'      => $request->start_date_education[$index] ?? null,
                        'end_date'        => $request->end_date_education[$index] ?? null,
                    ];

                    if (!empty($request->education_id) && isset($request->education_id[$index]) && !empty($request->education_id[$index])) {
                        $education = $this->educationRepository->find($request->education_id[$index]);
                        if ($education) {
                            $education->update($educationData);
                            $newEducationIds[] = $education->id;
                        }
                    } else {
                        $newEducation = $this->educationRepository->create($educationData);
                        $newEducationIds[] = $newEducation->id;
                    }
                }
            }

            // Xóa các học vấn không còn trong danh sách mới
            $this->educationRepository->deleteByIds(array_diff($currentEducationIds, $newEducationIds));

            // referrer
            $currentReferrerIds = $cv->referrers->pluck('id')->toArray();
            $newReferrerIds = [];

            if (!empty($request->contact_name)) {
                foreach ($request->contact_name as $index => $contact) {
                    $referrerData = [
                        'cv_id'        => $cvId,
                        'name'         => $contact ?? null,
                        'company_name' => $request->contact_company_name[$index] ?? null,
                        'position'     => $request->contact_position[$index] ?? null,
                        'phone'        => $request->contact_phone[$index] ?? null,
                    ];

                    if (!empty($request->referrer_id) && isset($request->referrer_id[$index]) && !empty($request->referrer_id[$index])) {
                        $referrer = $this->referrerRepository->find($request->referrer_id[$index]);
                        if ($referrer) {
                            $referrer->update($referrerData);
                            $newReferrerIds[] = $referrer->id;
                        }
                    } else {
                        $newReferrer = $this->referrerRepository->create($referrerData);
                        $newReferrerIds[] = $newReferrer->id;
                    }
                }
            }

            // Xóa các người tham chiếu không còn trong danh sách mới
            $this->referrerRepository->deleteByIds(array_diff($currentReferrerIds, $newReferrerIds));

            // skill and certificate
            $cv->cv_skill()->updateOrCreate(['cv_id' => $cvId], ['name' => $request->skills]);
            $cv->certificates()->updateOrCreate(['cv_id' => $cvId], ['description' => $request->certifications]);

            DB::commit();
            return $cv;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }







    public function renderCV($id)
    {
        $cv = $this->cvRepository->getCv($id);
        return $cv;
    }
}
