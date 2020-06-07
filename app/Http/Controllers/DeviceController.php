<?php

namespace App\Http\Controllers;

use App\Device;
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
}
