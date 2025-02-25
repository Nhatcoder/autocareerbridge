<?php

namespace App\Http\Controllers\Clients;

use App\Helpers\StorageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cv\CvRequest;
use App\Http\Requests\Cv\UploadCv;
use App\Models\Cv;
use App\Services\Cv\CvService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Spatie\Browsershot\Browsershot;

class ResumeController extends Controller
{
    protected $cvService;

    public function __construct(CvService $cvService)
    {
        $this->cvService = $cvService;
    }

    /**
     * Display the CV list template.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function listCv()
    {
        return view('client.pages.cv.list');
    }


    /**
     * Display the user's CV list.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function myCv()
    {
        try {
            $cv_creates = $this->cvService->getMyCV(TYPE_CV_CREATE);
            $cv_uploads = $this->cvService->getMyCV(TYPE_CV_UPLOAD);

            if (!$cv_creates && !$cv_uploads) {

                return redirect()->back()->with('error', 'Bạn chưa có CV nào.');
            }

            return view('client.pages.cv.my-cv', compact('cv_creates', 'cv_uploads'));
        } catch (\Exception $e) {
            $this->logExceptionDetails($e);
        }
    }

    /**
     * Create a new CV.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CvRequest $request)
    {
        try {

            $this->cvService->createCv($request);

            return response()->json([
                'type' => 'success',
                'message' => 'Tạo CV thành công!',
                'redirect' => route('myCv'),
            ]);
        } catch (\Exception $e) {
            $this->logExceptionDetails($e);
        }
    }



    /**
     * Update CV information.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CvRequest $request, $id)
    {
        try {
            $this->cvService->updateCv($request, $id);

            return response()->json([
                'redirect' => route('myCv'),
                'type' => 'success',
                'message' => 'Cập nhật CV thành công!'
            ]);
        } catch (\Exception $e) {
            $this->logExceptionDetails($e);
        }
    }


    /**
     * Download the CV as a PDF file.
     *
     * @param int $id
     * @return Illuminate\Support\Facades\Response
     */
    public function download($id)
    {
        $cv = $this->cvService->renderCV($id);

        if (!empty($cv->avatar)) {
            $path = public_path($cv->avatar);
            if (file_exists($path)) {
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $cv->avatar = 'data:image/' . $type . ';base64,' . base64_encode($data);
            }
        } else {
            $path = public_path('clients/images/content/base.png');
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $cv->avatar = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }

        $pdf = View::make("client.pages.cv.pdf.{$cv->template}", compact('cv'))->render();


        $fileName = $cv->title . '.pdf';
        $pdfPath = public_path("clients/{$fileName}");

        Browsershot::html($pdf)
            ->margins(10, 10, 10, 10)
            ->showBackground()
            ->noSandbox()
            ->savePdf($pdfPath);

        return Response::download($pdfPath);
    }


    /**
     * Preview the CV.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function view($id)
    {
        $cv = $this->cvService->renderCV($id);
        try {
            if (!$cv) {
                abort(404);
            }
            return view("client.pages.cv.view.{$cv->template}", compact('cv'));
        } catch (\Exception $e) {
            $this->logExceptionDetails($e);
        }
    }


    /**
     * Display the CV creation page using a template.
     *
     * @param string $template
     * @return \Illuminate\Contracts\View\View
     */
    public function createCV(Request $request)
    {
        $template = $request->query('type');

        $validTemplates = ['minimal', 'modern'];

        if (!in_array($template, $validTemplates)) {
            abort(404);
        }

        return view('client.pages.cv.template', compact('template'));
    }

    /**
     * Edit a CV.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function editCV($id)
    {
        $cv = $this->cvService->renderCV($id);
        try {
            if (!$cv) {
                abort(404);
            }
            $template = $cv->template;

            return view("client.pages.cv.edit", compact(['cv', 'template']));
        } catch (\Exception $e) {
            $this->logExceptionDetails($e);
        }
    }




    /**
     * Retrieve CV data as JSON.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCVData($id)
    {
        $cv = $this->cvService->renderCV($id);
        return response()->json([
            'cv' => $cv,
            'template' => $cv->template,
        ]);
    }

    /**
     * Delete a CV by its ID.
     *
     * @param int $id The ID of the CV to delete.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteCv($id)
    {
        try {
            $this->cvService->deleteCv($id);
            return redirect()->route('myCv')->with('status_success', 'Xóa CV thành công!');
        } catch (\Exception $e) {
            $this->logExceptionDetails($e);
        }
    }


    /**
     * Change the template of a CV.
     * @param \Illuminate\Http\Request $request The request containing CV template data.
     * @param int $id The ID of the CV to update.
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeCvTemplate(Request $request, $id)
    {
        try {
            $this->cvService->updateCv($request, $id);

            return response()->json([
                'type' => 'success',
                'message' => 'Đổi CV thành công!'
            ]);
        } catch (\Exception $e) {
            $this->logExceptionDetails($e);
        }
    }


    /**
     * Display the CV upload page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function uploadCv()
    {
        return view('client.pages.cv.upload');
    }


    /**
     * Store the uploaded CV.
     * @param UploadCv $request The request object containing the uploaded CV.
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadStoreCv(UploadCv $request)
    {
        $result = $this->cvService->upload($request);

        if ($result['success']) {
            return response()->json([
                'redirect' => route('myCv'),
                'success'  => true,
                'message'  => 'Upload thành công',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'] ?? 'Lỗi không xác định!',
        ]);
    }

    /**
     * Display the uploaded CV.
     *
     * @param int $id The ID of the CV to display.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function uploadCvView($id)
    {
        $cv = $this->cvService->getCvUpload($id);

        if (!$cv) {
            abort(404, 'CV không tồn tại!');
        }

        $filePath = StorageHelper::getStoragePath($cv->upload);

        if (!file_exists($filePath)) {
            abort(404, 'File không tồn tại!');
        }

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
        ]);
    }


    /**
     * Download the uploaded CV.
     *
     * @param int $id The ID of the CV to download.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadUploadedCv($id)
    {
        $cv = $this->cvService->getCvUpload($id);

        if (!$cv) {
            abort(404);
        }

        $filePath = StorageHelper::getStoragePath($cv->upload);

        if (!file_exists($filePath)) {
            abort(404);
        }

        return response()->download($filePath, $cv->title . '.pdf');
    }


    /**
     * Update the title of a CV upload.
     *
     * @param \Illuminate\Http\Request $request The request object containing the new title.
     * @param int $id The ID of the CV to update.
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateTitleCv(Request $request, $id)
    {
        try {
            $result = $this->cvService->updateTitleCv($request, $id);
            if ($result['success']) {
                return response()->json([
                    'redirect' => route('myCv'),
                    'type' => 'success',
                    'message' => 'Cập nhật CV thành công!'
                ]);
            }
        } catch (\Exception $e) {
            $this->logExceptionDetails($e);
        }
    }
}
