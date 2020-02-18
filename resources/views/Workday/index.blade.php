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
        <div style='margin-top: 8px;'>
            <form action="{{route('workday.store')}}">
                <input type="date" name='date'>
                <input type="submit" value='Novo Workday'>
            </form>
        </div>

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

                <div id="workday-notes-list-{{$workday->id}}" class="workday-notes-list <?= $isFirstWorkDay?'collapse show':'collapse' ?>" aria-labelledby="headingTwo" data-parent="#workday-{{$workday->id}}">
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

     <!-- Modal -->
    <?php $modalID = 'modal-associate-note-to-skill' ?>
    <div class="modal fade" id="{{$modalID}}" tabindex="-1" role="dialog" aria-labelledby="{{$modalID}}Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="{{$modalID}}Label"> Associar nota à skill </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" value="" id='note-assoc-id'>
                    <select class="js-example-basic-single w-100" name="state" multiple="multiple" onchange='document.getElementById("salvar-skill-assoc").style.display = "flex"'>
                        @foreach($skills as $skill)
                            <option title='{{$skill->icon}}' value="{{$skill->id}}"> {{$skill->name}} </option>
                        @endforeach
                    </select>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button onclick="saveNoteSkillAssociations();" type="button" style='display: none;' id='salvar-skill-assoc' class="btn btn-primary save-btn">Salvar Mudanças</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('load', () => {
            function formatSkillState(state){
                if(!state.id){
                    return state.text;
                }

                var imgUrl = "/storage/skills/"+state.title;
                var $state = $('<span class="sl2-skill-slot"> <img class="img-flag" /> <span> </span> </span>');

                $state.find("span").text(state.text);
                $state.find("img").attr("src", imgUrl);

                return $state;
            }

            $('.js-example-basic-single').select2({
                width: '100%',
                templateSelection: formatSkillState
            });
        });

        function saveNoteSkillAssociations() {
            var selected = [];
            $('.js-example-basic-single :selected').each(function() {
                selected[$(this).val()] = $(this).text();
            });

            let noteID = document.querySelector('#note-assoc-id').value = newNoteID;
            console.log(selected);

            $.ajax({
                type: "POST",
                url: "/note/ajax/update",
                data: {
                    laboratorios: selected
                },
                cache: true,

                success: function(data) {
                    console.log(data);
                }
            });
        }

        function afterSaveNote(noteID){
            let textarea = document.getElementById('note-content-'+noteID);
            calculateNoteContentRows(textarea);
        }

        function noteTitleOnclick(e){
            let input = e.target;
            if(input.value == '[New Note]'){
                input.select();
            }
        }

        function notecontetOnclick(e){
            let input = e.target;
            if(input.value == '[empty]\n'){
                input.select();
            }
        }

        function calculateNoteContentRows(textarea){
            let maxRows = 10;
            var rows = (textarea.value.match(/\n/g) || []).length;
            if(rows > maxRows)
                rows = maxRows;
            textarea.setAttribute('rows', rows + 1);
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
            title.onfocus = (event) => {
                noteTitleOnclick(event);
            }
            title.oninput = (event) => {
                showSaveButton(newNoteID);
            }

            let text = document.createElement('textarea');
            text.setAttribute('rows', 2);
            text.innerHTML = contentValue;
            if(text.value[text.value.length - 1] != '\n')
                text.value += '\n';
            text.setAttribute('id', 'note-content-'+newNoteID);
            text.onfocus = (event) => {
                notecontetOnclick(event);
            }
            text.oninput = (event) => {
                showSaveButton(newNoteID);
            }
            calculateNoteContentRows(text);

            let btnSalvar = document.createElement('button');
            btnSalvar.setAttribute('type', 'button');
            btnSalvar.innerHTML = 'Salvar';
            btnSalvar.setAttribute('id', 'btn-salvar-'+newNoteID);
            btnSalvar.style.display = 'none';
            btnSalvar.onclick = (event) => {
                updateNote(event, newNoteID);
            }

            let btnAssociateToSkill = document.createElement('button');
            btnAssociateToSkill.setAttribute('type', 'button');
            btnAssociateToSkill.innerHTML = 'Associar skill';
            btnAssociateToSkill.setAttribute('id', 'btn-assoc-skill-'+newNoteID);
            btnAssociateToSkill.onclick = (event) => {
                let modal = document.getElementById('modal-associate-note-to-skill');
                modal.querySelector('#note-assoc-id').value = newNoteID;
                $('#modal-associate-note-to-skill').modal('show');
            }

            newNote.appendChild(title);
            newNote.appendChild(text);
            newNote.appendChild(btnAssociateToSkill);
            newNote.appendChild(btnSalvar);


            list.insertBefore(newNote, list.firstChild);
        }

        async function appendNewNote(workdayID){
            const newNote = await createNote(workdayID);
            const newNoteID = newNote.data.id;

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
                res.data = res.data;
                console.log(res);
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
                afterSaveNote(noteID);
            });
        }

        function newWorkday(){

        }

        // Use tab to indent in textarea
        window.addEventListener('load', () => {
            $(document).delegate('textarea', 'keydown', function(e) {
                var keyCode = e.keyCode || e.which;

                if (keyCode == 9) {
                    e.preventDefault();
                    var start = this.selectionStart;
                    var end = this.selectionEnd;

                    // set textarea value to: text before caret + tab + text after caret
                    $(this).val($(this).val().substring(0, start)
                                + "\t"
                                + $(this).val().substring(end));

                    // put caret at right position again
                    this.selectionStart =
                    this.selectionEnd = start + 1;
                }
            });
        });
    </script>
@endsection
