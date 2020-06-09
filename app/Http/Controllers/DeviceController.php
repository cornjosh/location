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
      return view('device.index', compact('devices'));
    }

    public function create(){

    }

    public function show(Device $device){
        $locations = $device->locations;
        return view('device.show', compact('locations', 'device'));
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
        if ($startTime == null && $endTime == null){
        
        }
        
        if ($start != null && $end != null){
            $locations = $device->locations()->whereBetween('created_at', [$start, $end])->orderBy('created_at', 'asc')->get();
        }else{
            $locations = null;
        }

        return view('device.search', compact('device', 'locations', 'startTime', 'endTime'));
    }
}
