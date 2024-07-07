@section('title', 'Pendaftaran Peserta ' . $event->event_name)
<x-new-app-layout>
    <div x-data="{ buttonDisabled: false }" x-on:submit="buttonDisabled= true}">
        <div class="fullscreen full-image max-h-[7em]">
            <div class="overlay content-center first-content tertienary">
            </div>
        </div>
        <div class="max-w-full lg:max-w-2xl mx-auto my-20 bg-white p-8 rounded-3xl drop-shadow-md">
            <form id="formPendaftaran" class="mx-auto" action="{{ route('event.form.submit', $event->link_registration) }}" method="post" enctype="multipart/form-data">
                @csrf
                <h1 class="text-center text-4xl font-black text-zinc-800">Pendaftaran Peserta<br>{{ $event->event_name }}</h1>
                <hr class="h-1 mx-auto bg-purple-500 border-0 rounded my-6 dark:bg-white">
                <div>
                    <table>
                        <tr>
                            <td>Tempat</td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>{{ $event->location }}</td>
                        </td>
                        <tr>
                            <td>Tanggal Pelaksanaan</td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>{{ $event->event_start }} - {{ $event->event_end }}</td>
                        </td>
                        <tr>
                            <td>Tanggal Pendaftaran Peserta</td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>{{ $event->open_registration_date }} - {{ $event->close_registration_date }}</td>
                        </td>
                    </table>
                </div>
                <hr class="h-1 mx-auto bg-purple-500 border-0 rounded my-6 dark:bg-white">
                @if ($errors->any())
                <div class="relative leading-normal py-4 px-5 text-red-700 bg-red-100 rounded-lg mb-2" role="alert">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="mb-5">
                    <x-input-label for="name">Nama Lengkap</x-input-label>
                    <x-text-input type="text" id="name" name="name" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required></x-text-input>
                </div>
                <div class="mb-5">
                    <x-input-label for="email">Email</x-input-label>
                    <x-text-input type="email" id="email" name="email" placeholder="Masukkan email" value="{{ old('email') }}" required></x-text-input>
                </div>
                <div class="mb-5">
                    <x-input-label for="phone_number">Nomor Whatsapp (Format: 62)</x-input-label>
                    <x-text-input type="number" id="phone_number" name="phone_number" placeholder="Masukkan nomor Whatsapp" value="{{ old('phone_number') }}" required></x-text-input>
                </div>
                <div class="mb-5">
                    <x-input-label for="phone_number">Jenis Kelamin</x-input-label>
                    @php
                    $option = [ "male" => "Laki - laki", "female" => "Perempuan" ];
                    @endphp
                    <x-input-radio :options="$option" name="gender" required/>
                </div>
                <div class="mb-5">
                    <x-input-label for="phone_number">Instansi Asal</x-input-label>
                    @php
                    $option = [ "pancabudi" => "Universitas Pembangunan Pancabudi", "permikomnas" => "Pemikomnas", "public" => "Umum" ];
                    @endphp
                    <x-input-radio :options="$option" name="institusion" required/>
                </div>
                <!---
                <div class="mb-5">
                    <label for="game_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Cabang Olahraga</label>
                    <select id="game_id" name="game_id" class="bg-slate-100 text-gray-900 text-sm rounded-lg border-slate-300 focus:ring-purple-700 focus:border-blue-500 block w-full p-2.5 placeholder-zinc-400" required>
                        <option value="" selected>Pilih</option>
                        <option value="" ></option>
                    </select>
                </div>
                --->

                <hr class=" h-1 mx-auto my-4 bg-purple-500 border-0 rounded md:my-10 dark:bg-white">

                {{-- FILE PDF --}}
                <button type="submit" class="w-full text-white bg-purple-700 focus:bg-purple-950 hover:bg-purple-950 focus:ring-4 focus:outline-none focus:ring-purple-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center" x-bind:disabled="buttonDisabled">
                    <span x-show="!buttonDisabled">DAFTAR</span>
                    <span x-show="buttonDisabled">Loading...</span>
                </button>
            </form>
        </div>
        <!----MODAL SUCCESS DAFTAR--->
        @session('status')
        <div x-data="{ open: true }">
            <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-show="open">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-100 transition-opacity"></div>

                <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <div class="relative transform rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-96">
                            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                <div class="text-center">
                                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-green-100">
                                        @if (session('status') == true)
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="text-green-600 w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
                                        </svg>
                                        @else
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path d="M12 2C6.49 2 2 6.49 2 12C2 17.51 6.49 22 12 22C17.51 22 22 17.51 22 12C22 6.49 17.51 2 12 2ZM15.36 14.3C15.65 14.59 15.65 15.07 15.36 15.36C15.21 15.51 15.02 15.58 14.83 15.58C14.64 15.58 14.45 15.51 14.3 15.36L12 13.06L9.7 15.36C9.55 15.51 9.36 15.58 9.17 15.58C8.98 15.58 8.79 15.51 8.64 15.36C8.35 15.07 8.35 14.59 8.64 14.3L10.94 12L8.64 9.7C8.35 9.41 8.35 8.93 8.64 8.64C8.93 8.35 9.41 8.35 9.7 8.64L12 10.94L14.3 8.64C14.59 8.35 15.07 8.35 15.36 8.64C15.65 8.93 15.65 9.41 15.36 9.7L13.06 12L15.36 14.3Z" fill="#ff2e43"></path>
                                            </g>
                                        </svg>
                                        @endif
                                    </div>
                                    <div class="mt-5 text-center">
                                        <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Pendaftaran {{ session('status') == true ? "Berhasil" : "Gagal" }}</h3>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">{{ session('message') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 mb-2">
                                <button @click="open = false" type="button" class="inline-flex w-full justify-center rounded-md bg-purple-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-purple-500">TUTUP</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsession
        <!----END MODAL SUCCESS DAFTAR--->
    </div>
</x-new-app-layout>
