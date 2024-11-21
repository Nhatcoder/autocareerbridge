<?php

namespace App\Repositories\Company;

use App\Repositories\Base\BaseRepositoryInterface;

interface CompanyRepositoryInterface extends BaseRepositoryInterface
{
    public function findUniversity($request);

    public function index();

    public function getModel();

    //get info company
    public function findByUserIdAndSlug($userId);

    //get info company to edit
    public function findBySlug($slug, $userId);

    //get province
    public function getProvinces();

    //get districts of province
    public function getDistricts($provinceId);

    //get wards of districts
    public function getWards($districtId);

    //update avatar
    public function updateAvatar($identifier, $avatar);

    //create a business to add a photo for the first account update
    public function create($data = []);

    //update profile
    public function updateProfile($identifier, $data);

    //getAll
    public function getAll();

    //get company detail
    public function getCompanyBySlug($slug);

}
