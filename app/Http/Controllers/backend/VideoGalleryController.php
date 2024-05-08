<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class VideoGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = Video::latest()->get();
        return view('backend.pages.gallery.video-gallery', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|unique:videos,title',
            'embed_code' => 'required|string',
        ]);
        Video::create([
            'title' => $request->title,
            'embed_code' => $request->embed_code,
        ]);
        Toastr::success('Video added successfully!');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $video = Video::findOrFail($id);
        $request->validate([
            'title' => 'required|string|unique:videos,title,'.$video->id,
            'embed_code' => 'required|string',
        ]);
        $video->update([
            'title' => $request->title,
            'embed_code' => $request->embed_code,
        ]);
        Toastr::success('Video update successfully!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $video = Video::findOrFail($id);
        $video->delete();
        Toastr::success('Video delete successfully!');
        return back();
    }

    public function changeStatus($id)
    {
        $video = Video::findOrFail($id);
        if ($video->status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }
        $video->update([
            'status' => $status,
        ]);
        Toastr::success('Status updated!');
        return back();
    }
}