<?php

namespace App\Http\Controllers\front;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;


use Helper;

class DocumentsController extends Controller {
	public function index() {
		return view('documents.index');
	}
}