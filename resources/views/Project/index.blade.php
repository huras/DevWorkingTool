@extends('Layout.default')

@section('content')
    @foreach ($projects as $item)
        <div>
            <div>{{$item->name}}</div>
            <img src="{{asset('/storage/projects/'.$item->icon)}}" alt="">
        </div>
    @endforeach
@endsection
