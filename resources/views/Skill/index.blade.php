@extends('Layout.default')

@section('content')
    <script src="{{asset('/js/notes.js')}}"></script>
    <script src="{{asset('/js/skills.js')}}"></script>

    <!-- Skill Modal -->
    <?php $skillModalID = 'skill-modal' ?>
    <div class="modal fade skill-modal" id="{{$skillModalID}}" tabindex="-1" role="dialog" aria-labelledby="{{$skillModalID}}Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="" alt="" class='title-icon'>
                    <h5 class="modal-title" id="{{$skillModalID}}Label">
                        Modal title
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Dismiss</button> --}}
                    <button type="button" class="btn btn-primary btn-page">
                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="file" class="page-icon svg-inline--fa fa-file fa-w-12" role="img" viewBox="0 0 384 512"><path d="M224 136V0H24C10.7 0 0 10.7 0 24v464c0 13.3 10.7 24 24 24h336c13.3 0 24-10.7 24-24V160H248c-13.2 0-24-10.8-24-24zm160-14.1v6.1H256V0h6.1c6.4 0 12.5 2.5 17 7l97.9 98c4.5 4.5 7 10.6 7 16.9z"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

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
                    skill = new Skill('{{$skill->name}}', '{{$skill->icon}}', notes);
                    insertSkillSlot(skill);
                @endforeach
            </script>
        </div>
    </section>
@endsection
