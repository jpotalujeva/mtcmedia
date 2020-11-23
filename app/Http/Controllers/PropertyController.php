<?php

namespace App\Http\Controllers;

use App\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $properties = Property::latest()->paginate(5);

        return view('properties.index', compact('properties'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('properties.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $data = $request->post();

        $formattedAddr = str_replace(' ','+', $data['country'] . $data['town'] . $data['address'] );
        $geocodeFromAddr = file_get_contents
        ('http://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false');
        $output = json_decode($geocodeFromAddr);
        
        //Get latitude and longitute from json data
        $data['latitude'] = $output->results[0]->geometry->location->lat;
        $data['longitude'] = $output->results[0]->geometry->location->lng;
        $property = new Property;
        $property->country = $data['country'];
        $property->town = $data['town'];
        $property->price = $data['price'];
        $property->description = $data['description'];
        $property->sale_rent = $data['type'];
        $property->property_type = $data['property_type'];
        $property->address = $data['address'];
        $property->latitude = $data['latitude'];
        $property->longtitude = $data['longitude'];
        $property->number_of_bedrooms = $data['number_of_bedrooms'];
        $property->number_of_bathrooms = $data['number_of_bathrooms'];
        $property->save();
        // Property::create($request->post());

        return redirect()->route('properties.index')
            ->with('success', 'Property created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $property = Property::find($id);
         return view('properties.show', compact('property'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $property = Property::find($id);
         return view('properties.edit', compact('property'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $property = Property::find($id);
        $property->update($request->all());

        return redirect()->route('properties.index')
            ->with('success', 'Property updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $property = Property::find($id);
        $property->delete();

        return redirect()->route('properties.index')
            ->with('success', 'Property deleted successfully');
    }
}
