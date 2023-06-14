var movieSelect = document.getElementById('movie-select');
var dateSelect = document.getElementById('date-select');
var seansTable = document.getElementById('seans-table');

movieSelect.addEventListener('change', filterByMovieAndDate);
dateSelect.addEventListener('change', filterByMovieAndDate);

function formatDatePhp(date) {
    var parts = date.split('.');
    var day = parts[0];
    var month = parts[1];
    var year = parts[2];
    return year + '-' + month + '-' + day;
}

function formatDateJs(date) {
    var parts = date.split('-');
    var year = parts[0].slice(2); // Извлекаем последние две цифры года
    var month = parts[1];
    var day = parts[2];
    return day + '.' + month + '.' + year;
}

function filterByMovieAndDate() {
    var selectedMovie = movieSelect.value;
    var selectedDate = dateSelect.value !== '' ? formatDateJs(dateSelect.value) : '';


    var rows = seansTable.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    for (var i = 0; i < rows.length; i++) {
        var movieCell = rows[i].cells[0];
        var dateCell = rows[i].cells[1];

        var movieTitle = movieCell.textContent || movieCell.innerText;
        var seansDatePhp = dateCell.textContent || dateCell.innerText;
        var seansDateJs = formatDateJs(formatDatePhp(seansDatePhp)); // Используем formatDatePhp для преобразования даты в PHP формат, а затем преобразуем его в JS формат


        var showRow =
            (selectedMovie === '' || movieTitle === selectedMovie) &&
            (selectedDate === '' || seansDatePhp.includes(selectedDate) || seansDateJs.includes(selectedDate)); // Изменяем условие сравнения дат, чтобы учитывать частичное совпадение


        rows[i].style.display = showRow ? '' : 'none';
    }
}

filterByMovieAndDate();

