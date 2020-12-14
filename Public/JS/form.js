const textarea = document.querySelector("#review-text");
const reviewForm = document.querySelector("#review-form")

let prevKey;

function handleChange(e) {
	if (e.key === "Control") {
		prevKey = e.key;
	}

	if (prevKey === "Control" && e.key === "Enter") {
		reviewForm.requestSubmit();
	}
}

textarea.addEventListener("keydown", handleChange);
