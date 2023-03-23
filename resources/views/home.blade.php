@extends('layouts.app')

@section('content')
    <place club="{{ $club }}" user-data="{{ $userData }}"></place>
@endsection
<script>
    import PlaceComponent from "../js/components/PlaceComponent";
    import ExampleComponent from "../js/components/ExampleComponent";
    export default {
        components: {ExampleComponent, PlaceComponent}
    }
</script>
