@section('title', 'Cek Kehadiran Tiket')
<x-new-app-layout>
    <div class="fullscreen full-image max-h-[7em]">
        <div class="overlay content-center first-content tertienary">
        </div>
    </div>
    <div class="px-3 my-20">
        @session('attendance')
        <div class="row justify-center font-bold">{{ session('event') }} - {{ session('attendance') }} - HADIR</div>
        @endsession
        <div class=" row justify-center" onload="load()">
            <div class="container">
                <div id="qr-reader" style="width:500px"></div>
                <div id="qr-reader-results"></div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('js/qrcode.min.js') }}"></script>
    <script>
        function docReady(fn) {
            // see if DOM is already available
            if (document.readyState === "complete"
                || document.readyState === "interactive") {
                // call on next available tick
                setTimeout(fn, 1);
            } else {
                document.addEventListener("DOMContentLoaded", fn);
            }
        }

        docReady(function () {
            var resultContainer = document.getElementById('qr-reader-results');
            var lastResult, countResults = 0;
            function onScanSuccess(decodedText, decodedResult) {
                if (decodedText !== lastResult) {
                    ++countResults;
                    lastResult = decodedText;
                    // Handle on success condition with the decoded message.
                    console.log(`Scan result ${decodedText}`, decodedResult);
                    //console.log({{ route('event.ticket.check') }} + '?ticket='+decodedText)
                    window.location.href = "{{URL::signedRoute('event.ticket.check')}}" + '&ticket='+decodedText
                    //window.location.replace({{ route('event.ticket.check') . '?ticket=' }}decodedText);
                }
            }

            var html5QrcodeScanner = new Html5QrcodeScanner(
                "qr-reader", { fps: 10, qrbox: 250 });
            html5QrcodeScanner.render(onScanSuccess);
        });
    </script>
</x-new-app-layout>
