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

    createSlot() {
        let slot = document.createElement("div");

        let title = document.createElement("div");
        title.innerHTML = this.title;
        slot.appendChild(title);

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

        let retorno = $.ajax({
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

        console.log(retorno);
        return retorno;
    }
}
