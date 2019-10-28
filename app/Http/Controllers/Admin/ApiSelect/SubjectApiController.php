<?php

namespace App\Http\Controllers\Admin\ApiSelect;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Career;
class SubjectApiController extends Controller
{

  public function index(Request $request)
  {
      $search_term = $request->input('q');
      $form = collect($request->input('form'))->pluck('value', 'name');

      $options = Subject::query();

      if (! $form['career_origin_id']) {
          return [];
      }

      if ($form['career_origin_id']) {
          $options = $options->where('career_id', $form['career_origin_id']);
      }

      if ($search_term) {
          $results = $options->where('name', 'LIKE', '%'.$search_term.'%')->paginate(50);
      } else {
          $results = $options->paginate(50);
      }

      return $options->paginate(50);
  }

}
