<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProjectRequest;
use App\Project;
use Illuminate\Http\Request;


class ProjectsController extends Controller
{

    public function index(){

        $projects = auth()->user()->projects;

        return view('projects.index', compact('projects'));
    }


    public function store(CreateProjectRequest $request){

        $project = auth()->user()->projects()->create($request->only('title','description','notes'));

        return redirect()->route('show.project',$project);
    }


    public function show(Project $project){

        $this->authorize('update', $project);

        return view('projects.show', compact('project'));

    }


    public function edit(Project $project){

        return view('projects.edit', compact('project'));
    }


    public function create(){
        return view('projects.create');
    }


    public function update(Project $project){

        $this->authorize('update', $project);


        $attributes = \request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'notes'  => 'max:200'
        ]);

        $project->update($attributes);

        return redirect($project->path());

    }



}
