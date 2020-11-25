<?php

namespace App\Http\Controllers;

use App\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param int $page optional
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index(int $page = 1)
    {
        $client = new \GuzzleHttp\Client();
        $client->setDefaultOption('verify', false);
        $response = $client->get(env('MTC_API_URL') . "properties?api_key=" . env('MTC_API_KEY'));

        if($response->getStatusCode() !== 200){
            throw new \Exception('Api request error');
        }

        $properties = $response->getBody();

        return view('properties.index', compact('properties'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('properties.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->post();
        $client = new \GuzzleHttp\Client();

        $formattedAddr = str_replace(' ','+', $data['country'] . $data['town'] . $data['address'] );
        $geocodeFromAddr = file_get_contents
        ('http://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false&key='.env('GOOGLE_API_KEY'));
        $output = json_decode($geocodeFromAddr);

        //Get latitude and longitute from json data
        $data['latitude'] = $output->results[0]->geometry->location->lat;
        $data['longitude'] = $output->results[0]->geometry->location->lng;

        $client->setDefaultOption('verify', false);
        $options['body'] = [json_encode($data)];
        $response = $client->post(env('MTC_API_URL') . "property?api_key=" . env('MTC_API_KEY'), $options);
        if ($response->getStatusCode() !== 201) {
            return redirect()->route('properties.index')
                ->with('error', 'Property creation error.');
        }

        return redirect()->route('properties.index')
            ->with('success', 'Property created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function show($uuid)
    {
        $client = new \GuzzleHttp\Client();
        $client->setDefaultOption('verify', false);
        $response = $client->get(env('MTC_API_URL') . "property/". $uuid ."?api_key=" . env('MTC_API_KEY'));

        if($response->getStatusCode() !== 200){
            throw new \Exception('Api request error');
        }

        $property = $response->getBody();
         return view('properties.show', compact('property'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function edit($uuid)
    {
        $client = new \GuzzleHttp\Client();
        $client->setDefaultOption('verify', false);
        $response = $client->get(env('MTC_API_URL') . "property/". $uuid ."?api_key=" . env('MTC_API_KEY'));

        if($response->getStatusCode() !== 200){
            throw new \Exception('Api request error');
        }

        $property = $response->getBody();
         return view('properties.edit', compact('property'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function update($uuid, $request)
    {
        $client = new \GuzzleHttp\Client();
        $client->setDefaultOption('verify', false);
        $options['body'] = [json_encode($request->post())];
        $response = $client->put(env('MTC_API_URL') . "property/". $uuid ."?api_key=" . env('MTC_API_KEY'), $options);

        if($response->getStatusCode() !== 200){
            throw new \Exception('Api request error');
        }

        return redirect()->route('properties.index')
            ->with('success', 'Property updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($uuid)
    {
        $client = new \GuzzleHttp\Client();
        $client->setDefaultOption('verify', false);
        $response = $client->delete(env('MTC_API_URL') . "property/". $uuid ."?api_key=" . env('MTC_API_KEY'));

        if($response->getStatusCode() !== 200){
            throw new \Exception('Api request error');
        }

        return redirect()->route('properties.index')
            ->with('success', 'Property deleted successfully');
    }
}
