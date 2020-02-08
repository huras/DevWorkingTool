@extends('Layout.default')

@section('content')
    <?php
        $meses = [
            '01' => 'Janeiro',
            '02' => 'Fevereiro',
            '03' => 'Março',
            '04' => 'Abril',
            '05' => 'Maio',
            '06' => 'Junho',
            '07' => 'Julho',
            '08' => 'Agosto',
            '09' => 'Setembro',
            '10' => 'Outubro',
            '11' => 'Novembro',
            '12' => 'Dezembro',
        ];
    ?>
    <div class='container'>
        @foreach ($workdays as $workday)
            <div class='workday-slot'>
                <div class='head'>
                    <div class='data'>
                        <?php
                            $newDate = date('d-m-Y', strtotime($workday->date));
                            $newExplodedDate = explode('-', $newDate);
                            echo $newExplodedDate[0].'/'.$meses[$newExplodedDate[1]].'/'.$newExplodedDate[2];
                        ?>
                    </div>
                    <div class='actions'>
                        <button type='button' onclick="appendNewNote({{$workday->id}});" title='Nova Nota' class='nova-nota action'>
                            <img src="{{asset('/img/icons/sticky-note-regular.svg')}}" alt="" class='icon'>
                            <img src="{{asset('/img/icons/plus-circle-solid.svg')}}" alt="" class='icon-x'>
                        </button>
                    </div>
                </div>

                <div class='project-list'>
                    @foreach ($workday->projects as $project)
                        <div class='workday-project'>
                            <img src="{{asset('/storage/projects/'.$project->icon)}}" alt="">
                            <div>
                                {{$project->name}}
                            </div>
                        </div>
                    @endforeach
                </div>

                <div id='workday-notes-list' class='workday-notes-list'>
                    @foreach ($workday->notes as $note)
                        <div class='workday-note'>
                            <input oninput="showSaveButton({{$note->id}})" id='note-title-{{$note->id}}' type="text" value='{{$note->title}}' class='titulo'>
                            <?php $maxrows = 10; $rows = substr_count( $note->content, "\n" ) + 1; if($rows > $maxrows) { $rows = $maxrows;} ?>
                            <textarea oninput="showSaveButton({{$note->id}})" id='note-content-{{$note->id}}' rows="{{$rows}}">{{$note->content}}</textarea>
                            <button class='btn-salvar' id='btn-salvar-{{$note->id}}' type="button" onclick="updateNote(event, {{$note->id}})"> Salvar </button>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <script>
        function appendNewNote(workdayID){
            let list = document.getElementById('workday-notes-list');

            let newNote = document.createElement('div');
            newNote.classList.add('workday-note');

            let title = document.createElement('input');
            title.classList.add('titulo');
            title.value = "New note";

            let text = document.createElement('textarea');
            text.setAttribute('rows', 2);

            let button = document.createElement('button');
            button.setAttribute('type', 'button');
            button.innerHTML = 'Salvar';

            newNote.appendChild(title);
            newNote.appendChild(text);
            newNote.appendChild(button);

            list.insertBefore(newNote, list.firstChild);
        }

        function showSaveButton(noteID){
            let btnSalvar = document.getElementById('btn-salvar-'+noteID);
            btnSalvar.style.display = 'block';
        }
        function updateNote(e, noteID){
            token = $('meta[name="csrf-token"]').attr("content");
            var baseurl = window.location.origin;

            return $.ajax({
                url: baseurl + "/updateNote",
                type: "POST",
                data: {
                    id: noteID,
                    title: document.getElementById('note-title-'+noteID).value,
                    content: document.getElementById('note-content-'+noteID).value,
                    _token: token
                }
            })
            .done(function(res) {
                console.log(res);
                e.target.style.display = 'none';
            })
            .fail(function(res) {
                console.log(res);
            })
            .always(function(res) {
                console.log(res);
            });
        }
    </script>
@endsection
