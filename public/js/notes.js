class Note {
    constructor(title, content, id, type = "text") {
        this.id = id;
        this.title = title;
        this.content = content;
        this.type = type;
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

    afterSaveNote(noteID) {
        let textarea = document.getElementById("note-content-" + noteID);
        this.calculateNoteContentRows(textarea);
    }

    updateNote(e, noteID) {
        let token = $('meta[name="csrf-token"]').attr("content");
        var baseurl = window.location.origin;

        return $.ajax({
            url: baseurl + "/note/ajax/update",
            type: "POST",
            data: {
                id: noteID,
                type: document.getElementById("note-type-" + noteID).value,
                title: document.getElementById("note-title-" + noteID).value,
                content: document.getElementById("note-content-" + noteID)
                    .value,
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
                this.afterSaveNote(noteID);
            });
    }

    noteTitleOnclick(e) {
        let input = e.target;
        if (input.value == "[New Note]") {
            input.select();
        }
    }

    notecontetOnclick(e) {
        let input = e.target;
        if (input.value == "[empty]\n") {
            input.select();
        }
    }

    youtube_parser(url) {
        var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
        var match = url.match(regExp);
        return match && match[7].length == 11 ? match[7] : false;
    }

    hideAllContents() {
        if (this.youtubeIframe) this.youtubeIframe.style.display = "none";
        if (this.noteContent) this.noteContent.style.display = "none";
        if (this.imageViewer) this.imageViewer.style.display = "none";
    }

    changeShownContentType(type) {
        switch (type) {
            case "youtube":
                this.hideAllContents();
                if (this.youtubeIframe) {
                    let video_id = this.youtube_parser(this.content);
                    let finalURL = "https://www.youtube.com/embed/" + video_id;
                    this.youtubeIframe.setAttribute("src", finalURL);
                    this.youtubeIframe.style.display = "flex";
                }
                break;
            case "text":
                this.hideAllContents();
                if (this.noteContent) this.noteContent.style.display = "flex";
                break;
            case "image":
                this.hideAllContents();
                if (this.imageViewer) {
                    this.imageViewer.style.display = "flex";
                    let imagePreview = document.getElementById(
                        "image-preview-" + this.id
                    );

                    if (this.content.includes("http")) {
                        imagePreview.src = this.content;
                    } else {
                        imagePreview.src = caminhoPublico + "/" + this.content;
                    }
                }

                break;

            default:
                break;
        }
    }

    noteTypeOnChange(event) {
        this.type = event.target.value;
        this.changeShownContentType(this.type);
        this.showSaveButton();
    }

    showSaveButton() {
        if (this.btnSalvar) this.btnSalvar.style.display = "flex";
    }

    // Public funcitons
    createSlot() {
        let btnSalvar = document.createElement("button");
        btnSalvar.setAttribute("type", "button");
        btnSalvar.innerHTML = "Salvar";
        btnSalvar.setAttribute("id", "btn-salvar-" + this.id);
        btnSalvar.style.display = "none";
        btnSalvar.onclick = event => {
            this.updateNote(event, this.id);
        };
        this.btnSalvar = btnSalvar;

        let noteType = document.createElement("select");
        noteType.setAttribute("id", "note-type-" + this.id);
        noteType.classList.add("note-type");
        noteType.style.display = "flex";
        const noteTypes = ["text", "image", "youtube"];
        noteTypes.map(type => {
            let typeOption = document.createElement("option");
            typeOption.value = type;
            typeOption.innerHTML = type;
            if (type == this.type) {
                typeOption.setAttribute("selected", true);
            }
            noteType.appendChild(typeOption);
        });
        noteType.addEventListener("input", event => {
            this.noteTypeOnChange(event);
        });

        let noteTitle = document.createElement("input");
        noteTitle.classList.add("note-title");
        noteTitle.setAttribute("id", "note-title-" + this.id);
        noteTitle.value = this.title;
        noteTitle.oninput = event => {
            this.title = event.target.value;
            this.showSaveButton(this.id);
        };
        noteTitle.onfocus = event => {
            this.noteTitleOnclick(event);
        };

        let noteContent = document.createElement("textarea");
        noteContent.classList.add("note-content");
        noteContent.innerHTML = this.content;
        noteContent.setAttribute("id", "note-content-" + this.id);
        this.calculateNoteContentRows(noteContent);
        if (noteContent.value[noteContent.value.length - 1] != "\n")
            noteContent.value += "\n";
        noteContent.onfocus = event => {
            this.notecontetOnclick(event);
        };
        noteContent.oninput = event => {
            this.content = event.target.value;
            this.showSaveButton(this.id);
        };
        noteContent.onkeydown = e => {
            let me = noteContent;

            var keyCode = e.keyCode || e.which;

            if (keyCode == 9) {
                e.preventDefault();
                var start = me.selectionStart;
                var end = me.selectionEnd;

                // set textarea value to: text before caret + tab + text after caret
                $(me).val(
                    $(me)
                        .val()
                        .substring(0, start) +
                        "\t" +
                        $(me)
                            .val()
                            .substring(end)
                );

                // put caret at right position again
                me.selectionStart = me.selectionEnd = start + 1;
            }

            this.showSaveButton(this.id);
        };
        this.noteContent = noteContent;

        let youtubeIframe = document.createElement("iframe");
        youtubeIframe.setAttribute("width", "75%");
        youtubeIframe.setAttribute("height", "402");
        youtubeIframe.setAttribute("frameborder", "0");
        youtubeIframe.setAttribute(
            "allow",
            "accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
        );
        youtubeIframe.setAttribute("allowfullscreen", "");
        youtubeIframe.style.display = "none";
        youtubeIframe.id = "note-yt-iframe-" + this.id;
        this.youtubeIframe = youtubeIframe;

        let imagePreview = document.createElement("img");
        imagePreview.classList.add("image-previewer");
        imagePreview.id = "image-preview-" + this.id;
        let novaImagem = document.createElement("input");
        novaImagem.type = "file";
        let imageViewer = document.createElement("div");
        imageViewer.style.display = "none";
        imageViewer.appendChild(imagePreview);
        imageViewer.appendChild(novaImagem);
        this.imageViewer = imageViewer;

        let noteContentWrapper = document.createElement("div");
        noteContentWrapper.id = "note-content-wrapper-" + this.id;
        noteContentWrapper.appendChild(noteContent);
        noteContentWrapper.appendChild(youtubeIframe);
        noteContentWrapper.appendChild(imageViewer);
        noteContentWrapper.classList.add("note-ContentWrapper");

        let noteSlot = document.createElement("div");
        noteSlot.classList.add("note-slot");
        noteSlot.appendChild(noteTitle);
        noteSlot.appendChild(btnSalvar);
        noteSlot.appendChild(noteType);
        noteSlot.appendChild(noteContentWrapper);
        noteSlot.id = "note-" + this.id;

        this.changeShownContentType(this.type);

        return noteSlot;
    }

    static async createNoteForWorkday(workdayID) {
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

    static async createNoteForSkill(skillID) {
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

    static async newNote(id, relationship) {
        let token = $('meta[name="csrf-token"]').attr("content");
        var baseurl = window.location.origin;

        let retorno = $.ajax({
            url: baseurl + "/note/ajax/store/" + relationship,
            type: "POST",
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
