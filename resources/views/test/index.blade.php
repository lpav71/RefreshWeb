@extends('layouts.app')

@section('content')

@endsection

<script>
    import Games from "../../js/components/Games";
    import Top from "../../js/components/Top";
    import Users from "../../js/components/Users";
    export default {
        components: {Users, Top, Games}
    }
</script>
