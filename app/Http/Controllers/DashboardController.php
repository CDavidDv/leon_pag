<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\WorkContent;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Muestra la página de inicio para usuarios no autenticados
     *
     * @return \Inertia\Response
     */
    public function index(): Response
    {
        $sections = ['logo', 'welcome', 'hero', 'project_1', 'project_2', 'project_3', 'project_4', 'project_5', 'project_6', 'project_7', 'project_8', 'project_9'];
        $content = [];
        $media = [];

        foreach ($sections as $section) {
            $content[$section] = WorkContent::getSectionContent($section);
            $media[$section] = Media::where('section', $section)->get();
        }
        return Inertia::render('Welcome/index', [
            'workContent' => $content,
            'media' => $media
        ]);
    }

    public function edit(): Response
    {
        $sections = ['logo', 'welcome', 'hero', 'project_1', 'project_2', 'project_3', 'project_4', 'project_5', 'project_6', 'project_7', 'project_8', 'project_9'];
        $content = [];
        $media = [];

        foreach ($sections as $section) {
            $content[$section] = WorkContent::getSectionContent($section);
            $media[$section] = Media::where('section', $section)->get();
        }

        return Inertia::render('Welcome/edit', [
            'workContent' => $content,
            'media' => $media
        ]);
    }

    /**
     * Muestra el dashboard para usuarios autenticados
     *
     * @return \Inertia\Response
     */
    public function dashboard(): Response
    {
        $sections = ['logo', 'welcome', 'hero', 'project_1', 'project_2', 'project_3', 'project_4', 'project_5', 'project_6', 'project_7', 'project_8', 'project_9'];
        $content = [];
        $media = [];

        foreach ($sections as $section) {
            $content[$section] = WorkContent::getSectionContent($section);
            $media[$section] = Media::where('section', $section)->get();
        }
        return Inertia::render('Dashboard/index', [
            'workContent' => $content,
            'media' => $media
        ]);
    }

    public function dashboardEdit(): Response
    {
        $sections = ['logo', 'hero', 'project_1', 'project_2', 'project_3', 'project_4', 'project_5', 'project_6', 'project_7', 'project_8', 'project_9'];
        $content = [];
        $media = [];

        foreach ($sections as $section) {
            $content[$section] = WorkContent::getSectionContent($section);
            $media[$section] = Media::where('section', $section)->get();
        }
        return Inertia::render('Dashboard/edit', [
            'workContent' => $content,
            'media' => $media
        ]);
    }   

    public function work(): Response
    {
        $sections = ['logo', 'welcome', 'hero', 'project_1', 'project_2', 'project_3', 'project_4', 'project_5', 'project_6', 'project_7', 'project_8', 'project_9'];
        $content = [];
        $media = [];

        foreach ($sections as $section) {
            $content[$section] = WorkContent::getSectionContent($section);
            $media[$section] = Media::where('section', $section)->get();
        }
        return Inertia::render('Work/index', [
            'workContent' => $content,
            'media' => $media
        ]);
    }

    public function workEdit(): Response
    {
        // Cargar todo el contenido de Work desde la base de datos
        $sections = ['logo', 'hero', 'project_1', 'project_2', 'project_3', 'project_4', 'project_5', 'project_6', 'project_7', 'project_8', 'project_9'];
        $content = [];
        $media = [];

        foreach ($sections as $section) {
            $content[$section] = WorkContent::getSectionContent($section);
            $media[$section] = Media::where('section', $section)->get();
        }

        return Inertia::render('Work/edit', [
            'workContent' => $content,
            'media' => $media
        ]);
    }

    public function approach(): Response
    {
        $sections = ['logo', 'welcome', 'approach', 'services', 'service_1', 'service_2', 'service_3'];
        $content = [];
        $media = [];

        foreach ($sections as $section) {
            $content[$section] = WorkContent::getSectionContent($section);
            $media[$section] = Media::where('section', $section)->get();
        }
        return Inertia::render('Approach/index', [
            'workContent' => $content,
            'media' => $media
        ]);
    }

    public function approachEdit(): Response
    {
        $sections = ['welcome', 'approach', 'services', 'service_1', 'service_2', 'service_3'];
        $content = [];
        $media = [];

        foreach ($sections as $section) {
            $content[$section] = WorkContent::getSectionContent($section);
            $media[$section] = Media::where('section', $section)->get();
        }

        return Inertia::render('Approach/edit', [
            'workContent' => $content,
            'media' => $media
        ]);
    }

    public function about(): Response
    {
        $sections = ['logo', 'welcome', 'about', 'team', 'contact'];
        $content = [];
        $media = [];

        foreach ($sections as $section) {
            $content[$section] = WorkContent::getSectionContent($section);
            $media[$section] = Media::where('section', $section)->get();
        }
        return Inertia::render('About/index', [
            'workContent' => $content,
            'media' => $media
        ]);
    }

    public function aboutEdit(): Response
    {
        $sections = ['welcome', 'about', 'team', 'contact'];
        $content = [];
        $media = [];

        foreach ($sections as $section) {
            $content[$section] = WorkContent::getSectionContent($section);
            $media[$section] = Media::where('section', $section)->get();
        }

        return Inertia::render('About/edit', [
            'workContent' => $content,
            'media' => $media
        ]);
    }

    public function uploadVideo(Request $request)
    {
        $request->validate([
            'video' => 'required|file|mimes:mp4,webm,ogg,avi,mov,wmv|max:100000',
        ]);

        $video = $request->file('video');
        //crear la carpeta si no existe
        if (!Storage::disk('public')->exists('videos')) {
            Storage::disk('public')->makeDirectory('videos');
        }
        $video->storeAs('public/videos', $video->getClientOriginalName());

        return response()->json(['success' => true]);
    }   
} 