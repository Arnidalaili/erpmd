@extends('layouts.master')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                        <h3>{{$data['product']}}</h3>
                            <p>Product</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-coins"></i>
                        </div>
                        <a href="product" class="small-box-footer trado">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
</div>
</section>
</div>
@push('scripts')
<script>
    $(document).ready(function() {
        // if (!`{{ $myAuth->hasPermission('reminderoli', 'index') }}`) {
        //     $('#reminderoli').attr('href', '#')
        // }
    })
</script>
@endpush
@endsection