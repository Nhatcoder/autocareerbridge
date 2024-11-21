<?php
namespace App\Repositories\Hiring;

use Illuminate\Http\Request;
interface HiringRepositoryInterface
{
    public function getAllHirings($companyId);
    public function createHiring($request ,$companyId);
    public function editHiring($userId);
    public function updateHiring($request, $userId);
    public function deleteHiring($id);
    public function findHiring($request, $companyId);
}
