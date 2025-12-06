@section('title', 'Struktur Kepengurusan | Ikatan Mahasiswa Komputer Universitas Pembangunan Panca Budi')
<x-new-app-layout>
    <div class="fullscreen full-image max-h-[40em]">
        <div class="image">
            <img src="{{ url('images/agenda.webp') }}" alt="Background Agenda"/>
        </div>
        <div class="overlay content-center first-content tertienary">
            <div class="content">
                <div class="row">
                    <div class="col-6">
                        <!-- <img class="responsive-img logo-stempel" src="images/logo imakom.png" /> -->
                    </div>
                    <div class="col-6">
                        <h1 class="text-3xl text-red-600">PENGURUS & ANGGOTA KEORGANISASIAN 2025/2026</h1>
                    </div>
                </div>
                <div class="responsive-gap"></div>
            </div>
        </div>
    </div>

    <!-- ARTIKEL -->
    <div class="tertienary bg-white">
        <div class="text-center pt-20">
            <h1 class="text-3xl font-bold">STRUKTUR KEPENGURUSAN IMAKOM</h1>
        </div>
        <div class="grid justify-center mb-10">
            <div class="container mb-0">
                @foreach ($lead as $l)
                <div class="card" style=" border: 2px solid rgba(51, 46, 77, 0.82); border-radius: 15px;">
                    <div class="content">
                        <div class="imgBx">
                            <img src="{{ $l->photo == null ? url('./images/default.webp') : asset('storage/' . $l->photo) }}" alt="Photo Profile {{ $l->name }}">
                        </div>
                        <div class="contentBx ">
                            <h2 class="text-xl text-white font-bold">{{ $l->name }}<br><span class="text-lg">{{ str()->ucwords(Illuminate\Support\Str::of(str()->snake($l->position->name))->replace('_', ' ')) . ' Umum' }}</span>
                            </h2>
                        </div>
                    </div>

                    <ul class="sci">
                        <li style="--i:1">
                            <a href="{{ $l->facebook ?? 'javascript:void(0);' }}" aria-label="Facebook of {{ $l->name }}">
                                <i class="fa-brands fa-facebook" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li style="--i:2">
                            <a href="{{ $l->instagram ?? 'javascript:void(0);' }}" aria-label="Instagram of {{ $l->name }}">
                                <i class="fa-brands fa-instagram" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li style="--i:3">
                            <a href="{{ $l->linkedin ?? 'javascript:void(0);' }}" aria-label="LinkedIn of {{ $l->name }}">
                                <i class="fa-brands fa-linkedin" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                @endforeach
            </div>
            <div class="container mt-0">
                @foreach ($secretary as $secr)
                <div class="card" style="border: 2px solid rgba(51, 46, 77, 0.82); border-radius: 15px;">
                    <div class="content">
                        <div class="imgBx">
                            <img src="{{ $secr->photo == null ? url('./images/default.webp') : asset('storage/' . $secr->photo) }}" alt="Photo profile {{ $secr->name }}">
                        </div>
                        <div class="contentBx">
                            <h2 class="text-xl text-white font-bold">{{ $secr->name }}<br><span class="text-lg">{{ str()->ucwords(Illuminate\Support\Str::of(str()->snake($secr->position->name))->replace('_', ' ')) . ' Umum' }}</span>
                            </h2>
                        </div>
                    </div>

                    <ul class="sci">
                        <li style="--i:1">
                            <a href="{{ $secr->facebook ?? 'javascript:void(0);' }}" aria-label="Facebook of {{$secr->name}}">
                                <i class="fa-brands fa-facebook" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li style="--i:2">
                            <a href="{{ $secr->instagram ?? 'javascript:void(0);' }}" aria-label="Instagram of {{$secr->name}}">
                                <i class="fa-brands fa-instagram" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li style="--i:3">
                            <a href="{{ $secr->linkedin ?? 'javascript:void(0);' }}" aria-label="LinkedIn of {{$secr->name}}">
                                <i class="fa-brands fa-linkedin" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                @endforeach
            </div>
        </div>

        <h3 class="text-3xl font-bold text-center pb-0 mb-0"> DIVISI IMAKOM </h3>

        <section>
            <!-- START DIVISI IMAKOM -->
            @foreach ($division as $div)
            <div class="container mx-auto">
                <div class="card h-16 rounded-xl bg-orange-400">
                    <a href="javascript:void(0);" style="text-decoration:none;" aria-label="Card of {{ $div->name }}">
                        <h4 class="mx-auto text-white" style="margin:0 auto; color: white; font-size: 30px;">{{ $div->name }}</h4>
                    </a>
                </div>

                @php
                $members = $div->members;
                @endphp

                @foreach ($members as $member)
                <div class="card max-w-60 h-80 lg:h-72 max-h-96">
                    <div class="content static">
                        <div class="imgBx max-h-32 max-w-32">
                            <img src="{{ $member->photo == null ? url('./images/default.webp') : asset('storage/' . $member->photo) }}" alt="Photo profile {{ $member->name }}">
                        </div>
                        <div class="contentBx">
                            <h2 class="max-w-56">{{ $member->name }}<br>
                                <span class="text-lg">{{ $member->position->value == '1' ? 'Ketua Divisi' : 'Anggota Divisi' }}</span>
                            </h2>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <hr style="background:rgba(51, 46, 77, 0.82); padding:2px ; margin: 0 100px;">
            @endforeach
            <!-- END DIVISI IMAKOM -->


        </section>

    </div>
</x-new-app-layout>
