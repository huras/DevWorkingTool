
@if (session('toast'))
<?php $toast = session('toast'); ?>
    <div class='container' id='alert-container'>
        <div class="alert alert-{{$toast['context']}} alert-dismissible fade show closed" role="alert" id='alert'>
            {{-- <strong class='main'>Holy guacamole!</strong> --}}
            <span class='description'>{{$toast['msg']}}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
{{-- <div class="alert alert-{{$toast['context']}}" style='text-align: center;'>
    {{$toast['msg']}}
</div> --}}
@endif
