class Block {
    constructor(id, title, notes) {
        this.id = id;
        this.title = title;
        this.notes = notes;
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
