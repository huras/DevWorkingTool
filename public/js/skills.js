class Skill {
    constructor(id, name, icon, notes = []) {
        this.id = id;
        this.name = name;
        this.icon = icon;
        this.notes = notes;
    }

    static async getSkillDetails(id){
        return $.ajax({
            method: 'GET',
            url: '/skill/ajax/get',
            data: {
                id: id
            }
        }).always(function(res){
            // console.log(res);
        });
    }

    buildMenuFromNotes(){
        let menu = document.createElement('div');
        this.notes.map(note => {
            if(note.title != ''){
                let item = document.createElement('a');
                item.classList.add('w-100');
                item.innerHTML = note.title;
                menu.appendChild(item);
            }
        })
        return menu;
    }
}

async function openSkillInModal(skill) {
    console.log(await Skill.getSkillDetails(skill.id));

    let modal = document.getElementById("skill-modal");
    let title = modal.querySelector(".modal-title");
    title.innerHTML = skill.name;

    let icone = modal.querySelector(".title-icon");
    icone.setAttribute("src", skill.icon);

    let body = modal.querySelector(".modal-body");
    body.innerHTML = "";

    body.appendChild(skill.buildMenuFromNotes());
    skill.notes.map(item => {
        let note = new Note(item.title, item.content, item.id);
        let newSlot = note.createSlot();
        body.appendChild(newSlot);
    });

    $("#skill-modal").modal("show");
}

let listTargetID = "skill-listing";
function insertSkillSlot(skill) {
    let icone = document.createElement("img");
    icone.setAttribute("src", skill.icon);
    icone.classList.add("icone");

    let titulo = document.createElement("div");
    titulo.innerHTML = skill.name;

    let slot = document.createElement("div");
    slot.classList.add("slot");
    slot.appendChild(icone);
    slot.appendChild(titulo);
    slot.addEventListener("click", function() {
        openSkillInModal(skill);
    });

    let list = document.getElementById(listTargetID);
    list.appendChild(slot);
}
