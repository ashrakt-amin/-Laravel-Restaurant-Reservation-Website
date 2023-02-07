<?php

namespace App\Http\Controllers\Admin;

use App\Models\Table;
use App\Enums\TableStatus;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationStoreRequest;

class AdminReservationController extends Controller
{
   
    public function index()
    {
        $reservations = Reservation::all();
        return view('admin.reservations.index',get_defined_vars());
    }

   
    public function create()
    {
        $tables = Table::where('status', TableStatus::Available)->get();
        return view('admin.reservations.create',get_defined_vars());
    }

    
    public function store(ReservationStoreRequest $request)
    {
        $request_date = Carbon::parse($request->res_date);
        // return $request;
       
        $table =Table::findOrFail($request->table_id);
        // return $table->reservations;
       
        if($request->guest_number > $table->guest_number){
            return back()->with('warning', 'Please choose the table base on guests.');
        }
        foreach($table->reservations as $reservation){
            if($reservation->res_date == $request_date){
                return back()->with('warning', 'This table is reserved for this date.');
            }
        }
          Reservation::create([
            'first_name'        => $request->first_name,
            'last_name' => $request->last_name,
            'email'    => $request->email,
            'tel_number'      => $request->tel_number,
            'res_date'    => $request->res_date,
            'table_id'      => $request->table_id,
            'guest_number'    => $request->guest_number,
            'time'    => $request->time

          ]);
          return to_route('admin.reservations.index')->with('success', 'Reserve created successfully.');

    }

   
    public function show($id)
    {
        //
    }

    
    public function edit(Reservation $reservation)
    {
        $tables = Table::where(TableStatus::Available)->get();
       return view('admin.reservations.edit',get_defined_vars());
    }

    
    public function update(ReservationStoreRequest $request , Reservation $reservation)
    {
       $table =Table::findOrFail($request->table_id);
       if($table->guest_number > $request->guest_number){
        return back()->with('warning', 'Please choose the table base on guests.');
       }

       $request_date = Carbon::parse($request->res_date);
       $reservations = $table->reservations()->where('id','!=', $reservation->id);
       foreach($reservations as $res){
        if( $res->res_date == $request_date){
            return back()->with('warning', 'This table is reserved for this date.');
        }
       }
       $reservation->update($request->validated());
       return to_route('admin.reservations.index')->with('success', 'Reserve Updated successfully.');

    }

    
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return to_route('admin.reservations.index')->with('success', 'Reserve deleted successfully.');

    }
}
