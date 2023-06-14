var itemsPerPage = 4;
document.getElementById("filter-btn").addEventListener("click", function () {
    var selectedDateStr = document.getElementById("selected-date").value;
    var selectedDateParts = selectedDateStr.split("-");
    var selectedDate = selectedDateParts[2] + "." + selectedDateParts[1] + "." + selectedDateParts[0];

    var orders = document.getElementsByClassName("card-order-admin");

    // Скрываем все элементы
    for (var i = 0; i < orders.length; i++) {
        orders[i].style.display = "none";
    }

    // Фильтруем и отображаем только соответствующие заказы
    var filteredOrders = [];
    for (var i = 0; i < orders.length; i++) {
        var order = orders[i];
        var orderDateStr = order.getElementsByClassName("date-movie")[0].textContent;

        if (orderDateStr.includes(selectedDate)) {
            filteredOrders.push(order);
        }
    }

    // Показываем только первые три элемента
    for (var i = 0; i < filteredOrders.length; i++) {
        if (i < itemsPerPage) {
            filteredOrders[i].style.display = "flex";
        }
    }

    // Показываем контейнер с заказами после фильтрации
    var containerOrders = document.querySelector(".container-orders-admin");
    containerOrders.style.display = "block";

    // При каждом фильтре обновляем пагинацию
    updatePagination(filteredOrders);
});

// Функция для обновления пагинации
function updatePagination(filteredOrders) {
    var numPages = Math.ceil(filteredOrders.length / itemsPerPage);

    // Очищаем пагинацию
    var paginationContainer = document.getElementById("pagination");
    paginationContainer.innerHTML = "";

    // Создаем ссылки для пагинации
    for (var i = 1; i <= numPages; i++) {
        var link = document.createElement("a");
        link.href = "#";
        link.textContent = i;

        // Добавляем класс "active" к текущей странице
        if (i === 1) {
            link.classList.add("active");
        }

        // Обработчик события при клике на ссылку пагинации
        link.addEventListener("click", function (event) {
            event.preventDefault();

            // Удаляем класс "active" у всех ссылок
            var paginationLinks = paginationContainer.getElementsByTagName("a");
            for (var j = 0; j < paginationLinks.length; j++) {
                paginationLinks[j].classList.remove("active");
            }

            // Показываем только элементы текущей страницы
            var pageNumber = parseInt(this.textContent);
            var startIndex = (pageNumber - 1) * itemsPerPage;
            var endIndex = startIndex + itemsPerPage;

            for (var k = 0; k < filteredOrders.length; k++) {
                if (k >= startIndex && k < endIndex) {
                    filteredOrders[k].style.display = "flex";
                } else {
                    filteredOrders[k].style.display = "none";
                }
            }

            // Добавляем класс "active" к текущей ссылке
            this.classList.add("active");
        });

        paginationContainer.appendChild(link);
    }
}