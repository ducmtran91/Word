<?php

namespace App\Http\Controllers;

use App\Models\Vocabulary;
use App\Http\Requests\VocabularyPostRequest;

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

        $vocabulary = new Vocabulary();
        $vocabulary->word = $request->word;
        $vocabulary->pronounce = $request->pronounce;
        $vocabulary->image = $request->file('image')->store('words');
        $vocabulary->description = $request->description;
        $vocabulary->example = $request->example;
        $vocabulary->save();

        return response()->json([
            'success'   => true,
            'message'   => 'Record creation successful',
            'data'      => $vocabulary
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
        $request->validated();

        $vocabulary->update($request->all());
        return response()->json([
            'success'   => true,
            'message'   => 'Record Update successful',
            'data'      => $vocabulary
        ]);
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
        return response()->json([
            'success'   => true,
            'message'   => 'Record Delete successful',
            'data'      => $vocabulary
        ]);
    }
}
