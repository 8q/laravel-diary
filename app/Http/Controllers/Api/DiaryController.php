<?php

namespace App\Http\Controllers\Api;

use App\Diary;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use \Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class DiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $diaries = $user->diaries()->orderBy('datetime', 'desc')->orderBy('updated_at', 'desc')->get();
        return response()->json($diaries->toArray(), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $diaryCol = [
            'user_id' => $user->id,
            'datetime' => $request->input('diary.datetime'),
            'content' => $request->input('diary.content'),
        ];
        $validator = Validator::make($diaryCol, Diary::$rules);
        if (!$validator->fails()) {
            $diary = new Diary;
            $diary->fill($diaryCol)->save();
            return response()->json($diary->toArray(), 201);
        } else {
            return response()->json(['message' => 'Bad request'], 400);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $diary = Diary::where('user_id', $user->id)->where('id', $id)->first();
        if ($diary) {
            return response()->json($diary->toArray(), 200);
        } else {
            return response()->json(['message' => 'Not found'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $diary = Diary::where('user_id', $user->id)->where('id', $id)->first();
        if ($diary) {
            $diaryCol = $request->input('diary');
            unset($diaryCol['user_id']);
            $validator = Validator::make($diaryCol, ['datetime' => 'date', 'content' => 'string']);
            if (!$validator->fails()) {
                $diary->update($diaryCol);
                return response()->json($diary->toArray(), 200);
            } else {
                return response()->json(['message' => 'Bad request'], 400);
            }
        } else {
            return response()->json(['message' => 'Not found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $diary = Diary::where('user_id', $user->id)->where('id', $id)->first();
        if ($diary) {
            $diary->delete();
            return response()->json(['message' => 'Deleted'], 200);
        } else {
            return response()->json(['message' => 'Not found'], 404);
        }
    }
}
