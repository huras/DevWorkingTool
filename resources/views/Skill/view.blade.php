@extends('Layout.default')

@section('content')
    <script src="{{asset('/js/notes.js')}}"></script>
    <script src="{{asset('/js/blocks.js')}}"></script>
    <script src="{{asset('/js/skills.js')}}"></script>

    <div class='d-flex justify-content-center align-items-center'>
        <img src="{{$skill->icon}}" style='height: 95px; width: auto; margin-right: 8px;' alt="">
        <h1> {{$skill->name}} </h1>
    </div>

    <h2>Blocks</h2>
    <div>
        @foreach ($skill->blocks as $block)
            <div>
                {{$block->title}}
            </div>
        @endforeach
    </div>

    <br>

    <h2>Notes</h2>
    <h3>Indice</h3>
    <div>
        @foreach ($skill->notes as $note)
            <div>
                {{$note->title}}
            </div>
        @endforeach
    </div>

    <br>
    <div>
        @foreach ($skill->notes as $note)
            <div>
                <input type="text" class='w-100' value='{{$note->title}}'
                    style='text-align: center;'
                >
                <textarea name="" id="" class='w-100' cols="30" rows="10">{{$note->content}}</textarea>
            </div>
        @endforeach
    </div>
@endsection
