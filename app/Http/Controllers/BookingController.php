<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // $bookings=Booking::get();
        $loc = Branch::all();

        return view('booking.dashboard', compact('loc'));
    }


    public function showbooking(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $departure_date = $request->input('departure_date');
        $passengers = $request->input('no_of_passengers');

        // dd($request->all());
        $amount = $request->no_of_passengers;

        $data = Booking::with(['arrivalbranch', 'departurebranch'])
            ->where('departure_day', $departure_date)
            ->where('departure_state', $from)
            ->where('arrival_state', $to)
            // ->selectRaw('id,departure_time, departure_day, departure_state, arrival_time, arrival_day, arrival_day, price * ' . $amount . ' AS total_price')
            ->get();

        // dd($data);
        if ($data) {
            return view('booking.index', compact('data', 'passengers', 'amount'));
        } else {

            return back()->with('error', 'No Booking Found');
        }
    }


    public function bookpage($id, $amount)
    {

        // $persons = intval($amount);


        // $persons = intval($amount);

        // $booking = Booking::with(['arrivalbranch', 'departurebranch'])->findOrFail($id);
        // $total = $booking->selectRaw('SUM(vat) + SUM(levy) + SUM(tax) + SUBTRACT(discount, (SUM(price * ' . $persons . ') AS total)')->first()->total;

        $persons = intval($amount);

        $booking = Booking::with(['arrivalbranch', 'departurebranch'])->findOrFail($id);
        $total = $booking->selectRaw('(SELECT SUM(vat) + SUM(levy) + SUM(tax) + SUM(price * ' . $persons . ') FROM bookings) - discount AS total')->first()->total;


        return view('booking.confirmpage', compact('booking', 'persons', 'total'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        // dd('dd');
        $id = $request->input('booking_id');
        // $name=$request->input('name');
        // $email=$request->input('email');
        // $phone=$request->input('phone');
        $amount = $request->input('thetotalprice');

        return view('booking.payment', compact('id', 'amount'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Extracting input data
        $name = $request->input('name');
        $email = $request->input('email');
        $phone_number = $request->input('phone_number');
        $amount = $request->input('amount');

        // Generating invoice number
        $lastInvoice = Payment::latest()->first();
        $lastInvoice = $lastInvoice ? str_replace('NIWA-', '', $lastInvoice->invoice_number) : 0;
        $newid = str_pad($lastInvoice + 1, 7, 0, STR_PAD_LEFT);
        $lastInvoice = 'NIWA-' . $newid;

        // Constructing Remita API request
        $serviceTypeId = "4430731";
        $orderId = round(microtime(true) * 1000);
        $apiHash = hash('sha512', env('REMITA_MERCHANT_ID') . $serviceTypeId . $orderId . $amount . env('REMITA_API_KEY'));

        $fields = [
            "serviceTypeId" => $serviceTypeId,
            'amount' => $amount,
            "orderId" => $orderId,
            'payerName' => $name,
            'payerEmail' => $email,
            'payerPhone' => $phone_number,
            'description' => 'PAYMENT FOR BOATTRIP',
        ];

        // Sending request to Remita API
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => env('REMITA_BASE_URL') . '/echannelsvc/merchant/api/paymentinit',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($fields),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: remitaConsumerKey=' . env('REMITA_MERCHANT_ID') . ',remitaConsumerToken=' . $apiHash
            ],
        ]);
        $result = curl_exec($curl);
        // dd($result);

        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return redirect()->route('home')->with('error', $err);
        }
        $result = substr($result, 7);


        $newLength = strlen($result);
        $result = substr($result, 0, $newLength - 1);
        $data = json_decode($result, true);

        if ($data['statuscode'] == "025" && $data['RRR']) {
            // Saving payment transaction
            Payment::create([
                'payment_type' => 1,
                'payment_employee' => $name,
                'rrr' => $data['RRR'],
                'invoice_number' => $lastInvoice,
                'invoice_generated_at' => now(),
                'invoice_duration' => now()->addYear(),
                'payment_status' => 1,
                'amount' => $amount,
                'branch_id' => 2,
                'applicant_name' => $name,
                'service_application_id' => 1,
                'employer_id'=>1
            ]);

            // Redirecting based on payment type
            return redirect()->back()->with('success', 'Payment Reference Generated! RRR = ' . $data['RRR']);
        } else {
            return redirect()->back()->with('error', 'Problems encountered in generating RRR');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        //
    }
}
