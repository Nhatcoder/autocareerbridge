<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Cv;
use PDF;
use Mpdf\Mpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ResumeController extends Controller
{
    public function file()
    {
        $slug = Auth::guard('admin')->user()->cv->slug;

        $cv = Cv::query()->where('slug', $slug)->firstOrFail();

        return view('client.pages.cv.update-cv', compact('cv'));
    }

    public function listCv()
    {
        return view('client.pages.cv.list');
    }

    public function edit($slug)
    {
        $slug = Auth::guard('admin')->user()->cv->slug;

        $cv = Cv::query()->where('slug', $slug)->firstOrFail();

        return view('client.pages.cv.edit.information', compact('slug', 'cv'));
    }

    public function update(Request $request, $slug)
    {
        $slug = Auth::guard('admin')->user()->cv->slug;

        $cv = Cv::query()->where('slug', $slug)->firstOrFail();

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'position' => $request->position,
            'date_birth' => $request->date_birth,
            'sex' => $request->sex,
            'url' => $request->url,
        ];

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            if (!empty($cv->avatar)) {
                $filePath = str_replace('/storage', '', $cv->avatar);
                if (Storage::exists($filePath)) {
                    Storage::delete($filePath);
                }
            }

            $data['avatar'] = $request->file('avatar')->store('cvs', 'public');
            $data['avatar'] = '/storage/' . $data['avatar'];
        }

        $cv->update($data);

        return back();
    }

    public function viewPDF(Request $request)
    {
        $cv = Auth::guard('admin')->user()->cv;
        dd($cv);

        $data = [
            'cv' => $cv->toArray(),
            'educations' => $cv->educations,
            'experiences' => $cv->experiences,
            'achievements' => $cv->achievements,
        ];

        if (isset($_POST['minimal'])) {
            $html = view('pdf.minimal', $data)->render();
        }

        if (isset($_POST['elegant'])) {
            $html = view('pdf.elegant', $data)->render();
        }

        if (isset($_POST['modern'])) {
            $html = view('pdf.modern', $data)->render();
        }

        $mpdf = new Mpdf([
            'margin_top' => 0,
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_bottom' => 0,
        ]);

        $mpdf->WriteHTML($html);

        return response($mpdf->Output('', 'S'))->header('Content-Type', 'application/pdf');
    }
}
