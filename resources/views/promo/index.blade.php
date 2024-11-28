@extends('layouts.app')

@section('content')
    <promo club_id="{{ $club_id }}"></promo>
@endsection
<script>
    import Promo from "../../js/components/Promo";

    export default {
        components: {Promo}
    }
</script>
