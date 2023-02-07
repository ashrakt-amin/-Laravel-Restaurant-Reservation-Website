<?php

namespace App\Http\Controllers\UI;

use Carbon\Carbon;
use App\Models\Table;
use App\Enums\TableStatus;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReservationController extends Controller
{
  public function stepOne(Request $request)
  {
    $reservation = $request->session()->get('reservation');
    return view('ui.reservations.step-one', get_defined_vars());
  }


  public function storeStepOne(Request $request)
  {

    $validated = $request->validate([
      'first_name' => ['required'],
      'last_name' => ['required'],
      'email' => ['required', 'email'],
      'res_date' => ['required', 'date'],
      'tel_number' => ['required'],
      'guest_number' => ['required'],
      'time'    =>  ['required']

    ]);
     $hour=Carbon::parse($validated['res_date'])->format('H') ;
     $min=Carbon::parse($validated['res_date'])->format('i') ;
     $time = $hour + $validated['time'];

    if (empty($request->session()->get('reservation'))) {
      $reservation = new Reservation();
      $reservation->fill($validated);
      $request->session()->put('reservation', $reservation);
    } else {
      $reservation = $request->session()->get('reservation');
      $reservation->fill($validated);
      $request->session()->put('reservation', $reservation);
    }

    return to_route('reservations.step.two', get_defined_vars());
  }
  public function stepTwo(Request $request)
  {
    $reservation = $request->session()->get('reservation');
    //  return $request->validated;
    $res_table_ids = Reservation::orderBy('res_date')->get()
      ->filter(function ($reservations) use ($request) {
        return $reservations->res_date == $request->validated['res_date'];
      })->pluck('table_id');
    $tables = Table::where('status', TableStatus::Available)
      ->where('guest_number', '>=', $request->validated['guest_number'])
      ->whereNotIn('id', $res_table_ids)->get();
    return view('ui.reservations.step-two', get_defined_vars());
  }

  public function storeStepTwo(Request $request)
  {
    $validated = $request->validate([
      'table_id' => ['required']
    ]);
    $reservation = $request->session()->get('reservation');
    $reservation->fill($validated);
    $reservation->save();
    $request->session()->forget('reservation');
    return to_route('thankyou');
  }
}
