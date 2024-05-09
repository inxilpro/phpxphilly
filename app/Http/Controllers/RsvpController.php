<?php

namespace App\Http\Controllers;

use App\Http\Requests\RsvpRequest;
use App\Models\Rsvp;

class RsvpController extends Controller
{
	public function index()
	{
		return Rsvp::all();
	}
	
	public function store(RsvpRequest $request)
	{
		return Rsvp::create($request->validated());
	}
	
	public function show(Rsvp $rsvp)
	{
		return $rsvp;
	}
	
	public function update(RsvpRequest $request, Rsvp $rsvp)
	{
		$rsvp->update($request->validated());
		
		return $rsvp;
	}
	
	public function destroy(Rsvp $rsvp)
	{
		$rsvp->delete();
		
		return response()->json();
	}
}
