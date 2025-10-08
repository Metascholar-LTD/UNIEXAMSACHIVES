<?php

use App\Http\Controllers\Dashboard\AcademicController;
use App\Http\Controllers\Dashboard\AdvanceCommunicationController;
 
use App\Http\Controllers\Dashboard\DepartmentController;
use App\Http\Controllers\Dashboard\DetailsController;
use App\Http\Controllers\Dashboard\ExamsController;
use App\Http\Controllers\Dashboard\FilesController;
use App\Http\Controllers\Dashboard\FoldersController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Frontend\PagesController;
use Illuminate\Support\Facades\Route;

// Landing Homepage - Clean professional landing page
Route::get('/', [PagesController::class, 'welcome'])->name('frontend.welcome');

// Admin Route for Advance Communication System Users
Route::get('/admin', [PagesController::class, 'adminLogin'])->name('admin.login');
Route::post('/admin', [PagesController::class, 'adminLoginUser'])->name('admin.login.user');
Route::post('/admin/access-request', [PagesController::class, 'adminAccessRequest'])->name('admin.access.request');

// Authentication Routes - Clean URLs
Route::get('/login', [PagesController::class, 'login'])->name('frontend.login');
Route::post('/login', [PagesController::class, 'loginUser'])->name('login');
Route::post('/register', [PagesController::class, 'register'])->name('register');

