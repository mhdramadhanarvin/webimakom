@section('title', 'Tiket Pendaftaran Peserta ' . $participant->event->event_name)
<x-new-app-layout>
    <div class="fullscreen full-image max-h-[7em]">
        <div class="overlay content-center first-content tertienary">
        </div>
    </div>
    <div class="px-3 my-20 row justify-center">
        <div href="#" class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
            <div class="flex flex-col justify-between p-4 leading-normal">
                <span class="text-sm">Tiket Pendaftaran Kegiatan</span>
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $participant->event->event_name }}</h5>
                <p class="mb-3 text-lg font-normal text-gray-699 dark:text-gray-400">
                    {{ $participant->event->location }}
                </p>
                <h5 class="mb-2 text-md font-bold tracking-tight text-gray-900 dark:text-white py-2">{{ $participant->event->event_start }}</h5>
                <table>
                    <thead>
                        <tr>
                            <td class="font-bold">Nama</td>
                            <td class="font-bold">Tanggal Daftar</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $participant->name }}</td>
                            <td>{{ $participant->created_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <img class="object-cover w-40 rounded-t-lg h-40 md:h-auto md:w-48 md:rounded-none md:rounded-s-lg" src="{{ $qrcode }}" alt="">
        </div>
    </div>
</x-new-app-layout>
