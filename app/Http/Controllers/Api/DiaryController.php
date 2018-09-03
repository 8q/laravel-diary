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
        $diaries = Diary::authUserDiaries()->orderByTime()->get();
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
        $diary = new Diary();
        $params = $request->json()->get('diary');
        if (!$params) {
            return response()->json(['message' => 'Bad request'], 400);
        }

        $diary->fill($params);
        $diary->user_id = Auth::user()->id;
        if (!$diary->validator()->fails()) {
            $diary->save();
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
        $diary = Diary::authUserDiaries()->find($id);
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
        $diary = Diary::authUserDiaries()->find($id);
        if (!$diary) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $params = $request->json()->get('diary');
        if (!$params) {
            return response()->json(['message' => 'Bad request'], 400);
        }

        $diary->fill($params);
        if (!$diary->validator()->fails()) {
            $diary->save();
            return response()->json($diary->toArray(), 201);
        } else {
            return response()->json(['message' => 'Bad request'], 400);
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
        $diary = Diary::authUserDiaries()->find($id);
        if ($diary) {
            $diary->delete();
            return response()->json(['message' => 'Deleted'], 200);
        } else {
            return response()->json(['message' => 'Not found'], 404);
        }
    }
}
