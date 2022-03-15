<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SampleController extends Controller
{
    public function log(Request $request)
    {
        Log::emergency('ログサンプル', ['memo' => 'sample1']);
        Log::alert('ログサンプル', ['memo' => 'sample1']);
        Log::critical('ログサンプル', ['memo' => 'sample1']);
        Log::error('ログサンプル', ['memo' => 'sample1']);
        Log::warning('ログサンプル', ['memo' => 'sample1']);
        Log::notice('ログサンプル', ['memo' => 'sample1']);
        Log::info('ログサンプル', ['memo' => 'sample1']);
        Log::debug('ログサンプル', ['memo' => 'sample1']);

        return view('sample.log');
    }
}