// Password Reset Routes
Route::get('/forgot-password', [PagesController::class, 'forgotPassword'])->name('password.request');
Route::post('/forgot-password', [PagesController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [PagesController::class, 'resetPassword'])->name('password.reset');
Route::post('/reset-password', [PagesController::class, 'updatePassword'])->name('password.update');

// Legacy redirect for old login-form URL
Route::get('/login-form', function() {
    return redirect('/login', 301);
});

// Additional Pages (uncommented for future use)
Route::get('/about', [PagesController::class, 'about'])->name('frontend.about');
Route::get('/news', [PagesController::class, 'news'])->name('frontend.news');
Route::get('/leadership', [PagesController::class, 'leadership'])->name('frontend.leadership');
Route::get('/faqs', [PagesController::class, 'faqs'])->name('frontend.faqs');
Route::post('/clear-session-messages', [App\Http\Controllers\NotificationController::class, 'clearSessionMessages'])->name('clear.session.messages');

# Authentication Required Routes
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

    #Folders
    Route::get('/dashboard/folders', [FoldersController::class, 'index'])->name('dashboard.folders.index');
    Route::get('/dashboard/folders/create', [FoldersController::class, 'create'])->name('dashboard.folders.create');
    Route::post('/dashboard/folders', [FoldersController::class, 'store'])->name('dashboard.folders.store');
    Route::get('/dashboard/folders/{folder}', [FoldersController::class, 'show'])->name('dashboard.folders.show');
    Route::get('/dashboard/folders/{folder}/unlock', [FoldersController::class, 'unlockForm'])->name('dashboard.folders.unlock.form');
    Route::post('/dashboard/folders/{folder}/unlock', [FoldersController::class, 'unlock'])->name('dashboard.folders.unlock');
    Route::get('/dashboard/folders/{folder}/security', [FoldersController::class, 'security'])->name('dashboard.folders.security');
    Route::post('/dashboard/folders/{folder}/security', [FoldersController::class, 'updateSecurity'])->name('dashboard.folders.security.update');
    Route::get('/dashboard/folders/{folder}/edit', [FoldersController::class, 'edit'])->name('dashboard.folders.edit');
    Route::put('/dashboard/folders/{folder}', [FoldersController::class, 'update'])->name('dashboard.folders.update');
    Route::delete('/dashboard/folders/{folder}', [FoldersController::class, 'destroy'])->name('dashboard.folders.destroy');
    Route::post('/dashboard/folders/{folder}/add-files', [FoldersController::class, 'addFiles'])->name('dashboard.folders.add-files');
    Route::delete('/dashboard/folders/{folder}/files/{file}', [FoldersController::class, 'removeFile'])->name('dashboard.folders.remove-file');

    #memos (replaces legacy broadcast message)
    Route::get('/dashboard/message',[HomeController::class, 'message'])->name('dashboard.message');
    Route::get('/dashboard/memos/unread-count', [HomeController::class, 'unreadMemoCount'])->name('dashboard.memos.unreadCount');
    Route::get('/dashboard/memos/recent', [HomeController::class, 'recentMemos'])->name('dashboard.memos.recent');
    Route::post('/dashboard/memos/mark-all-read', [HomeController::class, 'markAllMemosRead'])->name('dashboard.memos.markAllRead');
    Route::post('/dashboard/memos/{recipient}/mark-as-read', [HomeController::class, 'markSingleMemoAsRead'])->name('dashboard.memo.markAsRead');
    Route::get('/dashboard/memos/{recipient}', [HomeController::class, 'readMemo'])->name('dashboard.memo.read');
    Route::get('/dashboard/memos/{recipient}/attachment/{index}/download', [HomeController::class, 'downloadMemoAttachment'])->name('dashboard.memo.download-attachment');
    
    #memo replies
    Route::post('/dashboard/memos/{recipient}/reply', [HomeController::class, 'replyToMemo'])->name('dashboard.memo.reply');
    Route::get('/dashboard/memos/{recipient}/replies', [HomeController::class, 'viewMemoReplies'])->name('dashboard.memo.replies');
    Route::post('/dashboard/memos/replies/{reply}/mark-as-read', [HomeController::class, 'markReplyAsRead'])->name('dashboard.memo.reply.markAsRead');
    Route::get('/dashboard/memos/replies/{reply}/attachment/{index}/download', [HomeController::class, 'downloadReplyAttachment'])->name('dashboard.memo.reply.download-attachment');
    
    #notifications
    Route::get('/dashboard/notifications', [HomeController::class, 'getNotifications'])->name('dashboard.notifications');
    Route::get('/dashboard/notifications/check', [HomeController::class, 'checkNewNotifications'])->name('dashboard.notifications.check');
    Route::post('/dashboard/notifications/{id}/mark-read', [HomeController::class, 'markNotificationAsRead'])->name('dashboard.notification.markAsRead');
    Route::post('/dashboard/notifications/mark-all-read', [HomeController::class, 'markAllNotificationsAsRead'])->name('dashboard.notifications.markAllRead');
    Route::post('/dashboard/notifications/mark-all-unified', [HomeController::class, 'markAllUnifiedAsRead'])->name('dashboard.notifications.markAllUnified');

    #profile
    Route::get('/dashboard/profile',[HomeController::class, 'profile'])->name('dashboard.profile');
    
    # File Downloads
    Route::get('/download/exam/{exam}', [App\Http\Controllers\Dashboard\ExamsController::class, 'downloadExam'])->name('download.exam');
    Route::get('/download/answer-key/{exam}', [App\Http\Controllers\Dashboard\ExamsController::class, 'downloadAnswerKey'])->name('download.answer.key');
    Route::get('/download/file/{file}', [App\Http\Controllers\Dashboard\FilesController::class, 'downloadFile'])->name('download.file');
    
    # Legacy Storage URL Redirects (for old files)
    Route::get('/storage/{path}', function($path) {
        // Try to find the file in the new storage system
        $newPath = 'exams/documents/' . basename($path);
        if (file_exists(public_path($newPath))) {
            return redirect(asset($newPath));
        }
        
        // If not found, show a helpful error message
        abort(404, 'File not found. This file may have been moved to the new storage system.');
    })->where('path', '.*');

    #settings
    Route::get('/dashboard/settings',[HomeController::class, 'settings'])->name('dashboard.settings');
    Route::post('/dashboard/update-user-info',[HomeController::class,'updateUserInfo'])->name('dashboard.user.info');
    Route::post('/dashboard/update-password',[HomeController::class,'updatePassword'])->name('dashboard.password.update');

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

    #Advanced Communication System (Users Only)
    Route::prefix('admin/communication')->name('admin.communication.')->middleware('auth')->group(function () {
        Route::get('/', [AdvanceCommunicationController::class, 'index'])->name('index');
        Route::get('/create', [AdvanceCommunicationController::class, 'create'])->name('create');
        Route::post('/store', [AdvanceCommunicationController::class, 'store'])->name('store');
        Route::get('/{campaign}', [AdvanceCommunicationController::class, 'show'])->name('show');
        Route::get('/{campaign}/edit', [AdvanceCommunicationController::class, 'edit'])->name('edit');
        Route::put('/{campaign}', [AdvanceCommunicationController::class, 'update'])->name('update');
        Route::delete('/{campaign}', [AdvanceCommunicationController::class, 'destroy'])->name('destroy');
        Route::post('/{campaign}/send', [AdvanceCommunicationController::class, 'send'])->name('send');
        Route::get('/statistics/overview', [AdvanceCommunicationController::class, 'statistics'])->name('statistics');
        Route::get('/{campaign}/attachment/{index}/download', [AdvanceCommunicationController::class, 'downloadAttachment'])->name('download-attachment');
        Route::delete('/{campaign}/attachment/{index}', [AdvanceCommunicationController::class, 'removeAttachment'])->name('remove-attachment');
        Route::get('/ajax/users', [AdvanceCommunicationController::class, 'getUsersAjax'])->name('users.ajax');
        Route::get('/{campaign}/replies', [AdvanceCommunicationController::class, 'viewReplies'])->name('replies');
    });

    #Advanced Communication System (Admin Only)
    Route::prefix('admin/communication-admin')->name('admin.communication-admin.')->middleware('auth')->group(function () {
        Route::get('/', [AdvanceCommunicationController::class, 'adminIndex'])->name('index');
        Route::get('/create', [AdvanceCommunicationController::class, 'adminCreate'])->name('create');
        Route::post('/store', [AdvanceCommunicationController::class, 'adminStore'])->name('store');
        Route::get('/{campaign}', [AdvanceCommunicationController::class, 'adminShow'])->name('show');
        Route::get('/{campaign}/edit', [AdvanceCommunicationController::class, 'adminEdit'])->name('edit');
        Route::put('/{campaign}', [AdvanceCommunicationController::class, 'adminUpdate'])->name('update');
        Route::delete('/{campaign}', [AdvanceCommunicationController::class, 'adminDestroy'])->name('destroy');
        Route::post('/{campaign}/send', [AdvanceCommunicationController::class, 'adminSend'])->name('send');
        Route::get('/statistics/overview', [AdvanceCommunicationController::class, 'adminStatistics'])->name('statistics');
        Route::get('/{campaign}/attachment/{index}/download', [AdvanceCommunicationController::class, 'adminDownloadAttachment'])->name('download-attachment');
        Route::delete('/{campaign}/attachment/{index}', [AdvanceCommunicationController::class, 'adminRemoveAttachment'])->name('remove-attachment');
        Route::get('/ajax/users', [AdvanceCommunicationController::class, 'adminGetUsersAjax'])->name('users.ajax');
        Route::get('/{campaign}/replies', [AdvanceCommunicationController::class, 'adminViewReplies'])->name('replies');
    });

    #logout
    Route::get('/logout',[HomeController::class, 'logout'])->name('logout');
});
