<?php

use App\Note;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/login', function (Request $request) {
    if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {
        return response(['success' => true], 200);
    } else {
        return
            response([
                'success' => false,
                'message' => 'Auth failed'
            ], 501);
    }
});

Route::get('/logout', function (Request $request) {
    Auth::logout();
    return response(['success' => true], 200);
});

Route::post('/updateNote', function (Request $request) {
    $note = Note::find($request->id);
    $note->markdown = $request->markdownText;
    $note->save();
    return response(['success' => true], 200);
});

Route::post('/saveNote', function (Request $request) {
    $note = new Note();
    $note->markdown = $request->markdownText;
    $note->save();
    return response(['success' => true], 200);
});

Route::get('/getNotes', function (Request $request) {
    return Note::orderBy('updated_at','DESC')->get();
});
