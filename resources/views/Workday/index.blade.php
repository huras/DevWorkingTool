@extends('Layout.default')

@section('content')
    <div class='container'>
        @foreach ($workdays as $workday)
            <div>
                <div> {{$workday->date}} </div>
                @foreach ($workday->projects as $project)
                    <div>
                        {{$project->name}}
                    </div>
                @endforeach

                <button type='button' onclick="appendNewNote({{$workday->id}});">Nova nota</button>

                <div id='workaday-notes-list'>
                    @foreach ($workday->notes as $note)
                        <div class='workday-note'>
                            <h4>{{$note->title}}</h4>
                            <?php $maxrows = 10; $rows = substr_count( $note->content, "\n" ) + 1; if($rows > $maxrows) { $rows = $maxrows;} ?>
                            <textarea style='width: 100%;' rows="{{$rows}}">{{$note->content}}</textarea>
                            <button type="button"> Salvar </button>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <script>
        function appendNewNote(workdayID){
            let list = document.getElementById('workaday-notes-list');

            let newNote = document.createElement('div');
            newNote.classList.add('workday-note');

            let title = document.createElement('h4');

            let text = document.createElement('textarea');
            text.setAttribute('rows', 2);

            let button = document.createElement('button');
            button.setAttribute('type', 'button');
            button.innerHTML = 'Salvar';

            newNote.appendChild(title);
            newNote.appendChild(text);
            newNote.appendChild(button);
            list.appendChild(newNote);
        }
    </script>
@endsection
