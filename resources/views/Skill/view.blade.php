@extends('Layout.default')

@section('title') DWT - {{$skill->name}} @endsection


@section('favicon') <link rel="icon" type="image/png" href="/storage/skill/thumbnail/{{$skill->icon}}" /> @endsection

@section('content')

<section class='w-100 main-section'>
    @include('components.skillSidebar')
    <div class='main-body w-100'>
        <div class='d-flex flex-column justify-content-center align-items-center'>
            <h1> {{$skill->name}} </h1>
            <div class='img-wrapper'>
                <img src="/storage/skill/{{$skill->icon}}" style='height: 150px; width: auto; margin-right: 8px;' alt="">
            </div>
        </div>
        <hr class='w-100'>

        <div class='actions'>            
            <a href="/block/newEmpty/skill/{{$skill->id}}">
                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="cubes" class="svg-inline--fa fa-cubes fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M488.6 250.2L392 214V105.5c0-15-9.3-28.4-23.4-33.7l-100-37.5c-8.1-3.1-17.1-3.1-25.3 0l-100 37.5c-14.1 5.3-23.4 18.7-23.4 33.7V214l-96.6 36.2C9.3 255.5 0 268.9 0 283.9V394c0 13.6 7.7 26.1 19.9 32.2l100 50c10.1 5.1 22.1 5.1 32.2 0l103.9-52 103.9 52c10.1 5.1 22.1 5.1 32.2 0l100-50c12.2-6.1 19.9-18.6 19.9-32.2V283.9c0-15-9.3-28.4-23.4-33.7zM358 214.8l-85 31.9v-68.2l85-37v73.3zM154 104.1l102-38.2 102 38.2v.6l-102 41.4-102-41.4v-.6zm84 291.1l-85 42.5v-79.1l85-38.8v75.4zm0-112l-102 41.4-102-41.4v-.6l102-38.2 102 38.2v.6zm240 112l-85 42.5v-79.1l85-38.8v75.4zm0-112l-102 41.4-102-41.4v-.6l102-38.2 102 38.2v.6z"></path></svg>
                <span>
                    New empty block
                </span>
            </a>
        </div>
        <hr class='w-100'>

        <div class='skil-index row'>
            @php
                $index = [];
                $index['typesIds'] = [];
                $index['skillGroups'] = [];
                foreach($skill->blocks()->orderBy('title', 'asc')->get() as $block){
                    $needle = '';
                    $relatedSkills = [];
                    $relatedSkillIds = [];
                    foreach ($block->skills()->orderBy('name', 'asc')->get() as $_skill){
                        $relatedSkillIds[] = $_skill->id;   
                        $relatedSkills[] = $_skill;
                        // <a href="/skill/view/{{$_skill->id}}" class='block-skill-link' title='{{$_skill->name}}'>
                        //     <img  skill-id='{{$_skill->id}}' src="/storage/skill/thumbnail/{{$_skill->icon}}">
                        // </a>
                    }
                    sort($relatedSkillIds);
                    $needle = $relatedSkillIds;

                    if(!in_array($needle, $index['typesIds'])){
                        $index['typesIds'][] = $needle;
                        $index['skillGroups'][] = ['skills' => $relatedSkills, 'blocks' => [$block]];
                    } else {
                        $index['skillGroups'][array_search($needle, $index['typesIds'])]['blocks'][] = $block;
                    }
                }
                
            @endphp
            @foreach ($index['skillGroups'] as $group)
                <div class='col-lg-4 col-md-6 col-12 skillGroup-slot'>
                    <div class='d-flex flex-column x-left w-100'>
                        <div class='d-flex w-100' style='margin-right: 4px;'>
                            @foreach ($group['skills'] as $_skill)
                                <img style='height: 24px; width: auto; margin-right: 4px;' src="/storage/skill/thumbnail/{{$_skill->icon}}">
                            @endforeach
                        </div>
                        <div class='d-flex flex-column x-left w-100'>
                            @foreach ($group['blocks'] as $_block)
                                <div class='d-flex'>
                                    {{-- <div class='d-flex' style='margin-right: 4px;'>
                                        @foreach ($group['skills'] as $_skill)
                                            <div class='d-flex flex-column x-left'>
                                                <img style='height: 16px; width: auto; margin-right: 2px;' src="/storage/skill/thumbnail/{{$_skill->icon}}">
                                            </div>
                                        @endforeach
                                    </div> --}}
                                    <a href='#block-slot-{{$_block->id}}'> * {{$_block->title}} </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <hr>
                </div>
            @endforeach
        </div>

        <hr>

        <h2> <span> <img src="/storage/skill/{{$skill->icon}}" style='height: 45px; width: auto; margin-right: 8px;' alt=""> </span>Contents</h2>
        <div class='skill-contents'>
            @foreach ($skill->blocks()->orderBy('updated_at','desc')->get() as $block)
                <div class='block-slot' id='block-slot-{{$block->id}}'>
                    <div class='actions'>
                        <div style='display:inline;' class='main' style='marign-right: 4px;'>
                            <svg style='fill: #7655be;' aria-hidden="true" focusable="false" data-prefix="fas" data-icon="cubes" class="svg-inline--fa fa-cubes fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M488.6 250.2L392 214V105.5c0-15-9.3-28.4-23.4-33.7l-100-37.5c-8.1-3.1-17.1-3.1-25.3 0l-100 37.5c-14.1 5.3-23.4 18.7-23.4 33.7V214l-96.6 36.2C9.3 255.5 0 268.9 0 283.9V394c0 13.6 7.7 26.1 19.9 32.2l100 50c10.1 5.1 22.1 5.1 32.2 0l103.9-52 103.9 52c10.1 5.1 22.1 5.1 32.2 0l100-50c12.2-6.1 19.9-18.6 19.9-32.2V283.9c0-15-9.3-28.4-23.4-33.7zM358 214.8l-85 31.9v-68.2l85-37v73.3zM154 104.1l102-38.2 102 38.2v.6l-102 41.4-102-41.4v-.6zm84 291.1l-85 42.5v-79.1l85-38.8v75.4zm0-112l-102 41.4-102-41.4v-.6l102-38.2 102 38.2v.6zm240 112l-85 42.5v-79.1l85-38.8v75.4zm0-112l-102 41.4-102-41.4v-.6l102-38.2 102 38.2v.6z"></path></svg>
                        </div>

                        <span style="margin:0px 10px 0px 6px; color: #aaaaaa;">|</span>

                        <span class='action collapsed' title='Expand/Collapse' onclick='afterExpandCollapse({{$block->id}})' style='border: none; background-color:transparent; padding: 0;' type="button" data-toggle="collapse" data-target="#block-body-{{$block->id}}" aria-expanded="false" aria-controls="block-body-{{$block->id}}">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-down" class="btn-show svg-inline--fa fa-caret-down fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z"></path></svg>
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-up" style='display:none;' class="btn-hide svg-inline--fa fa-caret-up fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M288.662 352H31.338c-17.818 0-26.741-21.543-14.142-34.142l128.662-128.662c7.81-7.81 20.474-7.81 28.284 0l128.662 128.662c12.6 12.599 3.676 34.142-14.142 34.142z"></path></svg>
                        </span>

                        <span class='action collapsed toggler' title='Expand/Collapse' onclick='afterExpandCollapse({{$block->id}})' style='border: none; background-color:transparent; padding: 0;' type="button" data-toggle="collapse" data-target="#block-body-{{$block->id}}" aria-expanded="false" aria-controls="block-body-{{$block->id}}">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-down" class="btn-show svg-inline--fa fa-caret-down fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z"></path></svg>
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-up" style='display:none;' class="btn-hide svg-inline--fa fa-caret-up fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M288.662 352H31.338c-17.818 0-26.741-21.543-14.142-34.142l128.662-128.662c7.81-7.81 20.474-7.81 28.284 0l128.662 128.662c12.6 12.599 3.676 34.142-14.142 34.142z"></path></svg>
                        </span>

                        <span title='Save block' onclick="updateBlockTitle({{$block->id}})">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="save" class="svg-inline--fa fa-save fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M433.941 129.941l-83.882-83.882A48 48 0 0 0 316.118 32H48C21.49 32 0 53.49 0 80v352c0 26.51 21.49 48 48 48h352c26.51 0 48-21.49 48-48V163.882a48 48 0 0 0-14.059-33.941zM224 416c-35.346 0-64-28.654-64-64 0-35.346 28.654-64 64-64s64 28.654 64 64c0 35.346-28.654 64-64 64zm96-304.52V212c0 6.627-5.373 12-12 12H76c-6.627 0-12-5.373-12-12V108c0-6.627 5.373-12 12-12h228.52c3.183 0 6.235 1.264 8.485 3.515l3.48 3.48A11.996 11.996 0 0 1 320 111.48z"></path></svg>
                        </span>
                        {{-- <span title='Change block type' onclick="updateBlockType({{$block->id}})">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="cogs" class="svg-inline--fa fa-cogs fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M512.1 191l-8.2 14.3c-3 5.3-9.4 7.5-15.1 5.4-11.8-4.4-22.6-10.7-32.1-18.6-4.6-3.8-5.8-10.5-2.8-15.7l8.2-14.3c-6.9-8-12.3-17.3-15.9-27.4h-16.5c-6 0-11.2-4.3-12.2-10.3-2-12-2.1-24.6 0-37.1 1-6 6.2-10.4 12.2-10.4h16.5c3.6-10.1 9-19.4 15.9-27.4l-8.2-14.3c-3-5.2-1.9-11.9 2.8-15.7 9.5-7.9 20.4-14.2 32.1-18.6 5.7-2.1 12.1.1 15.1 5.4l8.2 14.3c10.5-1.9 21.2-1.9 31.7 0L552 6.3c3-5.3 9.4-7.5 15.1-5.4 11.8 4.4 22.6 10.7 32.1 18.6 4.6 3.8 5.8 10.5 2.8 15.7l-8.2 14.3c6.9 8 12.3 17.3 15.9 27.4h16.5c6 0 11.2 4.3 12.2 10.3 2 12 2.1 24.6 0 37.1-1 6-6.2 10.4-12.2 10.4h-16.5c-3.6 10.1-9 19.4-15.9 27.4l8.2 14.3c3 5.2 1.9 11.9-2.8 15.7-9.5 7.9-20.4 14.2-32.1 18.6-5.7 2.1-12.1-.1-15.1-5.4l-8.2-14.3c-10.4 1.9-21.2 1.9-31.7 0zm-10.5-58.8c38.5 29.6 82.4-14.3 52.8-52.8-38.5-29.7-82.4 14.3-52.8 52.8zM386.3 286.1l33.7 16.8c10.1 5.8 14.5 18.1 10.5 29.1-8.9 24.2-26.4 46.4-42.6 65.8-7.4 8.9-20.2 11.1-30.3 5.3l-29.1-16.8c-16 13.7-34.6 24.6-54.9 31.7v33.6c0 11.6-8.3 21.6-19.7 23.6-24.6 4.2-50.4 4.4-75.9 0-11.5-2-20-11.9-20-23.6V418c-20.3-7.2-38.9-18-54.9-31.7L74 403c-10 5.8-22.9 3.6-30.3-5.3-16.2-19.4-33.3-41.6-42.2-65.7-4-10.9.4-23.2 10.5-29.1l33.3-16.8c-3.9-20.9-3.9-42.4 0-63.4L12 205.8c-10.1-5.8-14.6-18.1-10.5-29 8.9-24.2 26-46.4 42.2-65.8 7.4-8.9 20.2-11.1 30.3-5.3l29.1 16.8c16-13.7 34.6-24.6 54.9-31.7V57.1c0-11.5 8.2-21.5 19.6-23.5 24.6-4.2 50.5-4.4 76-.1 11.5 2 20 11.9 20 23.6v33.6c20.3 7.2 38.9 18 54.9 31.7l29.1-16.8c10-5.8 22.9-3.6 30.3 5.3 16.2 19.4 33.2 41.6 42.1 65.8 4 10.9.1 23.2-10 29.1l-33.7 16.8c3.9 21 3.9 42.5 0 63.5zm-117.6 21.1c59.2-77-28.7-164.9-105.7-105.7-59.2 77 28.7 164.9 105.7 105.7zm243.4 182.7l-8.2 14.3c-3 5.3-9.4 7.5-15.1 5.4-11.8-4.4-22.6-10.7-32.1-18.6-4.6-3.8-5.8-10.5-2.8-15.7l8.2-14.3c-6.9-8-12.3-17.3-15.9-27.4h-16.5c-6 0-11.2-4.3-12.2-10.3-2-12-2.1-24.6 0-37.1 1-6 6.2-10.4 12.2-10.4h16.5c3.6-10.1 9-19.4 15.9-27.4l-8.2-14.3c-3-5.2-1.9-11.9 2.8-15.7 9.5-7.9 20.4-14.2 32.1-18.6 5.7-2.1 12.1.1 15.1 5.4l8.2 14.3c10.5-1.9 21.2-1.9 31.7 0l8.2-14.3c3-5.3 9.4-7.5 15.1-5.4 11.8 4.4 22.6 10.7 32.1 18.6 4.6 3.8 5.8 10.5 2.8 15.7l-8.2 14.3c6.9 8 12.3 17.3 15.9 27.4h16.5c6 0 11.2 4.3 12.2 10.3 2 12 2.1 24.6 0 37.1-1 6-6.2 10.4-12.2 10.4h-16.5c-3.6 10.1-9 19.4-15.9 27.4l8.2 14.3c3 5.2 1.9 11.9-2.8 15.7-9.5 7.9-20.4 14.2-32.1 18.6-5.7 2.1-12.1-.1-15.1-5.4l-8.2-14.3c-10.4 1.9-21.2 1.9-31.7 0zM501.6 431c38.5 29.6 82.4-14.3 52.8-52.8-38.5-29.6-82.4 14.3-52.8 52.8z"></path></svg>
                        </span> --}}

                        {{-- <span style="margin:0px 10px 0px 6px; color: #aaaaaa;">|</span>
                        
                        <span title='Edit private style' onclick="">
                            <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="css3-alt" class="svg-inline--fa fa-css3-alt fa-w-12" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M0 32l34.9 395.8L192 480l157.1-52.2L384 32H0zm313.1 80l-4.8 47.3L193 208.6l-.3.1h111.5l-12.8 146.6-98.2 28.7-98.8-29.2-6.4-73.9h48.9l3.2 38.3 52.6 13.3 54.7-15.4 3.7-61.6-166.3-.5v-.1l-.2.1-3.6-46.3L193.1 162l6.5-2.7H76.7L70.9 112h242.2z"></path></svg>
                        </span>
                        <span title='Edit private scripts' onclick="">
                            <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="js" class="svg-inline--fa fa-js fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M0 32v448h448V32H0zm243.8 349.4c0 43.6-25.6 63.5-62.9 63.5-33.7 0-53.2-17.4-63.2-38.5l34.3-20.7c6.6 11.7 12.6 21.6 27.1 21.6 13.8 0 22.6-5.4 22.6-26.5V237.7h42.1v143.7zm99.6 63.5c-39.1 0-64.4-18.6-76.7-43l34.3-19.8c9 14.7 20.8 25.6 41.5 25.6 17.4 0 28.6-8.7 28.6-20.8 0-14.4-11.4-19.5-30.7-28l-10.5-4.5c-30.4-12.9-50.5-29.2-50.5-63.5 0-31.6 24.1-55.6 61.6-55.6 26.8 0 46 9.3 59.8 33.7L368 290c-7.2-12.9-15-18-27.1-18-12.3 0-20.1 7.8-20.1 18 0 12.6 7.8 17.7 25.9 25.6l10.5 4.5c35.8 15.3 55.9 31 55.9 66.2 0 37.8-29.8 58.6-69.7 58.6z"></path></svg>
                        </span>
                        <span title='Edit global scripts and styles' onclick="">
                            <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="file-code" class="svg-inline--fa fa-file-code fa-w-12" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M149.9 349.1l-.2-.2-32.8-28.9 32.8-28.9c3.6-3.2 4-8.8.8-12.4l-.2-.2-17.4-18.6c-3.4-3.6-9-3.7-12.4-.4l-57.7 54.1c-3.7 3.5-3.7 9.4 0 12.8l57.7 54.1c1.6 1.5 3.8 2.4 6 2.4 2.4 0 4.8-1 6.4-2.8l17.4-18.6c3.3-3.5 3.1-9.1-.4-12.4zm220-251.2L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zM256 51.9l76.1 76.1H256zM336 464H48V48h160v104c0 13.3 10.7 24 24 24h104zM209.6 214c-4.7-1.4-9.5 1.3-10.9 6L144 408.1c-1.4 4.7 1.3 9.6 6 10.9l24.4 7.1c4.7 1.4 9.6-1.4 10.9-6L240 231.9c1.4-4.7-1.3-9.6-6-10.9zm24.5 76.9l.2.2 32.8 28.9-32.8 28.9c-3.6 3.2-4 8.8-.8 12.4l.2.2 17.4 18.6c3.3 3.5 8.9 3.7 12.4.4l57.7-54.1c3.7-3.5 3.7-9.4 0-12.8l-57.7-54.1c-3.5-3.3-9.1-3.2-12.4.4l-17.4 18.6c-3.3 3.5-3.1 9.1.4 12.4z"></path></svg>
                        </span> --}}

                        <span style="margin:0px 10px 0px 6px; color: #aaaaaa;">|</span>

                        <span>
                            <a href="/note/newEmpty/block/{{$block->id}}/text" title='New empty text note'>
                                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="align-left" class="svg-inline--fa fa-align-left fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M12.83 352h262.34A12.82 12.82 0 0 0 288 339.17v-38.34A12.82 12.82 0 0 0 275.17 288H12.83A12.82 12.82 0 0 0 0 300.83v38.34A12.82 12.82 0 0 0 12.83 352zm0-256h262.34A12.82 12.82 0 0 0 288 83.17V44.83A12.82 12.82 0 0 0 275.17 32H12.83A12.82 12.82 0 0 0 0 44.83v38.34A12.82 12.82 0 0 0 12.83 96zM432 160H16a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0 256H16a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16z"></path></svg>
                            </a>
                        </span>

                        <span>
                            <a href="/note/newEmpty/block/{{$block->id}}/image" title='New empty image note'>
                                <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="image" class="svg-inline--fa fa-image fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M464 64H48C21.49 64 0 85.49 0 112v288c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V112c0-26.51-21.49-48-48-48zm-6 336H54a6 6 0 0 1-6-6V118a6 6 0 0 1 6-6h404a6 6 0 0 1 6 6v276a6 6 0 0 1-6 6zM128 152c-22.091 0-40 17.909-40 40s17.909 40 40 40 40-17.909 40-40-17.909-40-40-40zM96 352h320v-80l-87.515-87.515c-4.686-4.686-12.284-4.686-16.971 0L192 304l-39.515-39.515c-4.686-4.686-12.284-4.686-16.971 0L96 304v48z"></path></svg>
                            </a>
                        </span>

                        <span>
                            <a href="/note/newEmpty/block/{{$block->id}}/youtube" title='New empty youtube note'>
                                <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="youtube" class="svg-inline--fa fa-youtube fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"></path></svg> 
                            </a>
                        </span>

                        <span onclick='appendNote({{$block->id}}, "html-section")' title='New empty html section'>                            
                            <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="file-code" class="svg-inline--fa fa-file-code fa-w-12" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M149.9 349.1l-.2-.2-32.8-28.9 32.8-28.9c3.6-3.2 4-8.8.8-12.4l-.2-.2-17.4-18.6c-3.4-3.6-9-3.7-12.4-.4l-57.7 54.1c-3.7 3.5-3.7 9.4 0 12.8l57.7 54.1c1.6 1.5 3.8 2.4 6 2.4 2.4 0 4.8-1 6.4-2.8l17.4-18.6c3.3-3.5 3.1-9.1-.4-12.4zm220-251.2L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zM256 51.9l76.1 76.1H256zM336 464H48V48h160v104c0 13.3 10.7 24 24 24h104zM209.6 214c-4.7-1.4-9.5 1.3-10.9 6L144 408.1c-1.4 4.7 1.3 9.6 6 10.9l24.4 7.1c4.7 1.4 9.6-1.4 10.9-6L240 231.9c1.4-4.7-1.3-9.6-6-10.9zm24.5 76.9l.2.2 32.8 28.9-32.8 28.9c-3.6 3.2-4 8.8-.8 12.4l.2.2 17.4 18.6c3.3 3.5 8.9 3.7 12.4.4l57.7-54.1c3.7-3.5 3.7-9.4 0-12.8l-57.7-54.1c-3.5-3.3-9.1-3.2-12.4.4l-17.4 18.6c-3.3 3.5-3.1 9.1.4 12.4z"></path></svg>
                        </span>
                        
                        <span title='Add link to other skill' onclick="linkToOtherSkill({{$block->id}})">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="tag" class="svg-inline--fa fa-tag fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M0 252.118V48C0 21.49 21.49 0 48 0h204.118a48 48 0 0 1 33.941 14.059l211.882 211.882c18.745 18.745 18.745 49.137 0 67.882L293.823 497.941c-18.745 18.745-49.137 18.745-67.882 0L14.059 286.059A48 48 0 0 1 0 252.118zM112 64c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48z"></path></svg>
                        </span>

                        <span style="margin:0px 10px 0px 6px; color: #aaaaaa;">|</span>
                        

                        <div class='skill-logos' id='block-skill-logos-{{$block->id}}'>
                            @foreach ($block->skills as $_skill)
                                <a href="/skill/view/{{$_skill->id}}" class='block-skill-link' title='{{$_skill->name}}'>
                                    <img  skill-id='{{$_skill->id}}' src="/storage/skill/thumbnail/{{$_skill->icon}}">
                                </a>
                            @endforeach
                        </div>

                        <span style="margin:0px 10px 0px 6px; color: #aaaaaa;">|</span>

                        <div style='display:inline;' class='main' title='Contém {{count($block->notes)}} notes'>
                            <svg style='fill: #7655be; max-height: 15px;' aria-hidden="true" focusable="false" data-prefix="fas" data-icon="cube" class="svg-inline--fa fa-cube fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M239.1 6.3l-208 78c-18.7 7-31.1 25-31.1 45v225.1c0 18.2 10.3 34.8 26.5 42.9l208 104c13.5 6.8 29.4 6.8 42.9 0l208-104c16.3-8.1 26.5-24.8 26.5-42.9V129.3c0-20-12.4-37.9-31.1-44.9l-208-78C262 2.2 250 2.2 239.1 6.3zM256 68.4l192 72v1.1l-192 78-192-78v-1.1l192-72zm32 356V275.5l160-65v133.9l-160 80z"></path></svg>
                            <div style='display: inline; margin-right: 4px; margin-left: -12px;'> x <b>{{count($block->notes)}}</b> </div>
                        </div>
                    </div>
                    
                    <input type="text" id='block-title-{{$block->id}}' class='w-100 block-title-input' value='{{$block->title}}' style='text-align: center;'>
                    <br>

                    <div class='block-body collapse w-100' id='block-body-{{$block->id}}' data-parent="#block-slot-{{$block->id}}">
                        @foreach ($block->notes as $note)
                            <div class='note-slot {{$note->type}}' id='note-slot-{{$note->id}}'>
                                <div class='header w-100'>
                                    <div class='actions hidden'>
                                        <div title='Show/Hide actions' style='display:inline;' class='main' onclick='(document.querySelector("#note-slot-{{$note->id}} .actions")).classList.toggle("hidden");'>
                                            <svg style='fill: #7655be;' aria-hidden="true" focusable="false" data-prefix="fas" data-icon="cube" class="svg-inline--fa fa-cube fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M239.1 6.3l-208 78c-18.7 7-31.1 25-31.1 45v225.1c0 18.2 10.3 34.8 26.5 42.9l208 104c13.5 6.8 29.4 6.8 42.9 0l208-104c16.3-8.1 26.5-24.8 26.5-42.9V129.3c0-20-12.4-37.9-31.1-44.9l-208-78C262 2.2 250 2.2 239.1 6.3zM256 68.4l192 72v1.1l-192 78-192-78v-1.1l192-72zm32 356V275.5l160-65v133.9l-160 80z"></path></svg>
                                        </div>
                                        <span title='Save note' id='note-action-save-{{$note->id}}' class='hidden' onclick="updateNote({{$note->id}})">
                                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="save" class="svg-inline--fa fa-save fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M433.941 129.941l-83.882-83.882A48 48 0 0 0 316.118 32H48C21.49 32 0 53.49 0 80v352c0 26.51 21.49 48 48 48h352c26.51 0 48-21.49 48-48V163.882a48 48 0 0 0-14.059-33.941zM224 416c-35.346 0-64-28.654-64-64 0-35.346 28.654-64 64-64s64 28.654 64 64c0 35.346-28.654 64-64 64zm96-304.52V212c0 6.627-5.373 12-12 12H76c-6.627 0-12-5.373-12-12V108c0-6.627 5.373-12 12-12h228.52c3.183 0 6.235 1.264 8.485 3.515l3.48 3.48A11.996 11.996 0 0 1 320 111.48z"></path></svg>
                                        </span>
                                        <span title='Edit note' onclick="editNote({{$note->id}})" id='note-action-edit-{{$note->id}}'>
                                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pencil-alt" class="svg-inline--fa fa-pencil-alt fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M497.9 142.1l-46.1 46.1c-4.7 4.7-12.3 4.7-17 0l-111-111c-4.7-4.7-4.7-12.3 0-17l46.1-46.1c18.7-18.7 49.1-18.7 67.9 0l60.1 60.1c18.8 18.7 18.8 49.1 0 67.9zM284.2 99.8L21.6 362.4.4 483.9c-2.9 16.4 11.4 30.6 27.8 27.8l121.5-21.3 262.6-262.6c4.7-4.7 4.7-12.3 0-17l-111-111c-4.8-4.7-12.4-4.7-17.1 0zM124.1 339.9c-5.5-5.5-5.5-14.3 0-19.8l154-154c5.5-5.5 14.3-5.5 19.8 0s5.5 14.3 0 19.8l-154 154c-5.5 5.5-14.3 5.5-19.8 0zM88 424h48v36.3l-64.5 11.3-31.1-31.1L51.7 376H88v48z"></path></svg>
                                        </span>
                                        <span title='Change note type' onclick="prepareNoteTypeChange({{$note->id}})">
                                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="cogs" class="svg-inline--fa fa-cogs fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M512.1 191l-8.2 14.3c-3 5.3-9.4 7.5-15.1 5.4-11.8-4.4-22.6-10.7-32.1-18.6-4.6-3.8-5.8-10.5-2.8-15.7l8.2-14.3c-6.9-8-12.3-17.3-15.9-27.4h-16.5c-6 0-11.2-4.3-12.2-10.3-2-12-2.1-24.6 0-37.1 1-6 6.2-10.4 12.2-10.4h16.5c3.6-10.1 9-19.4 15.9-27.4l-8.2-14.3c-3-5.2-1.9-11.9 2.8-15.7 9.5-7.9 20.4-14.2 32.1-18.6 5.7-2.1 12.1.1 15.1 5.4l8.2 14.3c10.5-1.9 21.2-1.9 31.7 0L552 6.3c3-5.3 9.4-7.5 15.1-5.4 11.8 4.4 22.6 10.7 32.1 18.6 4.6 3.8 5.8 10.5 2.8 15.7l-8.2 14.3c6.9 8 12.3 17.3 15.9 27.4h16.5c6 0 11.2 4.3 12.2 10.3 2 12 2.1 24.6 0 37.1-1 6-6.2 10.4-12.2 10.4h-16.5c-3.6 10.1-9 19.4-15.9 27.4l8.2 14.3c3 5.2 1.9 11.9-2.8 15.7-9.5 7.9-20.4 14.2-32.1 18.6-5.7 2.1-12.1-.1-15.1-5.4l-8.2-14.3c-10.4 1.9-21.2 1.9-31.7 0zm-10.5-58.8c38.5 29.6 82.4-14.3 52.8-52.8-38.5-29.7-82.4 14.3-52.8 52.8zM386.3 286.1l33.7 16.8c10.1 5.8 14.5 18.1 10.5 29.1-8.9 24.2-26.4 46.4-42.6 65.8-7.4 8.9-20.2 11.1-30.3 5.3l-29.1-16.8c-16 13.7-34.6 24.6-54.9 31.7v33.6c0 11.6-8.3 21.6-19.7 23.6-24.6 4.2-50.4 4.4-75.9 0-11.5-2-20-11.9-20-23.6V418c-20.3-7.2-38.9-18-54.9-31.7L74 403c-10 5.8-22.9 3.6-30.3-5.3-16.2-19.4-33.3-41.6-42.2-65.7-4-10.9.4-23.2 10.5-29.1l33.3-16.8c-3.9-20.9-3.9-42.4 0-63.4L12 205.8c-10.1-5.8-14.6-18.1-10.5-29 8.9-24.2 26-46.4 42.2-65.8 7.4-8.9 20.2-11.1 30.3-5.3l29.1 16.8c16-13.7 34.6-24.6 54.9-31.7V57.1c0-11.5 8.2-21.5 19.6-23.5 24.6-4.2 50.5-4.4 76-.1 11.5 2 20 11.9 20 23.6v33.6c20.3 7.2 38.9 18 54.9 31.7l29.1-16.8c10-5.8 22.9-3.6 30.3 5.3 16.2 19.4 33.2 41.6 42.1 65.8 4 10.9.1 23.2-10 29.1l-33.7 16.8c3.9 21 3.9 42.5 0 63.5zm-117.6 21.1c59.2-77-28.7-164.9-105.7-105.7-59.2 77 28.7 164.9 105.7 105.7zm243.4 182.7l-8.2 14.3c-3 5.3-9.4 7.5-15.1 5.4-11.8-4.4-22.6-10.7-32.1-18.6-4.6-3.8-5.8-10.5-2.8-15.7l8.2-14.3c-6.9-8-12.3-17.3-15.9-27.4h-16.5c-6 0-11.2-4.3-12.2-10.3-2-12-2.1-24.6 0-37.1 1-6 6.2-10.4 12.2-10.4h16.5c3.6-10.1 9-19.4 15.9-27.4l-8.2-14.3c-3-5.2-1.9-11.9 2.8-15.7 9.5-7.9 20.4-14.2 32.1-18.6 5.7-2.1 12.1.1 15.1 5.4l8.2 14.3c10.5-1.9 21.2-1.9 31.7 0l8.2-14.3c3-5.3 9.4-7.5 15.1-5.4 11.8 4.4 22.6 10.7 32.1 18.6 4.6 3.8 5.8 10.5 2.8 15.7l-8.2 14.3c6.9 8 12.3 17.3 15.9 27.4h16.5c6 0 11.2 4.3 12.2 10.3 2 12 2.1 24.6 0 37.1-1 6-6.2 10.4-12.2 10.4h-16.5c-3.6 10.1-9 19.4-15.9 27.4l8.2 14.3c3 5.2 1.9 11.9-2.8 15.7-9.5 7.9-20.4 14.2-32.1 18.6-5.7 2.1-12.1-.1-15.1-5.4l-8.2-14.3c-10.4 1.9-21.2 1.9-31.7 0zM501.6 431c38.5 29.6 82.4-14.3 52.8-52.8-38.5-29.6-82.4 14.3-52.8 52.8z"></path></svg>
                                        </span>
                                        <span title='Remove note' onclick="if(confirm(`Deseja mesmo remover a nota '{{$note->title}}'`)) removeNote({{$note->id}})" id='note-action-remove-{{$note->id}}'>
                                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash-alt" class="svg-inline--fa fa-trash-alt fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M32 464a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128H32zm272-256a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zM432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"></path></svg>
                                        </span>
                                    </div>
                                    <input type="hidden" value='{{$note->type}}' id='note-type-{{$note->id}}'>
                                </div>
                                <div class='corpo w-100' id='note-body-{{$note->id}}'>
                                    @switch($note->type)
                                        @case('text')
                                                <div class='note-title' id='note-title-{{$note->id}}'>{!!$note->title!!}</div>
                                                @if($note->title == '.html' || $note->title == '.css' || $note->title == '.js')
                                                    <div class='note-content' id='note-content-{{$note->id}}'>{{$note->content}}</div>
                                                @else
                                                    <div class='note-content' id='note-content-{{$note->id}}'>{!!$note->content!!}</div>
                                                @endif
                                            @break
                                        @case('image')
                                                <img id='note-content-{{$note->id}}' class='note-content' src="/storage/note/thumbnail/{!!$note->content!!}">
                                                <div id='note-title-{{$note->id}}' class='note-title'> {!!$note->title!!} </div>
                                            @break
                                        @case('youtube')
                                                <div id='note-title-{{$note->id}}' class='note-title'> {!!$note->title!!} </div>
                                                @php
                                                    $matches = [];
                                                    preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", 
                                                        $note->content,
                                                        $matches
                                                    );
                                                @endphp
                                                <iframe width="420" height="315" original-url='{{$note->content}}' src="https://www.youtube.com/embed/{{$matches[1]}}">
                                                </iframe>
                                            @break
                                        @case('html-section')
                                                <div id='note-title-{{$note->id}}' class='note-title'> {!!$note->title!!} </div>
                                                @php
                                                    $matches = [];
                                                    preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", 
                                                        $note->content,
                                                        $matches
                                                    );
                                                @endphp
                                                <iframe width="420" height="315" original-url='{{$note->content}}' src="https://www.youtube.com/embed/{{$matches[1]}}">
                                                </iframe>
                                            @break
                                        @default
                                    @endswitch
                                </div>
                            </div>
                            <br>
                            
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Templates --}}
        <template id='text-note-edit-template'>
            <input class="note-title-input" id="note-title-input-ID">
            <textarea class="note-content-input" id="note-content-input-ID">
            </textarea>
        </template>

        <template id='text-note-template'>
            <div class='note-title' id='note-title-ID'></div>
            <div class='note-content' id='note-content-ID'></div>
        </template>
        {{-- End --}}

        <script>
            function getTextNote(id, title, content){
                let textNoteTemplate = document.getElementById("text-note-template").content;
                let newTextNote =  document.importNode(textNoteTemplate,true);
                let titleElement = newTextNote.querySelector('.note-title');
                titleElement.id = 'note-title-'+id;
                titleElement.innerHTML = title;

                let contentElement = newTextNote.querySelector('.note-content');
                contentElement.id = 'note-content-'+id;
                contentElement.innerHTML = content;
                console.log(newTextNote);
            }
            getTextNote(9, 'kkk', 'xD');

            let skills = JSON.parse(`{!!json_encode($skills)!!}`);
            function linkToOtherSkill(idBlock){
                let skillIcons = (document.getElementById('block-skill-logos-'+idBlock)).querySelectorAll('img');
                
                let skillsIn = [];
                for(img of skillIcons){
                    skillsIn.push(img.getAttribute('skill-id'));
                }            

                let wantedSkills = skills.filter((item) => {
                    return (skillsIn.indexOf(item.id+"") == -1);
                });
                let wantedSkillsIDS = wantedSkills.map(skill => {
                    return skill.id+"";
                })
                console.log(wantedSkillsIDS);
                
                $('#block-to-add-skill-link').val(idBlock);

                let options = document.querySelectorAll('#select-new-skill-link option');
                for(option of options){
                    if(wantedSkillsIDS.indexOf(option.getAttribute('value')) == -1){
                        option.setAttribute('disabled', 'disabled');
                    } else {
                        option.removeAttribute('disabled');
                    }
                }


                $('#modal-NewSKillLink').modal('show');
            }
            function addNewSkillLink(idBlock){
                let idSkill = $('#select-new-skill-link').val();
                let skill = (skills.filter(item => { return item.id+"" == idSkill }))[0];
                if(skill){
                    let newSkillSlot = "<a href='/skill/view/"+idSkill+"' class='block-skill-link' title='"+skill.name+"'> <img skill-id="+idSkill+" src='/storage/skill/thumbnail/"+skill.icon+"'> </a>";
                    let skillLogos = document.getElementById('block-skill-logos-'+idBlock);

                    $.ajax({
                        url: '/block/'+idBlock+'/ajax/newSkillLink/'+idSkill,
                        method: 'GET',
                        success: (res) => {
                            if(res.status){
                                skillLogos.innerHTML += newSkillSlot;
                                $('#modal-NewSKillLink').modal('hide');
                            } else {
                                alert('Erro ao adicionar novo link de skill, porfavor tente novamente. (Erro no servidor)');
                            }
                        },
                        error: (res) => {
                            alert('Erro ao adicionar novo link de skill, porfavor tente novamente.');                   
                        }
                    });                
                } else {
                    alert('Sk1ll inválida');
                }
            }

            function afterExpandCollapse(id) {
                setTimeout(() => {
                    let block = document.getElementById('block-slot-'+id);
                    let blockBody = document.getElementById('block-body-'+id);
                    if (blockBody.classList.contains('show')) {
                        for(el of block.querySelectorAll('.btn-show')){
                            el.style.display = 'none';
                        }
                        for(el of block.querySelectorAll('.btn-hide')){
                            el.style.display = 'flex';
                        }
                    } else {
                        block.scrollIntoView();
                        for(el of block.querySelectorAll('.btn-show')){
                            el.style.display = 'flex';
                        }
                        for(el of block.querySelectorAll('.btn-hide')){
                            el.style.display = 'none';
                        }
                    }
                }, 500);
            }

            function prepareNoteTypeChange(id){
                $('#modal-noteType').modal('show');
                $('#note-to-change-type').val(id);
            }

            function updateNoteType(id){
                let noteTypeInput = document.getElementById('note-type-'+id);
                noteTypeInput.value = $('#select-note-type').val();
                console.log(noteTypeInput.value);

                editNote(id);
                updateNote(id);
                $('#modal-noteType').modal('hide');
            }

            let updateBlockTitle = (id) => {
                const blockTitleInput = document.getElementById('block-title-'+id);
                $.ajax({
                    url: '/block/ajax/update',
                    method: 'get',
                    data: {
                        id: id,
                        title: blockTitleInput.value
                    },
                    success: (res) => {
                        console.log(res);
                    },
                    error: (res) => {
                        console.log('erro update block');
                    }
                })
            };

            function updateNote(id) {
                const noteTitle  = document.getElementById('note-title-'+id);
                const noteContent = document.getElementById('note-content-'+id);

                let type = document.getElementById('note-type-'+id).value;            

                let titleInput = document.getElementById('note-title-input-'+id);
                let contentInput = document.getElementById('note-content-input-'+id);
                
                let title = titleInput.value;
                let content = contentInput.value;

                switch (type) {
                    case 'text':
                        noteTitle.innerHTML = title;
                        if(title == '.html' || title == '.css' || title == '.js')
                            noteContent.innerHTML = content.trim();
                        else
                            noteContent.innerHTML = content.trim();
                        
                        break;

                    case 'image':
                        content = contentInput.files[0];
                        noteTitle.innerHTML = title;

                        if(!content)
                            noteContent.setAttribute('src', contentInput.getAttribute('src'));
                        else{
                            // Preview the image
                            var preview = noteContent;
                            var file    = content;
                            var reader  = new FileReader();

                            reader.onloadend = function () {
                                preview.src = reader.result;
                            }

                            if (file) {
                                reader.readAsDataURL(file);
                            } else {
                                preview.src = "";
                            }
                        }
                        
                        // remove form
                        let contentWrapper = contentInput.parentElement;
                        contentWrapper.parentElement.removeChild(contentWrapper);
                        contentInput = null;
                        break;
                
                    default:
                        break;
                }

                const _token = document.querySelector('meta[name=csrf-token]').getAttribute('content');
                console.log(_token);
                var data = new FormData();            
                data.append('id', id);
                data.append('title', title);
                data.append('content', content);
                data.append('type', type);
                data.append('_token', _token);

                noteTitle.classList.remove('hidden');
                noteContent.classList.remove('hidden');

                titleInput.parentElement.removeChild(titleInput);
                if(contentInput)
                contentInput.parentElement.removeChild(contentInput);

                $.ajax({
                    url: '/note/ajax/update',
                    method: 'post',
                    contentType: false, 
                    processData: false, 
                    data: data,
                    success: (res) => {
                        console.log(res);
                    },
                    error: (res) => {
                        console.log('erro update block');
                    }
                }).always((res) => {
                    const editButton = document.getElementById('note-action-edit-'+id);
                    const saveButton = document.getElementById('note-action-save-'+id);
                    saveButton.classList.add('hidden');
                    editButton.classList.remove('hidden');
                })
            };

            function appendNote(blockid, type){
                $.ajax({
                    url: '/note/ajax/newEmpty/block/'+blockid+'/'+type,
                    method: 'GET',
                    success: (res) => {
                        console.log(res);
                    },
                    error: (res) => {
                        alert('Erro ao criar bloco de '+type);
                    }
                });
            }

            let removeNote = (id) => {
                const noteSlot = document.getElementById('note-slot-'+id);
                $.ajax({
                    url: '/note/removeNote/'+id,
                    method: 'get',
                    data: {
                        id: id,
                    },
                    success: (res) => {
                        noteSlot.parentElement.removeChild(noteSlot);
                    },
                    error: (res) => {
                        console.log('erro delete block');
                    }
                });
            }

            let editNote = (id) => {
                const editButton = document.getElementById('note-action-edit-'+id);
                const saveButton = document.getElementById('note-action-save-'+id);
                editButton.classList.add('hidden');
                saveButton.classList.remove('hidden');

                const noteType = document.getElementById('note-type-'+id).value;
                const noteTitle  = document.getElementById('note-title-'+id);
                const noteContent = document.getElementById('note-content-'+id);

                let title = '';
                let content = '';
                let titleInput = undefined;
                let contentInput = undefined;

                const noteSlot = document.getElementById('note-slot-'+id);

                switch (noteType) {
                    case 'text':
                        title = noteTitle.innerHTML;
                        content = noteContent.innerHTML;

                        titleInput = document.createElement('input');
                        titleInput.value = title;
                        titleInput.classList.add('note-title-input');
                        titleInput.id = 'note-title-input-'+id;
                        noteSlot.appendChild(titleInput);

                        contentInput = document.createElement('textarea');
                        contentInput.innerHTML = content.trim();
                        contentInput.classList.add('note-content-input');
                        contentInput.id = 'note-content-input-'+id;
                        contentInput.style.height = (noteContent.clientHeight + 10)+'px';
                        noteSlot.appendChild(contentInput);
                        break;

                    case 'image':
                        title = noteTitle.innerHTML;
                        content = noteContent.getAttribute('src');

                        titleInput = document.createElement('input');
                        titleInput.value = title;
                        titleInput.classList.add('note-title-input');
                        titleInput.id = 'note-title-input-'+id;
                        noteSlot.appendChild(titleInput);

                        let contentWrapper = document.createElement('form');
                        contentWrapper.setAttribute('enctype', 'multipart/form-data');
                        contentWrapper.setAttribute('method', 'get');

                        contentInput = document.createElement('input');
                        contentInput.setAttribute('type','file');
                        contentInput.setAttribute('src', content);
                        contentInput.classList.add('note-content-input');
                        contentInput.id = 'note-content-input-'+id;

                        contentWrapper.appendChild(contentInput);
                        noteSlot.appendChild(contentWrapper);
                        break;
            
                    default:
                        break;
                }

                noteTitle.classList.add('hidden');
                noteContent.classList.add('hidden');
            }
        </script>

        {{-- Modais --}}
        <!-- Modal de tipo de note -->
        <div class="modal fade" id="modal-noteType" tabindex="-1" role="dialog" aria-labelledby="modal-noteTypeLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="modal-noteTypeLabel">Change note type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id='note-to-change-type' value=''>
                    <label for="">Note Type</label>
                    <select name="note-type" id="select-note-type">
                        <option value="text">Text</option>
                        <option value="image">Image</option>
                        <option value="youtube">Youtube</option>
                    </select>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="updateNoteType($('#note-to-change-type').val());">Save</button>
                </div>
            </div>
            </div>
        </div>

        {{-- Modal nova associação skill --}}
        <div class="modal fade" id="modal-NewSKillLink" tabindex="-1" role="dialog" aria-labelledby="modal-NewSKillLinkLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="modal-NewSKillLinkLabel"> Add link to skill </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id='block-to-add-skill-link' value=''>
                    <label for="">Skill</label>
                    <select name="note-type" id="select-new-skill-link">
                        @foreach ($skills as $skill)
                            <option value="{{$skill->id}}">{{$skill->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="addNewSkillLink($('#block-to-add-skill-link').val());">Save</button>
                </div>
            </div>
            </div>
        </div>
    </div>
</section>
@endsection
