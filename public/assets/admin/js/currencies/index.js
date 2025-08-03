$(function () {
    $("#table").DataTable({
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        ordering: true,
        searching: true,
        processing: true,
        serverSide: true,
        columnDefs: [
            {
                orderable: false,
                targets: [2, 3],
            },
        ],
        ajax: {
            url: "/api/currencies/data",
            type: "GET",
            dataSrc: function (json) {
                console.log(json);
                return json.data;
            },
        },
        columns: [
            {
                data: "name",
            },
            {
                data: "code",
            },
            {
                data: "symbol",
            },
            {
                data: "actions",
            },
        ],
    });
});
