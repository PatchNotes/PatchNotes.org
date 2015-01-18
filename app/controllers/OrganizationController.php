<?php

class OrganizationController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        if(Sentry::check()) {
            return View::make('organizations/index', array(
                'orgs' => Organization::fetchByCreator(Sentry::getUser())
            ));
        }

        return View::make('organizations/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return View::make('organizations/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Redirect
     */
    public function store() {
        $org = new Organization();
        $org->name = Input::get('name');
        $org->email = Input::get('email');
        $org->slug = Str::slug(Input::get('name'));
        $org->site_url = Input::get('site_url');
        $org->description = Input::get('description');

        if($org->save()) {
            $user = Sentry::getUser();

            $org->users()->attach($user, ['creator' => true]);

            return Redirect::to('organizations/' . $org->slug);
        } else {
            return Redirect::back()->withErrors($org->errors());
        }
    }

    /**
     * @param $slug
     * @return \Illuminate\View\View
     */
    public function show($slug) {
        $org = Organization::where('slug', $slug)->first();
        if(!$org) {
            // Return 404
        }

        return View::make('organizations/show', compact('org'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id) {

        return View::make('organizations/edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

}