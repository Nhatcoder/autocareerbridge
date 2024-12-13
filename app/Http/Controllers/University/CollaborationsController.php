<?php

namespace App\Http\Controllers\university;

use App\Http\Controllers\Controller;
use App\Http\Requests\CollabRequest;
use App\Services\Collaboration\CollaborationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * CollaborationsController handles collaboration management,
 * @author Ngyuyen Manh Hung
 * @access public
 * @package Collaboration
 * @see index()
 */
class CollaborationsController extends Controller
{
    protected $collaborationService;

    public function __construct(CollaborationService $collaborationService)
    {
        $this->collaborationService = $collaborationService;
    }

    public function index(Request $request)
    {
        $activeTab = $request->input('active_tab', 'accept');
        $page = $request->input('page', 1);
        $search = $request->input('search');

        if ($search) {
            $data = $this->collaborationService->searchAllCollaborations($search, $page);

            if ($request->ajax()) {
                return view('management.pages.university.collaboration.table', [
                    ...$data,
                    'isSearchResult' => true
                ]);
            }

            return view('management.pages.university.collaboration.index', [
                'data' => $data['data'],
                'accepted' => collect(),
                'pendingRequests' => collect(),
                'rejected' => collect(),
                'completed' => collect(),
                'activeTab' => 'search',
                'isSearchResult' => true
            ]);
        }

        $data = $this->collaborationService->getIndexService($activeTab, $page);
        if ($request->ajax()) {
            return view('management.pages.university.collaboration.table', ['data' => $data['data'], 'status' => $data['status']]);
        }

        return view('management.pages.university.collaboration.index', [
            'pendingRequests' => $data['pending'],
            'accepted' => $data['accepted'],
            'completed' => $data['completed'],
            'rejected' => $data['rejected'],
            'activeTab' => $activeTab,
            'data' => $data['data'],
        ]);
    }

    public function createRequest(CollabRequest $request)
    {
        $data = $request->only(['university_id', 'title', 'content']);

        $this->collaborationService->sendCollaborationEmail($data);
        return response()->json(['message' => 'Request sent successfully'], 201);
    }

    public function changeStatus(Request $request)
    {
        try {
            $data = $this->collaborationService->changeStatus($request->all());
            if(isset($data)) {
                return back()->with('status_success', __('message.university.collaboration.change_status_success'));
            }else{
                return back()->with('status_fail', __('message.university.collaboration.change_status_fail'));
            }
        } catch (\Exception $e) {
            return back()->with('status_fail', $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $data = $this->collaborationService->findById($id);
            if (!$data) {
                return back()->with('status_fail', __('message.university.collaboration.not_found'));
            }
            if ($data->created_by != auth('admin')->user()->role) {
                return back()->with('status_fail', __('message.university.collaboration.not_permission'));
            }
            $data->delete();
            return back()->with('status_success', __('message.university.collaboration.revoke_success'));
        } catch (\Exception $e) {
            return back()->with('status_fail', $e->getMessage());
        }
    }
}
