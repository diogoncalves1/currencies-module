const inputCode = document.querySelector("[role='code']");
const errorFeedbackCode = document.getElementById("errorFeedbackCode");

inputCode.addEventListener("input", function () {
    this.value = this.value.toUpperCase();
    if (this.value.length == 3) checkCurrencyCode(this.value);
});

async function checkCurrencyCode(code) {
    var url = "/currencies/check-code";
    var id = window.location.pathname
        .replace("/admin/currencies/", "")
        .replace("/edit", "");

    console.log(id);

    var response = await $.ajax({
        url: url,
        type: "GET",
        data: {
            code: code,
            id: id ?? null,
        },
    });
    if (response.exists) {
        inputCode.classList.remove("is-valid");
        inputCode.classList.add("is-invalid");
        errorFeedbackCode.innerText = "Esse código já existe";
    } else {
        inputCode.classList.remove("is-invalid");
    }

    return response.exists;
}
