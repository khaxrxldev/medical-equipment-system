<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Equipment;
use App\Models\Payment;
use App\Models\PaymentResponse;

class PaymentController extends Controller
{
	public function readAll()
	{
		$payments = Payment::all();
		return response() -> json(array('data' => $payments), 200);
	}

  public function read(string $id)
  {
    $payment = Payment::find($id);
    $application = Application::find($payment -> applicationId);
    $equipment = Equipment::find($application -> equipmentId);

		$paymentResponse = new PaymentResponse();

    $paymentResponse -> paymentId = $payment -> paymentId;
    $paymentResponse -> paymentAmount = $application -> applicationRentPrice;
    $paymentResponse -> equipmentName = $equipment -> equipmentName;

    return response() -> json(array('data' => $paymentResponse), 200);
  }

  public function readFile(string $id)
  {
    $payment = Payment::find($id);
    return response() -> json(array('data' => $payment -> paymentReceipt), 200);
  }

	public function create(Request $request)
	{
    $createPayment = Payment::create([
      'paymentId' => Str::uuid() -> toString(),
      'paymentAmount' => $request -> input('paymentAmount'),
      'paymentReceipt' => $request -> input('paymentReceipt'),
      'paymentDate' => $request -> input('paymentDate'),
      'paymentStatus' => $request -> input('paymentStatus'),
      'applicationId' => $request -> input('applicationId')
    ]);

		return response() -> json(array('data' => $createPayment), 200);
	}

  public function update(Request $request)
  {
    $paymentReceipt = $request -> file('paymentReceipt');
    $paymentReceiptContent = base64_encode($paymentReceipt -> get());

    $payment = Payment::find($request -> input('paymentId'));

    $payment -> paymentAmount = $request -> paymentAmount;
    $payment -> paymentStatus = $request -> paymentStatus;
    $payment -> paymentDate = $request -> paymentDate;
    $payment -> paymentReceipt = $paymentReceiptContent;

    $updatedPayment = $payment -> save();

    return response() -> json(array('data' => $updatedPayment), 200);
  }
}
