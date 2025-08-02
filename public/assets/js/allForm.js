const btnSubmit = document.getElementById("btnSubmit");

let groups = document.querySelectorAll(".form-group");

Array.from(groups).forEach((group) => {
    let input = group.querySelector(".form-control");
    let erroFeedback = group.querySelector(".invalid-feedback");
    input.addEventListener("input", () => {
        isInputValid(input, erroFeedback);
    });
});

btnSubmit.addEventListener("click", async () => {
    try {
        groups = document.querySelectorAll(".form-group");

        let request = await Promise.all(
            Array.from(groups).map(async (group) => {
                let input = group.querySelector(".form-control");

                if (input.classList.contains("validate")) {
                    let erroFeedback = group.querySelector(".invalid-feedback");
                    if (!(await isInputValid(input, erroFeedback))) return null;
                }

                let inputDataRole = input.getAttribute("data-role");

                if (inputDataRole == "selectMultiple") {
                    var inputValue = $(input).val();
                    inputDataRole = null;
                } else var inputValue = input.value;

                let inputRole = input.role;

                return {
                    dataRole: inputDataRole ? inputDataRole : null,
                    role: inputRole,
                    value: inputValue ? inputValue : null,
                };
            })
        );

        if (
            document.querySelector(
                ".nav-pills .nav-item .nav-link.active .extra"
            ) != null
        ) {
            var extra = document.querySelector(
                ".nav-pills .nav-item .nav-link.active .extra"
            );
            request.push({
                dataRole: null,
                role: extra.role,
                value: extra.getAttribute("data-value"),
            });
        }

        if (request.some((item) => item === null)) throw new Error("Error");

        let ajaxData = {};

        request.forEach((data) => {
            var role = data.role;
            var value = data.value ? data.value : null;
            var dataRole = data.dataRole ? data.dataRole : null;

            if (role) {
                if (!ajaxData[role]) ajaxData[role] = {};
            }

            if (dataRole && role) {
                ajaxData[role][dataRole] = value;
            } else {
                ajaxData[role] = value;
            }
        });

        const url = window.location.pathname.replace("/create", "");

        $.ajax({
            url: url,
            type: "POST",
            data: ajaxData,
            success: function (response) {
                console.log(response);
                successToast(response.message);
            },
            error: function (error) {
                console.log(error);
                errorToast("Erro na tentativa.");
            },
        });
    } catch (e) {
        infoToast("Preencha os campos corretamente");
    }
});
