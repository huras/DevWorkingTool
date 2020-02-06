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
                <h4>{{$note->title}}</h4>
                <?php $maxrows = 10; $rows = substr_count( $note->content, "\n" ) + 1; if($rows > $maxrows) { $rows = $maxrows;} ?>
                <textarea style='width: 100%;' rows="{{$rows}}">{{$note->content}}</textarea>
            @endforeach
        </div>
    @endforeach
@endsection
