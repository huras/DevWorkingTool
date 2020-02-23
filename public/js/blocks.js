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

    async createSlot() {
        let slot = document.createElement("div");

        let title = document.createElement("input");
        title.value = this.title;
        title.classList.add("title");
        slot.appendChild(title);

        let actions = document.createElement("div");
        actions.classList.add("actions");
        actions.classList.add("top");
        slot.appendChild(actions);

        let newNoteBtn = document.createElement("button");
        // newNoteBtn.classList.add('');
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
}
