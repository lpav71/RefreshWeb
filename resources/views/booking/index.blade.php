@extends('layouts.app')

@section('content')
<booking></booking>
@endsection
<script>
    import Booking from "../../js/components/Booking";
    export default {
        components: {Booking}
    }
</script>
