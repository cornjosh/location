<?php

namespace App\Http\Controllers;

use App\Device;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{
    public function index(){
        $devices = Auth::user()->devices;
        $breadcrumbs = [
            ['link'=>"/",'name'=>"首页"], ['name'=>"设备列表"]
        ];
        return view('device.index', compact('devices', 'breadcrumbs'));
    }

    public function create(){

    }

    public function show(Device $device){
        $locations = $device->locations;
        $breadcrumbs = [
            ['link'=>"/",'name'=>"首页"],['link'=>route('device.index'),'name'=>"设备列表"], ['name'=>$device->phone]
        ];
        return view('device.show', compact('locations', 'device', 'breadcrumbs'));
    }

    public function store(Request $request){
      $this->validate($request, [
        'phone' => 'required',
        'name' => 'required',
        'mark' => 'required'
      ]);

      Auth::user()->devices()->create([
        'phone' => $request['phone'],
        'name' => $request['name'],
        'mark' => $request['mark']
      ]);

      session()->flash('success', '新增设备成功');

      return redirect()->back();
    }

    public function edit(Device $device){

    }

    public function update(Device $device){

    }

    public function destroy(Device $device){
        $device->delete();
        session()->flash('success', '删除设备成功');
        return redirect()->back();
    }
    
    public function search(Device $device, $start = null, $end = null){
        $startTime = $start ? Carbon::parse($start) : null;
        $endTime = $end ? Carbon::parse($end) : null;
        
        if ($start != null && $end != null){
            $locations = $device->locations()->whereBetween('created_at', [$start, $end])->orderBy('created_at', 'asc')->get();
        }else{
            $locations = null;
        }
        $breadcrumbs = [
            ['link'=>"/",'name'=>"首页"],['link'=>route('device.index'),'name'=>"设备列表"], ['link'=>route('device.show', $device->id),'name'=>$device->phone], ['name'=>'范围搜索']
        ];
        return view('device.search', compact('device', 'locations', 'startTime', 'endTime', 'breadcrumbs'));
    }
    
    public function location(Device $device){
        return view('device.location', compact('device'));
    }
}
