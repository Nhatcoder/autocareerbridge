let isToastShowing = false;

function showToast(message) {
    if (isToastShowing) return;

    isToastShowing = true;

    toastr.success(message, "", {
        progressBar: true,
        timeOut: 3000,
        onHidden: function () {
            isToastShowing = false;
        },
    });
}


document.addEventListener("click", function (event) {
    if (event.target.closest(".toggle-favorite")) {
        let btn = event.target.closest(".toggle-favorite");
        let jobId = btn.dataset.jobId;
        let icon = btn.querySelector(".favorite-icon");
        let parent = btn;

        fetch("/job/wishlist", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": getCsrfToken(),
            },
            body: JSON.stringify({
                job_id: jobId,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.status === "added") {
                    showToast(data.message);
                }

                if (data.status === "added") {
                    icon.style.color = "red";
                    parent.style.border = "1px solid red";
                } else if (data.status === "removed") {
                    icon.style.color = "#ccc";
                    parent.style.border = "1px solid #e9e9e9";
                }
            })
            .catch((error) => {
                showToast("Có lỗi xảy ra, vui lòng thử lại!");
            });
    }
});

function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
}
