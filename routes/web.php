<?php

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::post('importCSV', function (Request $request) {
    $file = $request->file('file');
    $fileContents = file($file->getPathname());

    foreach ($fileContents as $line) {
        $data = str_getcsv($line);

        Course::create([
            'name' => $data[0],
            // Add more fields as needed
        ]);
    }

    return redirect()->back()->with('success', 'CSV file imported successfully.');
})->name('importCSV');

require __DIR__.'/auth.php';
