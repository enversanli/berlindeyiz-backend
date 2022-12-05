<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helper\ResponseHelper;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{

    /** @var ResponseHelper */
    protected $responseHelper;

    public function __construct(ResponseHelper $responseHelper)
    {
        $this->responseHelper = $responseHelper;
    }

    public function index()
    {
        $announcements = Announcement::orderBy('created_at', 'ASC')->paginate(20);

        return view('admin.announcements.index')->with('announcements', $announcements);
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function show($id)
    {
        $announcement = Announcement::findOrFail($id);

        return view('admin.announcements.detail')->with('announcement', $announcement);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3|max:255|string',
            'text' => 'required|min:3|string'
        ]);
        try {

            $announcement = Announcement::create([
                'title' => $request->title,
                'text' => $request->text
            ]);

            return redirect()->route('announcement.create')->with('message', $this->responseHelper->success(__('response.success'), __('response.successMessage', ['param' => __('common.created')])));
        } catch (\Exception $exception) {
            return redirect()->route('announcement.create')->with('message', $this->responseHelper->error(__('response.error'), __('response.went_wrong')));
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|min:3|max:255|string',
            'text' => 'required|min:3|string'
        ]);
        $announcement = Announcement::findOrFail($id);
        try {

            $announcement->update([
                'title' => $request->title,
                'text' => $request->text,
            ]);

            return redirect()->route('announcement.show', $id)->with('message', $this->responseHelper->success(__('response.success'), __('response.successMessage', ['param' => __('common.updated')])));

        } catch (\Exception $exception) {
            return redirect()->route('announcement.show', $id)->with('message', $this->responseHelper->error(__('response.error'), __('response.went_wrong')));
        }
    }

    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        try {

            $announcement->delete();
            return redirect()->route('announcement.index')->with('message', $this->responseHelper->success(__('response.success'), __('response.successMessage', ['param' => __('common.deleted')])));

        } catch (\Exception $exception) {
            return redirect()->route('announcement.create')->with('message', $this->responseHelper->error(__('response.error'), __('response.went_wrong')));
        }

    }
}
