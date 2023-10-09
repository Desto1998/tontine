{{--<script>--}}

{{--    @if ($message = Session::get('primary'))--}}
{{--        toastr.options =--}}
{{--        {--}}
{{--            "closeButton": true,--}}
{{--            "progressBar": true--}}
{{--        }--}}
{{--    toastr.success("{{ $message }}");--}}
{{--    @endif--}}
{{--        @if ($message = Session::get('success'))--}}
{{--        toastr.options =--}}
{{--        {--}}
{{--            "closeButton": true,--}}
{{--            "progressBar": true--}}
{{--        }--}}
{{--    toastr.success("{{ $message }}");--}}
{{--    @endif--}}

{{--        @if ($message = Session::get('error'))--}}
{{--        toastr.options =--}}
{{--        {--}}
{{--            "closeButton": true,--}}
{{--            "progressBar": true--}}
{{--        }--}}
{{--    toastr.error("{{ $message }}");--}}
{{--    @endif--}}


{{--        @if ($message = Session::get('warning'))--}}
{{--        toastr.options =--}}
{{--        {--}}
{{--            "closeButton": true,--}}
{{--            "progressBar": true--}}
{{--        }--}}
{{--    toastr.warning("{{$message }}");--}}
{{--    @endif--}}


{{--        @if ($message = Session::get('info'))--}}
{{--        toastr.options =--}}
{{--        {--}}
{{--            "closeButton": true,--}}
{{--            "progressBar": true--}}
{{--        }--}}
{{--    toastr.info("{{ $message }}");--}}
{{--    @endif--}}

{{--        @if ($message = Session::get('danger'))--}}
{{--        toastr.options =--}}
{{--        {--}}
{{--            "closeButton": true,--}}
{{--            "progressBar": true--}}
{{--        }--}}
{{--    toastr.error("{{ $message }}");--}}
{{--    @endif--}}


{{--        @if ($errors->any())--}}
{{--        toastr.options =--}}
{{--        {--}}
{{--            "closeButton": true,--}}
{{--            "progressBar": true--}}
{{--        }--}}
{{--    toastr.error("Veuillez vérifier le formulaire ci-dessous pour les erreurs!");--}}
{{--    @endif--}}

{{--</script>--}}

<script>

    @if ($message = Session::get('success'))
    Toast.fire({
        icon: 'success',
        title: '{{ $message }}'
    })
    @endif

    @if ($message = Session::get('info'))
    Toast.fire({
        icon: 'info',
        title: '{{ $message }}',
    })
    @endif

    @if ($message = Session::get('error'))
    Toast.fire({
        icon: 'error',
        title: '{{ $message }}'
    })
    @endif

    @if ($message = Session::get('warning'))
    Toast.fire({
        icon: 'warning',
        title: '{{$message }}'
    })
    @endif

    @if ($message = Session::get('danger'))
    Toast.fire({
        icon: 'error',
        title: '{{ $message }}'
    })
    @endif

    @if ($errors->any())
    Toast.fire({
        icon: 'error',
        title: '{!! implode('', $errors->all('<div>:message</div>')) !!} '
    })
    @endif

</script>
