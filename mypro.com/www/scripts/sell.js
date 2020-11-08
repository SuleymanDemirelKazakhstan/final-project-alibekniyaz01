let part = 1;

var interval = setInterval(isValid, 500);
var next = document.querySelector("#next");



function isValid() {
	let mark = document.querySelector("#mark");
    let getSelectMark = mark[mark.selectedIndex].text;

    let year = document.querySelector("#year");
    let getSelectYear = year[year.selectedIndex].text;

    let model = document.querySelector("#model");
    let getSelectModel = model[model.selectedIndex].text;

    if (getSelectMark != "Выберите марку..." && getSelectYear != "Выберите год...") {
    	document.querySelector("#next").classList.remove("not_valid");
    	document.querySelector("#next").classList.add("valid");
    }
}

function open_next_part() {
	part++;
	if (part == 4) {
		part = 3;
	}

	if (part == 1) {
		document.querySelector('.first_select_step').classList.remove("close");
		document.querySelector(".second_select_step").classList.add("close");
		document.querySelector(".third_select_step").classList.add("close");
	}
	else if (part == 2) {
		document.querySelector('.first_select_step').classList.add("close");
		document.querySelector(".second_select_step").classList.remove("close");
		document.querySelector(".third_select_step").classList.add("close");
	}
	else if (part == 3) {
		document.querySelector('.first_select_step').classList.add("close");
		document.querySelector(".second_select_step").classList.add("close");
		document.querySelector(".third_select_step").classList.remove("close");
	}
}

function open_previous_part() {
	part--;
	if (part == 0) {
		part = 1;
	}
	if (part == 1) {
		document.querySelector('.first_select_step').classList.remove("close");
		document.querySelector(".second_select_step").classList.add("close");
		document.querySelector(".third_select_step").classList.add("close");
	}
	else if (part == 2) {
		document.querySelector('.first_select_step').classList.add("close");
		document.querySelector(".second_select_step").classList.remove("close");
		document.querySelector(".third_select_step").classList.add("close");
	}
	else if (part == 3) {
		document.querySelector('.first_select_step').classList.add("close");
		document.querySelector(".second_select_step").classList.add("close");
		document.querySelector(".third_select_step").classList.remove("close");
	}
}

function selectMark() {
        let select = document.querySelector("#mark");
        let getSelectOption = select[select.selectedIndex].text;
        if (getSelectOption != "Выберите марку...")
          document.querySelector("#mark_text").value = getSelectOption;
      }

      function selectYear() {
        let select = document.querySelector("#year");
        let getSelectOption = select[select.selectedIndex].text;
        if (getSelectOption != "Выберите год...")
          document.querySelector("#year_text").value = getSelectOption;
      }

      function selectModel() {
        let select = document.querySelector("#model");
        let getSelectOption = select[select.selectedIndex].text;
        if (getSelectOption != "Выберите год...")
          document.querySelector("#model_text").value = getSelectOption;
      }

      function selectColor() {
        let select = document.querySelector("#select_color");
        let getSelectOption = select[select.selectedIndex].text;
        if (getSelectOption != "Выберите цвет...")
          document.querySelector("#model_text").value = getSelectOption;
      }