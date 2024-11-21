<?php

namespace App\Http\Controllers\University;
use App\Http\Controllers\Controller;
use App\Services\University\UniversityService;
use Exception;
use Illuminate\Http\Request;
/**
* 
* Display the university detail page
*
* @package App\Http\Controllers
* @author Dang Duc Chung
* @access public
* @see getDetailUniversity($id)
*/
class UniversitiesController extends Controller
{
    protected $universityService;
    public function __construct(UniversityService $universityService) {
        $this->universityService = $universityService;
    }

/**
 * Display a list of the company's hirings.
 * @author Dang Duc Chung
 * @access public
 * @param int $id The ID of the university to be displayed.
 * @return \Illuminate\View\View
 */
    public function showDetailUniversity($id){
            $data = $this->universityService->getDetail($id);
            $workshops = $this->universityService->getWorkShops($id);
            $full_address = $data['address']->specific_address  . ', ' .$data['address']->ward->name . ', ' . $data['address']->district->name . ', ' . $data['address']->province->name;
            $majors = $data['detail']->majors;
            $detail=$data['detail'];
            return view('university.detail.detailUniversity', compact('detail','full_address','majors','workshops'));   
          
    }

}
