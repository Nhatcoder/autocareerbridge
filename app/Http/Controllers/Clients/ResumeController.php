<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Cv;
use App\Services\Cv\CvService;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use PDF;
use Mpdf\Mpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Str;

class ResumeController extends Controller
{
    protected $cvService;

    public function __construct(CvService $cvService)
    {
        $this->cvService = $cvService;
    }


    public function file()
    {
        // dd(Auth::user());
        $slug = Auth::guard('admin')->user()->cv->slug;

        $cv = Cv::query()->where('slug', $slug)->firstOrFail();

        return view('client.pages.cv.update-cv', compact('cv'));
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
        $cvs = Cv::query()->get();
        return view('client.pages.cv.my-cv', compact('cvs'));
    }

    public function edit($slug)
    {
        $slug = Auth::guard('admin')->user()->cv->slug;

        $cv = Cv::query()->where('slug', $slug)->firstOrFail();

        return view('client.pages.cv.edit.information', compact('slug', 'cv'));
    }


    /**
     * Create a new CV.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->cvService->createCv($request);
        return redirect()->route('myCv');
    }

    /**
     * Update CV information.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $this->cvService->updateCv($request, $id);
        return redirect()->route('myCv');
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
        return view('client.pages.cv.pdf.minimal', compact('cv'));
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
        $template = $cv->template;
        return view("client.pages.cv.edit", compact(['cv', 'template']));
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
