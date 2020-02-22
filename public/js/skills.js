class Skill {
    constructor(id, name, icon, notes = [], blocks = []) {
        this.id = id;
        this.name = name;
        this.icon = icon;
        this.notes = notes;
        this.blocks = blocks;
    }

    static async getSkillDetails(id) {
        return $.ajax({
            method: "GET",
            url: "/skill/ajax/get",
            data: {
                id: id
            }
        }).always(function(res) {
            // console.log(res);
        });
    }

    buildMenu() {
        let menu = document.createElement("div");
        menu.classList.add("title-index");
        this.blocks.map(block => {
            if (block.title != "") {
                let icon = document.createElement("img");
                icon.src = this.icon;
                icon.classList.add("icon");

                let title = document.createElement("span");
                title.innerHTML = block.title;
                title.classList.add("title");

                let item = document.createElement("a");
                item.classList.add("slot");
                item.classList.add("w-100");
                const blockID = "#block-" + block.id;
                item.href = blockID;
                item.onclick = () => {
                    let blockSlot = document.querySelector(blockID);
                    blockSlot.classList.add("highlited");

                    setTimeout(() => {
                        blockSlot.classList.remove("highlited");
                    }, 1500);
                };
                item.appendChild(icon);
                item.appendChild(title);

                menu.appendChild(item);
            }
        });

        this.notes.map(note => {
            if (note.title != "") {
                let icon = document.createElement("img");
                icon.src = this.icon;
                icon.classList.add("icon");

                let title = document.createElement("span");
                title.innerHTML = note.title;
                title.classList.add("title");

                let item = document.createElement("a");
                item.classList.add("slot");
                item.classList.add("w-100");
                const noteID = "#note-" + note.id;
                item.href = noteID;
                item.onclick = () => {
                    let noteSlot = document.querySelector(noteID);
                    noteSlot.classList.add("highlited");

                    setTimeout(() => {
                        noteSlot.classList.remove("highlited");
                    }, 1500);
                };
                item.appendChild(icon);
                item.appendChild(title);

                menu.appendChild(item);
            }
        });
        return menu;
    }

    // Notes
    async newNote() {
        const newNoteRes = await Note.createNoteForSkill(this.id);
        const newNoteData = newNoteRes.data;
        let note = new Note(
            newNoteData.title,
            newNoteData.content,
            newNoteData.id
        );
        this.notes.push(note);
        return note;
    }

    // Blocks
    async newBlock() {
        const res = await Block.createBlock(this.id, "skill");
        console.log(res);
    }

    async fetchBlocks() {}

    async fetchNotes() {}

    async fetchAll() {
        await $.ajax({
            method: "get",
            url: "/skill/ajax/fetchAll/" + this.id
        }).always(res => {
            if (!res.error) {
                const data = res.data;
                this.name = data.name;
                this.icon = data.icon;
                this.notes = [];
                data.notes.map(note => {
                    this.notes.push(
                        new Note(note.title, note.content, note.id)
                    );
                });
                this.blocks = [];
                data.blocks.map(block => {
                    this.blocks.push(
                        new Block(block.id, block.title, block.notes)
                    );
                });
            }
        });
    }
}

async function openSkillInModal(skill) {
    await skill.fetchAll();

    let modal = document.getElementById("skill-modal");
    let title = modal.querySelector(".modal-title");
    title.innerHTML = skill.name;

    let icone = modal.querySelector(".title-icon");
    icone.setAttribute("src", skill.icon);

    let body = modal.querySelector(".modal-body");
    body.innerHTML = "";

    let newBlockBtn = modal.querySelector(".new-block-btn");
    newBlockBtn.onclick = async () => {
        let newBlock = await skill.newBlock();
        // let newSlot = newBlock.createSlot();
        // body.appendChild(newSlot);
    };

    let newNoteBtn = modal.querySelector(".new-note-btn");
    newNoteBtn.onclick = async () => {
        let newNote = await skill.newNote();
        let newSlot = newNote.createSlot();
        body.appendChild(newSlot);
    };

    body.appendChild(skill.buildMenu());
    skill.notes.map(item => {
        let note = new Note(item.title, item.content, item.id);
        let newSlot = note.createSlot();
        body.appendChild(newSlot);
    });
    skill.blocks.map(item => {
        let block = new Block(item.id, item.title, item.notes);
        let newSlot = block.createSlot();
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
