<div class='skill-sidebar'>
    <input type="text" class='w-100' placeholder="Digite para pesquisar..." style='min-height: 40px; padding-left: 8px;'>
    <table class='w-100' id='sidebar-skills-table'>
        <thead>
            <th></th>
        </thead>
        <tbody>
            @foreach ($skills as $item)
                <tr>
                    <td>
                        <div class='slot @if($item["id"] == $skill["id"]) active @endif' id='skill-sidebar-slot-{{$item["id"]}}'>
                            <div class='head'>
                                <div class='face' onclick='window.location = "/skill/view/{{$item["id"]}}"'>
                                    <div class='sidebar-skill-icon'>
                                        <img src="/storage/skill/thumbnail/{{$item->icon}}" style='height: 30px; width: auto; margin-right: 8px;' alt="">
                                    </div>
                                    <div> {{$item->name}} </div>
                                </div>
                                <div class='actions'>
                                    @if(count($item->childrens) > 0)
                                        <span 
                                            class='action'
                                            style="border: none; background-color:transparent; padding: 0;" 
                                            type="button"
                                            data-toggle="collapse" 
                                            data-target="#skill-sidebar-childrenlist-{{$item["id"]}}" {{-- Who will be collapsed --}}
                                            aria-expanded="false" 
                                            aria-controls="skill-sidebar-childrenlist-{{$item["id"]}}" {{-- Who will be collapsed --}}
                                        >
                                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="level-down-alt" class="svg-inline--fa fa-level-down-alt fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M313.553 392.331L209.587 504.334c-9.485 10.214-25.676 10.229-35.174 0L70.438 392.331C56.232 377.031 67.062 352 88.025 352H152V80H68.024a11.996 11.996 0 0 1-8.485-3.515l-56-56C-4.021 12.926 1.333 0 12.024 0H208c13.255 0 24 10.745 24 24v328h63.966c20.878 0 31.851 24.969 17.587 40.331z"></path></svg>
                                        </span>
                                    @endif
                                    <span class='action'>
                                    </span>
                                </div>
                            </div>
                            <div class='gaveta collapse w-100'
                                id='skill-sidebar-childrenlist-{{$item["id"]}}'
                                data-parent="#skill-sidebar-slot-{{$item["id"]}}" {{-- the parent of the div to be collapsed --}}
                            >
                                <div class='childrens'>
                                    @foreach ($item->childrens as $childrenSkill)
                                        <div id='children-skill-slot-{{$childrenSkill->id}}' class='children-slot' onclick='window.location = "/skill/view/{{$childrenSkill["id"]}}"'>
                                            <div style="min-width: 30px; min-height: 40px; display: flex; justify-content: center; align-items: center;">
                                                <img src="/storage/skill/thumbnail/{{$childrenSkill->icon}}" style='height: 30px; width: auto; margin-right: 8px;' alt="">
                                            </div>
                                            <div> {{$childrenSkill->name}} </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>