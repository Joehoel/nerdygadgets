const textarea = document.querySelector("#review-text");
const reviewForm = document.querySelector("#review-form")

textarea.addEventListener("keydown", handleChange);
let prevKey;

function handleChange(e) {
	if (e.key === "Control") {
		prevKey = e.key;
	}

	if (prevKey === "Control" && e.key === "Enter") {
        reviewForm.requestSubmit();
	}
}
