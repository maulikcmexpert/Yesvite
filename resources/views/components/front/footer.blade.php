
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/fontfaceobserver/2.1.0/fontfaceobserver.standalone.js"></script>

<script src="{{ asset('assets/event/js/fontLoder.js') }}"></script>
<!-- owl-carousel-js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<!-- custom-js -->
<script src="{{ asset('assets/admin/js/jquery-validate.js') }}"></script>

<script src="{{ asset('assets/admin/js/jquery-validate-additional.js') }}"></script>




<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js" integrity="sha512-Gs+PsXsGkmr+15rqObPJbenQ2wB3qYvTHuJO6YJzPe/dTLvhy0fmae2BcnaozxDo5iaF8emzmCZWbQ1XXiX2Ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- <script src="https://hammerjs.github.io/dist/hammer.min.js"></script> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput-jquery.min.js"></script>

<script src="{{ asset('assets/front/js/common.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.min.js" integrity="sha512-TToQDr91fBeG4RE5RjMl/tqNAo35hSRR4cbIFasiV2AAMQ6yKXXYhdSdEpUcRE6bqsTiB+FPLPls4ZAFMoK5WA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="{{ asset('assets/front/js/script.js') }}"></script>

<!-- ======== wow-js ======== -->
<script src="{{ asset('assets/front/js/animation.js') }}"></script>

<script src="{{ asset('assets/front/js/wow.min.js') }}"></script>

<script src="{{ asset('assets/front/js/design.js') }}"></script>

<script src="{{ asset('assets/front/js/map.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/spectrum-colorpicker2/dist/spectrum.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html-to-image/1.7.0/html-to-image.js" integrity="sha512-uIP4HNFMvnpcVpzoE17SkA3zrdBkNZy2G6t65q2m44kDBHd6emnvYOuXxtPdudQOsCMxO0HuhBnYm1ao9GvJWw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"></script>


{{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> --}}

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script src="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>

<script src="https://cdn.jsdelivr.net/bootstrap.timepicker/0.2.6/js/bootstrap-timepicker.min.js"></script>

<!-- {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script> --}} -->

{{-- <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js'></script> --}}

<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js'></script>

<script src='https://cdnjs.cloudflare.com/ajax/libs/eonasdan-bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js'></script>


{{-- <script type="text/javascript" async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBW43KgTNs_Kusuvbian6KYGi_QzXOLS4w&libraries=places&callback=initMap" ></script> --}}
<script
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBW43KgTNs_Kusuvbian6KYGi_QzXOLS4w&callback=initMap&v=weekly&libraries=places"
defer
></script>

<!-- {{-- <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> --}} -->

<script>
    new WOW().init()
</script>

@if(isset($js))

@foreach($js as $value)

<script src="{{ asset('assets/front') }}/js/{{$value}}.js"></script>

@endforeach

@endif

@stack('scripts')