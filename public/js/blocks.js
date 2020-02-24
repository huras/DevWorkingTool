class Block {
    constructor(id, title, notes = []) {
        this.id = id;
        this.title = title;
        if (notes != []) {
            this.notes = [];
            notes.map(note => {
                this.notes.push(new Note(note.title, note.content, note.id));
            });
        } else {
            this.notes = notes;
        }
    }

    showSaveButton() {
        let btnSalvar = document.getElementById("block-btn-salvar-" + this.id);
        btnSalvar.style.display = "flex";
    }

    async createSlot() {
        let slot = document.createElement("div");

        let title = document.createElement("input");
        title.value = this.title;
        title.classList.add("title");
        title.id = "block-title-" + this.id;
        title.oninput = event => {
            this.showSaveButton(this.id);
        };
        slot.appendChild(title);

        let actions = document.createElement("div");
        actions.classList.add("actions");
        actions.classList.add("top");
        slot.appendChild(actions);

        // Save Btn
        let saveBtn = document.createElement("button");
        saveBtn.addEventListener("click", async event => {
            this.updateBlock(event);
        });
        saveBtn.style.display = "none";
        saveBtn.id = "block-btn-salvar-" + this.id;
        saveBtn.innerHTML = "Save";
        actions.appendChild(saveBtn);

        // New Note Btn
        let newNoteBtn = document.createElement("button");
        newNoteBtn.addEventListener("click", async () => {
            let newNote = await this.newNote();
            let newSlot = newNote.createSlot();
            slot.appendChild(newSlot);
        });
        newNoteBtn.innerHTML = "New Note";
        actions.appendChild(newNoteBtn);

        this.notes.map(item => {
            let note = new Note(item.title, item.content, item.id);
            let newSlot = note.createSlot();
            slot.appendChild(newSlot);
        });

        slot.classList.add("block-slot");
        slot.id = "block-" + this.id;
        return slot;
    }

    static async createBlock(id, relationship) {
        let token = $('meta[name="csrf-token"]').attr("content");
        var baseurl = window.location.origin;

        let retorno = await $.ajax({
            url: baseurl + "/block/ajax/store/" + relationship,
            method: "POST",
            data: {
                id: id,
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

        return new Block(retorno.data.id, retorno.data.title, []);
    }

    // Notes
    async newNote() {
        const newNoteRes = await Note.newNote(this.id, "block");
        const newNoteData = newNoteRes.data;
        let note = new Note(
            newNoteData.title,
            newNoteData.content,
            newNoteData.id
        );
        this.notes.push(note);
        return note;
    }

    updateBlock(e) {
        let token = $('meta[name="csrf-token"]').attr("content");
        var baseurl = window.location.origin;

        return $.ajax({
            url: baseurl + "/block/ajax/update",
            type: "POST",
            data: {
                id: this.id,
                title: document.getElementById("block-title-" + this.id).value,
                _token: token
            }
        })
            .done(res => {
                console.log(res);
                e.target.style.display = "none";
            })
            .fail(res => {
                console.log(res);
            })
            .always(res => {
                console.log(res);
                // this.afterSaveNote(noteID);
            });
    }
}
