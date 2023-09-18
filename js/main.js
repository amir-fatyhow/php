$("#calculate").on("click", function () {
    const ax = $("#ax").val().trim();
    const ay = $("#ay").val().trim();
    const az = $("#az").val().trim();

    const bx = $("#bx").val().trim();
    const by = $("#by").val().trim();
    const bz = $("#bz").val().trim();

    const cx = $("#cx").val().trim();
    const cy = $("#cy").val().trim();
    const cz = $("#cz").val().trim();

    $.ajax({
        url: "php/ajax.php",
        type: "POST",
        cache: false,
        data: {
            "ax": ax, "ay": ay, "az": az,
            "bx": bx, "by": by, "bz": bz,
            "cx": cx, "cy": cy, "cz": cz
        },
        dataType: "text",
        beforeSend: function () {
            $("#calculate").prop("disabled", true);
        },
        success: function (data) {
            let temporary = document.querySelectorAll(".temporary");
            if (temporary.length) {
                temporary.forEach(value => value.remove());
            }
            document.getElementById("answer").innerHTML += data;
            $("#calculate").prop("disabled", false);
        }
    })
})

document.addEventListener("", () => {
    console.log("submit");
})
