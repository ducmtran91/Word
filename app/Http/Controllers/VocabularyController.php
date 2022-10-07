<?php

namespace App\Http\Controllers;

use App\Models\Vocabulary;
use Illuminate\Http\Request;
use App\Http\Requests\VocabularyPostRequest;
use Illuminate\Support\Facades\Storage;

class VocabularyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vocabularies = Vocabulary::where('word', '!=', "")->paginate(
            $perPage = 15, $columns = ['*'], $pageName = 'vocabularies'
        );
        return response()->json($vocabularies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\VocabularyPostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VocabularyPostRequest $request)
    {
        $request->validated();

        $vocabulary = new Vocabulary;
        $vocabulary->word = $request->word;
        $vocabulary->pronounce = $request->pronounce;
        $vocabulary->image = $request->file('image')->store('words');
        $vocabulary->description = $request->description;
        $vocabulary->example = $request->example;
        $vocabulary->save();

        return response()->json([
            'success'   => true,
            'message'   => 'Record creation successful',
            'data'      => ['image' => Storage::url($vocabulary->image)]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vocabulary  $vocabulary
     * @return \Illuminate\Http\Response
     */
    public function show(Vocabulary $vocabulary)
    {
        return $vocabulary;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\VocabularyPostRequest  $request
     * @param  \App\Models\Vocabulary  $vocabulary
     * @return \Illuminate\Http\Response
     */
    public function update(VocabularyPostRequest $request, Vocabulary $vocabulary)
    {
        // Retrieve a portion of the validated input data...
        // $validated = $request->safe()->only(['name', 'email']);
        // $validated = $request->safe()->except(['name', 'email']);
        var_dump($request->file('image'));
        echo 11111;
        if ($request->file('image')) {
            $request->validated();
        } else {
            $request->safe()->except(['image']);
        }
        //return $vocabulary->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vocabulary  $vocabulary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vocabulary $vocabulary)
    {
        $vocabulary->delete();
    }
}
