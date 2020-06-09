<?php

namespace App\Http\Controllers;

use App\Device;
use App\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index(){
    
    }
    
    public function create(){
    
    }
    
    public function show(Location $location){
        $device = $location->device;
        $breadcrumbs = [
            ['link'=>"/",'name'=>"首页"],['link'=>route('device.index'),'name'=>"设备列表"], ['link'=>route('device.show', $device->id),'name'=>$device->phone], ['name'=>$location->created_at->diffForHumans() . '的位置']
        ];
        return view('location.show', compact('location', 'device', 'breadcrumbs'));
    }
    
    public function store(Request $request){
        $this->validate($request, [
            'device' => 'required',
            'longitude' => 'required',
            'latitude' => 'required'
        ]);
        
        $device = Device::find($request['device']);
        
        $device->locations()->create([
            'longitude' => $request['longitude'],
            'latitude' => $request['latitude']
        ]);
    
        session()->flash('success', '新增位置成功');
    
        return redirect()->back();
    }
    
    public function edit(Location $location){
    
    }
    
    public function update(Location $location){
    
    }
    
    public function destroy(Location $location){
        $location->delete();
        session()->flash('success', '删除位置成功');
        return redirect()->back();
    }
}
