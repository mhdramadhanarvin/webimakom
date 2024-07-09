<x-mail::message>
# Hai, {{ $notifiable->name }}

Terima kasih sudah mendaftar pada kegiatan **{{ $notifiable->event->event_name }}**
Berikut rangkuman informasi kegiatan.

<x-mail::table>
|                    |                                      |
| ------------------ |:------------------------------------:|
| Nama Kegiatan      | {{ $notifiable->event->event_name}}  |
| Lokasi             | {{ $notifiable->event->location}}    |
| Tanggal Kegiatan   | {{ $notifiable->event->event_start}} |
</x-mail::table>

<x-mail::button :url="$url">
Tiket Pendaftaran
</x-mail::button>

Mohon simpan pesan ini sebagai bukti bahwa telah melakukan pendaftaran.

Salam,<br>
{{ config('app.name') }}
</x-mail::message>
