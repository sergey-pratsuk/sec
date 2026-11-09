<?php

use App\Livewire\CheckinForm;
use App\Livewire\DispatcherDashboard;
use App\Models\CheckinPhoto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;

Route::get('/', CheckinForm::class);

Route::get('/admin', DispatcherDashboard::class);

Route::get('/photos/{photo}', function (CheckinPhoto $photo) {
    if (!Storage::disk('local')->exists($photo->file_path)) abort(404);
    return Storage::disk('local')->response($photo->file_path);
})->name('photos.show');
