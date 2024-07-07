<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventSubmitValidation;
use App\Models\Event;
use App\Models\EventParticipant;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use App\Notifications\EventParticipantRegisterNotification;
use App\Services\EncryptDecrypt;
use chillerlan\QRCode\QRCode as QRCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EventController extends Controller
{
    public function index($link_registration): View
    {

        $event = Event::where('link_registration', $link_registration)->firstOrFail();
        if ($event == false) abort(404);

        if (Carbon::create($event->open_registration_date)->greaterThan(now())) { // registrasi belum dibuka
            Session::flash('status-event', false);
            Session::flash('message', 'Pendaftaran belum dibuka');
        } elseif (Carbon::create($event->close_registration_date)->lessThan(now())) { // registrasi sudah ditutup
            Session::flash('status-event', false);
            Session::flash('message', 'Pendaftaran sudah tutup');
        }

        $event->event_start = $this->formatDate($event->event_start);
        $event->event_end = $event->event_end == null ? "Selesai" : $this->formatDate($event->event_end);
        $event->open_registration_date = $this->formatDate($event->open_registration_date);
        $event->close_registration_date = $this->formatDate($event->close_registration_date);

        return view('event', compact('event'));
    }

    private function formatDate($date)
    {
        return Carbon::create($date)->format('d M Y H:i');
    }

    public function submit(EventSubmitValidation $request)
    {
        DB::beginTransaction();
        try {
            $event = Event::where('link_registration', $request->link_registration)->firstOrFail();
            if (!$event) throw new \Exception("Event tidak ditemukan.");

            $participant = EventParticipant::create([
                'event_id' => $event->id,
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
                'institusion' => $request->institusion,
            ]);

            $participant->notify(new EventParticipantRegisterNotification);

            DB::commit();

            return redirect()->route('event.form', $request->link_registration)->with([
                'status' => true,
                'message' => "Terima kasih telah melakukan perdaftaran, kami telah mengirimkan bukti pendaftaran melalui email anda, silahkan cek secara berkala ."
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return redirect()->route('event.form', $request->link_registration)->with([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function ticket(Request $request): View
    {
        $decryt = EncryptDecrypt::decryptText($request->ticket);
        $explodeLink = explode(":", $decryt);
        $participant = EventParticipant::find($explodeLink[1]);
        if (!$participant) abort(403);

        $qrcode = (new QRCode)->render($request->ticket);
        $participant->event->event_start = $this->formatDate($participant->event->event_start);

        return view('event-ticket', compact('participant', 'qrcode'));
    }

    public function ticketCheck(Request $request): View
    {
        if ($request->ticket) {
            $decryt = EncryptDecrypt::decryptText($request->ticket);
            $explodeLink = explode(":", $decryt);
            $participant = EventParticipant::find($explodeLink[1]);
            if (!$participant) abort(403);

            $participant->is_attended = true;
            $participant->save();

            Session::flash('attendance', $participant->name);
            Session::flash('event', $participant->event->event_name);
        }

        return view('event-ticket-check');
    }
}
