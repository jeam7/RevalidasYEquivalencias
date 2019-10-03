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

  // public function indexFacultyCareerOrigin(Request $request)
  // {
  //     $search_term = $request->input('q');
  //     $form = collect($request->input('form'))->pluck('value', 'name');
  //
  //     $options = Career::query();
  //
  //     if (! $form['college_id']) {
  //         return [];
  //     }
  //
  //     if ($form['college_id']) {
  //         $options = $options->join('schools as s', 's.id', '=', 'careers.school_id')
  //                             ->where('college_id', $form['college_id']);
  //         $options = $options->select('careers.*');
  //     }
  //
  //     if ($search_term) {
  //         $results = $options->where('careers.name', 'LIKE', '%'.$search_term.'%')->paginate(50);
  //     } else {
  //         $results = $options->paginate(50);
  //     }
  //     return $options->paginate(50);
  // }

  // public function indexFacultyCareerDestination(Request $request)
  // {
  //     $search_term = $request->input('q');
  //     $form = collect($request->input('form'))->pluck('value', 'name');
  //
  //     $options = Career::query();
  //
  //     if (! $form['college_destination_id']) {
  //         return [];
  //     }
  //
  //     if ($form['college_destination_id']) {
  //         $options = $options->join('schools as s', 's.id', '=', 'careers.school_id')
  //                             ->where('college_id', $form['college_destination_id']);
  //         $options = $options->select('careers.*');
  //     }
  //
  //     if ($search_term) {
  //         $results = $options->where('careers.name', 'LIKE', '%'.$search_term.'%')->paginate(50);
  //     } else {
  //         $results = $options->paginate(50);
  //     }
  //     return $options->paginate(50);
  // }
  //
  //
  //
  // public function indexFilterAjax(Request $request)
  // {
  //   $term = $request->input('term');
  //   $school_id = $request->input('school_id');
  //
  //   if ($school_id) {
  //     $options = Career::where('school_id', '=', $school_id)->where('name', 'like', '%'.$term.'%')->get()->pluck('name', 'id');
  //   }else {
  //     $options = Career::where('name', 'like', '%'.$term.'%')->get()->pluck('name', 'id');
  //   }
  //
  //   return $options;
  // }
}
