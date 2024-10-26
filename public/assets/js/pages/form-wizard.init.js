document.querySelector("#profile-img-file-input").addEventListener("change", function () {
    var imageElement = document.querySelector(".user-profile-image"),
        fileInput = document.querySelector(".profile-img-file-input").files[0],
        reader = new FileReader();

    reader.addEventListener("load", function () {
        imageElement.src = reader.result;
    }, false);

    if (fileInput) reader.readAsDataURL(fileInput);
});

document.querySelectorAll(".form-steps").forEach(function (step) {
    step.querySelectorAll(".nexttab").forEach(function (nextButton) {
        step.querySelectorAll('button[data-bs-toggle="pill"]').forEach(function (tabButton) {
            tabButton.addEventListener("show.bs.tab", function (event) {
                event.target.classList.add("done");
            });
        });

        nextButton.addEventListener("click", function () {
            var nextTabId = nextButton.getAttribute("data-nexttab");
            document.getElementById(nextTabId).click();
        });
    });

    step.querySelectorAll(".previestab").forEach(function (prevButton) {
        prevButton.addEventListener("click", function () {
            var prevTabId = prevButton.getAttribute("data-previous"),
                doneSteps = prevButton.closest("form").querySelectorAll(".custom-nav .done"),
                totalDone = doneSteps.length,
                lastDoneIndex = totalDone - 1;

            if (doneSteps[lastDoneIndex]) {
                doneSteps[lastDoneIndex].classList.remove("done");
            }

            document.getElementById(prevTabId).click();
        });
    });

    var tabButtons = step.querySelectorAll('button[data-bs-toggle="pill"]');
    
    tabButtons.forEach(function (tabButton, index) {
        tabButton.setAttribute("data-position", index);

        tabButton.addEventListener("click", function () {
            var progressBarElement;

            if (tabButton.getAttribute("data-progressbar")) {
                var totalTabs = document.getElementById("custom-progress-bar").querySelectorAll("li").length - 1;
                var progressPercent = (index / totalTabs) * 100;
                document.getElementById("custom-progress-bar").querySelector(".progress-bar").style.width = progressPercent + "%";
            }

            if (step.querySelectorAll(".custom-nav .done").length > 0) {
                step.querySelectorAll(".custom-nav .done").forEach(function (doneStep) {
                    doneStep.classList.remove("done");
                });
            }

            for (var i = 0; i <= index; i++) {
                if (tabButtons[i].classList.contains("active")) {
                    tabButtons[i].classList.remove("done");
                } else {
                    tabButtons[i].classList.add("done");
                }
            }
        });
    });
});
