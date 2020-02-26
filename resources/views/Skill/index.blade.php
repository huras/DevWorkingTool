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
            <div>ou</div>
            <label for="">Icone url:
                <input type="text" name='icon-url' value='{{old('icon-url')}}'>
            </label>
            @error('icon-url')
                <span class='text-danger'>{{ $message }}</span>
            @enderror
        </div>
        <input type="submit">
    </form>

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

                {{-- Actions --}}
                <div class='modal-actions'>
                    <button type="button" title="New Block" class='new-block-btn btn'>
                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="cubes" class="adicao svg-inline--fa fa-cubes fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M488.6 250.2L392 214V105.5c0-15-9.3-28.4-23.4-33.7l-100-37.5c-8.1-3.1-17.1-3.1-25.3 0l-100 37.5c-14.1 5.3-23.4 18.7-23.4 33.7V214l-96.6 36.2C9.3 255.5 0 268.9 0 283.9V394c0 13.6 7.7 26.1 19.9 32.2l100 50c10.1 5.1 22.1 5.1 32.2 0l103.9-52 103.9 52c10.1 5.1 22.1 5.1 32.2 0l100-50c12.2-6.1 19.9-18.6 19.9-32.2V283.9c0-15-9.3-28.4-23.4-33.7zM358 214.8l-85 31.9v-68.2l85-37v73.3zM154 104.1l102-38.2 102 38.2v.6l-102 41.4-102-41.4v-.6zm84 291.1l-85 42.5v-79.1l85-38.8v75.4zm0-112l-102 41.4-102-41.4v-.6l102-38.2 102 38.2v.6zm240 112l-85 42.5v-79.1l85-38.8v75.4zm0-112l-102 41.4-102-41.4v-.6l102-38.2 102 38.2v.6z"></path></svg>
                    </button>
                    <button type="button" title="New Note" class='new-note-btn btn'>
                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="cube" class="adicao svg-inline--fa fa-cube fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M239.1 6.3l-208 78c-18.7 7-31.1 25-31.1 45v225.1c0 18.2 10.3 34.8 26.5 42.9l208 104c13.5 6.8 29.4 6.8 42.9 0l208-104c16.3-8.1 26.5-24.8 26.5-42.9V129.3c0-20-12.4-37.9-31.1-44.9l-208-78C262 2.2 250 2.2 239.1 6.3zM256 68.4l192 72v1.1l-192 78-192-78v-1.1l192-72zm32 356V275.5l160-65v133.9l-160 80z"></path></svg>
                    </button>
                </div>

                {{-- Body --}}
                <div class="modal-body">

                </div>

                {{-- Footer --}}
                <div class="modal-footer">
                    {{-- <div class='actions'>
                        <button type="button" title="New Block" class='new-block-btn btn'>
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="cubes" class="adicao svg-inline--fa fa-cubes fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M488.6 250.2L392 214V105.5c0-15-9.3-28.4-23.4-33.7l-100-37.5c-8.1-3.1-17.1-3.1-25.3 0l-100 37.5c-14.1 5.3-23.4 18.7-23.4 33.7V214l-96.6 36.2C9.3 255.5 0 268.9 0 283.9V394c0 13.6 7.7 26.1 19.9 32.2l100 50c10.1 5.1 22.1 5.1 32.2 0l103.9-52 103.9 52c10.1 5.1 22.1 5.1 32.2 0l100-50c12.2-6.1 19.9-18.6 19.9-32.2V283.9c0-15-9.3-28.4-23.4-33.7zM358 214.8l-85 31.9v-68.2l85-37v73.3zM154 104.1l102-38.2 102 38.2v.6l-102 41.4-102-41.4v-.6zm84 291.1l-85 42.5v-79.1l85-38.8v75.4zm0-112l-102 41.4-102-41.4v-.6l102-38.2 102 38.2v.6zm240 112l-85 42.5v-79.1l85-38.8v75.4zm0-112l-102 41.4-102-41.4v-.6l102-38.2 102 38.2v.6z"></path></svg>
                        </button>
                        <button type="button" title="New Note" class='new-note-btn btn'>
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="cube" class="adicao svg-inline--fa fa-cube fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M239.1 6.3l-208 78c-18.7 7-31.1 25-31.1 45v225.1c0 18.2 10.3 34.8 26.5 42.9l208 104c13.5 6.8 29.4 6.8 42.9 0l208-104c16.3-8.1 26.5-24.8 26.5-42.9V129.3c0-20-12.4-37.9-31.1-44.9l-208-78C262 2.2 250 2.2 239.1 6.3zM256 68.4l192 72v1.1l-192 78-192-78v-1.1l192-72zm32 356V275.5l160-65v133.9l-160 80z"></path></svg>
                        </button>
                    </div> --}}

                    {{-- <div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Dismiss</button>
                        <button type="button" class="btn btn-primary btn-page">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="file" class="page-icon svg-inline--fa fa-file fa-w-12" role="img" viewBox="0 0 384 512"><path d="M224 136V0H24C10.7 0 0 10.7 0 24v464c0 13.3 10.7 24 24 24h336c13.3 0 24-10.7 24-24V160H248c-13.2 0-24-10.8-24-24zm160-14.1v6.1H256V0h6.1c6.4 0 12.5 2.5 17 7l97.9 98c4.5 4.5 7 10.6 7 16.9z"/></svg>
                        </button>
                    </div> --}}
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
                let skills = [];
            </script>
            @foreach ($skills as $skill)
                <div class='skill-row'>
                    @include('components.skillSlot', ['skill' => $skill, ])
                    <div class='actions'>

                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
