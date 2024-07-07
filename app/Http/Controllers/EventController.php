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

class EventController extends Controller
{
    public function index($link_registration): View
    {

        $event = Event::where('link_registration', $link_registration)->firstOrFail();
        if ($event == false) abort(404);

        $event->event_start = $this->formatDate($event->event_start);
        $event->event_end = $this->formatDate($event->event_end);
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

    public function ticket($ticket): View
    {
        $decryt = EncryptDecrypt::decryptText($ticket);
        $explodeLink = explode(":", $decryt);
        $participant = EventParticipant::find($explodeLink[1]);
        if (!$participant) abort(403);

        $qrcode = (new QRCode)->render($decryt);
        $participant->event->event_start = $this->formatDate($participant->event->event_start);

        return view('event-ticket', compact('participant', 'qrcode'));
    }
}
