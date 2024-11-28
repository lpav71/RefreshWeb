@extends('layouts.app')

@section('content')
    <games club_id="{{ $club_id }}" user_id="{{ $user_id }}"></games>
@endsection

<script>
    import Games from "../../js/components/Games";

    export default {
        components: {Games}
    }
</script>

