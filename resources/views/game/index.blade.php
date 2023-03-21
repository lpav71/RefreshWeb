@extends('layouts.app')

@section('content')
    <games></games>
@endsection

<script>
    import Games from "../../js/components/Games";
    import Top from "../../js/components/Top";
    import Users from "../../js/components/Users";
    export default {
        components: {Games}
    }
</script>

