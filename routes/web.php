<?php

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Laravel\Socialite\Facades\Socialite;
use App\Notifications\TelegramNotification;
use NotificationChannels\Telegram\TelegramUpdates;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/t_updates', function(){

        $updates = TelegramUpdates::create()->limit(2)->options([
            'timeout' => 0,
        ])->get();

        dd($updates);
    });

    Route::get('/t_redirect', function(){
        return Socialite::driver('telegram')->redirect();
    })->name('redirect-to-telegram-widget');

    Route::get('/t_callback', function (Request $request) {

        $telegramUser = Socialite::driver('telegram')->user();

        if(! $request->user()->telegram_chat_id) {
            $request->user()->update([
                'telegram_chat_id' => $telegramUser->id
            ]);
        }

        return redirect()->route('profile.show')->banner('Telegram connected successfully');

    })->name('telegram-callback');

    Route::post('/send', function(Request $request) {

        $attributes = $request->validate([
            'message' => ['required']
        ]);

        $request->user()->notify(new TelegramNotification($attributes['message']));

        return redirect()->back()->banner('Message sent successfully');
    });

});
