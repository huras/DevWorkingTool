@extends('Layout.default')

@section('content')
    <script src="{{asset('/js/notes.js')}}"></script>
    <script src="{{asset('/js/skills.js')}}"></script>

    <!-- Skill Modal -->
    <?php $skillModalID = 'skill-modal' ?>
    <div class="modal fade skill-modal" id="{{$skillModalID}}" tabindex="-1" role="dialog" aria-labelledby="{{$skillModalID}}Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                {{-- Header --}}
                <div class="modal-header">
                    <img src="" alt="" class='title-icon'>
                    <h5 class="modal-title" id="{{$skillModalID}}Label">
                        Modal title
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {{-- Body --}}
                <div class="modal-body">

                </div>

                {{-- Footer --}}
                <div class="modal-footer">
                    <div class='actions'>
                        <button type="button" title="New Note" class='new-note-btn'>
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="cube" class="new-note svg-inline--fa fa-cube fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M239.1 6.3l-208 78c-18.7 7-31.1 25-31.1 45v225.1c0 18.2 10.3 34.8 26.5 42.9l208 104c13.5 6.8 29.4 6.8 42.9 0l208-104c16.3-8.1 26.5-24.8 26.5-42.9V129.3c0-20-12.4-37.9-31.1-44.9l-208-78C262 2.2 250 2.2 239.1 6.3zM256 68.4l192 72v1.1l-192 78-192-78v-1.1l192-72zm32 356V275.5l160-65v133.9l-160 80z"></path></svg>
                        </button>
                    </div>

                    <div>
                        {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Dismiss</button> --}}
                        <button type="button" class="btn btn-primary btn-page">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="file" class="page-icon svg-inline--fa fa-file fa-w-12" role="img" viewBox="0 0 384 512"><path d="M224 136V0H24C10.7 0 0 10.7 0 24v464c0 13.3 10.7 24 24 24h336c13.3 0 24-10.7 24-24V160H248c-13.2 0-24-10.8-24-24zm160-14.1v6.1H256V0h6.1c6.4 0 12.5 2.5 17 7l97.9 98c4.5 4.5 7 10.6 7 16.9z"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Page contents --}}
    <section class='container'>
        <div style='text-align: center; width: 100%; margin-top: 8px;'>
            <h3>All Skills</h3>
        </div>
        <div class='skill-listing' id='skill-listing'>
            <script>
                let skill = null, notes = [];
                @foreach ($skills as $skill)
                    notes = [
                        @foreach($skill->notes as $note)
                            {
                                id: {{$note->id}},
                                title: `{{$note->title}}`,
                                content: `{{$note->content}}`,
                            },
                        @endforeach
                    ];
                    skill = new Skill({{$skill->id}}, '{{$skill->name}}', '{{$skill->icon}}', notes);
                    insertSkillSlot(skill);
                @endforeach
            </script>
        </div>
    </section>
@endsection
