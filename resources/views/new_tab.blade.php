@extends('layouts.app')
    
@section('content')
    
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        window.location.href = "<?php echo $full_url;?>";
    });
</script>
@endsection

