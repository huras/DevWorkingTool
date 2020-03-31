@extends('Layout.default')

@section('content')
    <script src="{{asset('/js/notes.js')}}"></script>
    <script src="{{asset('/js/blocks.js')}}"></script>
    <script src="{{asset('/js/skills.js')}}"></script>

    <form action="{{route('skill.store')}}" method='POST' enctype="multipart/form-data">
        @csrf
        <label for="">Nome:
            <input type="text" name='name' value='{{old('name')}}'>
            @error('name')
                <span class='text-danger'>{{ $message }}</span>
            @enderror
        </label>
        <div>
            <label for="">Icone Arquivo:
                <input type="file" name='icon' value='{{old('icon')}}'>
            </label>
            @error('icon')
                <span class='text-danger'>{{ $message }}</span>
            @enderror
        </div>
        <input type="submit">
    </form>


    {{-- Page contents --}}
    <section class='container'>
        <div style='text-align: center; width: 100%; margin-top: 8px;'>
            <h3>All Skills</h3>
        </div>
        <div class='skill-listing' id='skill-listing'>
            <script>
                let skills = [];
            </script>
            @foreach ($skills as $skill)
                <span>
                    <a class='skill-row' href='/skill/view/{{$skill->id}}'>
                        <img src="/storage/skill/thumbnail/{{$skill->icon}}" alt="" srcset="">
                        {{$skill->name}}
                    </a>
                </span>
            @endforeach
        </div>
    </section>
@endsection
