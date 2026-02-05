<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Rules\FileTypeValidate;
use Exception;
use Illuminate\Http\Request;

class WhitePaperController extends Controller
{

    public function index()
    {
        $pageTitle = 'White Paper-PDF';
        $path      = getFilePath('whitePaper');
        $pdf       = $path . '/whitepaper.pdf';
        return view('admin.white_paper.index', compact('pageTitle', 'pdf'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pdf' => ['required', 'max:5120', new FileTypeValidate(['pdf'])]
        ]);

        $file         = $request->file('pdf');
        $path         = getFilePath('whitePaper');
        $filename     = 'whitepaper.pdf';

        try {
            $file->move($path, $filename);
        } catch (Exception $ex) {
            $notify[] = ['error', 'Couldn\'t upload your whitepaper'];
            return back()->withNotify($notify);
        }

        $notify[] = ['success', 'White paper stored successfully.'];
        return back()->withNotify($notify);
    }
}
