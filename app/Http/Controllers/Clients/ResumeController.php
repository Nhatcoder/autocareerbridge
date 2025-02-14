<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cv\CvRequest;
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
            $cvs = $this->cvService->getMyCV();

            if (!$cvs) {
                return redirect()->back()->with('error', 'Bạn chưa có CV nào.');
            }

            return view('client.pages.cv.my-cv', compact('cvs'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
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
            Log::error('Lỗi khi tạo CV: ' . $e->getMessage());
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
            Log::error('Lỗi cập nhật CV: ' . $e->getMessage());
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
            return view("client.pages.cv.pdf.{$cv->template}", compact('cv'));
        } catch (\Exception $e) {
            Log::error('Lỗi không tìm thấy CV: ' . $e->getMessage());
        }
    }


    /**
     * Display the CV creation page using a template.
     *
     * @param string $template
     * @return \Illuminate\Contracts\View\View
     */
    public function createCV($template)
    {
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
            Log::error('Lỗi không tìm thấy CV: ' . $e->getMessage());
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
}
