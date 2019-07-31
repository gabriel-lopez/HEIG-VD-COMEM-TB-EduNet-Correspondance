<?php

namespace App\Http\Controllers;

use App\Keyword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeywordController extends Controller
{
    public function index()
    {
        $data = [
            'keywords' => Keyword::paginate(15)
        ];

        return view('keywords.index', $data);
    }

    public function show($id)
    {
        $keyword = Keyword::findorfail($id);

        $data = [
            'keyword' => $keyword,
            'students' => $keyword->students,
        ];

        return view('keywords.show', $data);
    }

    public function create()
    {
        return view('keywords.createOrUpdate');
    }

    public function store(Request $request)
    {
        $inputs = $request->all();

        $validation = Keyword::getValidation($inputs);

        if ($validation->fails())
        {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $student = Keyword::createOne($inputs);

        return redirect('/'); //TODO
    }

    public function edit($id)
    {
        $keyword = Keyword::findorfail($id);

        $data = [
            'keyword' => $keyword,
        ];

        return view('keywords.createOrUpdate', $data);
    }

    public function update(Request $request, $id)
    {
        $inputs = $request->all();

        $student = Keyword::findOrFail($id);

        $validation = Keyword::getValidation($inputs);

        if ($validation->fails())
        {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $student->fill($inputs)->save();

        return redirect()->route('keywords.index')->with('success', 'Item successfully edited!');
    }

    public function destroy($id)
    {
        $keyword = Keyword::findOrFail($id);

        // $keyword->students()->delete(); //TODO
        $keyword->delete();

        return redirect()->back()->with('success', 'Item successfully deleted!'); //TODO
    }
}
