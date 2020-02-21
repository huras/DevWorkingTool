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
        menu.classList.add('title-index')
        this.notes.map(note => {
            if(note.title != ''){
                let icon = document.createElement('img');
                icon.src = this.icon;
                icon.classList.add('icon');

                let title = document.createElement('span');
                title.innerHTML = note.title;
                title.classList.add('title');

                let item = document.createElement('a');
                item.classList.add('slot');
                item.classList.add('w-100');
                const noteID = '#note-'+note.id;
                item.href = noteID;
                item.onclick = () => {
                    let noteSlot = document.querySelector(noteID);
                    noteSlot.classList.add('highlited');

                    setTimeout(() => {
                        noteSlot.classList.remove('highlited');
                    }, 1500);
                };
                item.appendChild(icon);
                item.appendChild(title);

                menu.appendChild(item);
            }
        })
        return menu;
    }

    // Notes
    async newNote(){
        const newNoteRes = await Note.createNoteForSkill(this.id);
        const newNoteData = newNoteRes.data;
        let note = new Note(newNoteData.title, newNoteData.content, newNoteData.id);
        this.notes.push(note);
        return note;
    }
}

async function openSkillInModal(skill) {
    // let updatedSkill = await Skill.getSkillDetails(skill.id);
    // console(updatedSkill);
    // if(updatedSkill){
    //     // skill = new Skill(updatedSkill)
    // }

    let modal = document.getElementById("skill-modal");
    let title = modal.querySelector(".modal-title");
    title.innerHTML = skill.name;

    let icone = modal.querySelector(".title-icon");
    icone.setAttribute("src", skill.icon);

    let body = modal.querySelector(".modal-body");
    body.innerHTML = "";

    let newNoteBtn = modal.querySelector('.new-note-btn');
    newNoteBtn.onclick = async () => {
        let newNote = await skill.newNote();
        let newSlot = newNote.createSlot();
        body.appendChild(newSlot);
    };

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
