<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\RecruiterController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\SectionPreviewController;

// ── PUBLIC ──────────────────────────────────────────────────────────
Route::redirect('/login', '/cms/login')->name('login');
Route::redirect('/admin/login', '/cms/login')->name('admin.login');
Route::get('/',              [HomeController::class,    'index'])->name('home');
Route::get('/projects',      [ProjectController::class, 'index'])->name('projects');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/resume',        [ResumeController::class,  'index'])->name('resume');
Route::get('/career/{slug}', [CareerController::class, 'show'])->name('career.show');
Route::get('/cms/career/{slug}/preview', [CareerController::class, 'adminPreview'])
    ->middleware('auth')
    ->name('admin.career.preview');
Route::get('/cms/homepage-preview', [HomeController::class, 'index'])
    ->middleware('auth')
    ->name('admin.homepage-preview');
Route::get('/cms/resumes/{type}/preview', [CvController::class, 'adminPreview'])
    ->middleware('auth')
    ->name('admin.resume.preview');
Route::get('/cms/resumes/{type}/download', [CvController::class, 'adminDownload'])
    ->middleware('auth')
    ->name('admin.resume.download');
Route::get('/cms/recruiter-preview/site', [RecruiterController::class, 'index'])
    ->middleware('auth')
    ->name('admin.recruiter-preview.site');
Route::get('/cms/section-preview/{section}', [SectionPreviewController::class, 'show'])
    ->middleware('auth')
    ->name('admin.section-preview');

// CV Center
Route::get('/cv',                   [CvController::class, 'center'])->name('cv.center');
Route::get('/cv/{type}/preview',    [CvController::class, 'preview'])->name('cv.preview');
Route::get('/cv/{type}/download',   [CvController::class, 'download'])->name('cv.download');

// Contact (POST)
Route::post('/contact',             [ContactController::class, 'store'])->name('contact.store');

// AI Chat
Route::post('/chat',                [ChatController::class, 'chat'])->name('chat.send');

// Analytics pixel (AJAX)
Route::post('/track',               [AnalyticsController::class, 'track'])->name('analytics.track');
