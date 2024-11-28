@extends('layouts.app')

@section('content')
    <booking club_id="{{ $club_id  }}"></booking>
@endsection
<script>
    import Booking from "../../js/components/Booking";

    export default {
        components: {Booking}
    }
</script>
