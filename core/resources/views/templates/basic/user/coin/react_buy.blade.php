@extends($activeTemplate . 'layouts.master')

@section('content')
    <div id="gittu-presale-modal-root" style="position: relative;"></div>

    <script>
        window.addEventListener("DOMContentLoaded", function () {
            if (typeof window.renderGittuPresaleModal === "function") {
                window.renderGittuPresaleModal();
            }
        });
    </script>
@endsection
