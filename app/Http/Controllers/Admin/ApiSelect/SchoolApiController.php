<?php

namespace App\Http\Controllers\Admin\ApiSelect;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\School;
class SchoolApiController extends Controller
{

  public function index(Request $request)
  {
      $search_term = $request->input('q');
      $form = collect($request->input('form'))->pluck('value', 'name');

      if ($form->get('faculty_id') == NULL) {
        $form->put("faculty_id", NULL);
      }

      $options = School::query();

      if (!$form['faculty_id']) {
          $options = $options->where('college_id', $form['college_id']);
      }

      if ($form['faculty_id']) {
          $options = $options->where('faculty_id', $form['faculty_id']);
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
    $faculty_id = $request->input('faculty_id');

    if ($faculty_id) {
      $options = School::where('faculty_id', '=', $faculty_id)->where('name', 'like', '%'.$term.'%')->get()->pluck('name', 'id');
    }else {
      $options = School::where('name', 'like', '%'.$term.'%')->get()->pluck('name', 'id');
    }

    return $options;
  }
}
