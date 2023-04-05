@extends('layouts.app')

@section('content')
<shop club_id="{{ $club_id }}"></shop>
@endsection

<script>
    import Shop from "../../js/components/Shop";
    export default {
        components: {Shop}
    }
</script>
