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
        <?php $isFirstWorkDay = true; ?>
        @foreach ($workdays as $workday)
            <div class='workday-slot' workday-slot='id{{$workday->id}}' id='workday-{{$workday->id}}'>
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

                        <button type="button" class='action collapsed'
                            data-toggle="collapse" data-target="#workday-notes-list-{{$workday->id}}" aria-expanded="<?= $isFirstWorkDay?'true':'false' ?>" aria-controls="workday-notes-list-{{$workday->id}}"
                        >
                            fold
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

                <div id="workday-notes-list-{{$workday->id}}" class="workday-notes-list <?= $isFirstWorkDay?'collapse in':'collapse' ?>" aria-labelledby="headingTwo" data-parent="#workday-{{$workday->id}}">
                    <?php /*
                    <div class='workday-note'>
                        <input onclick="noteTitleOnclick(event);" oninput="showSaveButton({{$note->id}})" id='note-title-{{$note->id}}' type="text" value='{{$note->title}}' class='titulo'>
                        <?php $maxrows = 10; $rows = substr_count( $note->content, "\n" ) + 1; if($rows > $maxrows) { $rows = $maxrows;} ?>
                        <textarea onclick="notecontetOnclick(event)" oninput="showSaveButton({{$note->id}})" id='note-content-{{$note->id}}' rows="{{$rows}}">{{$note->content}}</textarea>
                        <button class='btn-salvar' id='btn-salvar-{{$note->id}}' type="button" onclick="updateNote(event, {{$note->id}})"> Salvar </button>
                    </div>
                    */ ?>
                    <script>
                        window.addEventListener("load", function(event) {
                            @foreach ($workday->notes as $note)
                                insertNote({{$note->id}}, `{{$note->title}}`, `{{$note->content}}`, {{$workday->id}});
                            @endforeach
                        });
                    </script>
                </div>
            </div>
            <?php if($isFirstWorkDay) $isFirstWorkDay = false; ?>
        @endforeach
    </div>

    <script>
        function noteTitleOnclick(e){
            let input = e.target;
            if(input.value == '[New Note]'){
                input.select();
            }
        }
        function notecontetOnclick(e){
            let input = e.target;
            if(input.value == '[empty]'){
                input.select();
            }
        }

        function insertNote(newNoteID, titleValue = "[New Note]", contentValue = '[empty]', workdayID = null){
            let list = document.querySelector('.workday-notes-list');
            if(workdayID != null){
                list = document.querySelector('div[workday-slot=id'+workdayID+'] .workday-notes-list')
            }

            let newNote = document.createElement('div');
            newNote.classList.add('workday-note');

            let title = document.createElement('input');
            title.classList.add('titulo');
            title.value = titleValue;
            title.setAttribute('id', 'note-title-'+newNoteID);
            title.onclick = (event) => {
                noteTitleOnclick(event);
            }

            let text = document.createElement('textarea');
            text.setAttribute('rows', 2);
            text.value = contentValue;
            if(text.value[text.value.length - 1] != '\n')
                text.value += '\n';
            text.setAttribute('id', 'note-content-'+newNoteID);
            text.onclick = (event) => {
                notecontetOnclick(event);
            }
            text.oninput = (event) => {
                showSaveButton(newNoteID);
            }
            let maxRows = 10;
            var rows = (text.value.match(/\n/g) || []).length;
            if(rows > maxRows)
                rows = maxRows;
            text.setAttribute('rows', rows + 1);

            let button = document.createElement('button');
            button.setAttribute('type', 'button');
            button.innerHTML = 'Salvar';
            button.setAttribute('id', 'btn-salvar-'+newNoteID);
            button.style.display = 'none';
            button.onclick = (event) => {
                updateNote(event, newNoteID);
            }

            newNote.appendChild(title);
            newNote.appendChild(text);
            newNote.appendChild(button);

            list.insertBefore(newNote, list.firstChild);
        }


        async function appendNewNote(workdayID){
            let newNoteID = await createNote(workdayID);

            if(newNoteID != false){
                insertNote(newNoteID);
            }
        }

        async function createNote(workdayID){
            let token = $('meta[name="csrf-token"]').attr("content");
            var baseurl = window.location.origin;

            return $.ajax({
                url: baseurl + "/note/ajax/store",
                type: "POST",
                data: {
                    id: workdayID,
                    _token: token
                }
            })
            .done(function(res) {
                res.data = JSON.parse(res.data);
                console.log(res);
                return res.data.id;
            })
            .fail(function(res) {
                console.log(res);
                return false;
            })
            .always(function(res) {
                console.log(res);
            });

            return false;
        }

        function showSaveButton(noteID){
            let btnSalvar = document.getElementById('btn-salvar-'+noteID);
            btnSalvar.style.display = 'block';
        }
        function updateNote(e, noteID){
            let token = $('meta[name="csrf-token"]').attr("content");
            var baseurl = window.location.origin;

            return $.ajax({
                url: baseurl + "/note/ajax/update",
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
