<?php

namespace App\Http\Controllers\Admin\ApiSelect;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Faculty;
class FacultyApiController extends Controller
{

  public function index(Request $request)
  {
      $search_term = $request->input('q');
      $form = collect($request->input('form'))->pluck('value', 'name');

      $options = Faculty::query();

      if (! $form['college_id']) {
          return [];
      }

      if ($form['college_id']) {
          $options = $options->where('college_id', $form['college_id']);
      }

      if ($search_term) {
          $results = $options->where('name', 'LIKE', '%'.$search_term.'%')->paginate(50);
      } else {
          $results = $options->paginate(50);
      }

      return $options->paginate(50);
  }

  public function indexFilterAjax(Request $request)
  {
    $term = $request->input('term');
    $college_id = $request->input('college_id');

    if ($college_id) {
      $options = Faculty::where('college_id', '=', $college_id)->where('name', 'like', '%'.$term.'%')->get()->pluck('name', 'id');
    }else {
      $options = Faculty::where('name', 'like', '%'.$term.'%')->get()->pluck('name', 'id');
    }
    
    return $options;
  }
}
