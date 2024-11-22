<?php

namespace App\Http\Controllers\University;

use App\Http\Controllers\Controller;
use App\Http\Requests\University\UniversityRegisterRequest;
use App\Models\University;
use App\Services\Universities\UniversityService;

use Illuminate\Http\Request;
use App\Http\Requests\University\UniversityUpdateImageRequest;
use App\Http\Requests\University\UniversityUpdateProfileRequest;
use App\Models\District;
use App\Models\Province;
use App\Models\Ward;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    protected $universityService;
    public function __construct(UniversityService $universityService)
    {
        $this->universityService = $universityService;
    }

    public function register()
    {
        return view('management.pages.university.profile.register');
    }

    public function handleRegister(UniversityRegisterRequest $request)
    {
        $userId = $request['user_id'];
        try {
            $specific = $request['specific_address'];
            $ward = $request['ward'];
            $district = $request['district'];
            $province = $request['province'];

            $mapIframe = $this->getMap($specific, $ward, $district, $province);

            $university = $this->universityService->create([
                'name' => $request['name'],
                'user_id' => $userId,
                'slug' => $request['slug'],
                'abbreviation' => $request['abbreviation'],
                'website_link' => $request['website'],
                'about' => $request['intro'],
                'description' => $request['description'],
                'map' => $mapIframe,
            ]);

            DB::table('addresses')->insert([
                'specific_address' => $specific,
                'province_id' => $province,
                'district_id' => $district,
                'ward_id' => $ward,
                'university_id' => $university->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->route('university.home')
                ->with('status_success', 'Đăng ký thông tin thành công');
        } catch (Exception $e) {
            return back()->with('status_fail', 'Lỗi khi cập nhật thông tin: ' . $e->getMessage());
        }
    }

    public function show()
    {
        $user = auth()->guard('admin')->user();
        $university_id = $user->id;
        $university = $this->universityService->getUniversityById($university_id);

        $specific_address = $university->address->specific_address;
        $wardText = $university->address->ward->name;
        $districtText = $university->address->district->name;
        $provinceText = $university->address->province->name;
        $address = $specific_address . ', ' . $wardText . ', ' . $districtText . ', ' . $provinceText;
        return view('management.pages.university.profile.index', compact(['university', 'address']));
    }

    public function uploadImage(UniversityUpdateImageRequest  $request)
    {

        $image = $request->file('university_image');
        $user = auth()->guard('admin')->user();
        $universityId = $user->id;

        $image = $request->file('university_image');
        $imageUrl = $this->universityService->uploadImage($universityId, $image);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật ảnh thành công!',
            'image_url' => $imageUrl
        ]);
    }

    public function update(UniversityUpdateProfileRequest $request)
    {
        try {
            $universityId = $request['id'];

            $specific = $request['specific_address'];
            $ward = $request['ward'];
            $district = $request['district'];
            $province = $request['province'];

            $mapIframe = $this->getMap($specific, $ward, $district, $province);

            // Xử lý cập nhật
            $university = $this->universityService->update($universityId, [
                'name' => $request['name'],
                'slug' => $request['slug'],
                'abbreviation' => $request['abbreviation'],
                'website_link' => $request['website'],
                'about' => $request['intro'],
                'description' => $request['description'],
                'map' => $mapIframe,
            ]);

            DB::table('addresses')->update([
                'specific_address' => $specific,
                'province_id' => $province,
                'district_id' => $district,
                'ward_id' => $ward,
                'university_id' => $universityId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->route('university.profile')
                ->with('status_success', 'Cập nhật thông tin thành công');
        } catch (Exception $e) {
            return back()->with('status_fail', 'Lỗi khi cập nhật thông tin: ' . $e->getMessage());
        }
    }


    public function getMap($specific_address, $wardId, $districtId, $provinceId)
    {
        // Giả sử bạn có các mô hình cho các bảng này
        $wardText = Ward::find($wardId)->name ?? 'Unknown Ward';
        $districtText = District::find($districtId)->name ?? 'Unknown District';
        $provinceText = Province::find($provinceId)->name ?? 'Unknown Province';

        $address = $specific_address . ', ' . $wardText . ', ' . $districtText . ', ' . $provinceText;
        $mapUrl = 'https://www.google.com/maps?q=' . urlencode($address) . '&output=embed';
        $mapIframe = '<iframe src="' . $mapUrl . '" width="600" height="450" frameborder="0" allowfullscreen></iframe>';

        return $mapIframe;
    }
}
