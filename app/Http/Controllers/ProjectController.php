<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Employee;
use App\Models\ProjectAssignment;

class ProjectController extends Controller
{
    public function index() {

        $projects = Project::all();

        return view('pages.admin.project.index')
            ->with([
                'projects' => $projects
            ]);
    }

    public function add() {

        $employees = Employee::all();

        return view('pages.admin.project.add')
            ->with([
                'employees' => $employees
            ]);

    }

    public function save(Request $request) {

        $project = Project::create($request->all());

        foreach($request->emp as $emp) {
            ProjectAssignment::create([
                'employee_id' => $emp,
                'project_id' => $project->id 
            ]);
        }

        return redirect()->route('projects.index')->with('success','Project details has been added!');
    }

    public function view($id) {

        $project = Project::find($id);
        $employees = Employee::all();

        return view('pages.admin.project.view')
            ->with([
                'project' => $project,
                'employees' => $employees
            ]);
    }

    public function update($id,Request $request) {

        Project::where('id',$id)->update($request->all());
        
        ProjectAssignment::where('project_id',$id)->delete();

        foreach($request->emp as $emp) {
            ProjectAssignment::create([
                'employee_id' => $emp,
                'project_id' => $id 
            ]);
        }

        return redirect()->back()-with('success','Project has been updated!');
    }
}
