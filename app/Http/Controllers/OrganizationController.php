<?php namespace PatchNotes\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use PatchNotes\Models\Organization;

class OrganizationController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $organizations = Organization::all();

        if(Auth::check()) {
            return view('organizations/index', array(
                'orgs' => Organization::fetchByCreator(Auth::getUser()),
                'organizations' => $organizations
            ));
        }
        return view('organizations/index', compact('organizations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view('organizations/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Redirect
     */
    public function store(Request $request) {
        $org = new Organization();
        $org->name = $request->get('name');
        $org->email = $request->get('email');
        $org->slug = str_slug($request->get('name'));
        $org->site_url = $request->get('site_url');
        $org->description = $request->get('description');

        if($org->save()) {
            $user = Auth::getUser();

            $org->users()->attach($user, ['creator' => true]);

            return redirect('organizations/' . $org->slug);
        } else {
            return redirect()->back()->withErrors($org->errors());
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
            abort(404);
        }

        return view('organizations/show', compact('org'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id) {

        return view('organizations/edit');
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