@extends('Layout.default')

@section('content')
    @foreach ($workdays as $workday)
        <div>
            <div> {{$workday->date}} </div>
            @foreach ($workday->projects as $project)
                <div>
                    {{$project->name}}
                </div>
            @endforeach

            @foreach ($workday->notes as $note)
                <div style='white-space: pre;'>
                    {{$note->content}}
                </div>
            @endforeach
        </div>
    @endforeach
@endsection
