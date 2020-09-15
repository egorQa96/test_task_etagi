<?php
$title="Страница Администратора"; // название формы
require __DIR__ . '/header.php'; // подключаем шапку проекта
require "db.php"; // подключаем файл для соединения с БД

// Создаем переменную для сбора данных от пользователя по методу POST
$data = $_POST;
if(isset($data['do_task'])) {
        // Создаем массив для сбора ошибок
	$errors = array();
	// Проводим проверки
    // trim — удаляет пробелы (или другие символы) из начала и конца строки
	if(trim($data['taskhead']) == '') {
		$errors[] = "Введите заголовок!";
	}
         // функция mb_strlen - получает длину строки
        // Если заголовок будет меньше 5 символов и больше 90, то выйдет ошибка
	if(mb_strlen($data['taskhead']) < 3 || mb_strlen($data['taskhead']) > 90) {
	    $errors[] = "Недопустимая длина заголовка";
    }
	// Проверка на уникальность заголовка
	if(R::count('tasks', "taskhead = ?", array($data['taskhead'])) > 0) {
		$errors[] = "Такой заголовок уже существует!";
	}
	if(empty($errors)) {
		// Все проверено, регистрируем
        // добавляем в таблицу записи
		$task = R::dispense('tasks');
		$task->taskhead = $data['taskhead'];
		$task->description = $data['description'];
		$task->priority = $data['priority'];
		$task->status = $data['status'];
		//$task->id = $_SESSION['logged_user']->id; Имеется ошибка связанная с добавлением в БД с id, foreign key.
		// Сохраняем таблицу
		R::store($task);
		header('Location: /adminpanel.php');
        echo '<div style="color: green; ">Вы успешно зарегистрированы! Можно <a href="login.php">авторизоваться</a>.</div><hr>';
	} else {
		echo '<div style="color: red; ">' . array_shift($errors). '</div><hr>';
	}
}
?>

<center>
<h1>Добро пожаловать на наш сайт!</h1>
</center>

<!-- Если авторизован выведет приветствие -->
<?php if(isset($_SESSION['logged_user'])) : ?>
	Здравствуйте Администратор <?php echo $_SESSION['logged_user']-> name;?></br>
	<?php 
$db_host='eu-cdbr-west-03.cleardb.net'; // ваш хост
$db_name='heroku_8bcc022f59a9e52'; // ваша бд
$db_user='b55848166756f5'; // пользователь бд
$db_pass='016d3c67'; // пароль к бд
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
   

		<?php while($data = mysqli_fetch_array($qr_result)){
        echo '<tr>';
        echo '<td>' . $data['taskhead'] . '</td>';
        echo '<td>' . $data['description'] . '</td>';
        echo '<td>' . $data['priority'] . '</td>';
		echo '<td>' . $data['status'] . '</td>';
        echo '</tr>';
    }
	echo '</tbody>';
	echo '</table>';
	echo '</script>';
	?>
	
<!-- Реализация модального окна, не получилось взаимодействовать с БД с помощью него.
<link rel='stylesheet' href='css/modal.css'> 
<a class="butksaton-satokavate" href="#modalwindow">Создание задачи</a>
<div class="anelumen lowingnuska" id="modalwindow">
<a href="#/" class="nedismiseg"></a>
<a href="#/" class="compatibg-ukastywise" aria-label="Close Modal Box">×</a>-->
<div class="container mt-4">
	<div class="row">
		<div class="col"> 
		<form action="adminpanel.php" method="post">
		<h2>Создание задачи.</h2>
	<input type="text" class="form-control" name="taskhead" id="taskhead" placeholder="Заголовок"><br>
	<textarea type="text" rows="5" class="form-control" name="description" id="description" placeholder="Описание (не обязательное поле)"></textarea><br><br>
	<select type="text" class="form-control" name="priority" id="priority" placeholder="Приоритет">
		<option value="Высокий">Высокий</option>
		<option value="Средний">Средний</option>
		<option value="Низкий">Низкий</option>
	</select><br>
	<select type="text" class="form-control" name="status" id="status" placeholder="Статус">
		<option value="К выполнению">К выполнению</option>
		<option value="Выполняется">Выполняется</option>
		<option value="Выполнена">Выполнена</option>
		<option value="Отменена">Отменена</option>
	</select><br>
	<button class="btn btn-success" name="do_task" type="submit">Новая задача</button><br>
  </form>
  </div>
</div>
</div>
</div>

<!-- Пользователь может нажать выйти для выхода из системы -->
<a href="logout.php">Выйти</a> <!-- файл logout.php -->

<?php endif; ?>

<?php require __DIR__ . '/footer.php'; ?> <!-- Подключаем подвал проекта -->