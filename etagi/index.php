<?php
$title="Главная страница"; // название формы
require __DIR__ . '/header.php'; // подключаем шапку проекта
require "db.php"; // подключаем файл для соединения с БД
?>
<div class="container mt-4">
<div class="row">
<div class="col">
<center>
<h1>Добро пожаловать на наш сайт!</h1>
</center>
</div>
</div>
</div>
<!-- Если авторизован выведет приветствие -->
<?php if(isset($_SESSION['logged_user'])) : ?>
	Привет,<?php echo $_SESSION['logged_user']-> name; ?></br>
<!-- Пользователь может нажать выйти для выхода из системы -->
<?php 
$db_host='localhost'; // ваш хост
$db_name='etagi'; // ваша бд
$db_user='root'; // пользователь бд
$db_pass='root'; // пароль к бд
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);// включаем сообщения об ошибках
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name); // коннект с сервером бд
$mysqli->set_charset("utf8"); // задаем кодировку

$result = $mysqli->query('SELECT * FROM tasks'); 
    // выбираем все значения из таблицы "Contacts"
    $qr_result = $mysqli->query("select * from tasks" . $db_table_to_show )
        or die(mysql_error());
		?>
 
   <script type="text/javascript">
"use strict";

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function _iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }

document.addEventListener('DOMContentLoaded', function () {
  var getSort = function getSort(_ref) {
    var target = _ref.target;
    var order = target.dataset.order = -(target.dataset.order || -1);

    var index = _toConsumableArray(target.parentNode.cells).indexOf(target);

    var collator = new Intl.Collator(['en', 'ru'], {
      numeric: true
    });

    var comparator = function comparator(index, order) {
      return function (a, b) {
        return order * collator.compare(a.children[index].innerHTML, b.children[index].innerHTML);
      };
    };

    var _iteratorNormalCompletion = true;
    var _didIteratorError = false;
    var _iteratorError = undefined;

    try {
      for (var _iterator = target.closest('table').tBodies[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
        var tBody = _step.value;
        tBody.append.apply(tBody, _toConsumableArray(_toConsumableArray(tBody.rows).sort(comparator(index, order))));
      }
    } catch (err) {
      _didIteratorError = true;
      _iteratorError = err;
    } finally {
      try {
        if (!_iteratorNormalCompletion && _iterator.return != null) {
          _iterator.return();
        }
      } finally {
        if (_didIteratorError) {
          throw _iteratorError;
        }
      }
    }

    var _iteratorNormalCompletion2 = true;
    var _didIteratorError2 = false;
    var _iteratorError2 = undefined;

    try {
      for (var _iterator2 = target.parentNode.cells[Symbol.iterator](), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {
        var cell = _step2.value;
        cell.classList.toggle('sorted', cell === target);
      }
    } catch (err) {
      _didIteratorError2 = true;
      _iteratorError2 = err;
    } finally {
      try {
        if (!_iteratorNormalCompletion2 && _iterator2.return != null) {
          _iterator2.return();
        }
      } finally {
        if (_didIteratorError2) {
          throw _iteratorError2;
        }
      }
    }
  };

  document.querySelectorAll('.table_sort thead').forEach(function (tableTH) {
    return tableTH.addEventListener('click', function () {
      return getSort(event);
    });
  });
});

</script>
 
    <table class="table_sort">
	<link rel="stylesheet" href="css/table.css" />
		<thead>
			<tr>
			<th>Заголовок</th>
			<th>Описание</th>
			<th>Приоритет</th>
			<th>Статус</th>
			</tr>
		</thead>
		<tbody>
		<?php
   // выводим в HTML-таблицу все данные клиентов из таблицы MySQL
    while($data = mysqli_fetch_array($qr_result)){
        echo '<tr>';
        echo '<td>' . $data['taskhead'] . '</td>';
        echo '<td>' . $data['description'] . '</td>';
        echo '<td>' . $data['priority'] . '</td>';
		echo '<td>' . $data['status'] . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
	?>
<a href="logout.php">Выйти</a> <!-- файл logout.php создадим ниже -->
<?php else : ?>

<!-- Если пользователь не авторизован выведет ссылки на авторизацию и регистрацию -->
<a href="login.php">Авторизоваться</a><br>
<a href="signup.php">Регистрация</a>
<?php endif; ?>

<?php require __DIR__ . '/footer.php'; ?> <!-- Подключаем подвал проекта -->