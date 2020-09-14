"use strict";

// Все таблицы в которых будет осуществлена сортировка по thead
const theads = document.querySelectorAll(".table_sort thead");
theads.forEach(thead => thead.addEventListener("click", evt => getSort(evt)));

function getSort({ target }) {
	// Доступ к атрибуту data будет задан через объект dataset, можно и через getAttribute
	// .dataset.order ~ data-order

	// Переключение если равен -1, то при -(-1) = 1, если -(1) = -1
	// В зависимости от того чему равен data-order, будет сменя стрелки "▲" "▼"
	const order = (target.dataset.order = -(target.dataset.order || -1));

	// Событие происходит target -> th, target.parentNode -> tr
	// tr.cells -> всех <th> или <td>  
	const thList = Array.from(target.parentNode.cells);

	// Index - нажатого th
	// (Можно заменить стандартный метод target.cellIndex,который выдает номер ячейки в строке <th> или <td>)
	const index = thList.indexOf(target);

	// Метод для правильного сравнения строк на разных языках, последующая их сортировать 
	const collator = new Intl.Collator(["en", "ru"], { numeric: true });

	// Функция сортировки использующая метод compare, и используемая внутри функции sort
	const comparator = (index, order) => (a, b) => {
		
		return (
			order * // order - переключатель, для того чтобы менять порядок сортировки: "с начала" или "с конца"
			collator.compare(a.children[index].textContent, b.children[index].textContent)
		);
	};

	// Коллекция элементов таблицы <tbody>
	const tablesBodies = Array.from(target.closest("table").tBodies);
	// console.log(tablesBodies)

	tablesBodies.forEach(tBody => {
		// tBody.rows - все ряды в таблице
		// Добавляет (несколько) отсортированных узлов или строки в конец
		tBody.append(...Array.from(tBody.rows).sort(comparator(index, order)));
	});

	/* 
		При нажатии на элементы th которые находяться в <thead>, происходит сравнения и переключении класс sorted
		 Если установлено значение false, класс будет только удален, но не добавлен. 
		 Если установлено значение true, класс будет только добавляться, но не удаляться 
	*/
	
	thList.forEach( th => th.classList.toggle("sorted", th === target));
}