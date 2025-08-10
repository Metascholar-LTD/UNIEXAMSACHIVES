<?php

use App\Http\Controllers\Dashboard\AcademicController;
use App\Http\Controllers\Dashboard\BroadcastController;
use App\Http\Controllers\Dashboard\DepartmentController;
use App\Http\Controllers\Dashboard\DetailsController;
use App\Http\Controllers\Dashboard\ExamsController;
use App\Http\Controllers\Dashboard\FilesController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\AdvancedCommunicationController;
use App\Http\Controllers\Frontend\PagesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PagesController::class, 'index'])->name('frontend.home');
// Route::get('/about', [PagesController::class, 'about'])->name('frontend.about');
// Route::get('/news', [PagesController::class, 'news'])->name('frontend.news');
// Route::get('/leadership', [PagesController::class, 'leadership'])->name('frontend.leadership');
// Route::get('/faqs', [PagesController::class, 'faqs'])->name('frontend.faqs');
Route::get('/login-form',[PagesController::class, 'login'])->name('frontend.login');
Route::post('/register',[PagesController::class, 'register'])->name('register');
Route::post('/login',[PagesController::class, 'loginUser'])->name('login');

#protected routes
Route::middleware(['auth'])->group(function () {
    #Dashboard - Home
    Route::get('/dashboard/home',[HomeController::class, 'dashboard'])->name('dashboard');

    #Documents
    Route::get('/dashboard/create',[HomeController::class, 'create'])->name('dashboard.create');
    Route::get('/dashboard/file/create',[HomeController::class, 'createFile'])->name('dashboard.file.create');

    Route::get('/dashboard/exams-documents',[HomeController::class, 'document'])->name('dashboard.document');
    #All Exams Archive
    Route::get('/dashboard/upload-exams',[HomeController::class, 'uploadedDocument'])->name('dashboard.upload.document');
    Route::get('/dashboard/all-upload-exams',[HomeController::class, 'allUploadedDocument'])->name('dashboard.all.upload.document');

    #Approved Exams
    Route::get('/dashboard/approved-exams',[HomeController::class, 'approvedExams'])->name('dashboard.approve.exams');
    Route::get('/dashboard/all-approved-exams',[HomeController::class, 'allApprovedExams'])->name('dashboard.all.approve.exams');

    #pending Exams
    Route::get('/dashboard/pending-exams',[HomeController::class, 'pendingExams'])->name('dashboard.pending.exams');
    Route::get('/dashboard/all-pending-exams',[HomeController::class, 'allPendingExams'])->name('dashboard.all.pending.exams');

    #exams
    Route::post('/dashbaord/exam/store',[ExamsController::class, 'store'])->name('dashboard.exam.store');
    Route::get('/dashboard/exams/{exam}/edit', [ExamsController::class, 'edit'])->name('exams.edit');
    Route::put('/dashboard/exams/{exam}', [ExamsController::class, 'update'])->name('exams.update');

    Route::post('/dashboard/exams/{exam}/approve', [ExamsController::class, 'approve'])->name('exams.approve');
    Route::delete('/dashboard/exams/{exam}', [ExamsController::class, 'destroy'])->name('exams.destroy');
    Route::delete('/dashboard/exam/{exam}', [ExamsController::class, 'delete'])->name('exam.destroy');
    Route::get('/exams/filter', [ExamsController::class, 'filter']);
    Route::get('/exams/search', [ExamsController::class, 'search'])->name('exam.search');

    #Files
    Route::post('/dashbaord/file/store',[FilesController::class, 'store'])->name('dashboard.file.store');
    Route::get('/dashboard/upload-files',[FilesController::class, 'uploadedFile'])->name('dashboard.upload.file');
    Route::get('/dashboard/all-upload-files',[FilesController::class, 'allUploadedFile'])->name('dashboard.all.upload.file');

    Route::get('/dashboard/file/{file}/edit', [FilesController::class, 'edit'])->name('files.edit');
    Route::put('/dashboard/files/{file}', [FilesController::class, 'update'])->name('files.update');

    #Approved Files
    Route::get('/dashboard/approved-files',[FilesController::class, 'approvedFiles'])->name('dashboard.approve.files');
    Route::get('/dashboard/all-approved-files',[FilesController::class, 'allApprovedFiles'])->name('dashboard.all.approve.files');

    #pending Exams
    Route::get('/dashboard/pending-files',[FilesController::class, 'pendingFiles'])->name('dashboard.pending.files');
    Route::get('/dashboard/all-pending-files',[FilesController::class, 'allPendingFiles'])->name('dashboard.all.pending.files');

    Route::post('/dashboard/file/{file}/approve', [FilesController::class, 'approve'])->name('file.approve');
    Route::delete('/dashboard/file/{file}', [FilesController::class, 'destroy'])->name('file.destroy');

    #broadcast message
    Route::get('/dashboard/message',[HomeController::class, 'message'])->name('dashboard.message');
    Route::get('/dashboard/create-message',[HomeController::class, 'createMessage'])->name('dashboard.message.create');
    Route::post('/dashboard/broadcast-message/send',[BroadcastController::class,'send'])->name('dashboard.message.send');
    Route::get('/dashboard/broadcast/messages/{id}',[BroadcastController::class,'read'])->name('dashboard.message.read');

    #profile
    Route::get('/dashboard/profile',[HomeController::class, 'profile'])->name('dashboard.profile');

    #settings
    Route::get('/dashboard/settings',[HomeController::class, 'settings'])->name('dashboard.settings');
    Route::post('/dashboard/update-user-info',[HomeController::class,'updateUserInfo'])->name('dashboard.user.info');

    #users
    Route::get('/dashboard/users',[HomeController::class, 'users'])->name('dashboard.users');
    Route::post('/dashboard/users/{user}/approve', [HomeController::class, 'approve'])->name('users.approve');
    Route::post('/dashboard/users/{user}/disapprove', [HomeController::class, 'disapprove'])->name('users.disapprove');
    Route::delete('/dashboard/users/{user}', [HomeController::class, 'destroy'])->name('users.destroy');

    #systems detail
    Route::post('/dashboard/system-details/store', [DetailsController::class, 'store'])->name('dashboard.details.store');

    #department
    Route::resource('departments', DepartmentController::class);

    #Academic Year
    Route::post('/dashboard/academic-year/store', [AcademicController::class, 'store'])->name('dashboard.academic.store');

    #logout
    Route::get('/logout',[HomeController::class, 'logout'])->name('logout');

    # Advanced Communication System (super-admin only UI; reuse is_admin for now)
    Route::middleware([])->group(function () {
        Route::get('/dashboard/comms', [AdvancedCommunicationController::class, 'index'])->name('comms.index');
        Route::get('/dashboard/comms/compose', [AdvancedCommunicationController::class, 'create'])->name('comms.create');
        Route::post('/dashboard/comms', [AdvancedCommunicationController::class, 'store'])->name('comms.store');
        Route::get('/dashboard/comms/{communication}', [AdvancedCommunicationController::class, 'show'])->name('comms.show');
        Route::get('/dashboard/comms/users/search', [AdvancedCommunicationController::class, 'searchUsers'])->name('comms.users.search');
    });
});
