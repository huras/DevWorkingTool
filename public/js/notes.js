class Note {
    constructor(title, content) {
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

    // Public funcitons
    createSlot() {
        let noteTitle = document.createElement("input");
        noteTitle.classList.add("note-title");
        noteTitle.value = this.title;

        let noteContent = document.createElement("textarea");
        noteContent.classList.add("note-content");
        noteContent.innerHTML = this.content;
        this.calculateNoteContentRows(noteContent);

        let noteSlot = document.createElement("div");
        noteSlot.classList.add("note-slot");
        noteSlot.appendChild(noteTitle);
        noteSlot.appendChild(noteContent);

        return noteSlot;
    }
}
