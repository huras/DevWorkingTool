class Note {
    constructor(title, content, id) {
        this.id = id;
        this.title = title;
        this.content = content;
    }



    calculateNoteContentRows(textarea) {
        let maxRows = 30;
        var rows = (textarea.value.match(/\n/g) || []).length;
        if (rows > maxRows) rows = maxRows;
        textarea.setAttribute(
            "rows",
            rows + 1 + Math.ceil(textarea.value.length / 270)
        );
    }

    afterSaveNote(noteID){
        let textarea = document.getElementById('note-content-'+noteID);
        this.calculateNoteContentRows(textarea);
    }

    updateNote(e, noteID){
        let token = $('meta[name="csrf-token"]').attr("content");
        var baseurl = window.location.origin;

        return $.ajax({
            url: baseurl + "/note/ajax/update",
            type: "POST",
            data: {
                id: noteID,
                title: document.getElementById('note-title-'+noteID).value,
                content: document.getElementById('note-content-'+noteID).value,
                _token: token
            }
        })
        .done((res) => {
            console.log(res);
            e.target.style.display = 'none';
        })
        .fail((res) => {
            console.log(res);
        })
        .always((res) => {
            console.log(res);
            this.afterSaveNote(noteID);
        });
    }

    noteTitleOnclick(e){
        let input = e.target;
        if(input.value == '[New Note]'){
            input.select();
        }
    }

    notecontetOnclick(e){
        let input = e.target;
        if(input.value == '[empty]\n'){
            input.select();
        }
    }

    showSaveButton(noteID){
        let btnSalvar = document.getElementById('btn-salvar-'+noteID);
        btnSalvar.style.display = 'block';
    }

    // Public funcitons
    createSlot() {
        let btnSalvar = document.createElement('button');
        btnSalvar.setAttribute('type', 'button');
        btnSalvar.innerHTML = 'Salvar';
        btnSalvar.setAttribute('id', 'btn-salvar-'+this.id);
        btnSalvar.style.display = 'none';
        btnSalvar.onclick = (event) => {
            this.updateNote(event, this.id);
        }

        let noteTitle = document.createElement("input");
        noteTitle.classList.add("note-title");
        noteTitle.setAttribute('id', 'note-title-'+this.id);
        noteTitle.value = this.title;
        noteTitle.oninput = (event) => {
            this.showSaveButton(this.id);
        }
        noteTitle.onfocus = (event) => {
            this.notecontetOnclick(event);
        }

        let noteContent = document.createElement("textarea");
        noteContent.classList.add("note-content");
        noteContent.innerHTML = this.content;
        noteContent.setAttribute('id', 'note-content-'+this.id);
        this.calculateNoteContentRows(noteContent);
        noteContent.onfocus = (event) => {
            this.notecontetOnclick(event);
        }
        noteContent.oninput = (event) => {
            this.showSaveButton(this.id);
        }
        noteContent.onkeydown = (e) => {
            let me = noteContent;

            var keyCode = e.keyCode || e.which;

            if (keyCode == 9) {
                e.preventDefault();
                var start = me.selectionStart;
                var end = me.selectionEnd;

                // set textarea value to: text before caret + tab + text after caret
                $(me).val($(me).val().substring(0, start)
                            + "\t"
                            + $(me).val().substring(end));

                // put caret at right position again
                me.selectionStart =
                me.selectionEnd = start + 1;
            }

            this.showSaveButton(this.id);
        }

        let noteSlot = document.createElement("div");
        noteSlot.classList.add("note-slot");
        noteSlot.appendChild(noteTitle);
        noteSlot.appendChild(noteContent);
        noteSlot.appendChild(btnSalvar);
        noteSlot.id = 'note-'+this.id;

        return noteSlot;
    }

    static async createNoteForWorkday(workdayID){
        let token = $('meta[name="csrf-token"]').attr("content");
        var baseurl = window.location.origin;

        return $.ajax({
            url: baseurl + "/note/ajax/store/workday",
            type: "POST",
            data: {
                id: workdayID,
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

        return false;
    }

    static async createNoteForSkill(skillID){
        let token = $('meta[name="csrf-token"]').attr("content");
        var baseurl = window.location.origin;

        let retorno = $.ajax({
            url: baseurl + "/note/ajax/store/skill",
            type: "POST",
            data: {
                id: skillID,
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
