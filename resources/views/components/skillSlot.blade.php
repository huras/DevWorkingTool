<script>
    if(!skills){
        let skills = [];
    }
    skills.push(new Skill({{$skill->id}}, '{{$skill->name}}', '{{$skill->icon}}'));
</script>

<a class='skill-slot' href='{{route('skill.view', ['id' => $skill->id])}}'>
    <img src="{{$skill->icon}}" alt="" class='icone'>
    <div class='titulo'>
        {{$skill->name}}
    </div>
</a>
